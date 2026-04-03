// Viewport Preview JS
// Usage: new ViewportPreview(containerElement, options)
// options: { aspect: 'square'|'cover', viewportWidth, viewportHeight, circle: true/false }
class ViewportPreview {
    constructor(root, opts = {}) {
        this.root = root;
        this.imgEl = root.querySelector('.viewport-img');
        this.inputFile = root.querySelector('input[type=file]');
        this.opts = Object.assign({ minScale: 0.5, maxScale: 4, step: 0.02 }, opts);
        this.pos = { x: 0, y: 0 };
        this.scale = 1;
        this.start = null;
        this.isDragging = false;
        this.init();
    }

    init() {
        if (!this.imgEl) return;
        // prevent image dragging
        this.imgEl.draggable = false;
        // store last pointer position to allow slider zoom centering
        this._lastPointer = null;
        this.root.addEventListener('pointermove', (e) => { this._lastPointer = e; });
        // pointer events
        this.root.addEventListener('pointerdown', this.onPointerDown.bind(this));
        window.addEventListener('pointermove', this.onPointerMove.bind(this));
        window.addEventListener('pointerup', this.onPointerUp.bind(this));
        // wheel for zoom
        this.root.addEventListener('wheel', (e) => {
            e.preventDefault();
            const delta = -e.deltaY / 500; // smooth
            this.setScale(this.scale * (1 + delta), { cx: e.clientX, cy: e.clientY });
        }, { passive: false });
        // slider control if present
        const slider = this.root.querySelector('.viewport-zoom');
        if (slider) {
            slider.addEventListener('input', (e) => {
                // prefer last pointer position; if none, use center of viewport
                const last = this._lastPointer;
                let center = null;
                if (last) center = { cx: last.clientX, cy: last.clientY };
                else {
                    const r = this.root.getBoundingClientRect(); center = { cx: r.left + r.width/2, cy: r.top + r.height/2 };
                }
                this.setScale(parseFloat(e.value), center);
            });
        }
        // file input change
        if (this.inputFile) {
            this.inputFile.addEventListener('change', (e) => { this.onFileChange(e); });
        }
        // touch gestures: pinch zoom
        this._touch = { pointers: new Map() };
        this.root.addEventListener('pointerdown', (e)=>{
            if (e.pointerType === 'touch') this._touch.pointers.set(e.pointerId, e);
        });
        this.root.addEventListener('pointerup', (e)=>{
            if (e.pointerType === 'touch') this._touch.pointers.delete(e.pointerId);
        });
        this.root.addEventListener('pointermove', (e)=>{
            if (e.pointerType === 'touch') {
                this._touch.pointers.set(e.pointerId, e);
                if (this._touch.pointers.size >= 2) this._handlePinch();
            }
        });
    }

    onFileChange(e) {
        const file = e.target.files && e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => { this.loadImage(ev.target.result); };
        reader.readAsDataURL(file);
    }

    loadImage(src) {
        this.imgEl.src = src;
        this.imgEl.onload = () => {
            // center and fit using object-fit cover behaviour
            const vw = this.root.clientWidth; const vh = this.root.clientHeight;
            const iw = this.imgEl.naturalWidth; const ih = this.imgEl.naturalHeight;
            // compute scale to cover
            const scaleToCover = Math.max(vw / iw, vh / ih);
            this.scale = Math.max(scaleToCover, 1);
            // center
            const displayW = iw * this.scale; const displayH = ih * this.scale;
            this.pos.x = (vw - displayW) / 2;
            this.pos.y = (vh - displayH) / 2;
            this.update();
        };
    }

    _handlePinch() {
        const pts = Array.from(this._touch.pointers.values());
        if (pts.length < 2) return;
        const a = pts[0], b = pts[1];
        const dx = a.clientX - b.clientX; const dy = a.clientY - b.clientY; const dist = Math.hypot(dx, dy);
        if (!this._touch.startDist) { this._touch.startDist = dist; this._touch.startScale = this.scale; return; }
        const factor = dist / this._touch.startDist;
        this.setScale(this._touch.startScale * factor);
    }

    onPointerDown(e) {
        if (e.button !== 0) return;
        this.isDragging = true; this.start = { x: e.clientX, y: e.clientY, posX: this.pos.x, posY: this.pos.y };
        this.root.classList.add('dragging');
        try { this.root.setPointerCapture && this.root.setPointerCapture(e.pointerId); } catch (err) {}
    }

    onPointerMove(e) {
        if (!this.isDragging || !this.start) return;
        const dx = e.clientX - this.start.x; const dy = e.clientY - this.start.y;
        this.pos.x = this.start.posX + dx; this.pos.y = this.start.posY + dy;
        this.constrain(); this.update();
    }

