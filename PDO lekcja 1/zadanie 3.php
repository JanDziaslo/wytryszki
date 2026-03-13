<?php
$port =13306;
$serwer = "100.125.41.106";
$baza = "wytrychy_db";
$uzytkownik = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";

$dsn = "mysql:host=$serwer;port=$port;dbname=$baza;charset=utf8mb4";

try {
    $polaczenie = new PDO($dsn, $uzytkownik, $haslo, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $zapytanie = "SELECT nazwa, cena FROM dania WHERE cena > 20";
    $wynik = $polaczenie->query($zapytanie);

    foreach ($wynik as $wiersz) {
        echo $wiersz['nazwa'] . " " . $wiersz['cena'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Blad polaczenia: " . $e->getMessage();
}
?>
