// Script para mostrar ou ocultar senha
function mostrarOcultarSenhaLogin() {
    var senha  = document.getElementById("Senha");
  
    if (senha.type == "password"){
      senha.type  = "text";
    } else {
      senha.type  = "password";
    }
  }