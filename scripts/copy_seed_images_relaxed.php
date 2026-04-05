<?php
// Script: copy_seed_images_relaxed.php
// Versión relajada: intenta emparejamientos por tokens y distancia Levenshtein

$base = realpath(__DIR__ . '/../');
$seeder = $base . '/database/seeders/ProductosSeeder.php';
$uploads = $base . '/public/uploads/productos';
$destDir = $base . '/resources/seeders/product-images';

if (!file_exists($seeder)) {
    echo "Seeder file not found: $seeder\n";
    exit(1);
}
if (!is_dir($uploads)) {
    echo "Uploads directory not found: $uploads\n";
    exit(1);
}
if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

$content = file_get_contents($seeder);
preg_match_all("/'nombre'\s*=>\s*'([^']+)'/", $content, $mNames);
preg_match_all("/'artista'\s*=>\s*'([^']+)'/", $content, $mArtists);
$names = array_values(array_unique($mNames[1] ?? []));
$artists = array_values(array_unique($mArtists[1] ?? []));

function slugify($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^A-Za-z0-9\/ _|+ -]/', '', $text);
    $text = strtolower(trim($text));
    $text = preg_replace('/[\/ _|+ -]+/', '-', $text);
    return $text;
}

// list upload files
$files = array_values(array_filter(scandir($uploads), function($f) use ($uploads){
    return is_file($uploads . DIRECTORY_SEPARATOR . $f) && in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp']);
}));

$filesSlugs = [];
foreach ($files as $f) {
    $nameNoExt = pathinfo($f, PATHINFO_FILENAME);
    $filesSlugs[$f] = slugify($nameNoExt);
}

$copied = [];
$notFound = [];

foreach ($names as $index => $name) {
    $productSlug = slugify($name);
    $destExists = false;
    // skip if already copied by previous script
    foreach (['jpg','jpeg','png','webp'] as $ext) {
        $maybe = $destDir . DIRECTORY_SEPARATOR . $productSlug . '.' . $ext;
        if (file_exists($maybe)) { $destExists = true; break; }
    }
    if ($destExists) continue;

    $found = false;

    // 1) token matching: split product into meaningful tokens (>3 chars)
    $tokens = preg_split('/[^A-Za-z0-9]+/', $productSlug);
    $tokens = array_filter(array_map('trim', $tokens), function($t){ return strlen($t) >= 3; });

    foreach ($filesSlugs as $file => $fileSlug) {
        foreach ($tokens as $tok) {
            if (strpos($fileSlug, $tok) !== false) {
                $src = $uploads . DIRECTORY_SEPARATOR . $file;
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $dest = $destDir . DIRECTORY_SEPARATOR . $productSlug . '.' . $ext;
                if (!file_exists($dest)) copy($src, $dest);
                $copied[$name] = basename($dest);
                $found = true;
                break 2;
            }
        }
    }
    if ($found) continue;

    // 2) try artist tokens
    $artist = $artists[$index] ?? null;
    if ($artist) {
        $artistSlug = slugify($artist);
        $artistTokens = preg_split('/[^A-Za-z0-9]+/', $artistSlug);
        $artistTokens = array_filter(array_map('trim', $artistTokens), function($t){ return strlen($t) >= 3; });
        foreach ($filesSlugs as $file => $fileSlug) {
            foreach ($artistTokens as $tok) {
                if (strpos($fileSlug, $tok) !== false) {
                    $src = $uploads . DIRECTORY_SEPARATOR . $file;
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $dest = $destDir . DIRECTORY_SEPARATOR . $productSlug . '.' . $ext;
                    if (!file_exists($dest)) copy($src, $dest);
                    $copied[$name] = basename($dest);
                    $found = true;
                    break 3;
                }
            }
        }
    }
    if ($found) continue;

    // 3) Levenshtein fuzzy match (relative threshold)
    $best = null; $bestFile = null;
    foreach ($filesSlugs as $file => $fileSlug) {
        $dist = levenshtein($productSlug, $fileSlug);
        if ($best === null || $dist < $best) { $best = $dist; $bestFile = $file; }
    }
    if ($best !== null) {
        // accept if small absolute distance or proportionally small
        $len = max(strlen($productSlug), 1);
        if ($best <= 5 || ($best / $len) <= 0.35) {
            $src = $uploads . DIRECTORY_SEPARATOR . $bestFile;
            $ext = pathinfo($bestFile, PATHINFO_EXTENSION);
            $dest = $destDir . DIRECTORY_SEPARATOR . $productSlug . '.' . $ext;
            if (!file_exists($dest)) copy($src, $dest);
            $copied[$name] = basename($dest);
            $found = true;
        }
    }

    if (!$found) $notFound[] = $name;
}

echo "Relaxed pass copied: " . count($copied) . "\n";
foreach ($copied as $prod => $file) echo "- $prod => $file\n";
if (count($notFound) > 0) {
    echo "\nStill not found: " . count($notFound) . "\n";
    foreach ($notFound as $n) echo "- $n\n";
}
echo "\nDone relaxed matching.\n";
