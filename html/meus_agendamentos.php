<!DOCTYPE html>
<html lang="pt-br">


<?php
session_start();

require_once '../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../backend/classes/servicos/ArmazenarServicos.php';
require_once '../backend/classes/agendamento/ArmazenarAgendamento.php';


$ArmazenarServicos = new ArmazenarServicoMYSQL();
$Servico = $ArmazenarServicos -> listarTodosServicos();


$Nome_servicos = isset($_SESSION['nome_servicos']) ? $_SESSION['nome_servicos'] : '';


if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../forms/login.php');
    exit();
} else {
    $logado = true;
    $Tipo = $_SESSION['tipo'];



  }
      $user_id = $_SESSION['ID'];
      $ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
      $logado = true;

    $usuario = $ArmazenarUsuario->listarTodosUsuarios();

    $Nome = $_SESSION['nome'];
    $Sobrenome = $_SESSION['sobrenome'];
    $Telefone = $_SESSION['telefone'];
    $Email = $_SESSION['email'];
    $Foto = $_SESSION['foto'];
    $Tipo = $_SESSION['tipo'];


    if ($Tipo == 0) {
      $Pontos_usuario = $ArmazenarUsuario->buscarPontosUsuario($user_id);
      if ($Pontos_usuario !== null) {
          $Pontos = $Pontos_usuario['Pontos'];
      }else{
        $Pontos = 0;
      }
  }


// Gerencia a mensagem de sessão
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}

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
    <link rel="stylesheet" href="../css/preset/reset.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/preset/vars.css">
    <link rel="stylesheet" href="../css/preset/modals.css">
    <link rel="stylesheet" href="../css/preset/bases/base-estilo.css">
    <link rel="stylesheet" href="../css/lista-style/lista_style.css">
    <link rel="stylesheet" href="../css/home-style/responsivo.css">
    
    <title>Usuários do Sistema</title>
</head>
<body>

<header>
        <nav class="menu" role="navigation" aria-label="Menu Principal">
            <img class="logo" src="../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img">
            <div class="hamburger" aria-label="Abrir menu responsivo">
                &#9776;
            </div>
            <ul class="links" role="menubar">
                <li role="menuitem"><a href="home.php">Home</a></li>
                <li class="dropdown" role="menuitem">
                    <a href="servicos/servicos.php" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Serviços <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
                    <ul class="dropdown-content" role="menu" aria-label="Serviços">
                
                    <?php
                $Servicos = $ArmazenarServicos->listarTodosServicos();
                while ($linhas = $Servicos->fetch_object()) {
                    ?>
               
                        <li role="menuitem"><a href="servicos/pagina_servico.php?id=<?php echo $linhas->ServicoID; ?>"><?php echo htmlspecialchars($linhas->nome_servicos); ?></a></li>
               
                <?php
                }
                ?>




              </ul>
          </li>
          
                  <?php if (isset($_SESSION['logado']) && $_SESSION['logado']): ?>
            <?php if ($Tipo == 0): ?>
                <li class="dropdown" role="menuitem">
                    <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Agendamento <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
                    <ul class="dropdown-content" role="menu" aria-label="Cupons">
                        <li role="menuitem"><a href="forms/agendamento/agendamento.php">Agendar serviço</a></li>
                        <li role="menuitem"><a href="meus_agendamentos.php">Meus Serviços agendados</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li role="menuitem"><a href="forms/agendamento/agendamento.php">Agendamento</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li role="menuitem"><a href="forms/agendamento/agendamento.php">Agendamento</a></li>
        <?php endif; ?>
    

      </ul>

          
          

          
                <div class="botoes">
                    <div class="dropdown-perfil">
                        <span class="dropbtn"><?php echo htmlspecialchars($Nome);  ?></span>
                        <div class="dropdown-perfil-content">
                            <div class="perfil-info">
                                <?php

                                if ($Foto) {
                                ?>
                                <img  src="data:image/jpeg;base64,<?= $Foto ?>" alt="Foto de Perfil">
                                <?php
                                } else {
                                ?>

                                <img src="https://voxnews.com.br/wp-content/uploads/2017/04/unnamed.png" alt="Foto de Perfil">
                                <?php

                                }


                                ?>
                            </div>
                            <ul>
                                <li><a href="#">Tipo: Usuário Comum</a></li>
                                <li><a href="pontos.php">Estrelas:  <?php echo htmlspecialchars($Pontos); ?></a></li>
                                <li><a href="perfil.php">Editar Perfil</a></li>
                                <li><a href="../backend/cadastro e login/logout.php" id="logoutButton">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </nav>
    </header>

