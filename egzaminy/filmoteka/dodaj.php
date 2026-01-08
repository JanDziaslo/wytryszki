<?php
$tytul = $POST['tytul'];
$gatunek = $POST['gatunek'];
$rok = $POST['rok'];
$ocena = $POST['ocena'];


$serwer = "127.0.0.1:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");
mysqli_set_charset($p, "utf8");
$zapytanie = "INSERT INTO filmy (tytul, gatunki_id, rok, ocena) VALUES ('$tytul', '$gatunek', '$rok', '$ocena')";
mysqli_query($p, $zapytanie);
mysqli_close($p);
echo "Film $tytul został dodany do bazy";
?>