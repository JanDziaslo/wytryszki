<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Pliki</title>
</head>
<body>
<h1>Zadanie 1</h1>
<?php
$plik = fopen("pliki/dane.txt", "r");
$znaki = fread($plik,5);
echo $znaki;
fclose($plik)
?>
<h1>Zadanie 2</h1>
<?php
$plik = fopen("pliki/tekst.txt", "r");
while (!feof($plik)) {
    $linia = fgets($plik);
    echo "<br>";
    echo $linia;
}
fclose($plik)
?>
<h1>Zadanie 3</h1>
<?php
$plik = fopen("pliki/tekst.txt", "r");
$licznik = 0;
while (!feof($plik)) {
    $linia = fgets($plik);
    $licznik = $licznik + 1;
}
echo $licznik;
fclose($plik)
?>
<h1>Zadanie 4</h1>
<?php
$plik = fopen("pliki/liczby.txt", "r");
$suma = 0;
while (!feof($plik))
{
    $znak = fgets($plik);
    $suma = $suma + $znak;
}
echo $suma;
fclose($plik)
?>
<h1>Zadanie 5</h1>
<?php
$plik = fopen("pliki/wynik.txt", "w");
for ($i = 1; $i <= 10; $i++) {
    fwrite($plik, $i);
    fwrite($plik, "\n");
}
echo "dane zostały zapisane do pliku";
fclose($plik)
?>
<h1>Zadanie 6</h1>
<?php
$plik = fopen("pliki/dane.txt", "r");
echo "nie chce mi sie";
#while (!feof($plik))
#{
 #
#}
fclose($plik)
?>

</body>
</html>