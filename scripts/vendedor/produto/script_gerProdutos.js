
    // Accordion 
    function myAccFunc() {
        var x = document.getElementById("demoAcc");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }

    // Open and close sidebar
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
    }
    
    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
    }

    function goToAlterProduto(id){
        window.location.href='./forms/form_alterProduto.php?id=' + id;
    }

    function goToDeletarProduto(id) {
        const dados = new FormData();
        dados.append("id", id);
      
        fetch("./actions/delProduto_exe.php", {
          method: "POST",
          body: dados
        })
        .then(response => {
            console.log(response);
            // Se a requisição tiver sido feita com sucesso
            if(response.ok){
                alert("Anúncio apagado com sucesso!");
                location.reload();
            } else {
               throw new Error("Houve um erro ao apagar o anúncio.");
            }
        }) // Caso ocorra um erro
        .catch(error => {
            alert("Erro na requisição: " + error);
            location.reload();
        });
    }

    function confirmarDelecao(id){
        showModalConfirmacao(
            "<i class=\"w3-text-amber fa fa-solid fa-exclamation-triangle\"></i> &nbsp;",
            "Você tem certeza?",
            "Ao confirmar, todos os dados do anúncio serão apagados permanentemente ",
            "",
            "w3-boder-amber",
            "Apagar"
        );

        $("#btnPrimario-modalDeNotificacao").off();
        $("#btnPrimario-modalDeNotificacao").on("click", function() { goToDeletarProduto(id) });

    }