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

    $imie = "Adam";
    $nazwisko = "Kowal";
    $wiek = 10;

    $zapytanie = "INSERT INTO uczniowie (imie, nazwisko, wiek) VALUES(:imie,:nazwisko,:wiek)";
    $instrukcja = $polaczenie->prepare($zapytanie);

$instrukcja = $polaczenie->prepare($zapytanie);

$instrukcja->execute([
    ':imie' => $imie,
    ':nazwisko' => $nazwisko,
    ':wiek' => $wiek]);

} catch (PDOException $e) {
    echo "Blad polaczenia: " . $e->getMessage();
}
?>
