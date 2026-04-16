<?php
$serwer = "100.125.41.106:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_16_04";

$p = mysqli_connect($serwer, $uzyt, $haslo, $baza) or die("Problem z serwerem!");

$zapytanie2 = "SELECT personel.id, personel.nazwisko FROM personel LEFT JOIN rejestr ON personel.id = rejestr.id_personel WHERE id_personel IS NULL;";
$wynik2 = mysqli_query($p, $zapytanie2);

if (isset($_POST['skrypt1']))
{
    $personel = $_POST['personel'];
    $zapytanie = "SELECT id, imie, nazwisko FROM personel WHERE status like '$personel'";
    $wynik1 = mysqli_query($p, $zapytanie);

}
else
{
    $zapytanie = "SELECT id, imie, nazwisko FROM personel WHERE status like 'policjant'";
    $wynik1 = mysqli_query($p, $zapytanie);
}
if (isset($_POST['skrypt3']))
{
    $id = (int)$_POST['id'];
    $zapytanie3 = "INSERT INTO rejestr VALUES (NULL, CURDATE(), $id, 14);";
    $wynik3 = mysqli_query($p, $zapytanie3);
}

    ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>ZGŁOSZENIA</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<header>
    <h1>Zgłoszenia wydarzeń</h1>
</header>
<main>
    <section id="lewy">
        <h2>Personel</h2>
        <form action="index.php" method="post" >
            <input type="radio" value="policjant" checked id="pol" name="personel" >
            <label for="pol">Policjant</label>
            <input type="radio" value="ratownik" id="rat" name="personel">
            <label for="rat">Ratownik</label>
            <input type="submit" id="przycisk" value="Pokaż" name="skrypt1">
        </form>
        <br>
        <table>
            <tr>
                <td>ID</td>
                <td>Imię</td>
                <td>Nazwisko</td>
            </tr>
            <?php
            while ($wiersz = mysqli_fetch_array($wynik1))
                echo "<tr>"
                    . "<td>" . $wiersz['id'] . "</td>"
                    . "<td>" . $wiersz['imie'] . "</td>"
                    . "<td>" . $wiersz['nazwisko'] . "</td>"
                    . "</tr>";
            ?>
        </table>
    </section>

    <section id="prawy">
        <h2>Nowe Zgłoszenie</h2><br>
        <ol>
            <?php
                while ($wiersz = mysqli_fetch_array($wynik2))
                    echo "<li>" . $wiersz['id']." ". $wiersz['nazwisko'] . "</li>";
            ?>
        </ol>
        <br><br>
        <form action="index.php" method="post">
            <label for="id">Wybierz id osoby z listy:</label>
            <input type="number" id="id" name="id">
            <input type="submit" id="przycisk" value="Dodaj zgłoszenie" name="skrypt3">
        </form>
    </section>
    <footer>
        <p>Strone Wykonał: Jan Dziąsło</p>
    </footer>
</main>
</body>
</html>