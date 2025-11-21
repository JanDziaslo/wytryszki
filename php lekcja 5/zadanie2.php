<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie2</title>
</head>
<body>
<h1>Dodawanie aktorow</h1>
<form action="zadanie2.php" method="post">
    <p><b>ID</b>
        <br><input type="number" name="id"></p>
    <p><b>Imie</b>
        <br><input type="text" name="imie"> </p>
    <p><b>nazwisko</b>
        <br><input type="text" name="nazwisko"> </p>
    <p><b>Płeć (m lub k)</b>
        <br><input type="text" name="plec"></p>
    <p><b>kraj urodzenia</b>
        <br><input type="text" name="kraj"> </p>
    <p><b>Data urodzenia (YYYY-MM-DD)</b>
        <br> <input type="date" name="data"></p>
    <p><input type="submit" value="Dodaj"></p>
</form>
<?php

$id=$_POST['id'];
$imie=$_POST['imie'];
$nazwisko=$_POST['nazwisko'];
$kraj=$_POST['kraj'];
$data=$_POST['data'];
$plec=$_POST['plec'];

$serwer = "100.102.15.25:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");

mysqli_set_charset($p, "utf8");

$q  =  "INSERT  INTO  aktorzy  VALUES  ('$id',  '$imie',  '$nazwisko',  '$plec'  , '$kraj','$data')";

mysqli_query($p, $q);

mysqli_close($p);

?>
</body>
</html>