<div class="main-content">


<div class="container-lista">
        <h1>Meus Serviços agendados</h1>
        <div class="table-container">
        <table>
            <thead>
                <tr>
                 
                    <th>Serviço principal</th>
                    <th>Dia</th>
                    <th>Horário</th>
                    <th>Preço</th>
                    <th>Local</th>
                    <th>Duração (Horas)</th>
                    <th>Serviços adicionais</th>
                    <th>Carro</th>
                    <th>Pagamento</th>
                    <th>Observações</th>
                    <th>Cancelar</th>
                    <th>Remarcar</th>
                
                   

                </tr>

             
            </thead>
            <tbody>
                <!-- Exemplo de linha de usuário -->
                
                <?php
                         while($linhas = $Agendamento -> fetch_object()) {
                            
                        ?>
                            <tr>
                                <td><?php echo $agendamento['nome_servico_principal']; ?></td>
                                <td><?php echo $linhas->Dia; ?></td>
                                <td><?php echo $linhas->Horario; ?></td>
                                <td> R$ <?php echo $linhas->Preco; ?></td>
                                <?php
                            if ($linhas -> Local == 1){
                                ?>
                                <td>
                                Na estética <button class="detalhes" data-endereco="Rua ângela Lessi larrubia, Vila Tavares, 62, Campo Limpo Paulista, SP - 13230077">ver detalhes</button>
                                </td>
                                <?php
                                    }else {
                                ?>

                                <td>
                                Em casa <button class="detalhes" data-endereco="<?php echo $agendamento['endereco_servico']; ?>">ver detalhes</button>
                                </td>
                                <?php
                                    }
                                ?>


                        </td>
                                <td><?php echo $linhas->duracao ?>h</td>
                                <td>
    <?php if ($linhas->Servico_Adicional == 1) { ?>
        <button class="ServicoAdd" onclick="openServicosAddModalMeusAgendamentos(<?php echo $linhas->AgendamentoID; ?>)">Visualizar</button>
    <?php } else { ?>
        nenhum
    <?php } ?>
</td>
                                <td><?php echo $linhas->Marca_carro; ?> <?php echo $linhas->Modelo_carro; ?>  </td>
                               
                                <td>
                                     <?php
                                     if ($linhas->Pagamento == 1) {
                                    ?>
                                      Dinheiro
                                    <?php
                                    } else {
                                    ?>
                                      PIX
                                    <?php
                                    }
                                    ?>
                                         
                                 </td>
                                 <td><?php echo $linhas->Observacoes; ?></td>
                                
                                 <td>

                                     <a href="../backend/excluir/excluirSeuAgendamento.php?id=<?php echo $linhas->AgendamentoID; ?>"><button class="excluir-btn"><i class="fas fa-trash"></i></button></a>
                                 </td>
                                 <td>

                                     <button class="remarcar-btn" data-agendamento-id="<?php echo $linhas->AgendamentoID; ?>"><i class="fas fa-calendar-alt"></i>
                                     </button>
                                 </td>



                            
                            </tr>    
                            <?php
                                 }
                            ?>
                            
    
                
        
            </tbody>
        </table>
        </div>
    </div>




</div>

<footer role="contentinfo">
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
</footer>




<div id="logoutModal" class="modal">
  <div class="modal-content" style="height: 200px">
    <span class="close">&times;</span>
    <p>Você tem certeza que deseja sair?</p>
    <button  class="confirmButton" id="confirmButtonLogout">sim</button>
    <button class="cancelButton" id="cancelButtonLogout">não</button>
  </div>
