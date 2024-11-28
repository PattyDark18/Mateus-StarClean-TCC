<?php
session_start();

// Inclua o arquivo com a definição da classe
require_once '../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../backend/classes/servicos/ArmazenarServicos.php';


$ArmazenarServicos = new ArmazenarServicoMYSQL();
$Servico = $ArmazenarServicos -> listarTodosServicos();

$Nome_servicos = isset($_SESSION['nome_servicos']) ? $_SESSION['nome_servicos'] : '';



// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location:forms/login.php');
    exit();
} else {
    $logado = true;
    

    if (isset($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        unset($_SESSION['mensagem']);
    } else {
        $mensagem = '';
    }


    $user_id = $_SESSION['ID'];
    $ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
    $usuario = $ArmazenarUsuario->buscarUsuario($user_id);
    $Pontos_usuario = $ArmazenarUsuario->buscarPontosUsuario($user_id);

    
    $Foto = $_SESSION['foto'];
  
    $Nome = $_SESSION['nome'];
    $Sobrenome = $_SESSION['sobrenome'];
    $Telefone = $_SESSION['telefone'];
    $Email = $_SESSION['email'];
    $Senha = $_SESSION['senha'];

    $Tipo = $_SESSION['tipo'];
    
    if ($Tipo == 0) {
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
  }







}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/preset/reset.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/preset/vars.css">
    <link rel="stylesheet" href="../css/preset/modals.css">
    <link rel="stylesheet" href="../css/preset/bases/base-estilo.css">
    <link rel="stylesheet" href="../css/perfil_e_pontos/perfil_style.css">
    <link rel="stylesheet" href="../css/home-style/responsivo.css">
    <title>Seu perfil - <?php echo htmlspecialchars($Nome); ?></title>
</head>
<body>




<?php if ($Tipo == 1): ?>

<header>
  <nav class="menu" role="navigation" aria-label="Menu Principal">
      
          <img class="logo" src="../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img" >
      
      <div class="hamburger" aria-label="Abrir menu responsivo">
          &#9776;
      </div>
      <ul class="links" role="menubar">
        <li role="menuitem"><a href="home.php">Home</a></li>
        <li class="dropdown" role="menuitem">
            <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Serviços <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
              <ul class="dropdown-content" role="menu" aria-label="Serviços">
                <li role="menuitem"><a href="adm/editar_servicos.php">Editar Serviços</a></li>
                <li role="menuitem"><a href="forms/adm/adicionar_servico.php">Adicionar Serviço</a></li>
              </ul>
          </li>
          <li role="menuitem"><a href="adm/editar_usuarios.php">Editar Usuários</a></li>
          <li role="menuitem"><a href="adm/editar_agendamentos.php">Editar Agendamentos</a></li>



          
          <li class="dropdown" role="menuitem">
            <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Estrelas<span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
              <ul class="dropdown-content" role="menu" aria-label="Estrelas">
                <li role="menuitem"><a href="adm/editar_cupons.php">Editar cupons</a></li>
                <li role="menuitem"><a href="forms/adm/adicionar_cupom.php">Adicionar Cupom</a></li>
                <li role="menuitem"><a href="adm/editar_premios.php">Editar prêmios</a></li>
                <li role="menuitem"><a href="forms/adm/adicionar_premios.php">Adicionar Premio</a></li>
               
              </ul>
          </li>
          
        </ul>

<?php else: ?>

<header>
  <nav class="menu" role="navigation" aria-label="Menu Principal">
      
          <img class="logo" src="../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img" >
      
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
    <?php endif; ?>

    <?php if (isset($_SESSION['logado'])): ?>
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
                        <?php
                        if($Tipo == 0){
                        ?>
                        <li><a href="#">Tipo: Usuário Comum</a></li>
                        <li><a href="pontos.php">Estrelas:  <?php echo $Pontos; ?></a></li>
                        <?php
                        }else if ($Tipo == 1){
                          ?>
                            <li><a href="#">Tipo: Administrador</a></li>
                          <?php
                        }
                        ?>
                     
                        <li><a href="perfil.php">Editar Perfil</a></li>
                        </li><a href="../backend/cadastro e login/logout.php" id="logoutButton">Logout</a></li>
                      </ul>


                  </div>
              </div>
          </div>
      <?php else: ?>
      <?php endif; ?>

        
  </nav>
</header>

    <main>
    <!-- <h1>Seu perfil - <?php echo "Usuário com ID:". htmlspecialchars($user_id); ?></h1> -->
        <h1>Seu perfil - <?php echo htmlspecialchars($Nome); ?></h1>
        <div class="perfil-container">
            <div class="foto-perfil-container">
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
                <button id="alterar-foto-btn">Alterar Foto</button>
            </div>
            <div class="info-perfil">
                <div class="perfil-info-section">
                    <div class="perfil-info-secao">
                        <h2>Informações Pessoais <button class="edit-info-btn"><i class="fas fa-pencil-alt"></i></button></h2>
                        <div class="info-item">
                            <p><strong>Nome:</strong> <?php echo htmlspecialchars($Nome); ?></p>
                           
                        </div>
                        <div class="info-item">
                            <p><strong>Sobrenome:</strong> <?php echo htmlspecialchars($Sobrenome); ?></p>
                           
                        </div>
                        <div class="info-item">
                            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($Telefone); ?></p>
               
                        </div>
                        <div class="info-item">
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($Email); ?></p>
                           
                        </div>
                        <!-- <div class="info-item">
                            <p><strong>senha:</strong> alterar senha</p>
                            
                        </div> -->
                        <div class="info-item">
                            <p><strong>Tipo de Usuário:</strong>
                            <?php
                        if($Tipo == 0){
                        ?>
                            Usuário Comum
                        <?php
                         }else if ($Tipo == 1){
                            ?>
                            Usuário Administrador
                            <?php
                         }?>
                        </p>
                            
                        </div>
                    </div>
                    <hr>

                    <?php
                    if($Tipo == 0){
                    ?>
                   
                    <div class="perfil-info-secao">
                        <h2>Endereço  <button onclick="mostrarModalEndereco()" class="edit-endereco-btn"><i class="fas fa-pencil-alt"></i></button></h2>
                        <h3>Nós pedimos seu endereço, para adequar as suas preferências ao agendar o serviço.</h3>
                        <div class="info-item">
                            <p><strong>CEP:</strong> <?php echo htmlspecialchars($CEP); ?></p>
                           
                        </div>
                        <div class="info-item">
                            <p><strong>Rua:</strong> <?php echo htmlspecialchars($Rua); ?></p>
                     
                        </div>
                        <div class="info-item">
                            <p><strong>Número:</strong> <?php echo htmlspecialchars($Numero); ?></p>
                 
                        </div>
                        <div class="info-item">
                            <p><strong>Bairro:</strong> <?php echo htmlspecialchars($Bairro); ?></p>
                          
                        </div>
                        <div class="info-item">
                            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($Cidade); ?></p>

                        </div>
                        <div class="info-item">
                            <p><strong>Estado:</strong> <?php echo htmlspecialchars($Estado); ?></p>
                          
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

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



    
    
    

    <!-- Modal -->

 
    <div id="fotoModal" class="modal">
        <div class="modal-content"  style="height: 300px">
            <span class="close">&times;</span>
            <h2>Pré-visualização da Foto</h2>
            <form id="fotoForm" action="../backend/editar/editar_foto_perfil.php" method="post" enctype="multipart/form-data">
            <img id="preview-img" src="" alt="Preview">
            <div class="modal-buttons">
                <button  class="confirmButton" id="confirmButtonFoto" type="submit">Confirmar</button>
                <button class="cancelButton" id="cancelButtonFoto" type="button">Cancelar</button>
            </div>
        </div>
        
            <input type="file" name="Foto" id="file-input" accept="image/*" style="display: none;">
        </form>
    
    </div>    

<!-- Modal HTML -->
<!-- Modal de Edição -->
<div id="editInfoModal" class="modal">
  <div class="modal-content" style="width: 600px; height: 500px">
    <span class="close">&times;</span>
    <h2>Editar Informações Pessoais</h2>
    <form action="../backend/editar/perfil/editar-info-pessoais.php?id=<?php echo $user_id ?>" method="POST">
      <input type="text" id="editNome" name="Nome" value="<?php echo htmlspecialchars($Nome); ?>"  placeholder="Nome">
      <input type="text" id="editSobrenome" name="Sobrenome"  value="<?php echo htmlspecialchars($Sobrenome); ?>"  placeholder="Sobrenome">
      <input type="tel" id="editTelefone" name="Telefone"  value="<?php echo htmlspecialchars($Telefone); ?>"  placeholder="Telefone">
      <!-- <div class="password-container">
                    <input type="password" id="password" name="SenhaNova"  placeholder="Digite sua nova Senha...">
                    <i id="togglePassword" class="fas fa-eye"></i>
                </div> -->

      <button type="submit" class="save-btn">Salvar Alterações</button>
      <button class="cancelButton" id="cancelButtonEditarPerfil">Cancelar</button>
    </form>
  </div>
</div>

<!-- Modal para Editar Endereço -->
<div id="editEnderecoModal" class="modal">
  <div class="modal-content" style="width: 600px; height: 600px">
  <span class="close">&times;</span>
    <h2>Editar Endereço</h2>
    <form action="../backend/editar/perfil/editar_endereco.php?id=<?php echo $user_id ?>" method="POST">
      <input type="text" id="editCEP" name="CEP" value="<?php echo htmlspecialchars($CEP); ?>" placeholder="CEP">
      <input type="text" id="editRua" name="Rua" value="<?php echo htmlspecialchars($Rua); ?>"  placeholder="Rua">
      <input type="text" id="editNumero" name="Numero" value="<?php echo htmlspecialchars($Numero); ?>" placeholder="Número">
      <input type="text" id="editBairro" name="Bairro" value="<?php echo htmlspecialchars($Bairro); ?>"  placeholder="Bairro">
      <input type="text" id="editCidade" name="Cidade" value="<?php echo htmlspecialchars($Cidade); ?>"  placeholder="Cidade">
      <input type="text" id="editEstado" name="Estado" value="<?php echo htmlspecialchars($Estado); ?>"  placeholder="Estado">
      <div id="error-message" style="margin-top: 10px;" class="error-message"></div> <!-- Novo elemento para exibir mensagens de erro -->
      <button type="submit" class="save-btn">Salvar Alterações</button>
      <button class="cancelButton" id="cancelButtonEditarAdress">Cancelar</button>
    </form>
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

    // Abre o modal quando o botão de logout é clicado
    document.getElementById('logoutButton').addEventListener('click', function (event) {
        event.preventDefault(); // Impede o redirecionamento imediato
        logoutModal.style.display = 'block'; // Exibe o modal
    });

    // Fecha o modal ao clicar no "X" ou no botão de cancelar
    closeBtn.addEventListener('click', function () {
        logoutModal.style.display = 'none';
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
    });
});

