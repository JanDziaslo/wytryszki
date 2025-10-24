<?php
// NAPRAWKA 8: Bezpieczne nagłówki HTTP
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Content-Security-Policy: default-src \'self\'; style-src \'unsafe-inline\'; script-src \'self\'');
header('Referrer-Policy: strict-origin-when-cross-origin');

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
    $requestUri = '/';
    $requestedPath = $basePath;
}

// Sprawdź czy ścieżka istnieje
if (!file_exists($requestedPath)) {
    http_response_code(404);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>404 Not Found</title>";
    echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}a{color:#64b5f6;}</style></head>";
    echo "<body><h1>404 - Nie znaleziono</h1>";
    echo "<p>Plik <strong>" . htmlspecialchars($requestUri, ENT_QUOTES, 'UTF-8') . "</strong> nie istnieje.</p>";
    echo "<a href='/'>← Powrót do głównej</a></body></html>";
    exit;
}

// NAPRAWKA 1: Sprawdź bezpieczeństwo - symlink-safe path traversal check
$realBase = realpath($basePath);
$realRequested = realpath($requestedPath);

if ($realBase === false) {
    http_response_code(500);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>500 Internal Server Error</title>";
    echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}</style></head>";
    echo "<body><h1>500 - Błąd konfiguracji serwera</h1></body></html>";
    exit;
}

// Symlink-safe check: upewnij się że realpath() zwrócił prawidłową ścieżkę
// i że ścieżka znajduje się w basePath (z dodatkowym separatorem)
if ($realRequested === false ||
    ($realRequested !== $realBase && strpos($realRequested, $realBase . DIRECTORY_SEPARATOR) !== 0)) {
    http_response_code(403);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>403 Forbidden</title>";
    echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}</style></head>";
    echo "<body><h1>403 - Zabroniony dostęp</h1></body></html>";
    exit;
}