</div>






<div id="ShowEndereco" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Endereço</h3>
        <p><strong>Endereço:</strong> <span id="endereco"></span></p>
    </div>
</div>


<div id="DeleteModal" class="modal">
    <div class="modal-content">
        <p>Deseja realmente Cancelar o agendamento?</p>
        <div class="button-container">
            <button id="confirmButtonExcluir" class="confirmButton">Confirmar</button>
            <button id="cancelButtonExcluir" class="cancelButton">Cancelar</button>

        </div>
    </div>
</div>


<div id="RemarcarModal" class="modal">
    <div class="modal-content" style="height:400px">
    <span class="close">&times;</span>
        <h2>Remarcar Agendamento</h2>
        <form>
            <label for="data">Escolha o dia:</label>
            <input type="date" name="data" id="data" value="" required>

            <label for="horario">Escolha um horário disponível:</label>
            <select id="horario" name="horario" required>
                <option value="">Selecione um horário</option>
            </select>
            <p id="mensagem-erro" style="display: none; color: red;"></p>
            <button type="submit">Remarcar</button>
        </form>
    </div>
</div>


<div id="ModalServicosAdd" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Serviços Adicionais</h2>
        <!-- Esta div será preenchida com os serviços adicionais -->
        <div id="modal-servicos-content"></div>
    </div>
</div>



<?php if (!empty($mensagem)): ?>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        </div>
    </div>
    <?php endif; ?>


<script>
   


   document.addEventListener('DOMContentLoaded', function () {
    const logoutModal = document.getElementById('logoutModal');
    const closeBtn = document.querySelector('.close');
    const cancelLogoutBtn = document.getElementById('cancelButtonLogout');
    const confirmLogoutBtn = document.getElementById('confirmButtonLogout');
    const showEnderecoModal = document.getElementById('ShowEndereco');
    const enderecoSpan = document.getElementById('endereco');

    // Abre o modal quando o botão de logout é clicado
    document.getElementById('logoutButton').addEventListener('click', function (event) {
        event.preventDefault(); // Impede o redirecionamento imediato
        logoutModal.style.display = 'block'; // Exibe o modal
    });

    // Fecha o modal ao clicar no "X" ou no botão de cancelar
    closeBtn.addEventListener('click', function () {
        logoutModal.style.display = 'none';
        showEnderecoModal.style.display = 'none';
    });

    cancelLogoutBtn.addEventListener('click', function () {
        logoutModal.style.display = 'none';
    });

    // Redireciona para o logout ao confirmar
    confirmLogoutBtn.addEventListener('click', function () {
        window.location.href = '../backend/cadastro e login/logout.php'; // Redireciona para o script de logout
    });

    // Fecha o modal ao clicar fora dele
    window.addEventListener('click', function (event) {
        if (event.target === logoutModal) {
            logoutModal.style.display = 'none';
        }
        if (event.target === showEnderecoModal) {
            showEnderecoModal.style.display = 'none';
        }
    });

    // Função para exibir o modal de endereço
    document.querySelectorAll('.detalhes').forEach(button => {
        button.addEventListener('click', function () {
            const endereco = this.getAttribute('data-endereco');
            enderecoSpan.textContent = endereco; // Atualiza o conteúdo do modal
            showEnderecoModal.style.display = 'block'; // Exibe o modal
        });
    });
});




