<?php
require_once 'ArmazenarAgendamento.php';
$armazenarAgendamento = new ArmazenarAgendamentoMYSQL();
$data = isset($_GET['data']) ? $_GET['data'] : null;

if ($data) {
    $duracoes = $armazenarAgendamento->obterDuracaoAgendamentos($data);
    echo json_encode($duracoes);
}
?>
