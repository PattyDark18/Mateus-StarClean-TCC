<!DOCTYPE html>
<html lang="pt-br">


<?php
session_start();
require_once '../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../backend/classes/servicos/ArmazenarServicos.php';


$ArmazenarServicos = new ArmazenarServicoMYSQL();
$Servico = $ArmazenarServicos -> listarTodosServicos();

$Nome_servicos = isset($_SESSION['nome_servicos']) ? $_SESSION['nome_servicos'] : '';



$Tipo = null;
// Verifica se o usuário está logado
if (isset($_SESSION['logado']) && $_SESSION['logado']) {
  
    $logado = true;

    $user_id = $_SESSION['ID'];
    $ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
    $usuario = $ArmazenarUsuario->buscarUsuario($user_id);
  
    $Pontos_usuario = $ArmazenarUsuario->buscarPontosUsuario($user_id);



    // Dados do usuário
    $Nome = $_SESSION['nome'];
    $Sobrenome = $_SESSION['sobrenome'];
    $Telefone = $_SESSION['telefone'];
    $Email = $_SESSION['email'];
    $Senha = $_SESSION['senha'];
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
}

// Gerencia a mensagem de sessão
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
    <!-- <link rel="shortcut icon" href="../src/img/logo/icone.ico"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/preset/reset.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/preset/vars.css">
    <link rel="stylesheet" href="../css/preset/modals.css">
    <link rel="stylesheet" href="../css/preset/bases/base-estilo.css">
    <link rel="stylesheet" href="../css/home-style/home-style.css">
    <link rel="stylesheet" href="../css/home-style/responsivo.css">
    
    <title>Home - Mateus StarClean</title>
</head>
<body>


  <header>
    <nav class="menu" role="navigation" aria-label="Menu Principal">
        
            <img class="logo" src="../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img" >
        
        <div class="hamburger" aria-label="Abrir menu responsivo">
            &#9776;
        </div>
        <ul class="links" role="menubar">
          <li role="menuitem"><a href="home.php">Home</a></li>
<?php if ($Tipo == 1): ?>

          <li class="dropdown" role="menuitem">
            <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Serviços <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only"></span></a>
              <ul class="dropdown-content" role="menu" aria-label="Serviços">
                <li role="menuitem"><a href="adm/editar_servicos.php">Editar Serviços</a></li>
                <li role="menuitem"><a href="forms/adm/adicionar_servico.php">Adicionar Serviço</a></li>
              </ul>
          </li>
          <li role="menuitem"><a href="adm/editar_usuarios.php">Editar Usuários</a></li>
          <li role="menuitem"><a href="adm/editar_agendamentos.php">Editar Agendamentos</a></li>



          
          <li class="dropdown" role="menuitem">
            <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Estrelas <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
              <ul class="dropdown-content" role="menu" aria-label="Cupons">
                <li role="menuitem"><a href="adm/editar_cupons.php">Editar cupons</a></li>
                <li role="menuitem"><a href="forms/adm/adicionar_cupom.php">Adicionar cupom</a></li>
                <li role="menuitem"><a href="adm/editar_premios.php">Editar prêmios</a></li>
                <li role="menuitem"><a href="forms/adm/adicionar_premios.php">Adicionar Premio</a></li>
               
              </ul>
          </li>
        </ul>

  <?php else: ?>


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
        <?php endif; ?>

      </ul>

          
          


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
            <div class="botoes">
                <a href="forms/criar_conta.php" class="cadastrar" role="button">Cadastre-se</a>
                <a href="forms/login.php" class="login" role="button">Login</a>
            </div>
        <?php endif; ?>

          
    </nav>
