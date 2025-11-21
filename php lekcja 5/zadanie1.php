<?php
$serwer = "100.102.15.25:3306";
$uzytkownik = "phpmyadmin";
$haslo = "opa";
$baza = "21.11_wytryszki";

// Włączenie raportowania błędów mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try
{
    $laczenie = mysqli_connect($serwer, $uzytkownik, $haslo, $baza);
    echo "Połączono z bazą danych pomyślnie.";
    mysqli_close($laczenie);
} catch (mysqli_sql_exception $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
?>