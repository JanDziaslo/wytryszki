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
            <input type="radio" value="1" checked id="pol" name="personel" >
            <label for="pol">Policjant</label>
            <input type="radio" value="2" id="rat" name="personel">
            <label for="rat">Ratownik</label>
            <input type="submit" id="przycisk" value="Pokaż">
        </form>
        <br>
        <table>
            <tr>
                <td>ID</td>
                <td>Imię</td>
                <td>Nazwisko</td>
            </tr>
        </table>
    </section>

    <section id="prawy">
        <h2>Nowe Zgłoszenie</h2><br>
        <ol>
            <li>opa</li>
        </ol>
        <br><br>
        <form action="index.php" method="post">
            <label for="id">Wybierz id osoby z listy:</label>
            <input type="number" id="id">
            <input type="submit" id="przycisk" value="Dodaj zgłoszenie">
        </form>
    </section>
    <footer>
        <p>Strone Wykonał: Jan Dziąsło</p>
    </footer>
</main>
</body>
</html>