<?php
echo "Dodano rezerwację do bazy";

$data=$_POST['data'];
$osoby=$_POST['osoby'];
$telefon=$_POST['telefon'];


$serwer = "100.102.15.25:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect($serwer, $uzyt, $haslo, $baza) or die("Problem z serwerem!");
if ($p) {
    echo "tak";
}
else {
    echo "nie";
}
    $z = "insert into rezerwacje VALUES ('$data', '$osoby', '$telefon' )";
mysqli_query($p, $z);

mysqli_close($p);

?>