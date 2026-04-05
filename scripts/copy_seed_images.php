<?php
// Script: copy_seed_images.php
// Copia imágenes desde public/uploads/productos a resources/seeders/product-images

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

$names = array_unique($mNames[1] ?? []);
$artists = array_unique($mArtists[1] ?? []);

function slugify($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^A-Za-z0-9\/ _|+ -]/', '', $text);
    $text = strtolower(trim($text));
    $text = preg_replace('/[\/ _|+ -]+/', '-', $text);
    return $text;
}

// Build list of available upload files
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

foreach ($names as $i => $name) {
    $productSlug = slugify($name);
    $found = false;
    // try exact/contains match on filename slug
    foreach ($filesSlugs as $file => $fileSlug) {
        if ($fileSlug === $productSlug || strpos($fileSlug, $productSlug) !== false || strpos($productSlug, $fileSlug) !== false) {
            $src = $uploads . DIRECTORY_SEPARATOR . $file;
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $dest = $destDir . DIRECTORY_SEPARATOR . $productSlug . '.' . $ext;
            if (!file_exists($dest)) copy($src, $dest);
            $copied[$name] = basename($dest);
            $found = true;
            break;
        }
    }
    if ($found) continue;
    // try match by artist name if available
    $artist = $artists[$i] ?? null;
    if ($artist) {
        $artistSlug = slugify($artist);
        foreach ($filesSlugs as $file => $fileSlug) {
            if ($fileSlug === $artistSlug || strpos($fileSlug, $artistSlug) !== false || strpos($artistSlug, $fileSlug) !== false) {
                $src = $uploads . DIRECTORY_SEPARATOR . $file;
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $dest = $destDir . DIRECTORY_SEPARATOR . $productSlug . '.' . $ext;
                if (!file_exists($dest)) copy($src, $dest);
                $copied[$name] = basename($dest);
                $found = true;
                break;
            }
        }
    }
    if (!$found) {
        $notFound[] = $name;
    }
}

// Report results
echo "Copied images: " . count($copied) . "\n";
foreach ($copied as $prod => $file) {
    echo "- $prod => $file\n";
}
if (count($notFound) > 0) {
    echo "\nNo se encontraron imágenes para: " . count($notFound) . " productos\n";
    foreach ($notFound as $n) echo "- $n\n";
}

echo "\nDone.\n";
