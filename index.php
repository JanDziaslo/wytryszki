<?php
// Pobierz ścieżkę z URL
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = parse_url($requestUri, PHP_URL_PATH);
$requestUri = urldecode($requestUri);

// Usuń podwójne slashe
$requestUri = preg_replace('#/+#', '/', $requestUri);

// Bazowa ścieżka
$basePath = __DIR__;

// Zbuduj pełną ścieżkę (obsługuje spacje!)
$requestedPath = $basePath . $requestUri;

// Normalizuj separatory
$requestedPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $requestedPath);

// Bezpieczeństwo - sprawdź czy to index.php
if (realpath($requestedPath) === __FILE__) {
    // Jeśli ktoś próbuje otworzyć index.php bezpośrednio - pokaż główny katalog
    $requestUri = '/';
    $requestedPath = $basePath;
}

// Sprawdź czy ścieżka istnieje
if (!file_exists($requestedPath)) {
    http_response_code(404);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>404 Not Found</title>";
    echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}a{color:#64b5f6;}</style></head>";
    echo "<body><h1>404 - Nie znaleziono</h1>";
    echo "<p>Plik <strong>" . htmlspecialchars($requestUri) . "</strong> nie istnieje.</p>";
    echo "<a href='/'>← Powrót do głównej</a></body></html>";
    exit;
}

// Sprawdź bezpieczeństwo - czy nie wychodzi poza DocumentRoot
$realBase = realpath($basePath);
$realRequested = realpath($requestedPath);

if ($realRequested === false || strpos($realRequested, $realBase) !== 0) {
    http_response_code(403);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>403 Forbidden</title>";
    echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}</style></head>";
    echo "<body><h1>403 - Zabroniony dostęp</h1></body></html>";
    exit;
}

// WAŻNE: Jeśli to plik PHP - WYKONAJ GO
if (is_file($realRequested)) {
    $extension = strtolower(pathinfo($realRequested, PATHINFO_EXTENSION));
    
    if ($extension === 'php') {
        // Zmień katalog roboczy na katalog pliku
        chdir(dirname($realRequested));
        
        // Wyczyść output buffer jeśli był otwarty
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // WYKONAJ plik PHP
        require $realRequested;
        exit;
    }
    
    // Jeśli to inny plik (nie PHP) - zwróć go z odpowiednim MIME type
    if (function_exists('mime_content_type')) {
        $mimeType = mime_content_type($realRequested);
    } else {
        $mimeType = 'application/octet-stream';
    }
    
    header('Content-Type: ' . $mimeType);
    readfile($realRequested);
    exit;
}

// Jeśli to katalog - pokaż listing
if (is_dir($realRequested)) {
    $items = @scandir($realRequested);
    
    if ($items === false) {
        http_response_code(403);
        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>403 Forbidden</title>";
        echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}</style></head>";
        echo "<body><h1>403 - Brak dostępu</h1></body></html>";
        exit;
    }
    
    header("Content-Type: text/html; charset=utf-8");
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Index of " . htmlspecialchars($requestUri) . "</title>";
    echo "<style>";
    echo "body { font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; background: #1a1a1a; }";
    echo ".container { max-width: 1000px; margin: 0 auto; background: #2d2d2d; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.5); }";
    echo "h2 { color: #e0e0e0; border-bottom: 2px solid #64b5f6; padding-bottom: 10px; margin-top: 0; }";
    echo "a { display: block; padding: 12px; margin: 5px 0; text-decoration: none; color: #64b5f6; border-radius: 4px; transition: all 0.2s; }";
    echo "a:hover { background: #3a3a3a; transform: translateX(5px); }";
    echo ".folder { font-weight: bold; }";
    echo ".file { color: #b0b0b0; }";
    echo ".parent { color: #90caf9; background: #383838; margin-bottom: 15px; font-weight: bold; }";
    echo "hr { border: none; border-top: 1px solid #444; margin: 20px 0; }";
    echo ".icon { display: inline-block; width: 24px; }";
    echo "</style></head><body><div class='container'>";
    echo "<h2>📂 Index of " . htmlspecialchars($requestUri) . "</h2>";
    
    // Link do katalogu nadrzędnego
    if ($requestUri !== '/' && $requestUri !== '') {
        $parentDir = dirname($requestUri);
        if ($parentDir === '.' || $parentDir === '') {
            $parentDir = '/';
        }
        echo "<a href='" . htmlspecialchars($parentDir) . "' class='parent'><span class='icon'>⬆️</span> [Katalog nadrzędny]</a>";
        echo "<hr>";
    }
    
    $folders = [];
    $files = [];
    
    // Rozdziel foldery i pliki
    foreach ($items as $item) {
        // Ukryj pliki/katalogi zaczynające się od kropki
        if ($item === '.' || $item === '..' || $item[0] === '.') {
            continue;
        }
        
        $fullPath = $realRequested . DIRECTORY_SEPARATOR . $item;
        
        if (is_dir($fullPath)) {
            $folders[] = $item;
        } else {
            $files[] = $item;
        }
    }
    
    // Sortuj alfabetycznie
    sort($folders, SORT_NATURAL | SORT_FLAG_CASE);
    sort($files, SORT_NATURAL | SORT_FLAG_CASE);
    
    // Wyświetl foldery
    foreach ($folders as $folder) {
        $urlPath = rtrim($requestUri, '/') . '/' . rawurlencode($folder);
        echo "<a href='" . htmlspecialchars($urlPath) . "/' class='folder'><span class='icon'>📁</span> " . htmlspecialchars($folder) . "/</a>";
    }
    
    // Wyświetl pliki
    foreach ($files as $file) {
        $urlPath = rtrim($requestUri, '/') . '/' . rawurlencode($file);
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        
        // Ikony dla różnych typów plików
        switch ($ext) {
            case 'php':
                $icon = '🐘';
                break;
            case 'html':
            case 'htm':
                $icon = '🌐';
                break;
            case 'css':
                $icon = '🎨';
                break;
            case 'js':
                $icon = '⚡';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'svg':
                $icon = '🖼️';
                break;
            case 'pdf':
                $icon = '📕';
                break;
            case 'txt':
            case 'md':
                $icon = '📝';
                break;
            default:
                $icon = '📄';
        }
        
        echo "<a href='" . htmlspecialchars($urlPath) . "' class='file'><span class='icon'>$icon</span> " . htmlspecialchars($file) . "</a>";
    }
    
    echo "</div></body></html>";
    exit;
}

// Jeśli dotarliśmy tutaj - coś poszło nie tak
http_response_code(500);
echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>500 Internal Server Error</title>";
echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}</style></head>";
echo "<body><h1>500 - Błąd serwera</h1></body></html>";
?>
