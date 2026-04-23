<?php

setcookie("test", "ok", time() + 604800);
setcookie("kolor", "gray", time() + 604800);
setcookie("login", "Dziaslo", time() + 604800);
setcookie("rola", "Rabin", time() + 604800);
$brak= false;
if ( $_SERVER ["REQUEST_METHOD"] == "POST" && isset($_POST['imie'])) {
    setcookie("imie", $_POST['imie'], time() + 604800);
}
if (isset ( $_POST ["usun"]) ) {
    unset($_COOKIE['test']);
    unset($_COOKIE['kolor']);
    unset($_COOKIE['imie']);
    unset($_COOKIE['visits']);
}
if (empty($_COOKIE)) {
    $brak = true;
}
$licznik = 1;
if (isset($_COOKIE ["visits"]) ) {
    $licznik = $_COOKIE["visits"] + 1;
}
setcookie ("visits", $licznik, time() + 604800) ;

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ciasteczka</title>

</head>
<style>
    body
    {
        background-color: <?php
if ( isset ( $_COOKIE ["kolor"]) ) {
    echo $_COOKIE ['kolor'];
}
  ?>;
    }
</style>
<body>
<h1>Zadanie 2 - wyswietlanie zawartosci ciasteczka</h1>
<?php
if ( isset ( $_COOKIE ["test"]) ) {
    echo $_COOKIE ['test'];
}
?>

<h1>Zadanie 4 - formularz zapisujacy imie w ciastko</h1>
<form action="index.php" method="post">
    <input type="text" name="imie" placeholder="Podaj imie">
    <input type="submit" value="Zapisz imie w ciastku">
</form>

<h1>Zadanie 5 - powitanie na podstawie oreo</h1>
<?php
if ( isset ( $_COOKIE ["imie"]) ) {
    echo "Witaj". " " .$_COOKIE ['imie'];
}
?>
<h1>Zadanie 6 - usuwanie jerzykow</h1>
<form action="index.php" method="post">
    <input type="submit" name="usun" value="Usun ciasteczka">
</form>

<h1>Zadanie 7 - komunikat o braku cookie</h1>
<?php
if ($brak) {
    echo "Brak ciasteczek";
}
else
{
    echo "Są ciasteczka";
}
?>
<h1>Zadanie 8 - licznik odwiedzin</h1>
<?php
    echo " Liczba odwiedzin : " . $licznik ;
?>

<h1>Zadanie 9 - login i rola</h1>
<?php
echo "Login : " . $_COOKIE ['login'] . "<br>";
echo "Rola : " . $_COOKIE ['rola'] . "<br>";
?>
</body>
</html>