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

    $stmt = $pdo->query("SELECT * FROM ryby");
    echo "Zadanie 1<br><br>";

    foreach ($stmt as $row) {
        echo $row['id'] . " " . $row['nazwa'] . " " . $row['wystepowanie'] . " " . $row['styl_zycia'] . "<br>";
    }
    echo "<br>";

    $stmt = $pdo->query("SELECT nazwa, styl_zycia FROM ryby");
    echo "Zadanie 2<br><br>";

    foreach ($stmt as $row) {
        echo $row['nazwa'] . " " . $row['styl_zycia'] . "<br>";
    }
    echo "<br>";

    $stmt = $pdo->query("SELECT * FROM samochody where kolor like 'czerwony'");
    echo "Zadanie 3<br><br>";

    foreach ($stmt as $row) {
        echo $row['id'] . " " . $row['marka'] . " ". $row['model']. " ". $row['rocznik'] . " " . $row['kolor'] . " " . $row['stan'] . "<br>";
    }
    echo "<br>";

    $stmt = $pdo->query("SELECT * FROM uzytkownik where nazwisko like 'k%'");
    echo "Zadanie 4<br><br>";

    foreach ($stmt as $row) {
        echo $row['id'] . " " . $row['imie'] . " ". $row['nazwisko']. " ". $row['telefon'] . " " . $row['email'] . "<br>";
    }
    echo "<br>";

    $stmt = $pdo->query("SELECT * FROM samochody  ORDER BY rocznik ASC");
    echo "Zadanie 5<br><br>";

    foreach ($stmt as $row) {
        echo $row['id'] . " " . $row['marka'] . " ". $row['model']. " ". $row['rocznik'] . " " . $row['kolor'] . " " . $row['stan'] . "<br>";
    }
    echo "<br>";
    echo "Zadanie 6<br><br>";

    echo "<form action='index.php' method='post'>";
    echo "<input type='number' name='rybka' id='rybka'> </input> <br><br>";
    echo "<input type='submit' name='submit' value='Wyświetl dane o rybce'> </input>; <br><br>";
    echo "</form>";

    if (isset($_POST["submit"]) && $_POST["rybka"] != '')
    {
        $stmt = $pdo->prepare("SELECT * FROM ryby WHERE id = :rybka_id;" );
        $stmt -> bindValue(':rybka_id', $_POST['rybka'], PDO::PARAM_INT);
        $stmt->execute();
    }


    foreach ($stmt as $row) {
        echo $row['id'] . " " . $row['nazwa'] . " " . $row['wystepowanie'] . " " . $row['styl_zycia'] . "<br>";
    }
    echo "<br>";


    echo "Zadanie 7<br><br>";
    echo "nie wiem nie chce dzialac, nie chce mi sie <br>";

    echo "<form action='index.php' method='get'>";
    echo "<input type='text' name='woj' id='woj'> </input> <br><br>";
    echo "<input type='submit' name='submit' value='Wyświetl dane o lowisku'> </input>; <br><br>";
    echo "</form>";

    if (isset($_GET["submit"]) && $_GET["woj"] != '')
    {
        $stmt = $pdo->prepare("SELECT * FROM lowisko WHERE wojewodztwo like :woj" );
        $stmt -> bindValue(':woj', $_GET['woj'], PDO::PARAM_INT);
        $stmt->execute();
    }


    foreach ($stmt as $row) {
        echo $row['id'] . " " . $row['Ryby_id'] . " " . $row['akwen'] . " " . $row['wojewodztwo'] . " " . $row['rodzaj'] . "<br>";
    }
    echo "<br>";




} catch (PDOException $e) {
    echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    exit();
}
?>