    onPointerUp(e) {
        this.isDragging = false; this.start = null; this.root.classList.remove('dragging');
        this._touch.startDist = null;
    }

    setScale(value, center) {
        const old = this.scale; const clamped = Math.min(Math.max(value, this.opts.minScale), this.opts.maxScale); this.scale = clamped;
        // if center provided, adjust pos so zoom centers on that point
        if (center && this.imgEl) {
            const rect = this.root.getBoundingClientRect();
            const cx = center.cx !== undefined ? center.cx : center.clientX; const cy = center.cy !== undefined ? center.cy : center.clientY;
            const localX = cx - rect.left; const localY = cy - rect.top;
            // compute image-space coords before scale
            const imgSpaceX = (localX - this.pos.x) / old; const imgSpaceY = (localY - this.pos.y) / old;
            // compute new pos so that imgSpace maps to same local coordinate
            this.pos.x = localX - imgSpaceX * this.scale; this.pos.y = localY - imgSpaceY * this.scale;
        }
        this.constrain(); this.update();
        // update slider if present
        const slider = this.root.querySelector('.viewport-zoom'); if (slider) slider.value = String(this.scale);
    }

    constrain() {
        // ensure image covers viewport (no empty gaps) unless scaled smaller than viewport
        const vw = this.root.clientWidth; const vh = this.root.clientHeight;
        const iw = this.imgEl.naturalWidth * this.scale || 0; const ih = this.imgEl.naturalHeight * this.scale || 0;
        // When the image is smaller than the viewport, center it.
        // When it's larger (zoomed in) allow free panning so the user can position the image
        // without aggressive clamping. We still keep it roughly bounded to avoid drifting
        // extremely far away by applying a soft clamp (optional) — here we allow full freedom.
        if (iw <= vw) {
            this.pos.x = (vw - iw) / 2;
        }
        if (ih <= vh) {
            this.pos.y = (vh - ih) / 2;
        }
    }

    update() {
        this.imgEl.style.transform = `translate(${this.pos.x}px, ${this.pos.y}px) scale(${this.scale})`;
        // notify listeners that viewport changed so UI can update preview in real-time
        try {
            this.root.dispatchEvent && this.root.dispatchEvent(new CustomEvent('viewport:change', { detail: { scale: this.scale, pos: this.pos } }));
        } catch (e) { /* ignore */ }
    }

    // Export the current viewport to a canvas dataURL (final cropped image)
    async exportCropped(px = null) {
        const vw = this.root.clientWidth; const vh = this.root.clientHeight;
        // if px is provided, produce a square output of size px x px (avatars are square)
        const outW = px || vw; const outH = px ? px : vh;
        const canvas = document.createElement('canvas'); canvas.width = outW; canvas.height = outH;
        const ctx = canvas.getContext('2d');
        // draw using the same math as update: compute source rectangle in natural image coords
        const iw = this.imgEl.naturalWidth; const ih = this.imgEl.naturalHeight;
        const srcX = Math.max(0, Math.round((-this.pos.x) / this.scale));
        const srcY = Math.max(0, Math.round((-this.pos.y) / this.scale));
        const srcW = Math.round(vw / this.scale); const srcH = Math.round(vh / this.scale);
        // clamp source rect to image bounds
        const adjSrcW = Math.max(0, Math.min(srcW, iw - srcX));
        const adjSrcH = Math.max(0, Math.min(srcH, ih - srcY));
        // fill white background so JPEG exports don't show black on transparent canvases
        ctx.fillStyle = '#fff'; ctx.fillRect(0, 0, outW, outH);
        try {
            if (adjSrcW > 0 && adjSrcH > 0) {
                ctx.drawImage(this.imgEl, srcX, srcY, adjSrcW, adjSrcH, 0, 0, outW, outH);
            } else {
                // fallback: draw entire image centered and cover
                const ratio = Math.max(outW / iw, outH / ih);
                const drawW = iw * ratio; const drawH = ih * ratio;
                const dx = (outW - drawW) / 2; const dy = (outH - drawH) / 2;
                ctx.drawImage(this.imgEl, 0, 0, iw, ih, dx, dy, drawW, drawH);
            }
        } catch (e) { console.error('exportCropped draw failed', e); }
        return canvas.toDataURL('image/jpeg', 0.9);
    }
}

// Auto-init helpers
window.ViewportPreview = ViewportPreview;
window.initViewportPreview = function(selector) {
    document.querySelectorAll(selector).forEach(el => {
        if (!el.__vp) el.__vp = new ViewportPreview(el);
    });
};