// WAŻNE: Jeśli to plik PHP - WYKONAJ GO
if (is_file($realRequested)) {
    $extension = strtolower(pathinfo($realRequested, PATHINFO_EXTENSION));

    // NAPRAWKA 2: Whitelist bezpiecznych rozszerzeń + niebezpieczne rozszerzenia
    $allowedExtensions = ['php'];
    $dangerousExtensions = ['phtml', 'phar', 'shtml', 'pht', 'phps', 'php3', 'php4', 'php5', 'phtml', 'pht', 'phps'];

    // Sprawdzenie czy rozszerzenie jest niebezpieczne WCZEŚNIEJ
    if (in_array($extension, $dangerousExtensions, true)) {
        http_response_code(403);
        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>403 Forbidden</title>";
        echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}</style></head>";
        echo "<body><h1>403 - Typ pliku zabroniony</h1></body></html>";
        exit;
    }

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
    $mimeType = 'application/octet-stream';

    if (function_exists('finfo_file')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $detected = finfo_file($finfo, $realRequested);
            finfo_close($finfo);
            if ($detected) {
                $mimeType = $detected;
            }
        }
    } elseif (function_exists('mime_content_type')) {
        $detected = @mime_content_type($realRequested);
        if ($detected) {
            $mimeType = $detected;
        }
    }

    // Sprawdzenie limitu rozmiaru pliku
    $maxFileSize = 100 * 1024 * 1024; // 100 MB
    $fileSize = filesize($realRequested);

    if ($fileSize > $maxFileSize) {
        http_response_code(413);
        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>413 Payload Too Large</title>";
        echo "<style>body{font-family:Arial;padding:40px;background:#1a1a1a;color:#e0e0e0;}h1{color:#ff6b6b;}</style></head>";
        echo "<body><h1>413 - Plik zbyt duży</h1></body></html>";
        exit;
    }

    // NAPRAWKA 3: Sanitizacja Content-Disposition - usunięcie znaków specjalnych
    $filename = preg_replace('/[^a-zA-Z0-9._\-]/', '_', basename($realRequested));
    $filename = preg_replace('/_+/', '_', $filename);

    header('Content-Type: ' . $mimeType);
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Length: ' . $fileSize);
    header('X-Content-Type-Options: nosniff');

    // NAPRAWKA 6: Zwiększony time limit dla dużych plików
    // Dynamiczny time limit: 1 sekunda na MB
    $recommendedTimeout = max(60, ceil($fileSize / (1024 * 1024)));
    set_time_limit($recommendedTimeout);
    ini_set('memory_limit', '256M');

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
    echo "<title>Wytryszki " . htmlspecialchars($requestUri, ENT_QUOTES, 'UTF-8') . "</title>";
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
    echo ".pagination { margin-top: 20px; text-align: center; color: #90caf9; }";
    echo ".pagination a { display: inline-block; margin: 0 5px; padding: 5px 10px; }";
    echo "</style></head><body><div class='container'>";
    echo "<h2>📂 Wytryszki " . htmlspecialchars($requestUri, ENT_QUOTES, 'UTF-8') . "</h2>";

    // Link do katalogu nadrzędnego
    if ($requestUri !== '/' && $requestUri !== '') {
        $parentDir = dirname($requestUri);
        if ($parentDir === '.' || $parentDir === '') {
            $parentDir = '/';
        }
        echo "<a href='" . htmlspecialchars($parentDir, ENT_QUOTES, 'UTF-8') . "' class='parent'><span class='icon'>⬆️</span> [Katalog nadrzędny]</a>";
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

    // NAPRAWKA 5: Paginacja dla dużych katalogów
    $itemsPerPage = 50;
    // NAPRAWKA 2: Ulepszona walidacja numeru strony - max limit na liczbę stron
    $maxPageNumber = 10000; // Maksymalnie 10000 stron (500,000 pozycji)
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, min((int)$_GET['page'], $maxPageNumber)) : 1;

    $allItems = array_merge($folders, $files);
    $totalItems = count($allItems);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $page = min($page, max(1, $totalPages));
    $startIndex = ($page - 1) * $itemsPerPage;
    $pagedItems = array_slice($allItems, $startIndex, $itemsPerPage);

    // Wyświetl foldery z tej strony
    $folderCount = 0;
    foreach ($pagedItems as $item) {
        $fullPath = $realRequested . DIRECTORY_SEPARATOR . $item;
        if (!is_dir($fullPath)) {
            continue;
        }
        $urlPath = rtrim($requestUri, '/') . '/' . rawurlencode($item);
        echo "<a href='" . htmlspecialchars($urlPath, ENT_QUOTES, 'UTF-8') . "/' class='folder'><span class='icon'>📁</span> " . htmlspecialchars($item, ENT_QUOTES, 'UTF-8') . "/</a>";
    }

    // Wyświetl pliki z tej strony
    foreach ($pagedItems as $item) {
        $fullPath = $realRequested . DIRECTORY_SEPARATOR . $item;
        if (is_dir($fullPath)) {
            continue;
        }
        $urlPath = rtrim($requestUri, '/') . '/' . rawurlencode($item);
        $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));

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

        echo "<a href='" . htmlspecialchars($urlPath, ENT_QUOTES, 'UTF-8') . "' class='file'><span class='icon'>$icon</span> " . htmlspecialchars($item, ENT_QUOTES, 'UTF-8') . "</a>";
    }

    // Paginacja - linki do innych stron
    if ($totalPages > 1) {
        echo "<div class='pagination'>";
        echo "Strona $page / $totalPages | ";

        if ($page > 1) {
            $prevPage = $page - 1;
            echo "<a href='" . htmlspecialchars($requestUri, ENT_QUOTES, 'UTF-8') . "?page=$prevPage'>← Poprzednia</a> ";
        }

        if ($page < $totalPages) {
            $nextPage = $page + 1;
            echo "<a href='" . htmlspecialchars($requestUri, ENT_QUOTES, 'UTF-8') . "?page=$nextPage'>Następna →</a>";
        }

        echo "</div>";
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
