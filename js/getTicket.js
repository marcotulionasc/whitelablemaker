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

function alterarQuantidade(valor, id) {
    var quantidadeElemento = document.getElementById(id);
    var quantidadeAtual = parseInt(quantidadeElemento.textContent) + valor;

    // Restrição para não permitir uma quantidade negativa
    quantidadeAtual = Math.max(0, quantidadeAtual);

    var precoUnitarioElemento = document.getElementById('preco-unitario');
    var precoUnitarioTexto = precoUnitarioElemento.innerText.replace('R$', '').replace(',', '.');
    var precoUnitario = parseFloat(precoUnitarioTexto);

    // Obter a quantidade do outro tipo de ingresso
    var outroId = id === 'quantidade1' ? 'quantidade2' : 'quantidade1';
    var outraQuantidade = parseInt(document.getElementById(outroId).textContent);

    // Verificar se a soma total de ingressos ultrapassa 4
    var totalIngressos = quantidadeAtual + outraQuantidade;
    if (totalIngressos > 4) {
        alert('Você não pode selecionar mais de 4 ingressos por pedido.');
        return;
    }

    // Atualizar a quantidade apenas se não ultrapassar o limite
    quantidadeElemento.innerText = quantidadeAtual;

    // Atualizar o preço total
    var precoTotalElemento = document.getElementById('total-price');
    var totalIngressosElemento = document.getElementById('total-ingressos');

    var precoTotal = (precoUnitario * quantidadeAtual) + (precoUnitario * outraQuantidade);
    precoTotalElemento.innerText = 'R$ ' + precoTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 });

    if (totalIngressos === 1 || totalIngressos === 0) {
        totalIngressosElemento.innerText = totalIngressos + ' Ingresso por';
    } else {
        totalIngressosElemento.innerText = totalIngressos + ' Ingressos por';
    }
}