cancelButtonFoto.addEventListener('click', function () {
    fotoModal.style.display = 'none';
    fileInput.value = ''; // Limpa o input de arquivo
    previewImg.src = ''; // Limpa a imagem pré-visualizada
});

    // Referências aos elementos do DOM
    document.addEventListener('DOMContentLoaded', function () {
    const fotoModal = document.getElementById('fotoModal');
    const closeFotoModal = fotoModal.querySelector('.close');
    const confirmButtonFoto = document.getElementById('confirmButtonFoto');
    const cancelButtonFoto = document.getElementById('cancelButtonFoto');
    const fileInput = document.getElementById('file-input');
    const previewImg = document.getElementById('preview-img');
    const fotoForm = document.getElementById('fotoForm');

    // Abre o modal de foto quando o botão é clicado
    document.getElementById('alterar-foto-btn').addEventListener('click', function () {
        fileInput.click();
    });

    // Exibe a foto pré-visualizada no modal
    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                fotoModal.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Fecha o modal ao clicar no "X"
    closeFotoModal.addEventListener('click', function () {
        fotoModal.style.display = 'none';
    });

    // Corrigido: Cancela a mudança e fecha o modal
    cancelButtonFoto.addEventListener('click', function () {
        fotoModal.style.display = 'none';
        fileInput.value = ''; // Limpa o input de arquivo
        previewImg.src = ''; // Limpa a imagem pré-visualizada
    });

    // Envia o formulário ao confirmar
    // Fecha o modal ao clicar fora dele
    window.addEventListener('click', function (event) {
        if (event.target === fotoModal) {
            fotoModal.style.display = 'none';
        }
    });
});




