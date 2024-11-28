<?php
session_start(); 
include_once '../../../backend/classes/Premios/ArmazenarPremios.php';



$PremioID = $_GET['id'];


    $ArmazenarPremios = new ArmazenarPremiosMYSQL();
  $alterar = $ArmazenarPremios->atualizarPremios($PremioID, $_POST['premio'], $_POST['tipo'], $_POST['valor_desconto'], $_POST['premio_qnt']);
  
    echo "erro: valor do Prêmio invalido";
$_SESSION['mensagem'] = "Informações alteradas com sucesso!";

header('Location: ../../../html/adm/editar_premios.php');
exit();



?>

