<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();

// Inclua o arquivo com a definição da classe
require_once '../../../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../../../backend/classes/Servicos/ArmazenarServicos.php';
require_once '../../../backend/classes/agendamento/ArmazenarAgendamento.php';
require_once '../../../backend/classes/premios/ArmazenarPremios.php';


$ArmazenarServicos = new ArmazenarServicoMYSQL();
$Servico = $ArmazenarServicos -> listarTodosServicos();

$Nome_servicos = isset($_SESSION['nome_servicos']) ? $_SESSION['nome_servicos'] : '';


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


    $Pontos_usuario = $ArmazenarUsuario->buscarPontosUsuario($user_id);
    if ($Pontos_usuario !== null) {
        $Pontos = $Pontos_usuario['Pontos'];
      }else{
          $Pontos = 0;
        }



    $data = null;
    $horariosOcupados = [];

    // Checa se a data foi enviada
    if (isset($_POST['data'])) {
        $data = $_POST['data'];
        $ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL();
        $horariosOcupados = $ArmazenarAgendamento->ListarHorariosOcupados($data);
    }

    // Transforme o array em uma string JSON
    $horariosOcupadosJson = json_encode($horariosOcupados);
}


?>




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../css/preset/reset.css">
    <link rel="stylesheet" href="../../../css/fonts.css">
    <link rel="stylesheet" href="../../../css/preset/vars.css">
    <link rel="stylesheet" href="../../../css/preset/modals.css">
    <link rel="stylesheet" href="../../../css/preset/bases/base-form.css">
    <link rel="stylesheet" href="../../../css/form-style/agendamentos.css">
    <title>Agendamento </title>
    
</head>
<body>



<div class="container">
    <div class="left-section" id="left-section">
        <button class="return"><a href="../../home.php"><i class="fas fa-arrow-left"></i></a></button>
        
        <div class="form-container active" id="form1">
            <h3>Confirme suas informações Pessoais</h3>
            <form id="agendamento-form" action="../../../backend/cadastro e login/cadastrarAgendamento.php"  method="POST">
                <label for="name">Nome </label>
                <input type="text" name="name"  id="name" value="<?php echo htmlspecialchars($Nome); ?>" placeholder="Nome" readonly>
                <label for="name">Sobrenome </label>
                <input type="text" name="sobrenome"  id="sobrenome" value="<?php echo htmlspecialchars($Sobrenome); ?>" placeholder="Sobrenome" readonly>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($Email); ?>" placeholder="E-mail" readonly>
                <label for="tel">Telefone</label>
                <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($Telefone); ?>" placeholder="Telefone" readonly>
                <h4 style="text-align:center">Tem algo a alterar? Vá para <a href="../../perfil.php">seu perfil</a></h4>
                <div class="button-container">
                <button class="NextFormButton" type="button" data-next-form="form2">Avançar</button>
                </div>
            
        </div>
        
        <div class="form-container" id="form2" style="color: black">
            <h3>Agendamento</h3>
            <label for="servico">Serviço a agendar:</label>
            <select name="servico" id="servico" required>
                <option value=""  disabled>Selecione um serviço</option>
                <?php
           $Servicos = $ArmazenarServicos->listarTodosServicos();
           if ($Servicos) {
               while ($linhas = $Servicos->fetch_object()) {
                   ?>
                       <option value="<?php echo $linhas->ServicoID ?>" data-duracao="<?php echo $linhas->duracao; ?>" data-preco="<?php echo $linhas->preco; ?>"><?php echo htmlspecialchars($linhas->nome_servicos); ?> - por R$ <?php echo $linhas->preco ?></option>
                   <?php
               }
           } else {
               echo "<option value='' disabled>Nenhum serviço disponível</option>";
           }
           ?>
            </select>



 

            <label for="data">Escolha o dia:</label>
            <input type="date" name="data" id="data" required>

            <label for="horario">Escolha um horário disponível:</label>
          
            <select id="horario" name="horario" required>
</select>


            <label for="escolha">Onde você deseja fazer o serviço?</label>
            <select name="escolha" id="escolha" required>
                <option value="" selected disabled>Selecione uma opção</option>
                <option value="1">Na estética automotiva</option>
                <option value="0">Em casa</option>
            </select>


<?php 

$armazenarUsuario = new ArmazenarUsuarioMYSQL();
$pontosArray = $armazenarUsuario->buscarPontosUsuario($user_id); // Obtém o array de pontos
$pontosUsuario = isset($pontosArray['Pontos']) ? $pontosArray['Pontos'] : 0; // Se houver 'Pontos', atribua, caso contrário 0


if ($pontosUsuario > 0): 
    $armazenarPremios = new ArmazenarPremiosMYSQL();
    $premiosDisponiveis = $armazenarPremios->buscarPremiosDisponiveis($pontosUsuario);
    $_SESSION['prêmiosDisponíveis'] = $premiosDisponiveis;
    ?>

<label for="premio">Trocar estrelas por recompensa: </label>
<select name="premio" id="premio">
    <option value="" disabled>Selecione um prêmio</option>
    <option value="Nenhum">Nenhum</option>
    <?php foreach ($premiosDisponiveis as $premio) { ?>
        <option value="<?php echo $premio['PremiosID']; ?>"><?php echo $premio['premio']; ?> - por <?php echo $premio['Valor_Pontos']; ?> estrelas</option>
    <?php } ?>
