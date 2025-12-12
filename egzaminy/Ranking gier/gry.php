<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Gry komputerowe</title>
    <link rel="stylesheet" href="styl.css">

</head>
<body>
<header>
    <h1>Ranking gier komputerowych</h1>
</header>
<aside class="lewy">
    <h3>Top 5 gier w tym miesiacu</h3>
    <ul>
        <li>opa</li>
    </ul>
    <h3>Nasz sklep</h3>
    <a href="http://sklep.gry.pl">Tu kupisz gry</a>
    <h3>Strone wykonał</h3>
    <text>213769420</text>
</aside>
<main>
<div class="gry">

</div>
</main>
<aside class="prawy">
    <h3>Dodaj nowa gre</h3>
    <form action="gry.php" method="post">
        <label for="nazwa">Nazwa</label><br>
        <input type="text" id="nazwa" name="nazwa"><br>
        <label for="opis">Opis</label><br>
        <input type="text" id="opis" name="opis"><br>
        <label for="cena">Cena</label><br>
        <input type="number" id="cena" name="cena"><br>
        <label for="zdjecie">Zdjecie</label><br>
        <input id="zdjecie" name="zdjecie" type="text"><br>
        <button type="submit">Dodaj</button><br><br>
    </form>
</aside>
<footer>
    <form action="gry.php" method="post">
        <input type="text" id="opis-stopka" name="opis-stopka">
        <button type="submit">Pokaż opis</button>
    </form>
</footer>

</body>
</html>

<?php

$serwer = "100.102.15.25:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");

mysqli_set_charset($p, "utf8");

$zapytanie3  =  "SELECT nazwa, punkty FROM gry LIMIT 5;";

mysqli_query($p, $zapytanie3);

mysqli_close($p);

?>