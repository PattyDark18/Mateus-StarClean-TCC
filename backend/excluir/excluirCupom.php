<?php
session_start();
include_once '../../backend/classes/Cupom/ArmazenarCupom.php';


$ArmazenarCupom = new ArmazenarCupomMYSQL(); // Adicione esta linha

$CupomID = $_GET['id'];

$excluir = $ArmazenarCupom->removerCupom($CupomID); // Certifique-se de que alterarstatus existe e está correto

$_SESSION['mensagem'] = "Cupom excluído.";
header('Location: ../../html/adm/editar_cupons.php');
exit();

?>