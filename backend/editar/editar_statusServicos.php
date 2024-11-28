<?php
session_start();
include_once '../../backend/classes/Servicos/ArmazenarServicos.php';


$ArmazenarServicos = new ArmazenarServicoMYSQL(); // Adicione esta linha

$ServicoID = $_GET['id'];
$status = $_GET['status'];

$alterar = $ArmazenarServicos->alterarStatus($ServicoID, $status); // Certifique-se de que alterarstatus existe e está correto


if ($status == 0) {
    $_SESSION['mensagem'] = "Serviço desativado.";
}else{
    $_SESSION['mensagem'] = "Serviço ativado";
}
header('Location: ../../html/adm/editar_servicos.php');
exit();

?>