document.addEventListener("DOMContentLoaded", function() {
    const deleteModal = document.getElementById("DeleteModal");
    const confirmButtonExcluir = document.getElementById("confirmButtonExcluir");
    const cancelButtonExcluir = document.getElementById("cancelButtonExcluir");

    let currentDeleteUrl = ''; // Armazena a URL da exclusão

    // Adiciona evento de clique para cada link de exclusão
    document.querySelectorAll(".excluir-btn").forEach(button => {
        button.parentNode.addEventListener("click", function(event) {
            event.preventDefault(); // Prevenir o comportamento padrão do link

            // Captura a URL da exclusão
            currentDeleteUrl = this.href;

            // Exibe o modal
            deleteModal.style.display = "block";
        });
    });

    // Confirma a exclusão e redireciona para a URL de exclusão
    confirmButtonExcluir.addEventListener("click", function() {
        window.location.href = currentDeleteUrl;
    });

    // Cancela a exclusão e fecha o modal
    cancelButtonExcluir.addEventListener("click", function() {
        deleteModal.style.display = "none";
    });

    // Fecha o modal ao clicar fora dele
    deleteModal.addEventListener("click", function(event) {
        if (event.target === this) {
            this.style.display = "none";
        }
    });

    document.getElementById("RemarcarModal").querySelector(".close").addEventListener("click", function() {
    document.getElementById("RemarcarModal").style.display = "none";
});


document.getElementById("RemarcarModal").querySelector(".close").addEventListener("click", function() {
    document.getElementById("RemarcarModal").style.display = "none";
});
});
// Adicione um evento de clique ao botão Remarcar
document.querySelectorAll('.remarcar-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        console.log('Botão Remarcar clicado!');
        event.preventDefault();
        const agendamentoID = this.dataset.agendamentoId; // Capture o ID do agendamento
        console.log('ID do agendamento:', agendamentoID); // Imprima o ID do agendamento
        document.getElementById('RemarcarModal').style.display = 'block'; // Exibe o modal

        // Armazene o ID do agendamento em uma variável
        window.agendamentoID = agendamentoID;

        // Preencha os campos do modal com os dados do agendamento
        <?php
        while($linhas = $Agendamento -> fetch_object()) {
            ?>
            if (agendamentoID == <?php echo $linhas->AgendamentoID; ?>) {
                document.getElementById('data').value = '<?php echo $linhas->Dia; ?>';
                document.getElementById('horario').value = '<?php echo $linhas->Horario; ?>';
            }
            <?php
        }
        ?>
    });
});