</select>
    
    <?php 
    // Se o usuário não tem pontos suficientes
    endif; 
    ?>
            <div class="button-container">
                <button class="returnFormButton" type="button" data-target-form="form1">Voltar</button>
                <button class="NextFormButton" type="button" data-next-form="form3">Avançar</button>
            </div>
        </div>

        <div class="form-container" id="form3">
            <h3 style="text-align:center">Endereço</h3>
            <label for="cep">CEP:</label>
            <input type="text" name="CEP" id="cep" value="<?php echo htmlspecialchars($CEP); ?>" placeholder="Seu CEP" onblur="consultarCEP(this.value)">
            <label for="endereco">Rua:</label>
            <input type="text" id="rua" name="Rua" placeholder="Rua" value="<?php echo htmlspecialchars($Rua); ?>">
            <label for="endereco">Número</label>
            <input type="number" name="Numero" id="numero" value="<?php echo htmlspecialchars($Numero); ?>" placeholder="Número da casa">
            <label for="bairro">Bairro:</label>
            <input type="text" name="Bairro" id="bairro" value="<?php echo htmlspecialchars($Bairro); ?>" placeholder="Seu bairro">
            <label for="cidade">Cidade:</label>
            <input type="text" name="Cidade" id="cidade" value="<?php echo htmlspecialchars($Cidade); ?>" placeholder="Sua cidade">
            <label for="estado">Estado:</label>
            <input type="text" name="Estado" id="estado" value="<?php echo htmlspecialchars($Estado); ?>" placeholder="Seu estado">
            <div class="button-container">
                <button class="returnFormButton" type="button" data-target-form="form2">Voltar</button>
                <button class="NextFormButton" type="button" data-next-form="form4">Avançar</button>
            </div>
        </div>

        <div class="form-container" id="form4" style="color: black">
        <h3>Agendamento - Serviços Adicionais</h3>

        <div class="dropdown" style= "color: black">
        <button class="dropbtn" style= "color: black; border-radius: 15px" >Selecione as opções</button>
        <div class="dropdown-content">
        <?php 
        $Servicos = $ArmazenarServicos->listarTodosServicos();
                while ($linhas = $Servicos->fetch_object()) {
                    ?>
                         <label><input type="checkbox" name="servicos_adicionais[]" value="<?php echo $linhas->ServicoID ?>" data-preco="<?php echo $linhas->preco; ?>"><?php echo htmlspecialchars($linhas->nome_servicos);  ?>- por R$ <?php echo $linhas->preco ?></label>
               
                <?php
                }
                ?>
        </div>
    </div>


            <div class="button-container">
                <button class="returnFormButton" type="button" data-target-form="form2">Voltar</button>
                <button class="NextFormButton" type="button" data-next-form="form5">Avançar</button>
            </div>
        </div>

        <div class="form-container" id="form5" style="color: black">
            <h3>Qual é o carro que você deixará sob nossos cuidados?</h3>
            <label for="make">Marca:</label>
            <select id="make" name="make" required>
                <option value="">Selecione a marca</option>
            </select>

            <label for="model">Modelo:</label>
            <select id="model" required name="model" disabled>
                <option value="">Selecione o modelo</option>
            </select>

            <div class="button-container">
                <button class="returnFormButton" type="button" data-target-form="form4">Voltar</button>
                <button class="NextFormButton" type="button" data-next-form="form6">Avançar</button>
            </div>
        </div>

        <div class="form-container" id="form6" >
            <h3>Método de Pagamento</h3>
            <label for="pagamento">Escolha o método de pagamento:</label>
            <select name="pagamento" id="pagamento" required>
                <option value="" disabled selected>Selecione um método</option>
                <option value="pix">Pix</option>
                <option value="especie">Em espécie</option>
            </select>

          

            <div class="button-container">
                <button class="returnFormButton" type="button" data-target-form="form5">Voltar</button>
                <button class="NextFormButton" type="button" data-next-form="form7">Avançar</button>
            </div>
        </div>

        <div class="form-container" id="form7">
            <h3>Alguma observação?</h3>
            <input type="text" name="observacoes" id="observacoes" placeholder="Digite aqui se houver alguma observação...">
            <div class="button-container">
                <button class="returnFormButton" type="button" data-target-form="form6">Voltar</button>
                <button id="finalizeButton" class="Concluir-btn" type="button">Finalizar</button>
            </div>
        </div>
    </div>


    <div class="right-section">
        <img id="section-image" src="../../../src/img/Agendamento/agendamento1.jpeg" alt="Imagem da Seção">
        <div class="footer">
            <div class="footer-grid">
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




<div id="cepModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p id="modal-message">CEP não encontrado.</p>
  </div>
</div>



<!-- Botão para abrir o Modal -->


