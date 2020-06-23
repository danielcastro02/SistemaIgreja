<!DOCTYPE html>
<?php
if (isset($_SESSION['logado'])) {
    header('location: ../Tela/home.php');
}
?>

<html>
    <head style="padding-left: 0">
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Base/header.php';
        ?>
    <body class="homeimg" style="padding-left: 0">
        <nav class="nav-extended">
            <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
                <a href="<?php echo $pontos; ?>./Tela/home.php" class="brand-logo left">Bem Vindo</a>
            </div>
        </nav>
        <main style="padding-left: 0">
            <div class="row" style="margin-top: 15vh;">
                <form action="../Controle/usuariosControle.php?function=login" class="card col l6 offset-l3 m8 offset-m2 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Faça Login</h4>
                        <div class="input-field col s10 offset-s1">
                            <input type="text" name="usuario">
                            <label>Usuario</label>
                        </div>
                        <div class="input-field col s10 offset-s1">
                            <input type="password" name="senha">
                            <label>Senha</label>
                        </div>
                    </div>
                    <div class="row center">
                        <input type="submit" class="btn corPadrao2" value="Login">
                        <?php
                        if (isset($_GET['msg'])) {
                            if ($_GET['msg'] == "erro") {
                                echo "LOGIN OU SENHA INCORRETOS!";
                            }
                        }
                        ?>
                    </div>

                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

