<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie 4</title>
</head>
<body>

<?php

$serwer = "100.102.15.25:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect($serwer, $uzyt, $haslo, $baza) or die("Problem z serwerem!");

mysqli_set_charset($p, "utf8");

$q = 'SELECT imie, nazwisko, kraj_ur, data_ur FROM aktorzy WHERE data_ur >= "1990-01-01"';

$wynik = mysqli_query($p, $q) or die("Cos nie dziala z kwerenda");

while ($wynik2 = mysqli_fetch_object($wynik)) {
    echo $wynik2->imie . " " . $wynik2->nazwisko . " " . $wynik2->kraj_ur . " " . $wynik2->data_ur . "<br>";
}

mysqli_free_result($wynik);
mysqli_close($p);



?>
</body>
</html>
