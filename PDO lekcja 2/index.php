<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>PDO lekcja 2</title>
</head>
<body>

<?php
$host = '100.125.41.106';
$port = '13306';
$dbname = 'PDO_wytrychy';
$user = 'wytrychy_user';
$pass = 'gDxajVS2BhMiqcY8xWHU34EpjRpC489T';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query('SET NAMES utf8');

    $stmtZad1 = $pdo->query("SELECT * FROM ryby");
    echo "Zadanie 1<br><br>";

    foreach ($stmtZad1 as $rowZad1) {
        echo $rowZad1['id'] . " " . $rowZad1['nazwa'] . " " . $rowZad1['wystepowanie'] . " " . $rowZad1['styl_zycia'] . "<br>";
    }
    echo "<br>";

    $stmtZad2 = $pdo->query("SELECT nazwa, styl_zycia FROM ryby");
    echo "Zadanie 2<br><br>";

    foreach ($stmtZad2 as $rowZad2) {
        echo $rowZad2['nazwa'] . " " . $rowZad2['styl_zycia'] . "<br>";
    }
    echo "<br>";

    $stmtZad3 = $pdo->query("SELECT * FROM samochody where kolor like 'czerwony'");
    echo "Zadanie 3<br><br>";

    foreach ($stmtZad3 as $rowZad3) {
        echo $rowZad3['id'] . " " . $rowZad3['marka'] . " ". $rowZad3['model']. " ". $rowZad3['rocznik'] . " " . $rowZad3['kolor'] . " " . $rowZad3['stan'] . "<br>";
    }
    echo "<br>";

    $stmtZad4 = $pdo->query("SELECT * FROM uzytkownik where nazwisko like 'k%'");
    echo "Zadanie 4<br><br>";

    foreach ($stmtZad4 as $rowZad4) {
        echo $rowZad4['id'] . " " . $rowZad4['imie'] . " ". $rowZad4['nazwisko']. " ". $rowZad4['telefon'] . " " . $rowZad4['email'] . "<br>";
    }
    echo "<br>";

    $stmtZad5 = $pdo->query("SELECT * FROM samochody  ORDER BY rocznik ASC");
    echo "Zadanie 5<br><br>";

    foreach ($stmtZad5 as $rowZad5) {
        echo $rowZad5['id'] . " " . $rowZad5['marka'] . " ". $rowZad5['model']. " ". $rowZad5['rocznik'] . " " . $rowZad5['kolor'] . " " . $rowZad5['stan'] . "<br>";
    }
    echo "<br>";
    echo "Zadanie 6<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='number' name='rybka' id='rybka'> </input> <br><br>";
    echo "<input type='submit' name='submit' value='Wyświetl dane o rybce'> </input> <br><br>";
    echo "</form>";

    $stmtZad6 = $stmtZad5;

    if (isset($_POST["submit"]) && $_POST["rybka"] != '')
    {
        $stmtZad6 = $pdo->prepare("SELECT * FROM ryby WHERE id = :rybka_id;" );
        $stmtZad6 -> bindValue(':rybka_id', $_POST['rybka'], PDO::PARAM_INT);
        $stmtZad6->execute();
    }


    foreach ($stmtZad6 as $rowZad6) {
        echo $rowZad6['id'] . " " . $rowZad6['nazwa'] . " " . $rowZad6['wystepowanie'] . " " . $rowZad6['styl_zycia'] . "<br>";
    }
    echo "<br>";


    echo "Zadanie 7<br><br>";

    echo "<form action='index.php' method='get'>";
    echo "<input type='text' name='woj' id='woj'> </input> <br><br>";
    echo "<input type='submit' name='submit7' value='Wyświetl dane o lowisku'> </input> <br><br>";
    echo "</form>";

    $stmtZad7 = $stmtZad6;

    if (isset($_GET["submit7"]) && $_GET["woj"] != '')
    {
        $stmtZad7 = $pdo->prepare("SELECT * FROM lowisko WHERE wojewodztwo like :woj" );
        $stmtZad7 -> bindValue(':woj', '%'.$_GET['woj'].'%', PDO::PARAM_STR);
        $stmtZad7->execute();
    }


    foreach ($stmtZad7 as $rowZad7) {
        echo $rowZad7['id'] . " " . $rowZad7['Ryby_id'] . " " . $rowZad7['akwen'] . " " . $rowZad7['wojewodztwo'] . " " . $rowZad7['rodzaj'] . "<br>";
    }
    echo "<br>";


    echo "Zadanie 8<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='text' name='rocznik' id='rocznik'> </input> <br><br>";
    echo "<input type='submit' name='submit8' value='Wyświetl dane o samochodzie'> </input> <br><br>";
    echo "</form>";

    $stmtZad8 = $stmtZad7;

    if (isset($_POST["submit8"]) && $_POST["rocznik"] != '')
    {
        $stmtZad8 = $pdo->prepare("SELECT * FROM samochody WHERE rocznik < :rok" );
        $stmtZad8 -> bindValue(':rok', $_POST['rocznik'], PDO::PARAM_INT);
        $stmtZad8->execute();
    }


    foreach ($stmtZad8 as $rowZad8) {
        echo $rowZad8['id'] . " " . $rowZad8['marka'] . " ". $rowZad8['model']. " ". $rowZad8['rocznik'] . " " . $rowZad8['kolor'] . " " . $rowZad8['stan'] . "<br>";
    }
    echo "<br>";



    echo "Zadanie 9<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='text' name='email' id='email'> </input> <br><br>";
    echo "<input type='submit' name='submit9' value='Wyświetl dane o uzytkowniku'> </input> <br><br>";
    echo "</form>";

    $stmtZad9 = $stmtZad8;

    if (isset($_POST["submit9"]) && $_POST["email"] != '')
    {
        $stmtZad9 = $pdo->prepare("SELECT * FROM uzytkownik WHERE email like :mail" );
        $stmtZad9 -> bindValue(':mail', '%'.$_POST['email'].'%', PDO::PARAM_STR);
        $stmtZad9->execute();
    }


    foreach ($stmtZad9 as $rowZad9) {
        echo $rowZad9['id'] . " " . $rowZad9['imie'] . " ". $rowZad9['nazwisko']. " ". $rowZad9['telefon'] . " " . $rowZad9['email'] . "<br>";
    }
    echo "<br>";



    echo "Zadanie 10<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='text' name='ryby'> </input> <br><br>";
    echo "<input type='submit' name='submit10' value='Wyświetl dane o uzytkowniku'> </input> <br><br>";
    echo "</form>";

    $stmtZad10 = $stmtZad9;

    if (isset($_POST["submit10"]) && $_POST["ryby"] != '')
    {
        $stmtZad10 = $pdo->prepare("SELECT * FROM ryby WHERE nazwa like :naz" );
        $stmtZad10 -> bindValue(':naz', '%'.$_POST['ryby'].'%', PDO::PARAM_STR);
        $stmtZad10->execute();
    }


    foreach ($stmtZad10 as $rowZad10) {
        echo $rowZad10['id'] . " " . $rowZad10['nazwa'] . " ". $rowZad10['wystepowanie']. " ". $rowZad10['styl_zycia'] . "<br>";
    }
    echo "<br>";





    echo "Zadanie 11<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='text' name='imie' placeholder='imie'>  <br><br>";
    echo "<input type='text' name='nazwisko' placeholder='naziwisko'>  <br><br>";
    echo "<input type='number' name='telefon' placeholder='telefon'>  <br><br>";
    echo "<input type='text' name='email' placeholder='email'> <br><br>";
    echo "<input type='submit' name='submit11' value='Wyświetl dane o uzytkowniku'> <br><br>";
    echo "</form>";

    $stmtZad11 = $stmtZad10;

    if (isset($_POST["submit11"]) && $_POST["imie"] && $_POST['nazwisko'] && $_POST['telefon'] && $_POST['email'] != '')
    {
        $stmtZad11 = $pdo->prepare("INSERT INTO uzytkownik (imie, nazwisko, telefon, email) VALUES (:imie, :nazwisko, :telefon, :email)" );
        $stmtZad11 -> bindValue(':imie', $_POST['imie'], PDO::PARAM_STR);
        $stmtZad11 -> bindValue(':nazwisko', $_POST['nazwisko'], PDO::PARAM_STR);
        $stmtZad11 -> bindValue(':telefon', $_POST['telefon'], PDO::PARAM_INT);
        $stmtZad11 -> bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmtZad11->execute();
    }

    echo "<br>";



    echo "Zadanie 12<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='text' name='id' placeholder='id uzytkownika'>  <br><br>";
    echo "<input type='text' name='numer' placeholder='aktualizowany numer'>  <br><br>";
    echo "<input type='submit' name='submit12' value='zaktualizuj numer uzytkownika'> <br><br>";
    echo "</form>";

    $stmtZad12 = $stmtZad11;

    if (isset($_POST["submit12"]) && $_POST["id"] && $_POST['numer'] != '')
    {
        $stmtZad12 = $pdo->prepare("UPDATE uzytkownik SET telefon = :numer where id = :id" );
        $stmtZad12 -> bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmtZad12 -> bindValue(':numer', $_POST['numer'], PDO::PARAM_INT);
        $stmtZad12->execute();
    }

    echo "<br>";




    echo "Zadanie 13<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='text' name='id' placeholder='id samochodu'>  <br><br>";
    echo "<input type='submit' name='submit13' value='usun samodchod'> <br><br>";
    echo "</form>";

    $stmtZad13 = $stmtZad12;

    if (isset($_POST["submit13"]) && $_POST["id"] != '')
    {
        $stmtZad13 = $pdo->prepare("DELETE FROM samochody WHERE id = :id" );
        $stmtZad13 -> bindValue(':id', $_POST['id'], PDO::PARAM_INT);;
        $stmtZad13->execute();
    }

    echo "<br>";




    echo "Zadanie 14<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='number' name='samochod' placeholder='id samochodu'>  <br><br>";
    echo "<input type='text' name='klient' placeholder='imie i nazwisko klienta'>  <br><br>";
    echo "<input type='number' name='telefon' placeholder='telefon klienta'>  <br><br>";
    echo "<input type='text' name='data' placeholder='data zamowienia'> <br><br>";
    echo "<input type='submit' name='submit14' value='dodaj zamowienie'> <br><br>";
    echo "</form>";

    $stmtZad14 = $stmtZad13;

    if (isset($_POST["submit14"]) && $_POST["samochod"] && $_POST['klient'] && $_POST['telefon'] && $_POST['data'] != '')
    {
        $stmtZad14 = $pdo->prepare("INSERT INTO zamowienia (Samochody_id, Klient, telefon, dataZam) VALUES (:id, :klient, :telefon, :data)" );
        $stmtZad14 -> bindValue(':id', $_POST['samochod'], PDO::PARAM_INT);;
        $stmtZad14 -> bindValue(':klient', '"'.$_POST['klient'].'"', PDO::PARAM_STR);
        $stmtZad14 -> bindValue(':telefon', $_POST['telefon'], PDO::PARAM_INT);
        $stmtZad14 -> bindValue(':data', $_POST['data'], PDO::PARAM_STR);
        $stmtZad14->execute();
    }
// sa cudzyslowy w kliencie ale szczerze? mam wyjebane jak usune to, to pewnie wszytko sie wywali na zbity pysk
// za duzo juz zrobilem jeszcze sie przemecze a zaraz obiadek wleci
    echo "<br>";





} catch (PDOException $e) {
    echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    exit();
}
?>


</body>
</html>