<!-- Estrutura do Modal -->
<div id="confirmationModal" class="modal-agendamento">
  <div class="modal-agendamento-content">
    <h2>Confirme suas informações</h2>

    <div class="caixa-confirmacao">
        <h3>Informações pessoais:</h3>
        <p id="NomeConfirm"></p>
        <p id="SobrenomeConfirm"></p>
        <p id="EmailConfirm"></p>
        <p id="TelefoneConfirm"></p>

    </div>
    
    <div class="caixa-confirmacao">

    <h3>Agendamento</h3>
    <p id="ServicoConfirm"></p>
    <p id="DataConfirm"></p>
    <p id="HoraConfirm"></p>
    <p id="localConfirm"></p>

    </div>


    <div class="caixa-confirmacao">

    <h3>Endereço</h3>
    <p id="CEPConfirm"></p>
    <p id="RuaConfirm"></p>
    <p id="NumeroConfirm"></p>
    <p id="BairroConfirm"></p>
    <p id="CidadeConfirm"></p>
    <p id="EstadoConfirm"></p>

    </div>


    <div class="caixa-confirmacao">

    <h3>Serviços adicionais: </h3> 
    <p id="ServicosAdicionaisContainer"></p>

    </div>


    <div class="caixa-confirmacao">

    <h3>Carro</h3>
    <p id="MarcaCarroConfirm"></p>
    <p id="ModeloCarroConfirm"></p>

    </div>
 

    <div class="caixa-confirmacao">

    <h3>Metodo de pagamento</h3>
    <p id="PagamentoMetodoConfirm"></p>

    </div>


    <div class="caixa-confirmacao">
    <h3>Observações:</h3>
    <p id="ObservacoesConfirm"></p>

    </div>
 
    <div class="caixa-confirmacao">
    <h3>Preço e Desconto</h3>
    <p id="PrecoOriginalConfirm"></p>
    <p id="PrecoServicosAdicionaisConfirm"></p>
    <p id="DescontoConfirm"></p>
    <p id="ValorFinalConfirm"></p>
</div>



    <!-- Botões de ação -->
    <button id="confirmButton" type="submit">Confirmar</a></button>
    <button id="cancelButton" type="button">Cancelar</button>
  </div>
</div>
</form>



<div id="errorModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Erro</h2>
        <p>Por favor, preencha todos os campos obrigatórios corretamente.</p>
    </div>
</div>


<div id="HorariosOcupadosModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Erro</h2>
        <p>Não é possível selecionar um horário para essa data. Por favor, selecione outra data.</p>
    </div>
</div>


<div id="HorarioSobrepostoModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Erro</h2>
    <p>Horário selecionado não está disponível. Ele vai sobrepor outro agendamento. Por favor, selecione outro horário.</p>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="../../../src/js/formularios.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const nextButtons = document.querySelectorAll('.NextFormButton');
    const returnButtons = document.querySelectorAll('.returnFormButton');
    const modal = document.getElementById('errorModal');
    const span = document.getElementsByClassName('close')[0];

    // Função para alterar a imagem e a cor de fundo ao mudar de formulário
    function updateImageAndBackground(formId) {
        const imageElement = document.getElementById('section-image');
        const leftSection = document.getElementById('left-section');

        switch (formId) {
            case 'form1':
                imageElement.src = '../../../src/img/Agendamento/agendamento1.jpeg';
                leftSection.style.backgroundColor = '#3A4A6B';
                break;
            case 'form2':
                imageElement.src = '../../../src/img/Agendamento/agendamento2.jpeg';
                leftSection.style.backgroundColor = '#B3FAA5';
                break;
            case 'form3':
                imageElement.src = '../../../src/img/Agendamento/agendamento3.jpeg';
                leftSection.style.backgroundColor = '#4F75A8';
                break;
            case 'form4':
                imageElement.src = '../../../src/img/Agendamento/agendamento4.jpg';
                leftSection.style.backgroundColor = '#DFC2A6';
                break;
            case 'form5':
                imageElement.src = '../../../src/img/Agendamento/agendamento5.jpeg';
                leftSection.style.backgroundColor = '#CCDDE8';
                break;
            case 'form6':
                imageElement.src = '../../../src/img/Agendamento/agendamento6.jpeg';
                leftSection.style.backgroundColor = '#8C8C8C';
                break;
            case 'form7':
                imageElement.src = '../../../src/img/Agendamento/agendamento7.jpg';
                leftSection.style.backgroundColor = '#4F75A8';
                break;
            default:
                console.error('Formulário desconhecido:', formId);
                break;
        }
    }

    // Função para mostrar o modal
    function showModal() {
        modal.style.display = "block";
    }

    // Função para fechar o modal
    function closeModal() {
        modal.style.display = "none";
    }

    // Função para verificar se todos os campos obrigatórios estão preenchidos
    function checkFormValidity(form) {
        
        return [...form.querySelectorAll('input[required], select[required], textarea[required]')].every(input => input.value.trim() !== '');
    }

    nextButtons.forEach(button => {
        button.addEventListener('click', function () {
            const currentForm = this.closest('.form-container');
            const nextFormId = this.getAttribute('data-next-form');

            // Verifique se todos os campos obrigatórios estão preenchidos
            if (!checkFormValidity(currentForm)) {
                showModal(); // Exibe o modal se não estiver tudo preenchido
                return; // Não avança para o próximo formulário
            }


                 // Verifique se todos os campos obrigatórios estão preenchidos
        if (!checkFormValidity(currentForm)) {
            showModal(); // Exibe o modal se não estiver tudo preenchido
            return; // Não avança para o próximo formulário
        }

        // Verifique se há horários disponíveis
        const selectHorario = document.getElementById('horario');
        if (selectHorario.disabled) {
            // Não há horários disponíveis, exibe um modal de erro
            const HorariosOcupadosModal = document.getElementById("HorariosOcupadosModal");
            HorariosOcupadosModal.style.display = "block";
            return; // Não avança para o próximo formulário
        }

      
            // Esconde todos os formulários
            document.querySelectorAll('.form-container').forEach(form => {
                form.classList.remove('active');
            });

            // Lógica para exibir o próximo formulário com base na condição
            if (nextFormId === 'form3') {
                if (document.getElementById('escolha').value === '0') {
                    document.getElementById('form3').classList.add('active');
                    updateImageAndBackground('form3');
                } else {
                    document.getElementById('form4').classList.add('active');
                    updateImageAndBackground('form4');
                }
            } else {
                document.getElementById(nextFormId).classList.add('active');
                updateImageAndBackground(nextFormId);
            }
        });
    });

    returnButtons.forEach(button => {
        button.addEventListener('click', function () {
            const currentForm = this.closest('.form-container');
            const targetFormId = this.getAttribute('data-target-form');
            document.querySelectorAll('.form-container').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(targetFormId).classList.add('active');
            updateImageAndBackground(targetFormId);
        });
    });

    // Fechar modal
    span.addEventListener('click', function () {
        closeModal();
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});


