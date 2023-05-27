<!DOCTYPE html>
<?php
    session_start();
    include("../database/conectaBD.php");
?>
<html>
<title>Chestplace</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./styles.css">
  <script src="./scripts/jQuery/jquery-3.6.4.min.js"></script>
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
body { background-color: #F0F0F0; }
nav { background-color: #3C486B!important; }

</style>
</head>
<body>
<body class="w3-content" style="max-width:1200px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <a href="../index.php">
    <img src="../imagens/logo_chestplace.png" style="width: 100%; margin-top: 10px;">
    </a>
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
          <p id="msgLoginInvalido" class="w3-center w3-text-red" style="display:none;">E-mail ou senha inválidos!</p>
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
            class="w3-button w3-block w3-theme w3-section w3-padding" style="background-color:#F9D949; font-weight: 700;" type="submit">Sou cliente (em breve!)</button>
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
                      $idCamiseta = $_GET["id"];
                      $queryProdutos = "SELECT * FROM camiseta WHERE id = ".$idCamiseta.";";
                      // SELECT camiseta.*, vendedor.* FROM camiseta JOIN vendedor ON camiseta.id_vendedor = vendedor.id_usuario WHERE id = ".$idCamiseta.";
                      // SELECT * FROM camiseta WHERE id = ".$idCamiseta.
                      $result = mysqli_query($conn, $queryProdutos);
                      if (mysqli_num_rows($result) > 0) {  
                        // Loop pelos resultados
                        while ($produto = mysqli_fetch_assoc($result)) {
                          $sql = "SELECT  id, imagem FROM imagem where id_produto =" .$produto['id']." limit 1;";
                          $resultadoimg = mysqli_query($conn, $sql);

                          // while ($rowimg = mysqli_fetch_assoc($resultadoimg)){
                          //   $imagemcamiseta = $rowimg['imagem'];
                          // }
                          echo "
                          <div id=\"div-camiseta\">
                            <div >
                              <div style = \"background-color: #F0F0F0; padding-right: 0px; padding-left: 0px; display: flex;
                              align-items: center; justify-content: center; \"   >
                                <div  class=\"w3-display-container\" style= \"margin-right: 40px; margin-left: 70px; background-color: black display: flex; margin: auto width: 56.2%; \">
                              "; 
                              echo "<span style=\"margin-right: 0px;\"class=\"w3-tag w3-display-topright\">".$produto["conservacao"]."</span>";
                              ?>
                              <!-- <button id="prev-img" class="w3-button w3-xlarge w3-round" style="background-color:#f4dc55"><i class="fa-solid fa-caret-left"></i></button> -->
                              <?php
                              $first = true;
                              $idImg = 0;
                                while($imagem = mysqli_fetch_assoc($resultadoimg)){
                                    $hide = $first ? "" : "w3-hide";
                                    echo "<img id=\"img-$idImg\"class=\"$hide\" src=\"data:imagem/jpeg;base64,".base64_encode($imagem["imagem"])."\" style=\"width: 100%; aspect-ratio: 1; object-fit:cover; margin:auto;\">";
                                    $first = false;
                                    $idImg++;
                                }
                                ?>
                                <!-- <button id="next-img" class="w3-button w3-xlarge w3-round" style="background-color:#f4dc55"><i class="fa-solid fa-caret-right"></i></button> -->
                                
                                <?php
                                echo "
                                <div style=\" flex-direction: row; display: flex; \"><p>Descricao: </p></div>
                                <div style=\" flex-direction: row; display: flex; width: 100%; \"><p style=\"color: #3C486B;\">".$produto["descricao"]."</p></div>
                                                                                                  
                                ";
                                
                              //Coloca título e preço do anúncio
                              echo "  
                                
                              </div>
                              <div style=\" margin: auto display: flex; flex-direction: row; margin-rigth: 15px;\">
                                <div style=\" margin-top:100px margin-bottom: 0px;\">
                                <p style=\"color: #3C486B; font-size: 31px;\">".$produto["titulo"]."</p>
                                </div>
                                <div style=\" margin-top:100px margin-bottom: 550px;\">
                                <p style=\"color: #3C486B; font-size: 28px;\"><b>R$".number_format($produto["preco"], 2, ',', '.')."</b></p>
                                </div>
                                <div style=\" margin-top: 0px; margin-bottom:50px;\">
                                <button  class=\" w3-left-align w3-button w3-black \">&nbsp;Comprar</button>
                                </div>
                                <div>
                                <p>
                                    <label class=\"w3-text-IE\"><b>Tamanhos/Quantidade</b>*</label>
                                    <table class=\"w3-table w3-card\" id=\"tabelaTamanhos\" style=\"width:100%\">
                                        <th class=\"w3-center\">Tamanho</th>
                                        <th class=\"w3-center\">Quantidade</th>";

                                $queryTamanhos = "SELECT * FROM tamanho";
                                $resultTamanhos = mysqli_query($conn, $queryTamanhos);

                                if (mysqli_num_rows($resultTamanhos) > 0) {
                                    while ($rowTamanho = mysqli_fetch_assoc($resultTamanhos)) {
                                        $queryEstoque = "SELECT * FROM estoque WHERE id_camiseta = $idCamiseta AND id_tamanho = " . $rowTamanho["id"];
                                        $resultEstoque = mysqli_query($conn, $queryEstoque);
                                        $rowEstq = mysqli_fetch_assoc($resultEstoque);

                                        // Verifica se o tamanho está disponível (possui estoque)
                                        if (mysqli_num_rows($resultEstoque) > 0) {
                                            $quantidade = isset($rowEstq["quantidade"]) ? $rowEstq["quantidade"] : "";

                                            echo "
                                            <tr>
                                                <td class=\"w3-left-align\">{$rowTamanho["codigo"]} - {$rowTamanho["descricao"]}</td>
                                                <td class=\"w3-center\">
                                                    <select class=\"quantidade\" id=\"inpt-{$rowTamanho["codigo"]}\" name=\"quantidade_{$rowTamanho["codigo"]}\" required>
                                                        <option value=\"\">Selecione uma quantidade</option>";

                                            // Recupera os valores de quantidade do banco de dados
                                            $queryQuantidades = "SELECT quantidade FROM estoque WHERE id_camiseta = $idCamiseta AND id_tamanho = " . $rowTamanho["id"];
                                            $resultQuantidades = mysqli_query($conn, $queryQuantidades);

                                            while ($rowQuantidade = mysqli_fetch_assoc($resultQuantidades)) {
                                                $optionQuantidade = $rowQuantidade["quantidade"];
                                                echo "<option value=\"$optionQuantidade\">$optionQuantidade</option>";
                                            }

                                            echo "</select>
                                                </td>
                                            </tr>";
                                        }
                                    }
                                }

                                echo "
                                    </table>
                                </p>
                                </div>
                              </div>
                            </div>
                            </div>
                            </div>
                          ";
                          
                        }
                    }
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
</body>
</html>