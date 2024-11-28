<?php
require_once 'ArmazenarAgendamento.php'; 
$agendamentoID = $_GET['id'];

$armazenarAgendamento = new ArmazenarAgendamentoMYSQL();
$agendamento = $armazenarAgendamento->buscarAgendamento($agendamentoID);

$servicosAdicionais = $armazenarAgendamento->listarAgendamentoComServicosAdicionais($agendamentoID);
// var_dump($servicosAdicionais);
if ($servicosAdicionais) {
    $html = '<ul>';
    foreach ($servicosAdicionais as $servico) {
        $html .= '<li>' . $servico->nome_servicos . '</li>';
    }
    $html .= '</ul>';
    echo $html;
} else {
    echo 'Nenhum';
}
