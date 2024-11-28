<?php

session_start();
include_once '../classes/agendamento/ArmazenarAgendamento.php';
include_once '../classes/agendamento/ClassAgendamento.php';
include_once '../classes/usuarios/ArmazenarUsuario.php';
include_once '../classes/usuarios/ClassUsuario.php';
include_once '../classes/Servicos/ArmazenarServicos.php';
include_once '../classes/Servicos/ClassServicos.php';
include_once '../classes/Premios/ArmazenarPremios.php';
include_once '../classes/Premios/ClassPremios.php';



$user_id = $_SESSION['ID'];
$servicoID = $_POST['servico'];
$servicos_adicionais = isset($_POST['servicos_adicionais']) ? $_POST['servicos_adicionais'] : [];
$armazenarAgendamento = new ArmazenarAgendamentoMYSQL();

$armazenarServico = new ArmazenarServicoMYSQL();
$servico = $armazenarServico->buscarServico($servicoID);
$servico = $servico->fetch_object(); 
$duracao_total = $servico->duracao;

if (!empty($servicos_adicionais)) {
    foreach ($servicos_adicionais as $servicoID_adicional) {
        $servico = $armazenarServico->buscarServico($servicoID_adicional);
        $servico = $servico->fetch_object(); 
        $duracao_total += $servico->duracao;
    }
}

$preco_total = 0;

// Adicionar o preço do serviço principal
$preco_principal = $armazenarServico->buscarPreco($servicoID);
$preco_total += $preco_principal;

// Adicionar o preço dos serviços adicionais
if (!empty($servicos_adicionais)) {
    foreach ($servicos_adicionais as $servicoID_adicional) {
        $preco_adicional = $armazenarServico->buscarPreco($servicoID_adicional);
        $preco_total += $preco_adicional;
    }
}
$premiosID = isset($_POST['premio']) ? $_POST['premio'] : null;// Obtém o ID do prêmio selecionado
$observacoes_adm = ""; // Inicializa as observações do administrador como vazio

if ($premiosID && $premiosID !== "Nenhum") {
    $armazenarPremios = new ArmazenarPremiosMYSQL();
    $premios = $armazenarPremios->BuscarValor_Pontos($premiosID); // Busca o valor em pontos do prêmio
    
    // Busca o valor do desconto do prêmio
    $valorDesconto = $armazenarPremios->BuscarValor_desconto($premiosID);

    // Agora obtenha os pontos do usuário e faça a subtração
    $armazenarUsuario = new ArmazenarUsuarioMYSQL();
    $pontosArray = $armazenarUsuario->buscarPontosUsuario($user_id);

    if (isset($pontosArray['Pontos'])) {
        $Pontos = $pontosArray['Pontos'];
        $pontosAtualizados = $Pontos - $premios;

        if ($pontosAtualizados < 0) {
            echo "Você não tem pontos suficientes para trocar por este prêmio.";
            exit();
        }

        // Atualiza os pontos do usuário
        $att_pontos = $armazenarUsuario->atualizarPontosUsados($user_id, $pontosAtualizados);
        
    } else {
        echo "Erro ao buscar os pontos do usuário.";
    }
}

$horario = $_POST['horario'];
$fimHorario = strtotime($horario) + ($duracao_total * 60);


// Obtém a data selecionada pelo usuário
$dataSelecionada = $_POST['data'];

// Verifica se a data selecionada é anterior à data atual
if (strtotime($dataSelecionada) < time()) {
    // Se a data selecionada for anterior, exibe uma mensagem de erro
    echo 'Você não pode selecionar uma data que já passou.';
    exit();
}


$local = $_POST['escolha']; // Aqui você captura o valor do local enviado pelo formulário

// Verifica se o local é igual a 0
if ($local == 0) {
    // Se for igual a 0, atualiza o endereço do usuário
    $armazenarUsuario = new ArmazenarUsuarioMYSQL();
    $atualizado = $armazenarUsuario->atualizarEndereco($_POST['CEP'], $_POST['Rua'], $_POST['Numero'], $_POST['Bairro'], $_POST['Cidade'], $_POST['Estado'], $user_id);

    if ($atualizado) {
        echo "Endereço atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o endereço.";
    }
}

$servicoAdicional = !empty($servicos_adicionais) ? 1 : 0;
if ($valorDesconto !== null) {
    // $preco_total = $preco_total; // Preço do serviço (inclui serviços adicionais)
    $porcentagemDesconto = ($valorDesconto / 100); // Porcentagem de desconto
    $desconto = $preco_total * $porcentagemDesconto; // Valor do desconto
    $precoComDesconto = $preco_total - $desconto; // Preço com desconto (inclui serviços adicionais)

    echo "Preço original: R$ " . number_format($preco_total, 2, ',', '.');
    echo "<br>Valor do desconto: R$ " . number_format($desconto, 2, ',', '.');
    echo "<br>Preço com desconto: R$ " . number_format($precoComDesconto, 2, ',', '.');
    
    // Cria o objeto Agendamento com o prêmio na observação
    $NovoAgendamento = new Agendamento('', $user_id, $servicoID, $_POST['data'], $_POST['horario'], $precoComDesconto, $_POST['escolha'], $servicoAdicional, $_POST['make'], $_POST['model'], $_POST['pagamento'], $_POST['observacoes'], 1, $armazenarPremios->BuscarPremio($premiosID), $duracao_total);
} else {
    // Cria o objeto Agendamento sem desconto e com observações em branco ou prêmio
    $NovoAgendamento = new Agendamento('', $user_id, $servicoID, $_POST['data'], $_POST['horario'], $preco_total, $_POST['escolha'], $servicoAdicional, $_POST['make'], $_POST['model'], $_POST['pagamento'], $_POST['observacoes'], 1, "", $duracao_total);
}

// Verifica o objeto agendamento criado


// Cadastra o agendamento
$ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL();
if ($ArmazenarAgendamento->cadastrarAgendamento($NovoAgendamento)) {
    // Pega o ID do agendamento recém-criado
    // $AgendamentoID = $this->conexao->getUltimoId();
    $agendamentoID = $ArmazenarAgendamento->getUltimoIdAgendamento();
    // Verifica se o ID do agendamento é válido
if ($agendamentoID > 0) {
        // Se houver serviços adicionais, insira-os na tabela agendamento_servicos
        if (!empty($servicos_adicionais)) {
            foreach ($servicos_adicionais as $servicoID) {
                $ArmazenarAgendamento->inserirServicoAdicional($agendamentoID, $servicoID);
            }
        
        }
            header('Location: ../../html/forms/agendamento/agradecimento.php?AgendamentoID=' . $agendamentoID);
            exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar o agendamento.";
        header('Location: ../../html/forms/agendamento/agendamento.php');
        exit();
    }
} else {
    $_SESSION['mensagem'] = "Erro ao cadastrar o agendamento.";
    header('Location: ../../html/forms/agendamento/agendamento.php');
    exit();
}



