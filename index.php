<?php
// Zdekoduj URL
$requestUri = urldecode($_SERVER['REQUEST_URI']);
$requestUri = parse_url($requestUri, PHP_URL_PATH);

// Zbuduj pełną ścieżkę do zasobu
$requestedPath = __DIR__ . $requestUri;

// Jeśli to plik i istnieje, pozwól PHP go obsłużyć
if (is_file($requestedPath)) {
    return false; // PHP wykona plik
}

// Jeśli to katalog, pokaż listę zawartości
if (is_dir($requestedPath)) {
    header("Content-Type: text/html; charset=utf-8");

    echo "<!DOCTYPE html>";
    echo "<html><head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Index of " . htmlspecialchars($requestUri) . "</title>";
    echo "<style>";
    echo "body { font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; background: #f5f5f5; }";
    echo ".container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }";
    echo "h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }";
    echo "a { display: block; padding: 12px; margin: 5px 0; text-decoration: none; color: #007bff; border-radius: 4px; transition: background 0.2s; }";
    echo "a:hover { background: #f0f8ff; }";
    echo ".folder { font-weight: bold; }";
    echo ".file { color: #555; }";
    echo ".parent { color: #666; background: #f8f9fa; margin-bottom: 15px; }";
    echo "hr { border: none; border-top: 1px solid #ddd; margin: 20px 0; }";
    echo "</style>";
    echo "</head><body>";
    echo "<div class='container'>";
    echo "<h2>📂 Index of " . htmlspecialchars($requestUri) . "</h2>";

    // Link do katalogu nadrzędnego
    if ($requestUri !== '/') {
        $parentDir = dirname($requestUri);
        if ($parentDir === '') $parentDir = '/';
        echo "<a href='" . htmlspecialchars($parentDir) . "' class='parent'>⬆️ [Katalog nadrzędny]</a>";
        echo "<hr>";
    }

    // Pobierz zawartość katalogu
    $items = scandir($requestedPath);
    $folders = [];
    $files = [];

    // Rozdziel foldery i pliki
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $fullPath = $requestedPath . '/' . $item;

        if (is_dir($fullPath)) {
            $folders[] = $item;
        } else {
            $files[] = $item;
        }
    }

    // Sortuj alfabetycznie
    sort($folders);
    sort($files);

    // Wyświetl najpierw foldery
    foreach ($folders as $folder) {
        $urlPath = rtrim($requestUri, '/') . '/' . rawurlencode($folder);
        echo "<a href='" . htmlspecialchars($urlPath) . "/' class='folder'>📁 " . htmlspecialchars($folder) . "/</a>";
    }

    // Potem pliki
    foreach ($files as $file) {
        $urlPath = rtrim($requestUri, '/') . '/' . rawurlencode($file);
        $icon = (pathinfo($file, PATHINFO_EXTENSION) === 'php') ? '🐘' : '📄';
        echo "<a href='" . htmlspecialchars($urlPath) . "' class='file'>$icon " . htmlspecialchars($file) . "</a>";
    }

    echo "</div>";
    echo "</body></html>";
    return true;
}

// Jeśli zasób nie istnieje, zwróć 404
http_response_code(404);
echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>404 Not Found</title></head>";
echo "<body><h1>404 - Nie znaleziono</h1>";
echo "<p>Zasób <strong>" . htmlspecialchars($requestUri) . "</strong> nie istnieje.</p>";
echo "</body></html>";
return true;
?>
