<!DOCTYPE html>
<html lang="pt-br">



<?php
session_start();


require_once '../../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../../backend/classes/servicos/ArmazenarServicos.php';

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


$user_id = $_SESSION['ID'];
$ArmazenarUsuario = new ArmazenarUsuarioMYSQL();

$Nome = $_SESSION['nome'];
$Sobrenome = $_SESSION['sobrenome'];
$Telefone = $_SESSION['telefone'];
$Email = $_SESSION['email'];
$Foto = $_SESSION['foto'];
$Tipo = $_SESSION['tipo'];


$ArmazenarServicos = new ArmazenarServicoMYSQL();
$Servico = $ArmazenarServicos -> listarTodosServicos();

$Nome_servicos = isset($_SESSION['nome_servicos']) ? $_SESSION['nome_servicos'] : '';
$preco = isset($_SESSION['preco']) ? $_SESSION['preco'] : '';
$descricao = isset($_SESSION['descricao']) ? $_SESSION['descricao'] : '';
$vantagens = isset($_SESSION['vantagens']) ? $_SESSION['vantagens'] : '';
$status = isset($_SESSION['status']) ? $_SESSION['status'] : '';


if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
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
    <title>Editar Serviços do Sistema</title>


</head>
<body>
<header>
    <nav class="menu" role="navigation" aria-label="Menu Principal">
        <img class="logo" src="../../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img">
        <div class="hamburger" aria-label="Abrir menu responsivo">&#9776;</div>
        <ul class="links" role="menubar">
            <li role="menuitem"><a href="../home.php">Home</a></li>
            <li class="dropdown" role="menuitem">
                <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Serviços <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only"></span></a>
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
                <span class="dropbtn"><?php echo htmlspecialchars($Nome); ?></span>
                <div class="dropdown-perfil-content">
                    <div class="perfil-info">
                        <?php if ($Foto) { ?>
                            <img src="data:image/jpeg;base64,<?= $Foto ?>" alt="Foto de Perfil">
                        <?php } else { ?>
                            <img src="https://voxnews.com.br/wp-content/uploads/2017/04/unnamed.png" alt="Foto de Perfil">
                        <?php } ?>
                    </div>
                    <ul>
                        <li><a href="#">Tipo: Administrador</a></li>
                        <li><a href="perfil.php">Editar Perfil</a></li>
                        <li><a href="../../backend/cadastro e login/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="main-content">
    <div class="container-lista">
        <h1>Lista de Serviços</h1>
        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Preço (média)</th>
                    <th>Vantagens</th>
                    <th>Status</th>
                    <th>Duração (horas)</th>
                    <th>Editar</th>
                    <th>Ver fotos</th>
                    <th>Excluir</th>
                </tr>
        
            </thead>
            <tbody>
                <?php
                $Servicos = $ArmazenarServicos->listarTodosServicos();
                while ($linhas = $Servicos->fetch_object()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($linhas->nome_servicos); ?></td>
                        <td><?php echo htmlspecialchars($linhas->descricao); ?></td>
                        <td>R$ <?php echo htmlspecialchars($linhas->preco); ?></td>
                        <td><?php echo htmlspecialchars($linhas->vantagens); ?></td>
                        <!-- <td><?php echo htmlspecialchars($linhas->status); ?></td> -->
                        <td>
                                <?php
                                    if ($linhas->status == 1) {
                                    ?>
                                        <button class="status_verde"><a href="../../backend/editar/editar_statusServicos.php?id=<?php echo $linhas->ServicoID; ?>&status=0" class="change-type">Ativado</a></button>
                                    <?php
                                    } else {
                                    ?>
                                         <button class="status_vermelho"><a href="../../backend/editar/editar_statusServicos.php?id=<?php echo $linhas->ServicoID; ?>&status=1" class="change-type">Desativado</a></button>
                                    <?php
                                    }
                                    ?>
                                </td>

                                  <td><?php echo htmlspecialchars($linhas->duracao); ?>h</td> 
                    <td>
                    <a href="../forms/adm/editar-servico-especifico.php?id=<?php echo $linhas->ServicoID; ?>"><button class="edit-btn"><i class="fas fa-pencil-alt"></i></button></a>
                    </td>
                    
                    <td>
                    <button class="see-more-btn" data-id="<?php echo $linhas->ServicoID; ?>" data-foto1="<?php echo base64_encode($linhas->foto1); ?>" data-foto2="<?php echo base64_encode($linhas->foto2); ?>" data-foto3="<?php echo base64_encode($linhas->foto3); ?>" data-foto4="<?php echo base64_encode($linhas->foto4); ?>" data-foto5="<?php echo base64_encode($linhas->foto5); ?>"><i class="fas fa-search"></i></button>
                    </td>

                    <td>
                        <a href="../../backend/excluir/excluirServicos.php?id=<?php echo $linhas->ServicoID; ?>"><button class="excluir-btn"><i class="fas fa-trash"></i></button></a>
                    </td>

                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>

<!-- Card de Fotos -->
<?php
$Servicos = $ArmazenarServicos->listarTodosServicos();
while ($linhas = $Servicos->fetch_object()) {
    ?>
    <div id="photo-card-<?php echo $linhas->ServicoID; ?>" class="photo-card" style="display:none;">
        <div class="photo-card-content">
            <span class="close-btn">&times;</span>
            <div class="photo-slider">
                <button class="prev-btn">&#10094;</button>
                <button class="next-btn">&#10095;</button>
                <div class="slides">
                    <?php 
                    // Busca as imagens no banco de dados
                    $imagens = $ArmazenarServicos->buscarFotos($linhas->ServicoID);

                    // Exibe as imagens
                    if ($imagens) {
                        foreach ($imagens as $imagem) {
                            echo '<img class="slide" src="../../src/uploads/fotos/' . $imagem . '" alt="Imagem">';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<button class="add-service-btn"><a href="../forms/adm/adicionar_servico.php" style="color: white;">
    <i class="fas fa-plus"></i>Adicionar serviço </a>
</button>



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
</footer>


<div id="confirmModal" class="modal">
    <div class="modal-content">
        <p>Deseja realmente alterar esta função?</p>
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
        <p>Deseja realmente excluir o Serviço?</p>
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
document.addEventListener('DOMContentLoaded', function() {
    const seeMoreBtns = document.querySelectorAll('.see-more-btn');
    const modals = document.querySelectorAll('.photo-card');
    
    // Adiciona evento de clique nos botões "Ver Mais"
    seeMoreBtns.forEach(function(button) {
        button.addEventListener('click', function() {
            const serviceID = button.getAttribute('data-id');
            const modal = document.getElementById('photo-card-' + serviceID);
            if (modal) {
                modal.style.display = 'block';  // Abre o modal
                initializeSlide(modal);  // Inicializa o slide para este modal
            }
        });
    });

    // Função para fechar o modal ao clicar no botão de fechar
    document.querySelectorAll('.close-btn').forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
            const modal = this.closest('.photo-card');
            modal.style.display = 'none';  // Fecha o modal
        });
    });

// Função para inicializar o slide em cada modal
function initializeSlide(modal) {
    const slides = modal.querySelector('.slides');
    const slideImages = modal.querySelectorAll('.slides img');
    const prevBtn = modal.querySelector('.prev-btn');
    const nextBtn = modal.querySelector('.next-btn');
    let currentIndex = 0;

    // Atualiza o slide atual
    function updateSlide() {
        const offset = -currentIndex * 100;
        slides.style.transform = `translateX(${offset}%)`;
    }

    // Navega para a foto anterior
    prevBtn.addEventListener('click', function() {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : slideImages.length - 1;
        updateSlide();
    });

    // Navega para a próxima foto
    nextBtn.addEventListener('click', function() {
        currentIndex = (currentIndex < slideImages.length - 1) ? currentIndex + 1 : 0;
        updateSlide();
    });

    // Inicializa o slide ao abrir o modal
    updateSlide();
}
});



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


