<!DOCTYPE html>
<html lang="pt-br">


<?php
session_start();


require_once '../../backend/classes/usuarios/ArmazenarUsuario.php';


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



    

if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
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
    
    <title>Usuários do Sistema</title>
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
        <h1>Lista de Usuários</h1>
        <table>
            <thead>
                <tr>
                 
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Email</th>
                    <th>telefone</th>
                    <th>Tipo</th>
                    <th>Excluir</th>
                   

                </tr>

             
            </thead>
            <tbody>
                <!-- Exemplo de linha de usuário -->
          
                <?php
                        while($linhas = $usuario -> fetch_object()) {
                        ?>
                            <tr>
                                <td><?php echo $linhas->Nome; ?></td>
                                <td><?php echo $linhas->Sobrenome; ?></td>
                                <td><?php echo $linhas->Email; ?></td>
                                <td><?php echo $linhas->Telefone; ?></td>
                                <!-- <td><?php echo $linhas->Tipo; ?></td> -->
                                <td>
                                <?php
                                    if ($linhas->Tipo == 1) {
                                    ?>
                                        <button class="tipoADM"><a href="../../backend/editar/editar_tipo.php?id=<?php echo $linhas->ID; ?>&tipo=0" class="change-type">Administrador</a></button>
                                    <?php
                                    } else {
                                    ?>
                                         <button class="tipoComum"><a href="../../backend/editar/editar_tipo.php?id=<?php echo $linhas->ID; ?>&tipo=1" class="change-type">Comum</a></button>
                                    <?php
                                    }
                                    ?>
                                </td>
                           
                                <td>
                                    <a href="../../backend/excluir/excluirUsuarios.php?id=<?php echo $linhas->ID; ?>"><button class="excluir-btn"><i class="fas fa-trash"></i></button></a>
                                </td>

                            </tr>
                        <?php
                        }
                        ?>      
    

              
        
            </tbody>
        </table>
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
        <p>Deseja realmente alterar o tipo do usuário?</p>
        <div class="button-container">
            <button id="confirmButtonTipo" class="confirmButton">Confirmar</button>
            <button id="cancelButtonTipo" class="cancelButton">Cancelar</button>
        </div>
    </div>
</div>

<div id="logoutModal" class="modal">
  <div class="modal-content" style="height: 200px">
    <span class="close">&times;</span>
    <p>Você tem certeza que deseja sair?</p>
    <button  class="confirmButton" id="confirmButtonLogout">sim</button>
    <button class="cancelButton" id="cancelButtonLogout">não</button>
  </div>
</div>




<div id="DeleteModal" class="modal">
    <div class="modal-content">
        <p>Deseja realmente excluir o Usuário?</p>
        <div class="button-container">
            <button id="confirmButtonExcluir" class="confirmButton">Confirmar</button>
            <button id="cancelButtonExcluir" class="cancelButton">Cancelar</button>
        </div>
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
        window.location.href = '../../backend/cadastro e login/logout.php'; // Redireciona para o script de logout
    });

    // Fecha o modal ao clicar fora dele
    window.addEventListener('click', function (event) {
        if (event.target === logoutModal) {
            logoutModal.style.display = 'none';
        }
    });
});


// Função para exibir o modal
function showConfirmModal(url) {
    const modal = document.getElementById('confirmModal');
    modal.style.display = 'block';

    // Botão de Confirmar
    document.getElementById('confirmButtonTipo').onclick = function() {
        window.location.href = url; // Redireciona para a URL de alteração
    };

    // Botão de Cancelar
    document.getElementById('cancelButtonTipo').onclick = function() {
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


