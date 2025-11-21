<?php
$serwer = "100.102.15.25:13306";
$uzyt = "wytrychy_user";
$haslo = "gDxajVS2BhMiqcY8xWHU34EpjRpC489T";
$baza = "wytrychy_db";

$p = mysqli_connect("$serwer", "$uzyt", "$haslo", "$baza") or die("Problem z serwerem!");

mysqli_set_charset($p, "utf8");

$q  =  "INSERT  INTO  aktorzy  VALUES  (2137,  'Bartosz',  'Nikitiuk',  'm'  , 'Polska','2137-09-11')";

mysqli_query($p, $q);

mysqli_close($p);


?>