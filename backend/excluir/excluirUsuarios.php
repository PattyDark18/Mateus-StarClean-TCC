<?php

session_start();
include_once '../../backend/classes/usuarios/ArmazenarUsuario.php';


$ArmazenarUsuarios= new ArmazenarUsuarioMYSQL(); // Adicione esta linha

$UsuarioID = $_GET['id'];

$excluir = $ArmazenarUsuarios->removerUsuario($UsuarioID); // Certifique-se de que removerServico existe e está correto


$_SESSION['mensagem'] = "Usuário excluido.";
header('Location: ../../html/adm/editar_usuarios.php');
exit();

?>