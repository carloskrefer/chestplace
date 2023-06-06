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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="./scripts/login.js"></script>
  <link rel="stylesheet" href="./styles.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
body { background-color: #F0F0F0; }
nav { background-color: #3C486B!important; }
.meu-form select {
  width: 150px;
  border-radius: 10px;
}
</style>
</head>
<body class="w3-content" style="max-width:1200px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <img src="./imagens/logo_chestplace.png" style="width: 100%; margin-top: 10px;">
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a onclick="myAccFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
      Camisetas <i class="fa fa-caret-down"></i>
    </a>
    <div id="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium" style="color:white;">
      <form method="GET" action="" class = "meu-form">
          <!-- <label for="data-criacao-select">Filtrar por data de criação:</label> -->
            <select id="data-criacao-select" name = "ordem" onchange="this.form.submit()" >
              <option value=""  disabled hidden selected>Filtro</option>
              <option value="mais-recentes">Mais recentes</option>
              <option value="mais-antigas">Mais antigas</option>
              <option value="nova">Novas</option>
              <option value="usada">Usadas</option>
          </select>
      </form >
      <form method="GET" action="" class = "meu-form">
          <select id="data-criacao-select" name = "preco" onchange="this.form.submit()">
            <option value="" disabled hidden selected>Preço</option>
            <option value="50">Ate R$50,00</option>
            <option value="100">R$50,00 - R$100,00</option>
            <option value="200">R$100,00 - R$200,00</option>
          </select>
      </form>
      <form method="GET" action="" class = "meu-form">
          <select id="data-criacao-select" name = "tamanho" onchange="this.form.submit()">
            <option value="" disabled hidden selected>Tamanho:</option>
              <option value="p">PP e P</option>
              <option value="m">M</option>
              <option value="g">G e GG</option>
              <option value="xg">Meiores que G</option>
          </select>
      </form>
      <form method="GET" action="" class = "meu-form">
          <select id="data-criacao-select" name = "marca" onchange="this.form.submit()">
            <option value="" disabled hidden selected>Marca:</option>
            <?php
            $marcas = mysqli_query($conn, "SELECT * FROM marca");

                // Inserindo cada uma das marcas no <select></select>
            if (mysqli_num_rows($marcas) > 0) {
                while($marca = mysqli_fetch_assoc($marcas)) {
                echo"<option value=".$marca["id"].">".$marca["nome"]."</option>";
                }
            }
            ?>
          </select>
      </form>
    </div>
  </div>
  <a href="#footer" class="w3-bar-item w3-button w3-padding w3-text-white">Contato</a> 
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-xlarge" style="background-color: #3C486B!important;">
  <img style="width: 218px; margin-top: 26px; margin-left: 16px;" src="./imagens/logo_chestplace.png">
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" style="color:#F9D949;" onclick="w3_open()"><i class="fa fa-bars"></i></a>
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
      // Também controla o link exibido ao clicar no próprio nome, após logado. Se for comprador, vai para a
      // página de gerenciamento de comprador. Se for vendedor, para página de gerenciamento de produtos.
        $usuarioLogou = isset($_SESSION ['nome_usuario']);
        $linkAoClicarNoNome = "/chestplace/index.php";
        if ($usuarioLogou) {
          $nomeUsuario = $_SESSION['nome_usuario'];   
          if (isset($_SESSION['tipo_usuario'])) {
            if ($_SESSION['tipo_usuario'] == 'comprador') {
              $linkAoClicarNoNome = "/chestplace/page_gerComprador.php";
            } else if ($_SESSION['tipo_usuario'] == 'vendedor') {
              $linkAoClicarNoNome = "/chestplace/page_gerProdutos.php";  
            } else if ($_SESSION['tipo_usuario'] == 'administrador') {
              $linkAoClicarNoNome = "/chestplace/index.php"; // TODO: quando criar página de administrador, colocar o link correto aqui.
            }
          }
          echo <<<END
            <span style="margin-right: 10px;">Olá,<a href="$linkAoClicarNoNome" > $nomeUsuario</a> </span>
            <button class="w3-btn w3-deep-orange w3-border" onclick="window.location.href='./logout.php'" 
            style="font-size: 15px; font-weight: 700; margin-right: 10px;">Sair</button>
          END;
        } else {
          echo <<<END
            <button type="button" class="w3-button w3-border" onclick="document.getElementById('id0L').style.display='block'" 
            style="font-size: 15px; font-weight: 700; margin-right: 10px; background-color: #F45050;">Entrar</button>
            <button type="button" class="w3-button w3-white w3-border" onclick="document.getElementById('modalCadastro').style.display='block'" 
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
          <!-- O controle de exibição desta mensagem é feito pelo código php logo abaixo desta DIV (id="id0L") de modal de login. -->
          <p id="msgLoginInvalido" class="w3-center w3-text-red" style="display:none;">E-mail ou senha inválidos!</p>
          <p id="msgContaExcluida" class="w3-center w3-text-red" style="display:none;">Você excluiu sua conta. Para tentar recuperá-la, entre em contato com <i>suporte@chestplace.com</i>.</p>
          <button class="w3-button w3-block w3-theme w3-section w3-padding" style="background-color:#F9D949; font-weight: 700;" type="submit">Entrar</button>
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('id0L').style.display='none'" type="button" class="w3-button w3-red">Cancelar</button>
        <span class="w3-right w3-padding w3-hide-small"><a href="#">Esqueceu a senha? (em breve)</a></span>
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
    if (isset($_SESSION ['usuarioExcluido'])) {
      echo <<<END
      <script>document.getElementById("id0L").style.display = "block";</script>
      <script>document.getElementById("msgContaExcluida").style.display = "block";</script>
      END;  
    }
    unset($_SESSION ['usuarioExcluido']);
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
          <button onclick="window.location.href='./forms/form_cadComprador.php'" 
            class="w3-button w3-block w3-theme w3-section w3-padding" style="background-color:#F9D949; font-weight: 700;" type="submit">Sou cliente</button>
          <button onclick="window.location.href='./forms/form_cadVendedor.php'"
            class="w3-button w3-block w3-theme w3-section w3-padding w3-orange" type="submit" style="font-weight:700;">Sou vendedor</button>
        </div>
      </div>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="document.getElementById('modalCadastro').style.display='none'" type="button" class="w3-button w3-red">Cancelar</button>
      </div>
    </div>
  </div>
  
  <!-- Product grid -->
  <?php
                    $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() ";
                    //predefine o sql para mostrar todas as camisetas postadas 
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                      // Verifica se o parâmetro "selecao" foi passado na URL
                      if (isset($_GET["ordem"])) {
                          // Obtém o valor selecionado
                          $valorSelecionado = $_GET["ordem"];
                  
                          // Atualiza a consulta SQL com base na opção selecionada
                          if ($valorSelecionado == "mais-recentes") {
                              $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() ORDER BY data_hora_publicacao DESC";
                          } elseif ($valorSelecionado == "mais-antigas") {
                            $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() ORDER BY data_hora_publicacao ASC ";
                          } elseif ($valorSelecionado == "nova") {
                            $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() AND conservacao = 'nova' ";
                          } elseif ($valorSelecionado == "usada") {
                            $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() AND conservacao <> 'nova' ";
                          }
                        }
                      if (isset($_GET["preco"])) {
                        // Obtém o valor selecionado
                        $valorSelecionado = $_GET["preco"];
                          // Atualiza a consulta SQL com base na opção selecionada
                        if ($valorSelecionado == "50") {
                            $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() AND preco <= 50 ";
                        } elseif ($valorSelecionado == "100") {
                          $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() AND preco >50 AND preco <=100 ";
                        } elseif ($valorSelecionado == "200") {
                          $sql = "SELECT titulo, preco, id FROM camiseta WHERE data_hora_publicacao <= NOW() AND preco >100 AND preco <=200 ";
                        } 
                      }
                      if (isset($_GET["tamanho"])) {
                        // Obtém o valor selecionado
                        $valorSelecionado = $_GET["tamanho"];
                          // Atualiza a consulta SQL com base na opção selecionada
                        if ($valorSelecionado == "p") {
                            $sql = "SELECT c.titulo, c.preco, c.id FROM camiseta c JOIN estoque e ON c.id = e.id_camiseta JOIN tamanho t ON e.id_tamanho = t.id WHERE data_hora_publicacao <= NOW() AND t.codigo LIKE 'p%' ";
                        } elseif ($valorSelecionado == "m") { 
                          $sql = "SELECT c.titulo, c.preco, c.id FROM camiseta c JOIN estoque e ON c.id = e.id_camiseta JOIN tamanho t ON e.id_tamanho = t.id WHERE data_hora_publicacao <= NOW() AND t.codigo LIKE 'm%' ";
                        } elseif ($valorSelecionado == "g") {
                          $sql = "SELECT c.titulo, c.preco, c.id FROM camiseta c JOIN estoque e ON c.id = e.id_camiseta JOIN tamanho t ON e.id_tamanho = t.id WHERE data_hora_publicacao <= NOW() AND t.codigo LIKE 'g%' ";
                        } elseif ($valorSelecionado == "xg") {
                          $sql = "SELECT c.titulo, c.preco, c.id FROM camiseta c JOIN estoque e ON c.id = e.id_camiseta JOIN tamanho t ON e.id_tamanho = t.id WHERE data_hora_publicacao <= NOW() AND t.codigo LIKE 'xg%' ";
                        } 
                      }
                      if (isset($_GET["marca"])) {
                        // Obtém o valor selecionado
                        $valorSelecionado = $_GET["marca"];
                          // Atualiza a consulta SQL com base na opção selecionada
                        $sql = "SELECT c.titulo, c.preco, c.id FROM camiseta c JOIN marca m ON c.id_marca = m.id WHERE data_hora_publicacao <= NOW() AND m.id = $valorSelecionado ";
                      
                    }
                  }
                    $resultado = mysqli_query($conn, $sql);
                    echo <<<END
                      <div class="w3-container w3-text-grey" id="jeans">
                        <p>
                      END;
                      
                        $qtd = mysqli_num_rows($resultado);
                        if ($qtd > 0) {
                  
                            echo $qtd." produto(s)";
                        }
                         else {
                          echo "0 produto";
                        }
                       echo <<<END
                      </p>
                    </div>
                    END;
                    

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
                                <div style = \"background-color: #F0F0F0; padding-right: 0px; padding-left: 0px;\" class=\"w3-container\">
                                  <div  class=\"w3-display-container\">
                            ";
                            // echo "<img src=\"data:" . $imageType . ";base64," . $base64Image . "\" style=\"width:100%;\">";
                            echo "<img style=\"width:13vw; aspect-ratio: 13/16; object-fit:cover;\" src=\"data:imagem/jpeg;base64,".base64_encode($imagemcamiseta)."\"width= \"100%\"\>";
                            //Coloca botões, título e preço do anúncio
                            echo "
                                  <div class=\"w3-display-middle w3-display-hover\">
                                      <button onclick=\"goToVisualizarProduto(".$produto["id"].")\" class=\" w3-left-align w3-button w3-black w3-block\"><i></i>&nbsp;Comprar</button>
                                  </div>
                                </div>
                                <p style=\"color: #3C486B;\">".$produto["titulo"]."<br><b>R$ ".number_format($produto["preco"], 2, ',', '.')."</b></p>
                                </div>
                              </div>
                            ";
                          }
                      }
                      else{
                        echo"
                        <div style=\"display: flex; text-align:right; width:300px;\">
                        <p style=\"width:100%;\">Não há camisetas cadastradas.<i class=\"fa-solid fa-circle-xmark\"></i></p><br>
                        
                        </div
                        ";
                      }
                      // Fecha a conexão com o banco de dados
                      mysqli_close($conn);
                      
    ?>      
    
  
  <!-- Subscribe section -->
  <div style = "background-color: #F0F0F0" class="w3-container w3-padding-32">
    <h1>Ofertas</h1>
    <p>Inscreva-se em nossa Newsletter para receber notícias e ofertas exclusivas:</p>
    <p><input class="w3-input w3-border" type="text" placeholder="usuario@dominio.com" style="width:100%"></p>
    <button type="button" class="w3-button w3-margin-bottom" style="background-color: #F45050;">Autorizo o envio de e-mails promocionais</button>
  </div>
  
  <!-- Footer -->
  <footer class="w3-padding-64 w3-light-grey w3-small w3-center" style="margin-left: 16px; margin-right: 16px;" id="footer">
    <div class="w3-row-padding">
      <div class="w3-col s4">
        <h4>Enviar e-mail</h4>
        <p>Dúvidas, sugestões ou solicitações.</p>
        <form action="/action_page.php" target="_blank">
          <p><input class="w3-input w3-border" type="text" placeholder="Nome" name="Name" required></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Seu e-mail" name="Email" required></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Título" name="Subject" required></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Mensagem" name="Message" required></p>
          <button type="submit" class="w3-button w3-block w3-black">Enviar</button>
        </form>
      </div>

      <div class="w3-col s4">
        <h4>Sobre</h4>
        <p><a href="#">Quem somos</a></p>
        <p><a href="#">Trabalhe conosco</a></p>
        <p><a href="#">Suporte</a></p>
        <p><a href="#">Transporte</a></p>
        <p><a href="#">Pagamentos</a></p>
        <p><a href="#">Cartões presente</a></p>
      </div>

      <div class="w3-col s4 w3-justify">
        <h4>Contato</h4>
        <p><i class="fa fa-fw fa-map-marker" style="color:#F45050;"></i> Chestplace Comércio Eletrônico Ltda<br>Rua Tocantins, 23 - Vargem Maior<br>Curitiba/PR - CEP: 82.830-100</p>
        <p><i class="fa fa-fw fa-phone" style="color:#F45050;"></i> 0800 365 4589</p>
        <p><i class="fa fa-fw fa-envelope" style="color:#F45050;"></i> contato@chestplace.com.br</p>
        <h4>Formas de pagamento</h4>
        <p><i class="fa fa-fw fa-barcode" style="color:#F45050;"></i> Boleto</p>
        <p><i class="fa fa-fw fa-credit-card" style="color:#F45050;"></i> Cartão de crédito</p>
        <br>
        <i class="fa fa-facebook-official w3-hover-opacity w3-large" style="color:#F45050;"></i>
        <i class="fa fa-instagram w3-hover-opacity w3-large" style="color:#F45050;"></i>
        <i class="fa fa-snapchat w3-hover-opacity w3-large" style="color:#F45050;"></i>
        <i class="fa fa-pinterest-p w3-hover-opacity w3-large" style="color:#F45050;"></i>
        <i class="fa fa-twitter w3-hover-opacity w3-large" style="color:#F45050;"></i>
        <i class="fa fa-linkedin w3-hover-opacity w3-large" style="color:#F45050;"></i>
      </div>
    </div>
  </footer>

  <div class="w3-center w3-padding-24" style="background-color: #F0F0F0;">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></div>

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
<script src="./scripts/comprador/scrip_visCamiseta.js"></script>

</body>
</html>