</header>
  
    <div class="main-content">
      
    <div class="container" role="region" aria-label="Nome da empresa e slogan">
      <div class="div-top">
      
       <h1 class="titulo">Mateus StarClean</h1>
        <h2 class="slogan">Aqui seu carro brilha mais que uma estrela!</h2>
      </div>
      <img src="../src/img/logo/logo.png" class="central-image" alt="imagem central">
      <div class="div-bottom">
        
      </div>
    </div>

       <div class="principal" role="main" aria-label="história da marca">
        <div class="informacoes">
          <h1>Sobre a Estética Automotiva</h1>
          <p class="text">
          Tudo começou com Mateus Araújo da Silveira, um Empreendedor livre que é apaixonado por automóveis desde a infância. Aos 11 anos, ele decidiu embarcar na jornada automotiva, movido por uma paixão que nascia sempre que o assunto era o cuidado com os carros.
          Em 2021, o mundo de Mateus se transformou. Ele mergulhou no universo da estética automotiva e foi acolhido pelo Veneto Studio Automotivo, que o impulsionou a crescer e a ganhar destaque na internet.
          </p>
        
    
        </div>
    
        <div class="container-foto" role="img" aria-label="container foto de perfil">
            <div class="foto">
                <img src="../src/img/foto-perfil.jpeg" alt="Mateus Araújo da Silveira - Empreendedor livre do Negócio Mateus StarClean">
            </div>
        </div>
        
      </div>

      <div class="destaque" role="region" aria-label="destaque da história da marca">
        <div class="video-container">
          <iframe width="640" height="360" src="https://www.youtube.com/embed/PJwyiy8q-dI?si=g3vRJC3uDwd4-bHY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <p>
         A partir da visita ao Veneto Studio, Mateus encontrou um novo caminho. Com o apoio de várias pessoas, ele colocou sua energia nesse empreendimento, um compromisso que se mantém até hoje.
        </p>
      </div>



      <div class="secundario" role="region" aria-label="história da marca - card com imagem">
        <div class="card-informativo">
          <div class="card-content">
            <div class="texto-card">
              <p>
               Através das redes sociais, Mateus compartilha sua paixão pelo trabalho autônomo com carros, acolhido também por outros entusiastas do universo automotivo. Por enquanto, a empresa ainda é um projeto, um sonho para o futuro, devido à juventude de Mateus. No entanto, com determinação, apoio da família e de figuras influentes, ele encontrou todo o suporte necessário para trazer um toque especial a cada carro de que cuida.
              </p>

              <?php if($Tipo!=1){ ?>
              <div class="agendar">
                <a role="button" href="./forms/agendamento/agendamento.php">Quero agendar agora!</a>
              </div>
              <?php } ?>
            </div>
            <div class="foto-card" role="img" aria-label="Imagem do Mateus realizando um serviço automotivo - complemento do card">
              <img src="../src/img/lavagem.jpeg" alt="Mateus fazendo uma lavagem simples num corsa">
            </div>
          </div>
        </div>
      </div> 

      
    </div>
  </div>
  <div class="video-servicos-home" id="video-servicos-home" role="region" aria-label="cards de alguns dos serviços oferecidos">
  <h2 class="titulo-secao">Alguns dos serviços oferecidos:</h2>
  <div class="container-servicos">
    <div class="servico">
      <video class="video-servico" muted autoplay loop>
        <source src="../src/videos/higienizacao_banco.mp4" type="video/mp4">
     
        Seu navegador não suporta a tag de vídeo.
      </video>
      <h3 class="titulo-servico">Higienização de Banco</h3>
      <div class="informacoes-servico">
        <p class="texto-servico">A higienização de banco cuida da limpeza e manutenção dos assentos do veículo, para garantir sua aparência, conforto e durabilidade.</p>
      </div>
      <?php if($Tipo!=1){ ?>
      <button class="saiba-mais">
        <a href="../html/servicos/servicos.php" aria-label="saiba mais sobre higienização de banco" aria-hidden="true" role="button">Saiba Mais</a>
      </button>
      <?php } ?>
    </div>

    <div class="servico">
      <video class="video-servico" muted autoplay loop>
        <source src="../src/videos/lavagem_Snowfoam.MP4" type="video/mp4">
       
        Seu navegador não suporta a tag de vídeo.
      </video>
      <h3 class="titulo-servico">Lavagem Snowfoam</h3>
      <div class="informacoes-servico">
        <p class="texto-servico">
        A lavagem com SnowFoam utiliza uma espuma densa para pré-lavar o veículo. A espuma adere à superfície do carro, amolecendo e encapsulando sujeira, poeira e contaminantes.</p>
      </div>
      <?php if($Tipo!=1){ ?>
      <button class="saiba-mais">
        <a href="../html/servicos/servicos.php" role="button" aria-label="saiba mais sobre Lavagem SnowFoam" aria-hidden="true">Saiba Mais</a>
      </button>
      <?php } ?>
    </div>

    <div class="servico">
      <video class="video-servico" muted autoplay loop>
        <source src="../src/videos/polimento.mp4" type="video/mp4">
      
        Seu navegador não suporta a tag de vídeo.
      </video>
      <h3 class="titulo-servico">Polimento</h3>
      <div class="informacoes-servico">
        <p class="texto-servico">O polimento é uma técnica para restaurar o brilho e remover 95% dos arranhões da superfície do veículo, proporcionando acabamento suave e lustroso.</p>
      </div>
      <?php if($Tipo!=1){ ?>
      <button class="saiba-mais">
        <a href="../html/servicos/servicos.php" role="button" aria-label="saiba mais sobre polimento" aria-hidden="true">Saiba Mais</a>
      </button>
      <?php } ?>
    </div>
  </div>
