document.addEventListener('DOMContentLoaded', (event) => {
    mostrarIngressos();
});

function mostrarIngressos() {
    document.getElementById('ingressos-container').style.display = 'block';
    document.getElementById('area-unica-container').style.display = 'block';
    document.getElementById('informacoes-container').style.display = 'none';

    // Mostra o elemento 'zoomContainer'
    var zoomContainer = document.getElementById('zoomContainer');
    zoomContainer.style.display = ''; // O valor '' faz com que o elemento volte ao seu valor padrão, que é 'block
}

function mostrarInformacoes() {
    document.getElementById('ingressos-container').style.display = 'none';
    document.getElementById('area-unica-container').style.display = 'none';
    document.getElementById('informacoes-container').style.display = 'block';

    var zoomContainer = document.getElementById('zoomContainer');
    zoomContainer.style.display = 'none';
}

var areaUnicaVisivel = false;

function toggleIngressos(id) {
    var details = document.getElementById(id);
    if (details.style.display === "none") {
        details.style.display = "block";
    } else {
        details.style.display = "none";
    }
}

function alterarQuantidade(quantidade, elementoQuantidade, tipoIngresso) {
    var quantidadeElemento = document.getElementById(elementoQuantidade);
    var quantidadeAtual = parseInt(quantidadeElemento.innerText);

    var totalIngressosElemento = document.getElementById('total-ingressos');
    var totalIngressos = parseInt(totalIngressosElemento.innerText);

    if (quantidadeAtual + quantidade < 0) {
        alert('A quantidade de ingressos não pode ser menor que 0.');
        return;
    }

    quantidadeAtual += quantidade;
    quantidadeElemento.innerText = quantidadeAtual;

    totalIngressos += quantidade;

    if (totalIngressos > 4) {
        alert('Você não pode selecionar mais de 4 ingressos por pedido.');
        quantidadeElemento.innerText = quantidadeAtual - quantidade; // Revert the quantity if it exceeds the limit
        return;
    }

    totalIngressosElemento.innerText = (totalIngressos === 1 || totalIngressos === 0) ?
        totalIngressos + ' Ingresso por' :
        totalIngressos + ' Ingressos por';

    // Atualizar o preço total na seção fixa (sticky section)

    // Atualizar o preço total
    atualizarTotalPrice();
}

function atualizarTotalPrice() {
    var totalIngressos = 0;

    // Obter os elementos e preços de cada tipo de ingresso dinamicamente
    for (var i = 1; i <= 4; i++) {
        var quantidade = parseInt(document.getElementById('quantidade' + i).innerText);
        var precoTexto = document.getElementById('preco-' + (i === 1 ? 'pista-solidario' : i === 2 ? 'pista' : i === 3 ? 'frontstage-solidario' : 'frontstage')).innerText;

        // Remover o 'R$ ' e converter para número
        var preco = parseFloat(precoTexto.replace('R$ ', ''));

        // Verificar se o preço é um número válido
        if (!isNaN(preco)) {
            totalIngressos += quantidade * preco;
        }
    }

    // Atualizar o elemento de preço total
    document.getElementById('total-price').innerText = 'R$ ' + totalIngressos.toLocaleString('pt-BR', { minimumFractionDigits: 2 });

}


