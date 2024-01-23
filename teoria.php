<?php
echo '<h2>Sesiones y Cookies</h2>';
//https://www.php.net/manual/en/features.php
setcookie("politica", "true");
echo var_dump($_COOKIE);
if($_COOKIE['politica']=="true"){
    echo 'Has aceptado la privacidad';
}
else{
    echo 'no hay cookies';
}
session_start();
$_SESSION['busqueda']="camisa";
