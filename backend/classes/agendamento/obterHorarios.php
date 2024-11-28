<?php
require_once 'ArmazenarAgendamento.php'; // Inclua sua classe

$data = isset($_GET['data']) ? $_GET['data'] : null;

if ($data) {
    $ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL();
    $horariosOcupados = $ArmazenarAgendamento->ListarHorariosOcupados($data);
    // var_dump($horariosOcupados);

    // Retorne como JSON
    echo json_encode($horariosOcupados);
}
?>
