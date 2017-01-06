<?php
session_start();
if (isset($_POST['registro'])) {
    header("Location: registro.php");
}

if (isset($_POST['login'])) {
    if (isset($_SESSION) && isset($_POST) && array_key_exists('CAPTCHA', $_SESSION)
        && array_key_exists('valor', $_POST) && ($_SESSION['CAPTCHA'] === $_POST['valor'])) {
        include ("includes/abrirbd.php");
        $sql = "SELECT * FROM usuarios WHERE user ='{$_POST['user']}'";
        $resultado = mysqli_query($link, $sql);

        if (mysqli_num_rows($resultado) == 1) {
            $usuario = mysqli_fetch_assoc($resultado);
            $hash = hash("sha256", $_POST['passwd'] . $usuario['salt'], false);
            $validUser = ($hash === $usuario['password']);

            if ($validUser) {
                $_SESSION['autenticado'] = 'correcto';
                $_SESSION['permisos'] = str_split($usuario['permisos']);
                $_SESSION['user'] = $usuario['user'];
                header("Location:MasterWeb.php");
            } else {
                $_SESSION['autenticado'] = 'incorrecto';
                header("Location: NoAuth.php");
            }
        } else {
            $_SESSION['autenticado'] = 'incorrecto';
            header("Location: NoAuth.php");
        }

        mysqli_close($link);
    }
    else {
        $_SESSION['autenticado'] = 'incorrecto';
        header("Location: login.php");
    }
} else {
    ?>
    <html>
        <head>
            <title> Login </title>
            <meta charset="UTF-8">
        </head>
        <body>
            <br><br><br>
        <center>
            <img src="logo.png" width= 120 height= 60>
            <br><br><br>
            <form action= '<?php "{$_SERVER['PHP_SELF']}" ?>' method = post>
                <input type=submit name = 'registro' value = "REGISTRAR USUARIO"> <br><br><br>
                <table bgcolor = 'lightgrey'> 
                    <tr>
                        <td width= 100> Usuario: </td> 
                        <td> <input type = text name ='user'></td>
                    </tr>
                    <tr>
                        <td width= 100> Password: </td> 
                        <td> <input type = password name ='passwd'></td>
                    </tr>
                </table><br>
                <img src= captcha.php>
                <input type= text name= 'valor'> <br><br><br>
                <input type=submit name = 'login' value = "LOGIN"><br><br><br>
            </form>
            <a href =logincert.php> autenticación con certificado </a>
        </center>
    </body>
    </html>
    <?php
}
?>
    