// Seleciona os botões de editar
const editInfoButton = document.querySelector('.edit-info-btn');
const editEnderecoButton = document.querySelector('.edit-endereco-btn');

// Seleciona os modais
const infoModal = document.getElementById('editInfoModal');
const enderecoModal = document.getElementById('editEnderecoModal');

// Seleciona os botões de fechar para cada modal
const closeInfoModalBtn = infoModal.querySelector('.close');
const closeEnderecoModalBtn = enderecoModal.querySelector('.close');

// Abre o modal de informações pessoais
editInfoButton.addEventListener('click', () => {
  infoModal.style.display = 'flex'; // Mostrar o modal de informações pessoais
});

// Abre o modal de endereço
editEnderecoButton.addEventListener('click', () => {
  enderecoModal.style.display = 'flex'; // Mostrar o modal de endereço
});

// Fecha o modal de informações pessoais
closeInfoModalBtn.addEventListener('click', () => {
  infoModal.style.display = 'none'; // Esconder o modal de informações pessoais
});

// Fecha o modal de endereço
closeEnderecoModalBtn.addEventListener('click', () => {
  enderecoModal.style.display = 'none'; // Esconder o modal de endereço
});

// Fecha os modais ao clicar fora do conteúdo
window.addEventListener('click', (e) => {
  if (e.target === infoModal) {
    infoModal.style.display = 'none';
  }
  if (e.target === enderecoModal) {
    enderecoModal.style.display = 'none';
  }
});












