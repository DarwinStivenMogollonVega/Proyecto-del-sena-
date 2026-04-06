import os

def scan(root='resources/views'):
    issues = []
    pairs = {
        '@if': '@endif',
        '@hasSection': '@endif',
        '@isset': '@endisset',
        '@unless': '@endunless',
        '@auth': '@endauth',
        '@guest': '@endguest',
        '@production': '@endproduction',
    }
    for dirpath, _, files in os.walk(root):
        for f in files:
            if not f.endswith('.blade.php'):
                continue
            path = os.path.join(dirpath, f)
            try:
                with open(path, 'r', encoding='utf-8') as fh:
                    text = fh.read()
            except Exception:
                continue
            counts = {k: text.count(k) for k in ['@foreach','@endforeach','@forelse','@endforelse','@for','@endfor']}
            mismatch = False
            # check loop directives
            if counts['@foreach'] != counts['@endforeach'] or counts['@forelse'] != counts['@endforelse'] or counts['@for'] != counts['@endfor']:
                mismatch = True
            # check paired openers/enders
            pair_counts = {}
            for o, e in pairs.items():
                oc = text.count(o)
                ec = text.count(e)
                pair_counts[o] = (oc, ec)
                if oc != ec:
                    mismatch = True
            if mismatch:
                counts.update({'pairs': pair_counts})
                issues.append((path, counts))
    return issues

if __name__ == '__main__':
    iss = scan()
    if not iss:
        print('No imbalanced blade directives found')
    else:
        for p, c in iss:
            print(p)
            print(c)
