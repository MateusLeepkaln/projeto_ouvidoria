<?php

$host = "localhost";
$user = "root";
$pass = "usbw";
$dbname = "usuario";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Falha ao realizar conexao com o BD: ". mysqli_connect_error());
}