function atualizarServicosAdicionais() {
    // Capturar o valor do serviço principal selecionado
    var servicoPrincipalSelect = document.getElementById("servico");
    var servicoPrincipal = servicoPrincipalSelect.value;

    // Obter todas as opções de serviços adicionais (checkboxes)
    var servicosAdicionais = document.querySelectorAll('.dropdown-content input[type="checkbox"]');

    // Iterar sobre as opções e ocultar aquelas que correspondem ao serviço principal
    servicosAdicionais.forEach(function(servicoAdicional) {
        if (servicoAdicional.value === servicoPrincipal) {
            // Oculta a opção correspondente ao serviço principal
            servicoAdicional.closest('label').style.display = 'none';
            servicoAdicional.checked = false; // Desmarca, caso esteja marcado
        } else {
            // Exibe as opções que não correspondem ao serviço principal
            servicoAdicional.closest('label').style.display = 'block';
        }
    });
}

// Adicionar o evento "change" no select do serviço principal para atualizar quando mudar
document.getElementById("servico").addEventListener("change", atualizarServicosAdicionais);

// Chamar a função para atualizar os serviços adicionais quando a página é carregada
document.addEventListener('DOMContentLoaded', function () {
    atualizarServicosAdicionais();
});





document.addEventListener('DOMContentLoaded', function () {
    const makeSelect = document.getElementById('make');
    const modelSelect = document.getElementById('model');

    // Dados das marcas e modelos
    const carData = {
        "Audi": ["A3", "A4", "A5", "A6", "A7", "A8", "Q3", "Q5", "Q7", "Q8", "e-tron", " Outro"],
        "BMW": ["Série 1", "Série 2", "Série 3", "Série 4", "Série 5", "Série 7", "Série 8", "X1", "X2", "X3", "X4", "X5", "X6", "X7", "i3", "i4", "iX", "Outro"],
        "BYD": ["Han EV", "Tang EV", "Outro"],
        "Chevrolet": ["Onix", "Onix Plus", "Tracker", "Equinox", "S10", "Trailblazer", "Spin", "Cruze", "Bolt EV", "Corsa", "Outro"],
        "Chrysler": ["300C", "Pacifica", "Outro"],
        "Citroën": ["C3", "C4 Cactus", "C4 Lounge", "Jumpy", "Berlingo", "Outro"],
        "Dodge": ["Durango", "Challenger", "Charger", "Journey", "Outro"],
        "Ferrari": ["488", "812 Superfast", "F8 Tributo", "Roma", "Portofino", "Outro"],
        "Fiat": ["Argo", "Mobi", "Strada", "Toro", "Cronos", "Fiorino", "Uno", "500e", "Outro"],
        "Ford": ["Ka", "Ka Sedan", "EcoSport", "Ranger", "Territory", "Mustang Mach-E", "Outro"],
        "Geely": ["Coolray", "Azkarra", "Outro"],
        "Haval": ["H6", "Outro"],
        "Honda": ["Civic", "City", "City Hatchback", "Fit", "HR-V", "WR-V", "CR-V", "Outro"],
        "Hyundai": ["HB20", "HB20S", "Creta", "Tucson", "Santa Fe", "Kona Elétrico", "Ioniq 5", "Outro"],
        "Jaguar": ["XE", "XF", "F-PACE", "E-PACE", "I-PACE", "F-TYPE", "Outro"],
        "Jeep": ["Renegade", "Compass", "Commander", "Grand Cherokee", "Wrangler", "Outro"],
        "JAC": ["T40", "T50", "T60", "T80", "iEV20", "iEV40", "iEV60", "Outro"],
        "Kia": ["Picanto", "Rio", "Cerato", "Stonic", "Sportage", "Sorento", "Seltos", "Carnival", "Outro"],
        "Lamborghini": ["Huracán", "Aventador", "Urus", "Outro"],
        "Land Rover": ["Range Rover", "Range Rover Sport", "Range Rover Velar", "Range Rover Evoque", "Discovery", "Discovery Sport", "Defender", "Outro"],
        "Lexus": ["UX", "NX", "RX", "ES", "LS", "LC", "Outro"],
        "Lifan": ["X60", "X80", "Outro"],
        "Maserati": ["Ghibli", "Quattroporte", "Levante", "GranTurismo", "Outro"],
        "McLaren": ["540C", "570S", "720S", "GT", "Outro"],
        "Mercedes-Benz": ["Classe A", "Classe C", "Classe E", "Classe G", "Classe S", "CLA", "GLA", "GLB", "GLC", "GLE", "GLS", "EQB", "EQC", "EQS", "Outro"],
        "Mini": ["Cooper", "Cooper S", "Countryman", "Clubman", "Outro"],
        "Mitsubishi": ["ASX", "Eclipse Cross", "Outlander", "Pajero Sport", "L200 Triton", "Outro"],
        "Nissan": ["March", "Versa", "Kicks", "Frontier", "Leaf", "Outro"],
        "Peugeot": ["208", "2008", "3008", "5008", "Partner", "Expert"],
        "Porsche": ["718", "911", "Taycan", "Panamera", "Macan", "Cayenne", "Outro"],
        "Ram": ["1500", "2500", "3500", "Outro"],
        "Renault": ["Kwid", "Sandero", " Logan", "Duster", "Captur", "Oroch", "Outro"],
        "Rolls-Royce": ["Ghost", "Wraith", "Dawn", "Cullinan", "Phantom", "Outro"],
        "SsangYong": ["Tivoli", "XLV", "Korando", "Rexton", "Actyon Sports", "Outro"],
        "Subaru": ["Impreza", "XV", "Forester", "Outback", "Outro"],
        "Suzuki": ["Jimny", "S-Cross", "Vitara", "Outro"],
        "Tesla": ["Model 3", "Model S", "Model X", "Model Y", "Outro"],
        "Toyota": ["Corolla", "Corolla Cross", "Yaris", "Yaris Sedan", "Hilux", "SW4", "RAV4", "Camry", "Prius", "Outro"],
        "Troller": ["T4"],
        "Volkswagen": ["Gol", "Voyage", "Polo", "Virtus", "Nivus", "T-Cross", "Taos", "Tiguan", "Amarok", "Jetta", "Passat", "ID.4", "Outro"],
        "Volvo": ["XC40", "XC60", "XC90", "S60", "V60", "Outro"],
        "Outro": ["Outro"]
    };

    // Função para carregar marcas no select
    function loadMakes() {
        for (const make in carData) {
            const option = document.createElement('option');
            option.value = make;
            option.textContent = make;
            makeSelect.appendChild(option);
        }
    }

    // Função para carregar modelos com base na marca selecionada
    function loadModels(make) {
        modelSelect.innerHTML = '';
        if (make && carData[make]) {
            carData[make].forEach(model => {
                const option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                modelSelect.appendChild(option);
            });
            modelSelect.disabled = false;
        } else {
            modelSelect.disabled = true;
        }
    }

    // Event listeners
    makeSelect.addEventListener('change', function () {
        loadModels(makeSelect.value);
    });

    // Inicializar marcas
    loadMakes();
});

