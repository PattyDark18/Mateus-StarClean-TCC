<!DOCTYPE html>
<html lang="pt-br">



<?php
session_start();




require_once '../../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../../backend/classes/servicos/ArmazenarServicos.php';

$ArmazenarServicos = new ArmazenarServicoMYSQL();
$Servico = $ArmazenarServicos -> listarTodosServicos();
$ServicoID = $_GET['id'];
$ServicoBuscar = $ArmazenarServicos->buscarServico($ServicoID);
if($ServicoBuscar){
$Servico = $ServicoBuscar->fetch_assoc();
$nomeServico = $Servico['nome_servicos'];
$descricaoServico = $Servico['descricao'];
$vantagensServico = $Servico['vantagens'];
$Preco = $Servico['preco'];
$foto1 = isset($Servico['foto1']) ? $Servico['foto1'] : null;
$foto2 = isset($Servico['foto2']) ? $Servico['foto2'] : null;
$foto3 = isset($Servico['foto3']) ? $Servico['foto3'] : null;
$foto4 = isset($Servico['foto4']) ? $Servico['foto4'] : null;
$foto5 = isset($Servico['foto5']) ? $Servico['foto5'] : null;

    }else{
        echo "Erro: serviço não encontrado";
    }



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
    <link rel="stylesheet" href="../../css/servicos/servico.especifico.css">
    <link rel="stylesheet" href="../../css/home-style/responsivo.css">
    
    <title><?php echo $nomeServico ?></title>
</head>
<body>

<?php if ($Tipo == 1): ?>

<header>
  <nav class="menu" role="navigation" aria-label="Menu Principal">
      
          <img class="logo" src="../../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img" >
      
      <div class="hamburger" aria-label="Abrir menu responsivo">
          &#9776;
      </div>
      <ul class="links" role="menubar">
        <li role="menuitem"><a href="../home.php">Home</a></li>
        <li role="menuitem"><a href="../adm/editar_servicos.php">Editar Serviços</a></li>
        <li role="menuitem"><a href="../adm/editar_usuarios.php">Editar Usuários</a></li>
      </ul>

<?php else: ?>

<header>
  <nav class="menu" role="navigation" aria-label="Menu Principal">
      
          <img class="logo" src="../../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img" >
      
      <div class="hamburger" aria-label="Abrir menu responsivo">
          &#9776;
      </div>
      <ul class="links" role="menubar">
        <li role="menuitem"><a href="../home.php">Home</a></li>
        <li class="dropdown" role="menuitem">
          <a href="servicos.php" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Serviços <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
            <ul class="dropdown-content" role="menu" aria-label="Serviços">
            <?php
                $Servicos = $ArmazenarServicos->listarTodosServicos();
                while ($linhas = $Servicos->fetch_object()) {
                    ?>
               
                        <li role="menuitem"><a href="pagina_servico.php?id=<?php echo $linhas->ServicoID; ?>"><?php echo htmlspecialchars($linhas->nome_servicos); ?></a></li>
               
                <?php
                }
                ?>




              </ul>
          </li>
          
                  <?php if (isset($_SESSION['logado']) && $_SESSION['logado']): ?>
            <?php if ($Tipo == 0): ?>
                <li class="dropdown" role="menuitem">
                    <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Agendamento <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
                    <ul class="dropdown-content" role="menu" aria-label="agendamento">
                        <li role="menuitem"><a href="../forms/agendamento/agendamento.php">Agendar serviço</a></li>
                        <li role="menuitem"><a href="../meus_agendamentos.php">Meus Serviços agendados</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li role="menuitem"><a href="../forms/agendamento/agendamento.php">Agendamento</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li role="menuitem"><a href="../forms/agendamento/agendamento.php">Agendamento</a></li>
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
                                <img  src="data:image/jpeg;base64,<?= ($Foto) ?>" alt="Foto de Perfil">
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
                        <li><a href="../pontos.php">Estrelas:  <?php echo $Pontos; ?></a></li>
                        <?php
                        }else if ($Tipo == 1){
                          ?>
                            <li><a href="#">Tipo: Administrador</a></li>
                        
                          <?php
                        }
                        ?>
                     
                        <li><a href="perfil.php">Editar Perfil</a></li>
                        </li><a href="../../backend/cadastro e login/logout.php" id="logoutButton">Logout</a></li>
                      </ul>


                  </div>
              </div>
          </div>
      <?php else: ?>
          <div class="botoes">
              <a href="../forms/criar_conta.php" class="cadastrar" role="button">Cadastre-se</a>
              <a href="../forms/login.php" class="login" role="button">Login</a>
          </div>
      <?php endif; ?>

        
  </nav>
</header>

<div class="main-content">
<div class="cards-container">
    <div class="card">
        <div class="card-content">
            <h3><?php echo $nomeServico ?> - a partir de: R$<?php echo $Preco ?></h3>
            <p>
                <?php echo $descricaoServico ?>
            </p>
        </div>

        <div class="half-moon-image right btn-adjust">
        <img src="../../src/uploads/fotos/<?= htmlspecialchars($foto1) ?>"" alt="">
       
        </div>
    </div>

    <div class="card">
        <div class="half-moon-image left">
       <img src="../../src/uploads/fotos/<?= htmlspecialchars($foto2) ?>"" alt="">
        </div>
        <div class="card-content">
            <h3>Vantagens - por que fazer esse serviço?</h3>
                <p>
                    <?php echo $vantagensServico ?>
            </p>
        </div>
    </div>

    <div class="card card-slide">
 
        <h3>Veja algumas fotos desse serviço:</h3>
        <div class="slide-container">
            <div class="slides">
                <div class="slide">
                <img src="../../src/uploads/fotos/<?= htmlspecialchars($foto3) ?>"" alt="">
                </div>
                <div class="slide">
          <img src="../../src/uploads/fotos/<?= htmlspecialchars($foto4) ?>"" alt="">
                </div>
                <div class="slide">
             <img src="../../src/uploads/fotos/<?= htmlspecialchars($foto5) ?>"" alt="">
                </div>
            </div>
            <button class="prev" onclick="prevSlide()">&#10094;</button>
            <button class="next" onclick="nextSlide()">&#10095;</button>
        </div>
   
</div>



</div>



    <div class="bottom-buttons">
        <a href="../servicos/servicos.php" class="button view-services">Ver outros serviços</a>
        <a href="../forms/agendamento/agendamento.php" class="button schedule-service">Quero agendar esse serviço</a>
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




<script src="../../src/js/pg_servico.js"></script>
<script src="../../src/js/script.js"></script>



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

</script>
</body>
</html>
