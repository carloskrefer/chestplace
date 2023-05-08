const dataCriacaoSelect = document.getElementById("data-criacao-select");
const camisetasContainer = document.getElementById("camisetas-container");

dataCriacaoSelect.addEventListener("change", () => {
  const selectedOption = dataCriacaoSelect.value;
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    camisetasContainer.innerHTML = xhr.response;
  };

  xhr.open("GET", `filtrar_camisetas.php?ordem=${selectedOption}`);
  xhr.send();
});
