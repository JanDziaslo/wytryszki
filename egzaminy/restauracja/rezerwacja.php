<?php
echo "Dodano rezerwację do bazy";

$data=$_POST['data'];
$osoby=$_POST['osoby'];
$telefon=$_POST['telefon'];


$serwer = "127.0.0.1:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect($serwer, $uzyt, $haslo, $baza) or die("Problem z serwerem!");

$z = "INSERT INTO rezerwacje (data_rez, liczba_osob, telefon) VALUES ('$data', '$osoby', '$telefon')";

mysqli_query($p, $z);

mysqli_close($p);

?>