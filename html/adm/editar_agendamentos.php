<!DOCTYPE html>
<html lang="pt-br">


<?php
session_start();


require_once '../../backend/classes/usuarios/ArmazenarUsuario.php';

require_once '../../backend/classes/agendamento/ArmazenarAgendamento.php';


if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../forms/login.php');
    exit();
} else {
    $logado = true;
    $Tipo = $_SESSION['tipo'];


    if ($Tipo == 0) {
        header('Location:../home.php');
        exit();
        
      }
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


    $usuario = $ArmazenarUsuario->buscarUsuario($user_id);
    $CEP = $usuario['cep'];
    $Rua = $usuario['rua'];
    $Numero = $usuario['numero'];
    $Bairro = $usuario['bairro'];
    $Cidade = $usuario['cidade'];
    $Estado = $usuario['estado'];




    $ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL();
    $Agendamento = $ArmazenarAgendamento->listarTodosAgendamentos();

    
    
    
    if (isset($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        unset($_SESSION['mensagem']);
    } else {
        $mensagem = '';
    }
    
        ?>


<head>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/preset/reset.css">
    <link rel="stylesheet" href="../../css/fonts.css">
    <link rel="stylesheet" href="../../css/preset/vars.css">
    <link rel="stylesheet" href="../../css/preset/modals.css">
    <link rel="stylesheet" href="../../css/preset/bases/base-estilo.css">
    <link rel="stylesheet" href="../../css/lista-style/lista_style.css">
    <link rel="stylesheet" href="../../css/home-style/responsivo.css">
    
    <title>Agendamentos do Sistema</title>
</head>
<body>


<header>
  <nav class="menu" role="navigation" aria-label="Menu Principal">
      
          <img class="logo" src="../../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img" >
      
      <div class="hamburger" aria-label="Abrir menu responsivo">
          &#9776;
      </div>
      <ul class="links" role="menubar">
        <li role="menuitem"><a href="../home.php">Home</a></li>
        <li class="dropdown" role="menuitem">
            <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Serviços <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
              <ul class="dropdown-content" role="menu" aria-label="Serviços">
                <li role="menuitem"><a href="editar_servicos.php">Editar Serviços</a></li>
                <li role="menuitem"><a href="../forms/adm/adicionar_servico.php">Adicionar Serviço</a></li>
               
              </ul>
          </li>
          <li role="menuitem"><a href="editar_usuarios.php">Editar Usuários</a></li>
          <li role="menuitem"><a href="editar_agendamentos.php">Editar Agendamentos</a></li>


          <li class="dropdown" role="menuitem">
            <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Estrelas <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
              <ul class="dropdown-content" role="menu" aria-label="Estrelas">
                <li role="menuitem"><a href="editar_cupons.php">Editar cupons</a></li>
                <li role="menuitem"><a href="../forms/adm/adicionar_cupom.php">Adicionar Cupom</a></li>
                <li role="menuitem"><a href="editar_premios.php">Editar prêmios</a></li>
                <li role="menuitem"><a href="../forms/adm/adicionar_premios.php">Adicionar Premio</a></li>
               
              </ul>
          </li>
       
        </ul>

          <div class="botoes">
              <div class="dropdown-perfil">
                  <span class="dropbtn"><?php echo $Nome;?></span>
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
            
                    
                            <li><a href="#">Tipo: Administrador</a></li>
                        <li><a href="../perfil.php">Editar Perfil</a></li>
                        </li><a href="../../backend/cadastro e login/logout.php" id="logoutButton">Logout</a></li>
                      </ul>


                  </div>
              </div>
          </div>
  </nav>
</header>

<div class="main-content">


<div class="container-lista">
        <h1>Lista de Agendamentos</h1>
        <div class="table-container">
        <table>
            <thead>
                <tr>
                    
                    <th>Usuário</th>
                    <th>Serviço principal</th>
                    <th>Dia</th>
                    <th>Horário</th>
                    <th>Preço</th>
                    <th>Local</th>
                    <th>Duração (Horas)</th>
                    <th>Serviços adicionais</th>
                    <th>Carro</th>
                    <th>Pagamento</th>
                    <th>Observações do Usuário</th>
                    <th>Observações do Administrador</th>
                    <th>Status</th>
                    <th>Excluir</th>

                </tr>

            
            </thead>
            <tbody>
                <?php
while ($linhas = $Agendamento->fetch_object()) {
    $user_id_tabela = $linhas->UsuarioID;
    
    // Buscar o nome do usuário para o agendamento específico
    $usuarioInfo = $ArmazenarUsuario->buscarUsuario($user_id_tabela);

    
    // Passando o ID do agendamento

    $AgendamentoComEndereco = $ArmazenarAgendamento->listarAgendamentoComEndereco($user_id_tabela);
    $AgendamentoComNomeDoServico = $ArmazenarAgendamento->listarAgendamentosComNomeDoServico($user_id_tabela);
    $AgendamentoComNomeDoUsuario = $ArmazenarAgendamento->listarAgendamentosComNomeDoUsuario($user_id_tabela);

    if ($AgendamentoComEndereco) {
        $agendamentosComEndereco = [];
        while ($row = $AgendamentoComEndereco->fetch_assoc()) {
            $agendamentosComEndereco[$row['AgendamentoID']] = $row['endereco_servico'];
        }
    } else {
        $agendamentosComEndereco = [];
    }

    if ($AgendamentoComNomeDoServico) {
        $agendamentosComNomeDoServico = [];
        while ($row = $AgendamentoComNomeDoServico->fetch_assoc()) {
            $agendamentosComNomeDoServico[] = $row;
        }
    } else {
        $agendamentosComNomeDoServico = [];
    }

    if ($AgendamentoComNomeDoUsuario) {
        $agendamentosComNomeDoUsuario = [];
        while ($row = $AgendamentoComNomeDoUsuario->fetch_assoc()) {
            $agendamentosComNomeDoUsuario[] = $row;
        }
    } else {
        $agendamentosComNomeDoUsuario = [];
    }

    // Combinar os dados
    foreach ($agendamentosComNomeDoServico as &$agendamento) {
        $agendamento['endereco_servico'] = $agendamentosComEndereco[$agendamento['AgendamentoID']] ?? 'Não disponível';
    }

    ?>
                    
                    <tr>
                        <td><?php  echo $agendamentosComNomeDoUsuario[0]['nome_usuario']; ?></td>
                        <td><?php echo $agendamento['nome_servico_principal']; ?></td>
                        <td><?php echo htmlspecialchars($linhas->Dia); ?></td>
                        <td><?php echo htmlspecialchars($linhas->Horario); ?></td>
                        <td> R$ <?php echo htmlspecialchars($linhas->Preco); ?></td>
                        <td>
                        <?php
                            if ($linhas -> Local == 1){
                                ?>
                                Na estética  <button class="detalhes" data-endereco="Rua ângela Lessi larrubia, Vila Tavares, 62, Campo Limpo Paulista, SP - 13230077">ver detalhes</button>

                                <?php
                                    }else {
                                ?>

                                Em casa <button class="detalhes" data-endereco="<?php echo $agendamento['endereco_servico']; ?>">ver detalhes</button>

                                <?php
                                    }
                                ?>
                        </td>
                      
                        <td><?php echo $linhas->duracao ?>h</td>
                        <td>
    <?php if ($linhas->Servico_Adicional == 1) { ?>
        <button class="ServicoAdd" onclick="openServicosAddModal(<?php echo $linhas->AgendamentoID; ?>)">Visualizar</button>
    <?php } else { ?>
        nenhum
    <?php } ?>
</td>


                        <td><?php echo htmlspecialchars($linhas->Modelo_carro);?> <?php echo htmlspecialchars($linhas->Marca_carro); ?></td>
                        <td>
                            <?php
                            if ($linhas -> Pagamento == 1){
                                ?>
                            Dinheiro 

                                <?php
                                    }else {
                                ?>

                               PIX

                                <?php
                                    }
                                ?>
                            
                        </td>

                        <td><?php echo htmlspecialchars($linhas->Observacoes); ?></td>
                        <td><?php echo htmlspecialchars($linhas->observacoes_adm); ?>
<button class="edit-btn" data-agendamento-id="<?php echo $linhas->AgendamentoID; ?>"><i class="fas fa-pencil-alt"></i></button>
</td>

                        <td>
                                <?php
                                    if ($linhas->Status == 1) {
                                    ?>
                                        <a href="../../backend/editar/editar_statusAgendamento.php?id=<?php echo $linhas->AgendamentoID; ?>&status=0" class="change-type"> <button class="pendente"><i class="far fa-clock"></i></button></a>
                                    <?php
                                    } else {
                                    ?>
                                      <a href="../../backend/editar/editar_statusAgendamento.php?id=<?php echo $linhas->AgendamentoID; ?>&status=1" class="change-type"><button class="concluido"><i class="fas fa-check-circle"></i></button></a>
                                    <?php
                                    }
                                    ?>
                        </td>

                        <td>
                    <a href="../../backend/excluir/excluirAgendamento.php?id=<?php echo $linhas->AgendamentoID; ?>"><button class="excluir-btn"><i class="fas fa-trash"></i></button></a>
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


<div id="confirmModal" class="modal">
    <div class="modal-content">
        <p>Deseja realmente alterar o Status do agendamento?</p>
        <div class="button-container">
            <button id="confirmButtonStatus" class="confirmButton">Confirmar</button>
            <button id="cancelButtonStatus" class="cancelButton">Cancelar</button>
        </div>
    </div>
</div>

<div id="logoutModal" class="modal">
  <div class="modal-content" style="height: 200px">
    <span class="close">&times;</span>
    <p>Você tem certeza que deseja sair?</p>
    <button  class="confirmButton" id="confirmButtonLogout">Sim</button>
    <button class="cancelButton" id="cancelButtonLogout">Não</button>
  </div>
</div>

<div id="DeleteModal" class="modal">
    <div class="modal-content">
        <p>Deseja realmente excluir o agendamento?</p>
        <div class="button-container">
            <button id="confirmButtonExcluir" class="confirmButton">Confirmar</button>
            <button id="cancelButtonExcluir" class="cancelButton">Cancelar</button>
        </div>
    </div>
</div>


<div id="ShowEndereco" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Endereço</h3>
        <p><strong>Endereço:</strong> <span id="endereco"></span></p>
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

<div id="ObservacoesAdmModal" class="modal">
    <div class="modal-content"  style="height:200px">
        <span class="close">&times;</span>
        <h2>Observações do Administrador</h2>
        <p id="observacoes-adm-content"></p>
        <input type="text" id="observacoes-adm-input" value="" placeholder="Digite a observação...">
        <div class="button-container">
            <button id="save-observacoes-adm-btn" class="save-btn">Salvar</button>
            <button id="cancel-observacoes-adm-btn" class="cancel-btn">Cancelar</button>
        </div>
    </div>
</div>


<!-- Modal HTML -->
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
        window.location.href = '../../backend/cadastro e login/logout.php'; // Redireciona para o script de logout
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


// Função para exibir o modal
function showConfirmModal(url) {
    const modal = document.getElementById('confirmModal');
    modal.style.display = 'block';

    // Botão de Confirmar
    document.getElementById('confirmButtonStatus').onclick = function() {
        window.location.href = url; // Redireciona para a URL de alteração
    };

    // Botão de Cancelar
    document.getElementById('cancelButtonStatus').onclick = function() {
        modal.style.display = 'none'; // Fecha o modal
    };

    // Fechar o modal se clicar fora do conteúdo
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
}

// Adiciona evento aos links de alteração de tipo
document.querySelectorAll('.change-type').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Previne o comportamento padrão do link
        const url = this.href; // Pega a URL do link
        showConfirmModal(url); // Exibe o modal e passa a URL
    });
});