// Adicione um evento de submit ao formulário de remarcar agendamento
// Adicione um evento de submit ao formulário de remarcar agendamento
document.getElementById('RemarcarModal').addEventListener('submit', function(event) {
    event.preventDefault();
    const data = document.getElementById('data').value;
    const selectHorario = document.getElementById('horario');
    if (!selectHorario.disabled) {
        const horario = selectHorario.value;
        window.location.href = '../backend/editar/remarcarAgendamento.php?id=' + window.agendamentoID + '&data=' + data + '&horario=' + horario;
    } else {
        const mensagemErro = document.getElementById('mensagem-erro');
        mensagemErro.textContent = 'Não é possível selecionar um horário para essa data.';
        mensagemErro.style.display = 'block';
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

    // Desativa dias sem horários disponíveis
    function desativarDiasSemHorarios() {
        const dias = document.querySelectorAll('#data option'); // Ajuste o seletor conforme sua implementação

        dias.forEach(dia => {
            const dataSelecionada = dia.value; // Obtém o valor da opção de dia

            // Verifica se o dia não tem horários disponíveis
            fetch(`..//backend/classes/agendamento/obterHorarios.php?data=${dataSelecionada}`)
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
    fetch(`../backend/classes/agendamento/obterHorarios.php?data=${data}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(horariosOcupados => {
            const selectHorario = document.getElementById('horario');
            selectHorario.innerHTML = ''; // Limpa opções existentes
            selectHorario.disabled = false; 

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
            fetch(`../backend/classes/agendamento/obterDuracoes.php?data=${data}`)
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
                    const optionsDisponiveis = Array.from(selectHorario.options).filter(opt => !opt.disabled);
                    if (optionsDisponiveis.length === 0) {
                        selectHorario.disabled = true; // Desativa o select
                    } else {
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



// Obtém o modal
var modal = document.getElementById("RemarcarModal");

// Obtém o botão de fechar
var span = modal.querySelector('.close');

// Quando o usuário clicar no "x", fecha o modal
span.addEventListener('click', function() {
    modal.style.display = "none";
})

// Quando o usuário clicar fora do modal, fecha o modal
window.addEventListener('click', function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
})






function openServicosAddModalMeusAgendamentos(agendamentoID) {
    // Exibe o modal
    document.getElementById("ModalServicosAdd").style.display = "block";
    
    // Faz a requisição AJAX para buscar os serviços adicionais do agendamento
    fetch('../backend/classes/agendamento/Servicos_adicionais.php?id=' + agendamentoID)
        .then(response => response.text())
        .then(data => {
            // Insere a resposta (nomes dos serviços) no conteúdo do modal
            document.getElementById("modal-servicos-content").innerHTML = data;
        })
        .catch(error => {
            // Exibe uma mensagem de erro em caso de falha
            document.getElementById("modal-servicos-content").innerHTML = "Erro ao carregar os serviços adicionais.";
        });
}



// Obtém o modal
var modal = document.getElementById("ModalServicosAdd");

// Obtém o botão de fechar
var span = modal.querySelector('.close');

// Quando o usuário clicar no "x", fecha o modal
span.addEventListener('click', function() {
    modal.style.display = "none";
})

// Quando o usuário clicar fora do modal, fecha o modal
window.addEventListener('click', function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
})



document.getElementById('horario').addEventListener('change', function() {
    const horarioSelecionado = this.value;
    const servicoSelect = document.getElementById('servico');
    const duracaoServico = parseInt(servicoSelect.selectedOptions[0].getAttribute('data-duracao'));
    console.log('Horário selecionado:', horarioSelecionado);
    console.log('Duração do serviço:', duracaoServico);
    verificarSobreposicao(horarioSelecionado, duracaoServico);
});
document.getElementById('RemarcarModal').addEventListener('submit', async function(event) {
    event.preventDefault();
    const data = document.getElementById('data').value;
    const selectHorario = document.getElementById('horario');
    if (!selectHorario.disabled) {
        const horario = selectHorario.value;
        const servicoSelect = document.getElementById('servico');
        const duracaoServico = parseInt(servicoSelect.selectedOptions[0].getAttribute('data-duracao'));
        const sobreposicao = await verificarSobreposicao(horario, duracaoServico);
        if (!sobreposicao) {
            window.location.href = '../backend/editar/remarcarAgendamento.php?id=' + window.agendamentoID + '&data=' + data + '&horario=' + horario;
        } else {
            const mensagemErro = document.getElementById('mensagem-erro');
            mensagemErro.textContent = 'O horário selecionado já está ocupado. Por favor, escolha outro horário.';
            mensagemErro.style.display = 'block';
        }
    } else {
        const mensagemErro = document.getElementById('mensagem-erro');
        mensagemErro.textContent = 'Não é possível selecionar um horário para essa data.';
        mensagemErro.style.display = 'block';
    }
});


async function verificarSobreposicao(horarioSelecionado, duracaoServico) {
    console.log('Verificando sobreposição...');
    // Obter os horários ocupados para a data selecionada
    const response = await fetch(`../backend/classes/agendamento/obterHorarios.php?data=${document.getElementById('data').value}`);
    const horariosOcupados = await response.json();
    console.log('Horários ocupados:', horariosOcupados);
    // Obter as durações dos agendamentos para a data selecionada
    const response2 = await fetch(`../backend/classes/agendamento/obterDuracoes.php?data=${document.getElementById('data').value}`);
    const duracoesAgendadas = await response2.json();
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

    return sobreposicao;
}



    // Obtém o modal
    var modal = document.getElementById("myModal");

    // Obtém o botão de fechar
    var span = document.getElementsByClassName("close")[0];

    // Se houver uma mensagem, exibe o modal
    <?php if (!empty($mensagem)): ?>
        window.onload = function() {
            modal.style.display = "block";
        }
    <?php endif; ?>

    // Quando o usuário clicar no "x", fecha o modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Quando o usuário clicar fora do modal, fecha o modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }










</script>
<script src="../src/js/script.js"></script>
</body>
</html>
