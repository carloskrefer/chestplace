/**
 * Consulta os dados de um CEP através da API do ViaCEP.
 *
 * @param string $cep O CEP a ser consultado no sistema.
 * @return array|null Os dados do CEP retornados pela API do ViaCEP ou null em caso de erro.
 */
async function consultarCEP(cep) {
    try {
      const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
      const data = await response.json();
      
      if (response.ok) {
        return data;
      } else {
        throw new Error(data.message);
      }
    } catch (error) {
      console.error(error);
      return null;
    }
}

