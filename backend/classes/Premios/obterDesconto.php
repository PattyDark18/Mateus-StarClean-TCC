<?php
require_once 'ArmazenarPremios.php';

$premioID = $_GET['premio'];

$armazenarPremios = new ArmazenarPremiosMYSQL();

// Verifique se o ID do prêmio é válido
if (!is_numeric($premioID) || $premioID <= 0) {
    echo json_encode(['error' => 'ID do prêmio inválido.']);
    exit();
}

$valorDesconto = $armazenarPremios->BuscarValor_desconto($premioID);

echo json_encode(['valor_desconto' => $valorDesconto]);
?>