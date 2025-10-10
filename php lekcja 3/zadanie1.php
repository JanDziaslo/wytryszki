<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie1</title>
</head>
<body>
<?php
function spr_pierwsza()
{
    $n = 2137;
    $licznik = 0;
    for ($i = 1; $i <= $n; $i++)
    {
        if ($n % $i == 0)
        {
            $licznik++;
        }
    }
    if ($licznik == 2)
    {
        echo "Liczba " . $n . " jest liczbą pierwszą<br>";
    }
    else
    {
        echo "Liczba " . $n . " nie jest liczbą pierwszą<br>";
    }

}
spr_pierwsza();
        
?>
</body>
</html><?php
