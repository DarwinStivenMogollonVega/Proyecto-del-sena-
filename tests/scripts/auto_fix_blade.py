import os
import shutil

pairs = {
    '@if': '@endif',
    '@hasSection': '@endif',
    '@isset': '@endisset',
    '@unless': '@endunless',
    '@auth': '@endauth',
    '@guest': '@endguest',
    '@production': '@endproduction',
}

loops = {
    '@foreach': '@endforeach',
    '@forelse': '@endforelse',
    '@for': '@endfor',
}

def scan_and_fix(root='resources/views'):
    modified = []
    for dirpath, _, files in os.walk(root):
        for name in files:
            if not name.endswith('.blade.php'):
                continue
            path = os.path.join(dirpath, name)
            try:
                with open(path, 'r', encoding='utf-8') as fh:
                    text = fh.read()
            except Exception as e:
                print(f"SKIP {path}: read error: {e}")
                continue

            to_add = []

            # check loops
            for o, e in loops.items():
                oc = text.count(o)
                ec = text.count(e)
                if oc > ec:
                    for _ in range(oc - ec):
                        to_add.append(e)

            # check paired openers
            for o, e in pairs.items():
                oc = text.count(o)
                ec = text.count(e)
                if oc > ec:
                    for _ in range(oc - ec):
                        to_add.append(e)

            if to_add:
                # backup
                bak = path + '.bak'
                try:
                    if not os.path.exists(bak):
                        shutil.copy2(path, bak)
                except Exception as e:
                    print(f"WARN backup failed for {path}: {e}")

                # append before EOF
                try:
                    with open(path, 'a', encoding='utf-8') as fh:
                        fh.write('\n<!-- AUTO-FIX: added missing Blade end directives -->\n')
                        for token in to_add:
                            fh.write(token + '\n')
                    modified.append((path, to_add))
                    print(f"MODIFIED {path}: added {len(to_add)} directives")
                except Exception as e:
                    print(f"ERROR writing {path}: {e}")

    return modified

if __name__ == '__main__':
    print('Starting auto-fix scan...')
    mods = scan_and_fix()
    if not mods:
        print('No changes needed')
    else:
        print('\nSummary of modified files:')
        for p, adds in mods:
            print(f"- {p}: added {len(adds)} tokens -> {adds}")
