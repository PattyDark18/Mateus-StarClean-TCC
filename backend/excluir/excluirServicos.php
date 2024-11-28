<?php
session_start();
include_once '../../backend/classes/Servicos/ArmazenarServicos.php';


$ArmazenarServicos = new ArmazenarServicoMYSQL(); // Adicione esta linha

$ServicoID = $_GET['id'];

$excluir = $ArmazenarServicos->removerServico($ServicoID); // Certifique-se de que removerServico existe e está correto

header('Location: ../../html/adm/editar_servicos.php');
$_SESSION['mensagem'] = "Serviço excluído.";
exit();

?>