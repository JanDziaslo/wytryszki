<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie3</title>
</head>
<body>

<?php

$serwer = "100.102.15.25:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");

mysqli_set_charset($p, "utf8");

$q = 'select imie, nazwisko, kraj_ur, data_ur from aktorzy where data_ur >="1990-01-10"';

$wynik = mysqli_query($p, $q) or die("cos nie dziala z kwarenda");

while ($wynik2 = mysqli_fetch_assoc($wynik))
{
    echo $wynik2 ['imie']." ".$wynik2['nazwisko']." ".$wynik2 ['kraj_ur']." ".$wynik2 ['data_ur']."<br>";
}

mysqli_close($p);

?>
</body>
</html>
