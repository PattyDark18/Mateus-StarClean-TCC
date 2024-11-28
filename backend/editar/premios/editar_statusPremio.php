<?php
session_start();
include_once '../../classes/Premios/ArmazenarPremios.php';


$ArmazenarPremios = new ArmazenarPremiosMYSQL(); // Adicione esta linha

$PremioID = $_GET['id'];
$status = $_GET['status'];

$alterar = $ArmazenarPremios->alterarStatus($PremioID, $status); // Certifique-se de que alterarstatus existe e está correto


if ($status == 0) {
    $_SESSION['mensagem'] = "Cupom desativado.";
}else{
    $_SESSION['mensagem'] = "Cupom ativado";
}
header('Location: ../../../html/adm/editar_premios.php');
exit();


?>