document.addEventListener("DOMContentLoaded", function() {
    const deleteModal = document.getElementById("DeleteModal");
    const confirmButtonExcluir = document.getElementById("confirmButtonExcluir");
    const cancelButtonExcluir = document.getElementById("cancelButtonExcluir");

    let currentDeleteUrl = ''; // Para armazenar a URL da exclusão

    // Para cada botão de exclusão
    document.querySelectorAll(".excluir-btn").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault(); // Prevenir o comportamento padrão do link
            currentDeleteUrl = this.parentElement.getAttribute("href"); // Captura a URL da exclusão
            deleteModal.style.display = "block"; // Exibe o modal
        });
    });

    // Confirma a exclusão
    confirmButtonExcluir.addEventListener("click", function() {
        window.location.href = currentDeleteUrl; // Redireciona para a URL de exclusão
    });

    // Cancela a exclusão
    cancelButtonExcluir.addEventListener("click", function() {
        deleteModal.style.display = "none"; // Fecha o modal
    });

    // Fecha o modal ao clicar fora dele
    window.addEventListener("click", function(event) {
        if (event.target === deleteModal) {
            deleteModal.style.display = "none"; // Fecha o modal
        }
    });
});




function openModal(agendamentoID) {
    // Exibe o modal
    document.getElementById("ModalServicosAdd").style.display = "block";
    
    // Faz a requisição AJAX para buscar os serviços adicionais do agendamento
    $.ajax({
        url: 'buscarServicosAdicionais.php', // Endereço do script PHP que busca os serviços adicionais
        method: 'POST',
        data: { id: agendamentoID },
        success: function(response) {
            // Insere a resposta (nomes dos serviços) no conteúdo do modal
            document.getElementById("modal-servicos-content").innerHTML = response;
        },
        error: function() {
            // Exibe uma mensagem de erro em caso de falha
            document.getElementById("modal-servicos-content").innerHTML = "Erro ao carregar os serviços adicionais.";
        }
    });
}

