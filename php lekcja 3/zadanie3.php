<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie3</title>
</head>
<body>
<?php
$a=3;
$b=4;
$c=5;
function pitagoras($a, $b, $c)
{
    if ($a * $a + $b * $b == $c * $c )
    {
        return "trójkąt jest pitagorejski";
        function pole($a, $b)
        {
            $z = 0.5 * $a * $b;
            return "pole: $z" ;
        }
        {

        }
    } else {
        return "trójkąt nie jest pitagorejski";
    }
}
echo pitagoras($a, $b, $c);
?>
</body>
</html>
