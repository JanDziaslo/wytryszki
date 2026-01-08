<?php
$serwer = "127.0.0.1:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect($serwer, $uzyt, $haslo, $baza) or die("Problem z serwerem!");
mysqli_set_charset($p, "utf8");

$tytul = $_POST['tytul'];
$gatunek = $_POST['gatunek'];
$rok = $_POST['rok'];
$ocena = $_POST['ocena'];

$zapytanie = "INSERT INTO filmy (tytul, gatunki_id, rok, ocena, rezyserzy_id) VALUES ('$tytul', '$gatunek', '$rok', '$ocena', '1')";
mysqli_query($p, $zapytanie);
mysqli_close($p);
echo "Film $tytul został dodany do bazy";
?>