<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie4</title>
</head>
<body>
<?php
$i=1;
while ($i = 100)
{
    if ($i % 2 != 0 && $i % 3 == 0)
    {
        echo $i . "<br>";
    }
    $i++;
}
?>
</body>
</html>