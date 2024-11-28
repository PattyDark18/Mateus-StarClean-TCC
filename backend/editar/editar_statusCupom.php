<?php

session_start();
include_once '../../backend/classes/Cupom/ArmazenarCupom.php';


$ArmazenarCupom = new ArmazenarCupomMYSQL(); // Adicione esta linha

$CupomID = $_GET['id'];
$status = $_GET['status'];

$alterar = $ArmazenarCupom->alterarStatus($CupomID, $status); // Certifique-se de que alterarstatus existe e está correto



if ($status == 0) {
    $_SESSION['mensagem'] = "Cupom desativado.";
}else{
    $_SESSION['mensagem'] = "Cupom ativado";
}

header('Location: ../../html/adm/editar_cupons.php');
exit();

?>