document.getElementById('togglePassword').addEventListener('click', function () {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});


// Função para consultar o CEP
// Função para mostrar a mensagem de erro abaixo do último campo de entrada
function mostrarMensagemDeErro(mensagem) {
    var errorMessageElement = document.getElementById('error-message');
    errorMessageElement.textContent = mensagem;
}

// Função para limpar a mensagem de erro
function limparMensagemDeErro() {
    var errorMessageElement = document.getElementById('error-message');
    errorMessageElement.textContent = '';
}

// Função para consultar o CEP
function consultarCEP(cep) {
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                preencherCamposEndereco(data);  // Preenche os campos com o resultado da consulta
                limparMensagemDeErro(); // Limpa qualquer mensagem de erro anterior
            } else {
                mostrarMensagemDeErro('CEP não encontrado.');
            }
        })
        .catch(error => {
            console.error('Erro ao consultar API do ViaCEP:', error);
            mostrarMensagemDeErro('Erro ao consultar CEP. Por favor, tente novamente.');
        });
}

// Função para preencher os campos de endereço no modal de edição
function preencherCamposEndereco(data) {
    document.getElementById('editRua').value = data.logradouro || '';  // Preenche o campo "Rua"
    document.getElementById('editBairro').value = data.bairro || '';   // Preenche o campo "Bairro"
    document.getElementById('editCidade').value = data.localidade || ''; // Preenche o campo "Cidade"
    document.getElementById('editEstado').value = data.uf || '';       // Preenche o campo "Estado"
}

// Evento para capturar a ação no campo de CEP e chamar a função de consulta
document.getElementById('editCEP').addEventListener('blur', function() {
    var cep = this.value.replace(/\D/g, '');  // Remove qualquer caractere não numérico do CEP
    if (cep.length === 8) {  // Verifica se o CEP possui 8 dígitos
        consultarCEP(cep);   // Chama a função de consulta de CEP
    } else {
        mostrarMensagemDeErro('CEP inválido. Verifique e tente novamente.');
    }
});

// Função para mostrar o modal
function mostrarModal() {
    var modal = document.getElementById('editEnderecoModal');
    modal.style.display = "block";

    // Fecha o modal ao clicar no 'x'
    var closeBtn = modal.getElementsByClassName('close')[0];
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };

    // Fecha o modal ao clicar fora dele
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
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
