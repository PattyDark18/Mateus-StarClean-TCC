<?php
session_start();

include_once '../classes/usuarios/ArmazenarUsuario.php';

$ArmazenarUsuario = new ArmazenarUsuarioMYSQL(); // Adicione esta linha

$id = $_GET['id'];
$tipo = $_GET['tipo'];

$alterar = $ArmazenarUsuario->alterarTipo($id, $tipo); // Certifique-se de que alterarTipo existe e está correto

$_SESSION['mensagem'] = "Tipo Alterado com Sucesso!";
header('Location: ../../html/adm/editar_usuarios.php');
exit();

?>


