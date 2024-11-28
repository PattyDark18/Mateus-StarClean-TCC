<?php
session_start();
include_once '../../classes/usuarios/ArmazenarUsuario.php';
include_once '../../classes/usuarios/ArmazenarToken.php';

if (isset($_GET['token']) && isset($_GET['user_id'])) {
    $token = $_GET['token'];
    $user_id = $_GET['user_id'];


    $ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
    $ArmazenarToken = new ArmazenarTokenMYSQL();
    if ($ArmazenarToken->validarToken($token, $user_id)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $novaSenha = $_POST['nova_senha'];
            $ArmazenarUsuario->atualizarSenha($user_id, $novaSenha);
            $_SESSION['mensagem'] = 'Senha redefinida com sucesso!';
            header('Location: ../../../html/forms/login.php');
        } else {
            ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../css/preset/reset.css">
    <link rel="stylesheet" href="../../../css/fonts.css">
    <link rel="stylesheet" href="../../../css/preset/vars.css">
    <link rel="stylesheet" href="../../../css/preset/modals.css">
    <link rel="stylesheet" href="../../../css/preset/bases/base-form.css">
    <link rel="stylesheet" href="../../../css/form-style/esqueci_senha.css">
    <!-- <link rel="stylesheet" href="../../css/responsivo.css"> -->
    <title>Esqueci minha Senha</title>
</head>
<body>

<div class="container">
<button class="return"><a href="../../../html/forms/login.php"><i class="fas fa-arrow-left"></i></a></button>
<div class="form-wrapper">
<div class="form-container">
<form class="form" action="" method="post">
            <label for="nova_senha">Digite sua Nova Senha:</label>
            <div class="password-container">
            <input type="password" id="nova_senha" name="nova_senha" placeholder="digite sua nova senha" required>
            <input type="submit" value="Redefinir senha">
            <span id="togglePassword" class="fa fa-fw fa-eye"></span>
            </div>
        </form>
        </div>
        </div>
</div>
        <script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const password = document.getElementById('nova_senha'); // Alterei para 'nova_senha'
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});

</script>

            <?php
        }
    } else {
        echo 'Token inválido.';
    }
}
?>