</div>

<div class="capsule" id="capsule">
    <div class="contents">
        <!-- <h2>Cápsula do Tempo</h2> -->
        <p>Dentro desta cápsula, guardamos as raízes da nossa paixão pela estética automotiva. Cada elemento representa o cuidado e a dedicação que colocamos em cada veículo. Clique para abrir e descubra como a Mateus StarClean está transformando o universo automotivo com uma identidade visual renovada e soluções inovadoras!</p>
        <div class="secret" id="openButton">Clique para abrir! <i class="fas fa-key"></i></div>
    </div>
</div>

<div class="popup" id="popup">
    <span id="closeButton" class="close-btn">×</span>
    <div class="popup-content">
        <h2>Descubra o Manual da Marca</h2>
        <p>Bem-vindo ao nosso manual! Aqui, revelamos não apenas a identidade visual da Mateus StarClean, mas também a missão e os valores que nos impulsionam. Passe o mouse sobre a imagem para visualizar a capa do manual e clique para baixá-lo. Dentro dele, você encontrará os segredos que fazem de nós seu parceiro de confiança na estética automotiva.</p>
    </div>
    <div class="manual-preview">
        <img src="../src/img/outros/manual-da-marca-capa.jpeg" alt="Capa do Manual" class="manual-cover">
        <a href="../src/manual da Marca/Manual da Marca - Mateus StarClean.pdf" class="download-link" download>   <i class="fas fa-download"></i></a>
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

  </div>


<!-- Modal de Confirmação de Logout -->
<div id="logoutModal" class="modal">
  <div class="modal-content" style="height: 200px">
    <span class="close">&times;</span>
    <p>Você tem certeza que deseja sair?</p>
    <button  class="confirmButton" id="confirmButtonLogout">sim</button>
    <button class="cancelButton" id="cancelButtonLogout">não</button>
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

    <script src="../src/js/script.js"></script>
    <script>
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




// Função para abrir o popup
function openPopup() {
    const popup = document.getElementById('popup');
    popup.classList.add('show');
}

// Função para fechar o popup
function closePopup() {
    const popup = document.getElementById('popup');
    popup.classList.remove('show');
}

// Eventos para abrir e fechar o popup
document.getElementById('openButton').addEventListener('click', openPopup);
document.getElementById('closeButton').addEventListener('click', closePopup);

// Seleciona os elementos necessários
const manualPreview = document.querySelector('.manual-preview');
const manualCover = document.querySelector('.manual-cover');
const downloadLink = document.querySelector('.download-link');

// Eventos para mostrar e ocultar a capa
manualPreview.addEventListener('mouseover', () => {
    manualCover.style.right = '0';
    manualCover.style.opacity = '1';
    downloadLink.style.display = 'block';
});

manualPreview.addEventListener('mouseout', () => {
    manualCover.style.right = '100%';
    manualCover.style.opacity = '0';
    downloadLink.style.display = 'none';
});
</script>


</body>
</html>
