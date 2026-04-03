(function () {
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.js-wishlist-toggle');
        if (!btn) return;
        e.preventDefault();

        var id = btn.getAttribute('data-product-id');
        if (!id) return;

        var url = '/deseados/toggle/' + id;
        var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        btn.disabled = true;
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(function (res) {
            return res.json();
        }).then(function (json) {
            if (json && json.success) {
                var icon = btn.querySelector('i');
                if (!icon) return;
                if (json.inWishlist) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                    icon.classList.add('text-danger');
                    showDzToast('Producto agregado a Deseados', 'success');
                } else {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.remove('text-danger');
                    icon.classList.add('bi-heart');
                    // If the button is inside a wishlist item container, remove the item from DOM
                    var itemCol = btn.closest('.wishlist-item-col');
                    if (itemCol) {
                        // smooth remove
                        itemCol.style.transition = 'opacity 180ms ease, height 220ms ease, margin 220ms ease';
                        itemCol.style.opacity = '0';
                        itemCol.style.height = '0px';
                        itemCol.style.margin = '0px';
                        setTimeout(function () { itemCol.remove(); }, 260);
                    }
                    showDzToast('Producto eliminado de Deseados', 'danger');
                }
            } else {
                console.error('Wishlist toggle failed', json);
                // pequeño feedback al usuario
                if (window.alert) window.alert('No se pudo actualizar la lista de deseados');
            }
        }).catch(function (err) {
            console.error(err);
            if (window.alert) window.alert('Error de red al actualizar deseados');
        }).finally(function () {
            btn.disabled = false;
        });
    });
})();

function showDzToast(message, type) {
    try {
        var toastEl = document.getElementById('dz-global-toast');
        if (!toastEl) return;
        var body = toastEl.querySelector('.toast-body');
        if (body) body.textContent = message;

        // normalize type: 'success' | 'danger' | default -> dark
        var allowed = { 'success': 'text-bg-success', 'danger': 'text-bg-danger' };
        // remove previous text-bg-* classes
        toastEl.classList.forEach(function (cls) {
            if (cls.indexOf('text-bg-') === 0) {
                toastEl.classList.remove(cls);
            }
        });
        var newCls = allowed[type] || 'text-bg-dark';
        toastEl.classList.add(newCls);

        var toast = bootstrap.Toast.getOrCreateInstance(toastEl);
        toast.show();
    } catch (e) {
        // fallback
        console.log(message);
    }
}
