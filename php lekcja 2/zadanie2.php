<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie2</title>
</head>
<body>
<?php
$x= 3;
$y= 4;
$z= 5;
if ($x*$x+$y*$y==$z*$z || $x*$x+$z*$z==$y*$y || $y*$y+$z*$z==$x*$x)
{
    echo "trojkąt jest pitagorejski";
}
else
{
    echo "trójkąt nie jest pitagorejski";
}
?>
</body>
</html>