<?php

session_start();

if (isset($_SERVER) && is_array($_SERVER) && array_key_exists('SSL_CLIENT_S_DN_CN', $_SERVER)
    && is_string($_SERVER['SSL_CLIENT_S_DN_CN']) && (strlen($_SERVER['SSL_CLIENT_S_DN_CN']) > 0)) {
    include ("includes/abrirbd.php");

    $query  = "SELECT * FROM usuarios WHERE user ='{$_SERVER['SSL_CLIENT_S_DN_CN']}'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $user                       = mysqli_fetch_assoc($result);
        $_SESSION['autenticado']    = 'correcto';
        $_SESSION['permisos']       = str_split($user['permisos']);
        $_SESSION['user']           = $user['user'];

        header("Location:MasterWeb.php");
    } else {
        $_SESSION['autenticado'] = 'incorrecto';
        header("Location: NoAuth.php");
    }

    mysqli_close($link);
}
else {
    $_SESSION['autenticado'] = 'incorrecto';
    header("Location: NoAuth.php");
}