// Obtém os elementos do DOM
const modal = document.getElementById("confirmationModal");
const finalizeButton = document.getElementById("finalizeButton");
const cancelButton = document.getElementById("cancelButton");
const confirmButton = document.getElementById("confirmButton");

// Função para exibir o modal
function showModal() {
    // Preenche o modal com os dados do formulário
    populateModal();
    modal.style.display = "block"; // Exibe o Modal
}

// Função para preencher o Modal com os dados do formulário
// Função para preencher o Modal com os dados do formulário
function populateModal() {
    var servicoSelect = document.getElementById("servico");
    var selectedOptionText = servicoSelect.options[servicoSelect.selectedIndex].text;

    var EscolhaSelect = document.getElementById("escolha");
    var selectedOptionLocalText = EscolhaSelect.options[EscolhaSelect.selectedIndex].text;

    var checkboxes = document.querySelectorAll('.dropdown-content input[type="checkbox"]');
    var selectedOptionsText = [];
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            selectedOptionsText.push(checkbox.nextSibling.textContent.trim());
        }
    });

    document.getElementById("NomeConfirm").textContent = "Nome: " + document.getElementById("name").value;
    document.getElementById("SobrenomeConfirm").textContent = "Sobrenome: " + document.getElementById("sobrenome").value;
    document.getElementById("EmailConfirm").textContent = "Email: " + document.getElementById("email").value;
    document.getElementById("TelefoneConfirm").textContent = "Telefone: " + document.getElementById("phone").value;

    document.getElementById("ServicoConfirm").textContent = "Serviço: " + selectedOptionText;
    document.getElementById("DataConfirm").textContent = "Data: " + document.getElementById("data").value;
    document.getElementById("HoraConfirm").textContent = "Horário: " + document.getElementById("horario").value;
    document.getElementById("localConfirm").textContent = "local: " + selectedOptionLocalText;

    const selectedOptionLocal = document.getElementById("escolha").value;

if (selectedOptionLocal === "0") {
    document.getElementById("CEPConfirm").textContent = document.getElementById("cep").value;
    document.getElementById("RuaConfirm").textContent = document.getElementById("rua").value;
    document.getElementById("NumeroConfirm").textContent = document.getElementById("numero").value;
    document.getElementById("BairroConfirm").textContent = document.getElementById("bairro").value;
    document.getElementById("CidadeConfirm").textContent = document.getElementById("cidade").value;
    document.getElementById("EstadoConfirm").textContent = document.getElementById("estado").value;
} else if (selectedOptionLocal === "1") {
    document.getElementById("CEPConfirm").textContent = "CEP: 13230077";
    document.getElementById("RuaConfirm").textContent = "Rua ângela Lessi Larrubia";
    document.getElementById("NumeroConfirm").textContent = "62";
    document.getElementById("BairroConfirm").textContent = "Vila Tavares";
    document.getElementById("CidadeConfirm").textContent = "Campo Limpo Paulista";
    document.getElementById("EstadoConfirm").textContent = "SP";
}

    document.getElementById("ServicosAdicionaisContainer").textContent = "Serviços adicionais: " + (selectedOptionsText.length > 0 ? selectedOptionsText.join(', ') : "Nenhum adicional selecionado");
    document.getElementById("MarcaCarroConfirm").textContent = document.getElementById("make").value;
    document.getElementById("ModeloCarroConfirm").textContent = document.getElementById("model").value;

    document.getElementById("PagamentoMetodoConfirm").textContent = document.getElementById("pagamento").value;

    document.getElementById("ObservacoesConfirm").textContent = document.getElementById("observacoes").value;

    // Atualize os valores do modal de confirmação
    atualizarModalConfirmacao();
}

