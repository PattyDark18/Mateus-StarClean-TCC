<?php
session_start();
include_once '../../../backend/classes/Premios/ArmazenarPremios.php';


$ArmazenarPremios = new ArmazenarPremiosMYSQL(); // Adicione esta linha

$PremiosID = $_GET['id'];

$excluir = $ArmazenarPremios->removerPremios($PremiosID); // Certifique-se de que removerPremios100 existe e está correto

$_SESSION['mensagem'] = "Prêmio excluído.";
header('Location: ../../../html/adm/editar_premios.php');
exit();

?>