function closeModal() {
    document.getElementById("ModalServicosAdd").style.display = "none";
}

// Fecha o modal se o usuário clicar fora dele
window.onclick = function(event) {
    const modal = document.getElementById("ModalServicosAdd");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}




document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        console.log('Botão Editar clicado!');
        event.preventDefault();
        const agendamentoID = this.dataset.agendamentoId; // Capture o ID do agendamento
        console.log('ID do agendamento:', agendamentoID); // Imprima o ID do agendamento
        document.getElementById('ObservacoesAdmModal').style.display = 'block'; // Exibe o modal

        // Armazene o ID do agendamento em uma variável
        window.agendamentoID = agendamentoID;

        // Preencha o campo de observações do administrador com os dados do agendamento
        const observacoesAdmValor = this.parentNode.parentNode.cells[11].textContent;
        console.log('Valor da observação:', observacoesAdmValor);
        document.getElementById('observacoes-adm-input').value = observacoesAdmValor;
    });
});


document.getElementById('save-observacoes-adm-btn').addEventListener('click', function(event) {
    event.preventDefault();
    const agendamentoID = window.agendamentoID;
    const observacoesAdm = document.getElementById('observacoes-adm-input').value;
    window.location.href = '../../backend/editar/editar_observacoesAdm.php?id=' + agendamentoID + '&observacoes=' + observacoesAdm;
});


// Fecha o modal se o usuário clicar fora dele
window.addEventListener('click', function(event) {
    const modal = document.getElementById("ObservacoesAdmModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
});

document.querySelectorAll('.close').forEach(span => {
    span.addEventListener('click', function(event) {
        document.getElementById('ObservacoesAdmModal').style.display = 'none';
    });
});


document.getElementById('cancel-observacoes-adm-btn').addEventListener('click', function(event) {
    document.getElementById('ObservacoesAdmModal').style.display = 'none';
});








function openServicosAddModal(agendamentoID) {
    // Exibe o modal
    document.getElementById("ModalServicosAdd").style.display = "block";
    
    // Faz a requisição AJAX para buscar os serviços adicionais do agendamento
    fetch('../../backend/classes/agendamento/Servicos_adicionais.php?id=' + agendamentoID)
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
<script src="../../src/js/script.js"></script>
</body>
</html>
