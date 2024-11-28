<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();

// Inclua o arquivo com a definição da classe
require_once '../../../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../../../backend/classes/Agendamento/ArmazenarAgendamento.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location:../../forms/login.php');
    exit();
} else {
    $logado = true;

    $user_id = $_SESSION['ID'];
    $ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
    $usuario = $ArmazenarUsuario->buscarUsuario($user_id);
    
    // Defina as variáveis com base nas informações do usuário
    $Nome = $usuario['Nome'];
    $Sobrenome = $usuario['Sobrenome'];
    $Telefone = $usuario['Telefone'];
    $Email = $usuario['Email'];
    $CEP = $usuario['cep'];
    $Rua = $usuario['rua'];
    $Numero = $usuario['numero'];
    $Bairro = $usuario['bairro'];
    $Cidade = $usuario['cidade'];
    $Estado = $usuario['estado'];
}


// Assumindo que o ID do agendamento foi salvo na sessão após o cadastro.
$AgendamentoID = $_GET['AgendamentoID']; // ou como você estiver armazenando

$ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL();
$agendamento = $ArmazenarAgendamento->buscarAgendamento($AgendamentoID);

// Captura os detalhes do agendamento
$Servico_Principal = $agendamento['Servico_Principal'];
$Dia = $agendamento['Dia'];
$Horario = $agendamento['Horario'];
$Local = $agendamento['Local'];



$ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL();
$Status = isset($_POST['Status']) ? $_POST['Status'] : null;
$Agendamento = $ArmazenarAgendamento->listarAgendamentoDoUsuario($user_id);
$AgendamentoComEndereco = $ArmazenarAgendamento->listarAgendamentoComEndereco($user_id);
$AgendamentoComNomeDoServico = $ArmazenarAgendamento->listarAgendamentosComNomeDoServico($user_id);



$agendamentosComEndereco = [];
while ($row = $AgendamentoComEndereco->fetch_assoc()) {
    $agendamentosComEndereco[$row['AgendamentoID']] = $row['endereco_servico'];
}

$agendamentosComNomeDoServico = [];
while ($row = $AgendamentoComNomeDoServico->fetch_assoc()) {
    $agendamentosComNomeDoServico[] = $row;
}

// Agora combinar os dados
foreach ($agendamentosComNomeDoServico as &$agendamento) {
    // Verificar se o AgendamentoID existe no array de endereços
    $agendamento['endereco_servico'] = $agendamentosComEndereco[$agendamento['AgendamentoID']] ?? 'Não disponível';
}




?>






<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../css/preset/reset.css">
    <link rel="stylesheet" href="../../../css/fonts.css">
    <link rel="stylesheet" href="../../../css/preset/vars.css">
    <link rel="stylesheet" href="../../../css/preset/modal.css">
    <link rel="stylesheet" href="../../../css/preset/bases/base-form.css">
    <link rel="stylesheet" href="../../../css/form-style/agradecimento.css">
    <title>Agradecimento</title>


    
</head>
<body>



<div class="container">
<div class="background-image"></div>
<div class="content">
<h1>Serviço agendado com sucesso!</h1>
<h2>Agradecemos pela prefêrencia, <?php echo $Nome ?> !</h2>
<h3>em caso de dúvidas, entre em contato com <a href="mailto:@mateus.starclean@gmail.com"> @mateus.starclean@gmail.com </a> ou  <a href="https://wa.me/5511982491185" target="_blank">clique aqui</a> para enviar uma mensagem para nosso WhatsApp .</h3>


<div class="informacoes-agendamento">
    <div class="lista-informacoes">
        <ul>
            <li><b>Serviço Principal:</b> <?php echo  $agendamento['nome_servico_principal']; ?></li>
            <li><b>Serviço(s) adicional(is):</b>
            <div class="servicios-adicionais"></div>
            </li>
            <li><b>data: </b> <?php echo $Dia ?></li>
            <li><b>hora:</b><?php echo $Horario ?></li>
            <li><b>local: </b>
        <?php if($Local == 1){ ?>
        Rua ângela Lessi Larrubia, Vila Tavares, 62, Campo Limpo Paulista, SP - 13230077 
    <?php }else echo $agendamento['endereco_servico']; ?>
        </li>
        </ul>
    </div>
</div>




<div class="btn-container">
            <button class="btn-voltar"><a href="../../home.php">Voltar ao Início</a></button>
        </div>
<div class="btn-container">
            <button class="btn-voltar"><a href="../../meus_agendamentos.php">Ver seus agendamentos</a></button>
        </div>


<div class="footer">
            <div class="footer-grid">
                <div class="footer-column">
                    <i><img class="logo" src="../../../src/img/logo/logo.png " alt="" srcset=""></i>
                </div>
         <div class="footer-column">
      <a href="https://www.instagram.com/mateuscar_oficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
        <i class="fab fa-instagram instagram-icon"></i>
      </a>
    </div>
    
    <div class="footer-column">
      <a href="https://youtube.com/@mateuscar?feature=shared" target="_blank">
        <i class="fab fa-youtube youtube-icon"></i>
      </a>
    </div>
    
    <div class="footer-column">
        <a href="https://wa.me/5511982491185" target="_blank">
            <i class="fab fa-whatsapp whatsapp-icon"></i>
        </a>
    </div>
    
      <div class="footer-column">
        <a href="mailto:mateus_StarClean@gmail.com">
          <i class="fas fa-envelope email-icon"></i>
          </a>
      
        </div>
        <div class="footer-column">
          <a href="https://maps.app.goo.gl/hVR7QxxeoczKUuWg6" target="_blank">
          <i class="fas fa-map-marker-alt location-icon"></i>
          </a>
         
        </div>



            </div>
        </div>
</div>
</div>



        

<script>

  const agendamentoID = <?php echo $AgendamentoID; ?>;

  fetch(`../../../backend/classes/agendamento/Servicos_adicionais.php?id=${agendamentoID}`)
    .then(response => response.text())
    .then(html => {
      const serviciosAdicionaisElement = document.querySelector('.servicios-adicionais');
      serviciosAdicionaisElement.innerHTML = html;
    })
    .catch(error => console.error('Erro ao carregar serviços adicionais:', error));
</script>

</script>
</body>
</html>


