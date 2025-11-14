<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie2</title>
</head>
<body>
<h1>Zakup zeszytów</h1>
<form action="zadanie1.php" method="post">
    <p><b> Kwota w zl</b>
    <br><input type="text" name="kwota"></p>
    <p><input type="radio" value="Funt"></p>
    <p><input type="radio" value="Euro"></p>
    <p><input type="submit" value="Przelicz"></p>
</form>
<?php
echo "<p> Dokonales nastepujacych zakupow: </p>";
$linie=$_POST['linie'];
$kratke=$_POST['kratke'];
$gladkie=$_POST['gladkie'];
echo "<p> Zeszyty w linie: $linie szt. </p>";
echo "<p> Zeszyty w kratke: $kratke szt. </p>";
echo "<p> Zeszyty gladkie: $gladkie szt. </p>";
$koszt_wszytkie=($linie*1.5)+($kratke*1.3)+($gladkie*1);
echo "<p> Koszt wszystkich zeszytow wynosi: $koszt_wszytkie zl </p>";
?>
</body>
</html>