// Função para atualizar o modal de confirmação
function atualizarModalConfirmacao() {
    const servicoSelect = document.getElementById('servico');
    const servicoPrincipal = servicoSelect.selectedOptions[0];
    const precoOriginal = parseFloat(servicoPrincipal.getAttribute('data-preco')); // Obtenha o preço do atributo data-preco

    // Obtenha os serviços adicionais
    const servicosAdicionaisCheckboxes = document.querySelectorAll('input[name="servicos_adicionais[]"]:checked');
    let precoServicosAdicionais = 0;
    let servicosAdicionaisNomes = [];

    servicosAdicionaisCheckboxes.forEach(function (checkbox) {
        const precoAdicional = parseFloat(checkbox.getAttribute('data-preco')); // Obtenha o preço do atributo data-preco
        precoServicosAdicionais += precoAdicional;
        servicosAdicionaisNomes.push(checkbox.closest('label').textContent);
    });
// Obtenha o desconto se houver

let descontoValue = 0;
    const premioSelect = document.getElementById('premio');
    if (premioSelect && premioSelect.value !== 'Nenhum') {
        const premioID = premioSelect.value;
    // Obtenha o valor do desconto do premio
    fetch(`../../../backend/classes/Premios/obterDesconto.php?premio=${premioID}`)
    .then(response => response.json()) // Obtenha o objeto JSON
    .then(desconto => {
        console.log(desconto); // Verifique o que o servidor está retornando
        const descontoPorcentagem = desconto.valor_desconto; // Obtenha o valor do desconto em porcentagem
        const valorTotal = precoOriginal + precoServicosAdicionais; // Calcule o valor total
        descontoValue = (valorTotal / 100) * descontoPorcentagem; // Calcule o valor do desconto

        // Verifique se o desconto é 0 ou o tipo é 1
        if (descontoValue === 0) {
    // Mostrar os preços corretamente
    document.getElementById('PrecoOriginalConfirm').innerText = `Preço Original: R$${precoOriginal.toFixed(2)}`;
    document.getElementById('PrecoServicosAdicionaisConfirm').innerText = `Preço Adicionais: R$${precoServicosAdicionais.toFixed(2)}`;
    document.getElementById('DescontoConfirm').innerText = `Nenhum desconto aplicável`;
    document.getElementById('ValorFinalConfirm').innerText = `Valor Final: R$${valorTotal.toFixed(2)}`;
} else if (typeof descontoPorcentagem === 'number') {
    // Calcule o valor final
    const valorFinal = calcularValorFinal(valorTotal, descontoValue);

    // Atualize os elementos de confirmação
    document.getElementById('PrecoOriginalConfirm').innerText = `Preço Original: R$${precoOriginal.toFixed(2)}`;
    document.getElementById('PrecoServicosAdicionaisConfirm').innerText = `Preço Adicionais: R$${precoServicosAdicionais.toFixed(2)}`;
    document.getElementById('DescontoConfirm').innerText = `Desconto: R$${descontoValue.toFixed(2)}`;
    document.getElementById('ValorFinalConfirm').innerText = `Valor Final: R$${valorFinal.toFixed(2)}`;
} else {
    // Defina um valor padrão para descontoPorcentagem
    const descontoPorcentagem = 0;
    // Calcule o valor final
    const valorFinal = calcularValorFinal(valorTotal, descontoValue);

    // Atualize os elementos de confirmação
    document.getElementById('PrecoOriginalConfirm').innerText = `Preço Original: R$${precoOriginal.toFixed(2)}`;
    document.getElementById('PrecoServicosAdicionaisConfirm').innerText = `Preço Adicionais: R$${precoServicosAdicionais.toFixed(2)}`;
    document.getElementById('DescontoConfirm').innerText = `Desconto: R$${descontoValue.toFixed(2)}`;
    document.getElementById('ValorFinalConfirm').innerText = `Valor Final: R$${valorFinal.toFixed(2)}`;
}
    })
} else {
    // Calcule o valor final
    const valorFinal = calcularValorFinal(precoOriginal + precoServicosAdicionais, 0);

    // Atualize os elementos de confirmação
    document.getElementById('PrecoOriginalConfirm').innerText = `Preço Original: R$${precoOriginal.toFixed(2)}`;
    document.getElementById('PrecoServicosAdicionaisConfirm').innerText = `Preço Adicionais: R$${precoServicosAdicionais.toFixed(2)}`;
    document.getElementById('DescontoConfirm').innerText = `Desconto: nenhum desconto aplicado`;
    document.getElementById('ValorFinalConfirm').innerText = `Valor Final: R$${valorFinal.toFixed(2)}`;
}

// Função para calcular o valor final
function calcularValorFinal(precoOriginal, desconto) {
    return precoOriginal - desconto;
}
}
// Abre o Modal ao clicar no botão "Finalizar"
finalizeButton.addEventListener('click', function () {
    showModal(); // Chama a função que exibe o modal
});

