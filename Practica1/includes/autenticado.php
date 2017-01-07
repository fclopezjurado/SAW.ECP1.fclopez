<?php

if (!(isset($_SESSION) && array_key_exists('autenticado', $_SESSION) && ($_SESSION['autenticado'] === 'correcto'))) {
    header("Location:../login.php");
    exit;
}

?>