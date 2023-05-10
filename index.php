<!DOCTYPE html>
<?php
  session_start();
  require './database/conectaBD.php'; 
?>
<html>
<head>
<title>Chestplace</title>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="./scripts/login.js"></script>
  <link rel="stylesheet" href="./styles.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
body { background-color: #cca310; }
</style>
</head>
<body class="w3-content" style="max-width:1200px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <img src="./imagens/logo_chestplace.png" style="width: 100%; margin-top: 10px;">
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a onclick="myAccFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
      Camisetas <i class="fa fa-caret-down"></i>
    </a>
    <div id="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <form method="GET" action="">
          <label for="data-criacao-select">Filtrar por data de criação:</label>
            <select id="data-criacao-select" name = "ordem" onchange="this.form.submit()" >
              <option value=""  disabled hidden selected>Filtro</option>
              <option value="mais-recentes">Mais recentes</option>
              <option value="mais-antigas">Mais antigas</option>
              <option value="nova">Novas</option>
              <option value="usada">Usadas</option>
          </select>
          
      </form>
    </div>
  </div>
  <a href="#footer" class="w3-bar-item w3-button w3-padding">Contato</a> 
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <!-- Top header -->
  <header class="w3-container w3-xlarge">
    <p class="w3-left">Camisetas</p>
    <p class="w3-right">
      <?php
        // Exibe nome do usuário logado e o botão de logout, se não mostrará os botões de login e cadastro
        $usuarioLogou = isset($_SESSION ['nome_usuario']);
        if ($usuarioLogou) {
          $nomeUsuario = $_SESSION['nome_usuario'];
          echo <<<END
            <span style="margin-right: 10px;">Olá,<a href="/chestplace/page_gerProdutos.php " > $nomeUsuario</a> </span>
            <button class="w3-btn w3-deep-orange w3-border" onclick="window.location.href='./logout.php'" 
            style="font-size: 15px; font-weight: 700; margin-right: 10px;">Sair</button>
          END;
        } else {
          echo <<<END
            <button class="w3-btn w3-deep-orange w3-border" onclick="document.getElementById('id0L').style.display='block'" 
            style="font-size: 15px; font-weight: 700; margin-right: 10px;">Entrar</button>
            <button class="w3-btn w3-white w3-border" onclick="document.getElementById('modalCadastro').style.display='block'" 
            style="font-size: 15px; font-weight: 700; margin-right: 10px;">Cadastrar-se</button>
          END;
        }
      ?>     
      <i class="fa fa-shopping-cart w3-margin-right"></i>
      <i class="fa fa-search"></i>
    </p>
  </header>

  <!-- MODAL LOGIN: pop up para realizar Login -->
  <div id="id0L" class="w3-modal ">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">
      <div class="w3-center"> 
        <span onclick="document.getElementById('id0L').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Fechar">×</span>
      </div>

      <h2 class="w3-center w3-xxlarge">Entrar</h2>

      <form action="login.php" method="POST" class="w3-container w3-card-4 w3-light-grey w3-margin">
        <div class="w3-section">
          <label class="w3-text-IE"><b>E-mail</b></label>
          <input class="w3-input w3-border w3-margin-bottom" type="text" name="Login" pattern="(?=.+@.+\..+).{1,255}" 
            title="Deve informar um e-mail com até 255 caracteres." placeholder="usuario@dominio.com" required maxlength="255">
          <label class="w3-text-IE"><b>Senha</b></label>
          <input class="w3-input w3-border" name="Senha" id="Senha" type="password"  
             placeholder="" 
            title="Deve informar uma senha com 6 a 255 caracteres" 
            required maxlength="255">
          <p>
          <input type="checkbox" class="w3-btn w3-theme"  onclick="mostrarOcultarSenhaLogin()"> <b>Mostrar senha</b>
          </p>
          <p id="msgLoginInvalido" class="w3-center w3-text-red" style="display:none;">E-mail ou senha inválidos!</p>
          <button class="w3-button w3-block w3-theme w3-section w3-padding w3-cyan" type="submit">Entrar</button>
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('id0L').style.display='none'" type="button" class="w3-button w3-red">Cancelar</button>
        <span class="w3-right w3-padding w3-hide-small"><a href="#">Esqueceu a senha?</a></span>
      </div>
    </div>
  </div>
  <?php
    // Se falhou login, exibir modal de login e uma mensagem sobre o erro
    if (isset($_SESSION ['login_senha_invalidos'])) {
      echo <<<END
      <script>document.getElementById("id0L").style.display = "block";</script>
      <script>document.getElementById("msgLoginInvalido").style.display = "block";</script>
      END;
    } 
    unset($_SESSION ['login_senha_invalidos']);
  ?>

  <!-- MODAL CADASTRO: pop up com botões que redirecionam para diferentes tipos de cadastro (vendedor ou comprador) --> 
  <div id="modalCadastro" class="w3-modal ">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">
      <div class="w3-center"> 
        <span onclick="document.getElementById('modalCadastro').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Fechar">×</span>
      </div>

      <h2 class="w3-center w3-xxlarge">Cadastrar</h2>

      <div class="w3-container w3-card-4 w3-light-grey w3-margin">
        <div class="w3-section">
          <button onclick="//TODO: adicionar aqui o futuro link de cadastro do cliente" 
            class="w3-button w3-block w3-theme w3-section w3-padding w3-amber" type="submit">Sou cliente (em breve!)</button>
          <button onclick="window.location.href='./forms/form_cadVendedor.php'"
            class="w3-button w3-block w3-theme w3-section w3-padding w3-orange" type="submit">Sou vendedor</button>
        </div>
      </div>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('modalCadastro').style.display='none'" type="button" class="w3-button w3-red">Cancelar</button>
      </div>
    </div>
  </div>
  <div class="w3-container w3-text-grey" id="jeans">
      <p>
      <?php
        $queryQtde = "
        SELECT count(*) qtde 
        FROM camiseta ";

        $result = mysqli_query($conn, $queryQtde);

        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo $row["qtde"]." produtos";
          }
        } else {
          echo "0 results";
        }
      ?>  
      </p>
    </div>
  <!-- Product grid -->
  <?php
                    $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao >= CURDATE() ";
                    //predefine o sql para mostrar todas as camisetas postadas 
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                      // Verifica se o parâmetro "selecao" foi passado na URL
                      if (isset($_GET["ordem"])) {
                          // Obtém o valor selecionado
                          $valorSelecionado = $_GET["ordem"];
                  
                          // Atualiza a consulta SQL com base na opção selecionada
                          if ($valorSelecionado == "mais-recentes") {
                              $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao >= CURDATE() ORDER BY data_hora_publicacao DESC";
                          } elseif ($valorSelecionado == "mais-antigas") {
                            $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao >= CURDATE() ORDER BY data_hora_publicacao ASC ";
                          } elseif ($valorSelecionado == "nova") {
                            $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao >= CURDATE() AND conservacao = 'nova' ";
                          } elseif ($valorSelecionado == "usada") {
                            $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao >= CURDATE() AND conservacao = 'usada' ";
                          } 
                      }
                    }
                    $resultado = mysqli_query($conn, $sql);
                    
                    

                      // Verifica se há resultados
                      if (mysqli_num_rows($resultado) > 0) {  
                          // Loop pelos resultados
                          while ($produto = mysqli_fetch_assoc($resultado)) {
                            $sql = "SELECT  id, imagem FROM imagem where id_produto =" .$produto['id']." limit 1;";
                            $resultadoimg = mysqli_query($conn, $sql);
                            while ($rowimg = mysqli_fetch_assoc($resultadoimg)){
                              $imagemcamiseta = $rowimg['imagem'];
                            }
                            echo "
                              <div class=\"w3-col l3 s6\">
                                <div style = \"background-color: #cca310\" class=\"w3-container\">
                                  <div  class=\"w3-display-container\">
                            ";
                            // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
                            echo "<img src=\"data:imagem/jpeg;base64,".base64_encode($imagemcamiseta)."\"width= \"100%\"\>";
                            //Coloca botões, título e preço do anúncio
                            echo "
                                </div>
                                <p class = \"w3-text-white\">".$produto["titulo"]."<br><b>R$ ".number_format($produto["preco"], 2, ',', '.')."</b></p>
                                </div>
                              </div>
                            ";
                          }
                      }
                      // Fecha a conexão com o banco de dados
                      mysqli_close($conn);
                      
    ?>      
    
  
  <!-- Subscribe section -->
  <div style = "background-color: #cca310" class="w3-container w3-padding-32">
    <h1>Subscribe</h1>
    <p>To get special offers and VIP treatment:</p>
    <p><input class="w3-input w3-border" type="text" placeholder="Enter e-mail" style="width:100%"></p>
    <button type="button" class="w3-button w3-red w3-margin-bottom">Subscribe</button>
  </div>
  
  <!-- Footer -->
  <footer class="w3-padding-64 w3-light-grey w3-small w3-center" id="footer">
    <div class="w3-row-padding">
      <div class="w3-col s4">
        <h4>Contact</h4>
        <p>Questions? Go ahead.</p>
        <form action="/action_page.php" target="_blank">
          <p><input class="w3-input w3-border" type="text" placeholder="Name" name="Name" required></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Email" name="Email" required></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Subject" name="Subject" required></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Message" name="Message" required></p>
          <button type="submit" class="w3-button w3-block w3-black">Send</button>
        </form>
      </div>

      <div class="w3-col s4">
        <h4>About</h4>
        <p><a href="#">About us</a></p>
        <p><a href="#">We're hiring</a></p>
        <p><a href="#">Support</a></p>
        <p><a href="#">Find store</a></p>
        <p><a href="#">Shipment</a></p>
        <p><a href="#">Payment</a></p>
        <p><a href="#">Gift card</a></p>
        <p><a href="#">Return</a></p>
        <p><a href="#">Help</a></p>
      </div>

      <div class="w3-col s4 w3-justify">
        <h4>Store</h4>
        <p><i class="fa fa-fw fa-map-marker"></i> Company Name</p>
        <p><i class="fa fa-fw fa-phone"></i> 0044123123</p>
        <p><i class="fa fa-fw fa-envelope"></i> ex@mail.com</p>
        <h4>We accept</h4>
        <p><i class="fa fa-fw fa-cc-amex"></i> Amex</p>
        <p><i class="fa fa-fw fa-credit-card"></i> Credit Card</p>
        <br>
        <i class="fa fa-facebook-official w3-hover-opacity w3-large"></i>
        <i class="fa fa-instagram w3-hover-opacity w3-large"></i>
        <i class="fa fa-snapchat w3-hover-opacity w3-large"></i>
        <i class="fa fa-pinterest-p w3-hover-opacity w3-large"></i>
        <i class="fa fa-twitter w3-hover-opacity w3-large"></i>
        <i class="fa fa-linkedin w3-hover-opacity w3-large"></i>
      </div>
    </div>
  </footer>

  <div class="w3-black w3-center w3-padding-24">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></div>

  <!-- End page content -->
</div>

<!-- Newsletter Modal -->
<div id="newsletter" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
    <div class="w3-container w3-white w3-center">
      <i onclick="document.getElementById('newsletter').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
      <h2 class="w3-wide">NEWSLETTER</h2>
      <p>Join our mailing list to receive updates on new arrivals and special offers.</p>
      <p><input class="w3-input w3-border" type="text" placeholder="Enter e-mail"></p>
      <button type="button" class="w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('newsletter').style.display='none'">Subscribe</button>
    </div>
  </div>
</div>

<script>
// Accordion 
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

// Click on the "Jeans" link on page load to open the accordion for demo purposes
document.getElementById("myBtn").click();


// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>