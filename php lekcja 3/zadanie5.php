<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie5</title>
</head>
<body>
<?php
$tekst="kto pod kim dołki kopie, ten sam w nie wpada";
echo $tekst . "<br>";
if (strpos($tekst,"kto") !== false)
{
    echo "jest kto";
} else {
    echo "nie ma kto";
}
?>
</body>
</html>
