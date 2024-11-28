<?php

include_once '../../classes/Premios/ArmazenarPremios.php';
include_once '../../classes/Premios/ClassPremios.php';

$Valor_Pontos = $_POST['premio_qnt'] ?? null;
echo "Valor de Pontos: " . $Valor_Pontos . "<br>"; // Verifique o valor de pontos

if (empty($_POST['premio'])) {
    $_SESSION['mensagem'] = "O campo prêmio não pode estar vazio.";
    header('Location:../../../html/adm/editar_premios.php');
    exit;
}

$ArmazenarPremios = new ArmazenarPremiosMYSQL();
$NovoPremio = new Premios('', $_POST['premio'], 1, $_POST['tipo'], $_POST['valor_desconto'], $Valor_Pontos);
$ArmazenarPremios->cadastrarPremios($NovoPremio);

header('Location:../../../html/adm/editar_premios.php');
exit;

?>