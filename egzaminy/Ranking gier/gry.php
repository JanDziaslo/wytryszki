<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Gry komputerowe</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<header>
    <h1>Ranking gier komputerowych</h1><br>
</header>
<aside class="lewy">
    <h3>Top 5 gier w tym miesiacu</h3><br>
    <ul>
   <?php skrypt1(); ?>
    </ul>

    <br><h3>Nasz sklep</h3><br>
    <a href="http://sklep.gry.pl">Tu kupisz gry</a><br>
    <h3>Strone wykonał</h3><br>
    <text>213769420</text>
    <br>
</aside>
<main>
<div class="gry">
<?php skrypt2(); ?>
</div>
</main>
<aside class="prawy">
    <h3>Dodaj nowa gre</h3><br>
    <form action="gry.php" method="post">
        <label for="nazwa">Nazwa</label><br>
        <input type="text" id="nazwa" name="nazwa"><br>
        <label for="opis">Opis</label><br>
        <input type="text" id="opis" name="opis"><br>
        <label for="cena">Cena</label><br>
        <input type="number" id="cena" name="cena"><br>
        <label for="zdjecie">Zdjecie</label><br>
        <input id="zdjecie" name="zdjecie" type="text"><br>
        <button type="submit" name="dodaj">Dodaj</button><br><br>
    </form>
</aside>
<footer>
    <form action="gry.php" method="post">
        <input type="number" id="opis-stopka" name="opis-stopka">
        <button type="submit" name="opis">Pokaż opis</button>
    </form>
</footer>

</body>
</html>

<?php

function skrypt1()
{
    $serwer = "100.102.15.25:13306";
    $uzyt = "wytrychy_user";
    $haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
    $baza = "wytrychy_db";

    $p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");
    mysqli_set_charset($p, "utf8");
    $zapytanie3  =  "SELECT nazwa, punkty FROM gry order by punkty desc LIMIT 5;";
    $wynik = mysqli_query($p, $zapytanie3);

    while ($wiersz = mysqli_fetch_array($wynik))
    {
        echo "<li>" . $wiersz['nazwa'] ." ". "<div class='punkty'>" . $wiersz['punkty'] . "</div>"."</li>";
    }

    mysqli_close($p);
}

function skrypt2()
{
    $serwer = "100.102.15.25:13306";
    $uzyt = "wytrychy_user";
    $haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
    $baza = "wytrychy_db";

    $p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");
    mysqli_set_charset($p, "utf8");
    $zapytanie1  =  "select id, nazwa, zdjecie from gry;";

    $wynik = mysqli_query($p, $zapytanie1);

    while ($wiersz = mysqli_fetch_array($wynik))
    {
        echo
            "<div class='obrazek'>".
            "<img src='img/" . $wiersz['zdjecie'] . "' alt='" . $wiersz['nazwa'] . "'>" . "<br>" .
            "<p>" . $wiersz['nazwa'] . "</p>" . "<br>" .
            "</div>";
    }
    mysqli_close($p);
}
if (isset($_POST['dodaj']))
{
    skrypt4();
}
elseif (isset($_POST['opis']))
{
    skrypt3();
}

function skrypt3()
{
    $serwer = "100.102.15.25:13306";
    $uzyt = "wytrychy_user";
    $haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
    $baza = "wytrychy_db";

    $p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");

    mysqli_set_charset($p, "utf8");
    $ID = $_POST['opis-stopka'];

    $zapytanie  =  "SELECT nazwa, punkty, cena, opis FROM gry WHERE id = $ID;";

    $wynik = mysqli_query($p, $zapytanie);

    while ($wiersz = mysqli_fetch_array($wynik))
    {
        echo
        "<footer style='margin-top: -90px'>" .
            "<h2>". $wiersz['nazwa']. ", " . $wiersz['punkty'] . " punktów, " . $wiersz['cena'] . " zł" . "</h2>".
            "<p>" . $wiersz['opis'] . "</p>".
        "</footer>";
    }

    mysqli_close($p);
}

function skrypt4()
{
    $nazwa = $_POST['nazwa'];
    if ($nazwa!=null)
    {
        $serwer = "100.102.15.25:13306";
        $uzyt = "wytrychy_user";
        $haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
        $baza = "wytrychy_db";

        $p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");

        mysqli_set_charset($p, "utf8");
        $nazwa = $_POST['nazwa'];
        $opis = $_POST['opis'];
        $cena = $_POST['cena'];
        $zdjecie = $_POST['zdjecie'];

        $zapytanie4 = "insert into gry (nazwa, opis, cena, zdjecie) values ($nazwa', '$opis', $cena, '$zdjecie');";
        echo "$zapytanie4";
        mysqli_query($p, $zapytanie4);

        mysqli_close($p);
    }
    else {
        die("Brak nazwy gry!");
    }

}
?>