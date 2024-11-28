<?php
session_start();
require '../../../vendor/autoload.php'; // Carrega o autoload gerado pelo Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once '../../classes/usuarios/ArmazenarUsuario.php';
include_once '../../classes/usuarios/ClassUsuario.php';
include_once '../../classes/usuarios/ArmazenarToken.php';

// Gerencia a mensagem de sessão
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
} else {
    $mensagem = '';
}

// Inclui a classe para armazenar o usuário
$ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
$ArmazenarToken = new ArmazenarTokenMYSQL();

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    // $user = $ArmazenarUsuario->pegarIDPeloEmail($email);
    $UsuarioDestinatario = $ArmazenarUsuario->pegarUsuarioPeloEmail($email);
    
    if ($UsuarioDestinatario) {
        $user_email = $UsuarioDestinatario['Email'];
        echo 'Enviando e-mail para: ' . $user_email;
        
        $token = uniqid();
        $ArmazenarToken->armazenarToken($UsuarioDestinatario['ID'], $token);

        $assunto = 'Redefinir Senha - Mateus StarClean';
        $corpo = '
        Olá, ' . $UsuarioDestinatario['Nome'] . '! 
        Se você solicitou redefinição de senha, clique no link abaixo para continuar o processo. Caso contrário, ignore este e-mail.

        Clique no link para redefinir sua senha: <a href="http://localhost/Mateus_StarCleanOficial/backend/editar/usuario-senha/reset_password_token.php?token=' . $token . '&user_id=' . $UsuarioDestinatario['ID'] . '">Redefinir senha</a>
        
        Copyright © 2024 Mateus StarClean. Todos os direitos reservados.
        ';
        $corpo = nl2br($corpo); // converte quebras de linha em tags <br>
        // Configurações do SMTP
        $smtp_host = 'smtp.gmail.com';
        $smtp_port = 587;
        $smtp_username = 'carmateus966@gmail.com'; // Substitua pelo seu e-mail
        $smtp_password = 'bfgh uzte bagc qsrh'; // Substitua pela sua senha

        // Cria uma nova instância do PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = 'tls';
            $mail->Port = $smtp_port;

            $mail->setFrom($smtp_username, 'Mateus StarClean');
            $mail->addAddress($user_email);
            $mail->Subject = $assunto;
            $mail->Body = $corpo;
            $mail->isHTML(true); // Permite que o corpo do e-mail seja HTML

            $mail->send();
            echo 'E-mail enviado com sucesso!';
        } catch (Exception $e) {
            echo 'Erro ao enviar e-mail: ', $e->getMessage();
        }
    } else {
        $_SESSION['mensagem'] = 'Usuário não encontrado.';
        header('Location: ../../../html/forms/esqueci-senha.php');
    }
}

if (isset($_GET['token']) && isset($_GET['user_id'])) {
    $token = $_GET['token'];
    $user_id = $_GET['user_id'];

    if ($ArmazenarToken->validarToken($token, $user_id)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $novaSenha = $_POST['nova_senha'];
            $ArmazenarUsuario->atualizarSenha($user_id, $novaSenha);
              $_SESSION['mensagem'] = 'Senha redefinida com sucesso.';
              header('Location: ../../../html/forms/login.php');
        } else {

            header('Location: reset_password_token.php?token=' . $token . '&user_id=' . $UsuarioDestinatario['ID']);
            
        }
    } else {
        echo 'Token inválido.';
    }
}
?>

