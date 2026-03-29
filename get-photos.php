<?php
header('Content-Type: application/json');

$folder = __DIR__ . '/Photos';
$basePath = 'Photos/';

$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
$photos = [];

if (is_dir($folder)) {
    $files = scandir($folder);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $fullPath = $folder . '/' . $file;

        if (is_file($fullPath)) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (in_array($extension, $allowedExtensions, true)) {
                $nameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
                $prettyTitle = ucwords(str_replace(['-', '_'], ' ', $nameWithoutExtension));

                $photos[] = [
                    'src' => $basePath . rawurlencode($file),
                    'title' => $prettyTitle,
                    'text' => 'A glimpse into past Servant Events at Heit’s Point.'
                ];
            }
        }
    }

    usort($photos, function ($a, $b) {
        return strcmp($a['src'], $b['src']);
    });
}

echo json_encode($photos);
?>