// Fecha o Modal ao clicar no botão "Cancelar"
cancelButton.addEventListener('click', function () {
    modal.style.display = "none"; // Esconde o Modal
});

// Confirma e fecha o Modal ao clicar no botão "Confirmar"
confirmButton.addEventListener('click', function () {
    // alert("Informações confirmadas! Enviando formulário...");
    // Aqui você pode adicionar a lógica para enviar o formulário ou realizar outras ações
    modal.style.display = "none"; // Esconde o Modal após a confirmação
});

// Fecha o Modal se o usuário clicar fora dele
window.addEventListener('click', function (event) {
    if (event.target === modal) {
        modal.style.display = "none"; // Esconde o Modal
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const dataInput = document.getElementById('data');

    // Define o valor mínimo para a data como hoje
    const hoje = new Date();
    const dia = String(hoje.getDate()).padStart(2, '0');
    const mes = String(hoje.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
    const ano = hoje.getFullYear();
    dataInput.setAttribute('min', `${ano}-${mes}-${dia}`);

    if (dataInput) { // Verifica se o elemento existe
        dataInput.addEventListener('change', function () {
            const data = dataInput.value; // Pega o valor da data
            atualizarHorarios(data); // Chama a função
        });
        
    }

    // Resto do seu código...
});

document.addEventListener('DOMContentLoaded', function () {
    const dataInput = document.getElementById('data');

    // Define o valor mínimo para a data como hoje
    const hoje = new Date();
    const dia = String(hoje.getDate()).padStart(2, '0');
    const mes = String(hoje.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
    const ano = hoje.getFullYear();
    dataInput.setAttribute('min', `${ano}-${mes}-${dia}`);

    // Desativa dias sem horários disponíveis
    function desativarDiasSemHorarios() {
        const dias = document.querySelectorAll('#data option'); // Ajuste o seletor conforme sua implementação

        dias.forEach(dia => {
            const dataSelecionada = dia.value; // Obtém o valor da opção de dia

            // Verifica se o dia não tem horários disponíveis
            fetch(`../../../backend/classes/agendamento/obterHorarios.php?data=${dataSelecionada}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(horariosOcupados => {
                    // Se não houver horários ocupados, desativa o dia
                    if (horariosOcupados.length === 0) {
                        dia.disabled = true; // Desativa o dia
                    }
                })
                .catch(error => console.error('Erro ao verificar horários:', error));
        });
    }

    // Chama a função para desativar os dias
    desativarDiasSemHorarios();

    if (dataInput) { // Verifica se o elemento existe
        dataInput.addEventListener('change', function () {
            const data = dataInput.value; // Pega o valor da data
            atualizarHorarios(data); // Chama a função
        });
    }

    // Resto do seu código...
});

document.addEventListener('DOMContentLoaded', function () {
    const dataInput = document.getElementById('data');

    if (dataInput) { // Verifica se o elemento existe
        dataInput.addEventListener('change', function () {
            const data = dataInput.value; // Pega o valor da data
            atualizarHorarios(data); // Chama a função
        });
    }

    function atualizarHorarios(data) {
    fetch(`../../../backend/classes/agendamento/obterHorarios.php?data=${data}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(horariosOcupados => {
            const selectHorario = document.getElementById('horario');
            selectHorario.innerHTML = ''; // Limpa opções existentes

            // Criar horários disponíveis de 8h até 18h
            for (let hora = 8; hora <= 18; hora++) {
                const horarioFormatado = `${hora.toString().padStart(2, '0')}:00:00`;
                const option = document.createElement('option');
                option.value = horarioFormatado;
                option.textContent = horarioFormatado;

                // Adiciona a opção ao select
                selectHorario.appendChild(option);
            }

            // Obter durações dos agendamentos para a data selecionada
            fetch(`../../../backend/classes/agendamento/obterDuracoes.php?data=${data}`)
                .then(response => response.json())
                .then(duracoesAgendadas => {
                    console.log('Duracoes Agendadas:', duracoesAgendadas);

                    // Converte a duração do agendamento para número
                    const duracaoEmHoras = parseInt(duracoesAgendadas[0], 10); // Assumindo que seja o único valor

                    // Desativar horários ocupados e os subsequentes de acordo com a duração do serviço
                    horariosOcupados.forEach(horario => {
                        const optionOculta = Array.from(selectHorario.options).find(opt => opt.value === horario);
                        if (optionOculta) {
                            optionOculta.disabled = true; // Desativa a opção existente

                            // Desativa horários subsequentes
                            const horaInicialOcupada = new Date(`1970-01-01T${horario}`);
                            for (let i = 1; i < duracaoEmHoras; i++) {
                                const horaDesativar = new Date(horaInicialOcupada.getTime() + i * 60 * 60 * 1000); // Incrementa 1 hora
                                const horarioDesativar = `${horaDesativar.getHours().toString().padStart(2, '0')}:00:00`;

                                // Desativa a opção correspondente
                                const optionDesativar = Array.from(selectHorario.options).find(opt => opt.value === horarioDesativar);
                                if (optionDesativar) {
                                    optionDesativar.disabled = true; // Desativa a opção correspondente
                                }
                            }
                        }
                    });

                    // Verifica se todos os horários estão ocupados
// Verifica se todos os horários estão ocupados
const optionsDisponiveis = Array.from(selectHorario.options).filter(opt => !opt.disabled);
if (optionsDisponiveis.length === 0) {
    selectHorario.disabled = true; // Desativa o select

    // Exibe um modal com a mensagem de erro
    const HorariosOcupadosModal = document.getElementById("HorariosOcupadosModal");
    HorariosOcupadosModal.style.display = "block";
    var span = document.getElementsByClassName("close")[0];
    
    // Adicione o código aqui
    var errorModal = document.getElementById("HorariosOcupadosModal");
    var errorSpan = document.getElementsByClassName("close")[0];

    // Quando o usuário clicar no "x", fecha o modal de erro
    errorSpan.onclick = function() {
        errorModal.style.display = "none";
    }

    // Quando o usuário clicar fora do modal de erro, fecha o modal de erro
    window.onclick = function(event) {
        if (event.target == errorModal) {
            errorModal.style.display = "none";
        }
    }
    
} else {
    selectHorario.disabled = false; // Ativa o select
    // Sugerir o próximo horário disponível
    const proximoHorarioDisponivel = optionsDisponiveis[0].value;
    selectHorario.value = proximoHorarioDisponivel;
}
                })
                .catch(error => console.error('Erro ao obter durações:', error));
        })
        .catch(error => console.error('Erro:', error));
}
    

    // Carrega os horários disponíveis após o formulário ser carregado
    const selectHorario = document.getElementById('horario');
    if (selectHorario) {
        const data = document.getElementById('data').value;
        atualizarHorarios(data);
    }
});


function verificarSobreposicao(horarioSelecionado, duracaoServico) {
    console.log('Verificando sobreposição...');
    // Obter os horários ocupados para a data selecionada
    fetch(`../../../backend/classes/agendamento/obterHorarios.php?data=${document.getElementById('data').value}`)
        .then(response => response.json())
        .then(horariosOcupados => {
            console.log('Horários ocupados:', horariosOcupados);
            // Obter as durações dos agendamentos para a data selecionada
            fetch(`../../../backend/classes/agendamento/obterDuracoes.php?data=${document.getElementById('data').value}`)
                .then(response => response.json())
                .then(duracoesAgendadas => {
                    console.log('Durações agendadas:', duracoesAgendadas);
                    // Verificar se o horário selecionado vai "sobrepor" um outro agendamento
                    const horaInicial = new Date(`1970-01-01T${horarioSelecionado}`);
                    const horaFinal = new Date(horaInicial.getTime() + duracaoServico * 60 * 60 * 1000);

                    let sobreposicao = false;

                    horariosOcupados.forEach(horario => {
                        const horaAgendamento = new Date(`1970-01-01T${horario}`);
                        const duracaoAgendamento = duracoesAgendadas[0];
                        const horaAgendamentoFinal = new Date(horaAgendamento.getTime() + duracaoAgendamento * 60 * 60 * 1000);

                        if (horaInicial >= horaAgendamento && horaInicial < horaAgendamentoFinal) {
                            sobreposicao = true;
                            console.log('Sobreposição detectada!');
                        } else if (horaFinal > horaAgendamento && horaFinal <= horaAgendamentoFinal) {
                            sobreposicao = true;
                            console.log('Sobreposição detectada!');
                        }
                    });

                    if (sobreposicao) {
                        // O horário selecionado vai "sobrepor" um outro agendamento
                        const HorarioSobrepostoModal = document.getElementById("HorarioSobrepostoModal");
                        HorarioSobrepostoModal.style.display = "block";
                        document.getElementById('horario').value = '';
                        console.log('Modal aberto!');
                    } else {
                        console.log('Nenhuma sobreposição detectada!');
                    }
                })
                .catch(error => console.error('Erro ao verificar sobreposição:', error));
        })
        .catch(error => console.error('Erro ao verificar sobreposição:', error));
}

// Chamar a função para verificar sobreposição
document.getElementById('horario').addEventListener('change', function() {
    const horarioSelecionado = this.value;
    const servicoSelect = document.getElementById('servico');
    const duracaoServico = parseInt(servicoSelect.selectedOptions[0].getAttribute('data-duracao'));
    console.log('Horário selecionado:', horarioSelecionado);
    console.log('Duração do serviço:', duracaoServico);
    verificarSobreposicao(horarioSelecionado, duracaoServico);
});



// Atualizar duração do serviço quando o serviço for alterado
document.getElementById('servico').addEventListener('change', function() {
    const servicoSelect = document.getElementById('servico');
    const duracaoServico = parseInt(servicoSelect.selectedOptions[0].getAttribute('data-duracao'));
    console.log('Duração do serviço:', duracaoServico);
});

// Fechar modal quando clicado no botão de fechar
const HorarioSobrepostoModal = document.getElementById("HorarioSobrepostoModal");
const closeBtn = HorarioSobrepostoModal.querySelector('.close');
closeBtn.addEventListener('click', function() {
    HorarioSobrepostoModal.style.display = "none";
});

// Fechar modal quando clicado fora do modal
window.addEventListener('click', function(event) {
    if (event.target == HorarioSobrepostoModal) {
        HorarioSobrepostoModal.style.display = "none";
    }
});






























</script>
</body>
</html>
