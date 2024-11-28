<?php
// Inicia a sessão para manipular dados de sessão
session_start();

// Destroi todas as variáveis de sessão e encerra a sessão
session_destroy();

// Armazena a mensagem na sessão antes de destruí-la
session_start(); // Precisa reiniciar a sessão para armazenar a mensagem
$_SESSION['mensagem'] = 'Usuário desconectado';

// Redireciona o usuário para a página de login
header('Location: ../../html/forms/login.php');
exit();


?>

