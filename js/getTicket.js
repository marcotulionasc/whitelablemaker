document.addEventListener('DOMContentLoaded', (event) => {
    mostrarIngressos();
});

function mostrarIngressos() {
    exibirOcultarElemento('ingressos-container', 'block');
    exibirOcultarElemento('area-unica-container', 'block');
    exibirOcultarElemento('informacoes-container', 'none');
    exibirOcultarElemento('zoomContainer', ''); // O valor '' faz com que o elemento volte ao seu valor padrão, que é 'block
}

function mostrarInformacoes() {
    exibirOcultarElemento('ingressos-container', 'none');
    exibirOcultarElemento('area-unica-container', 'none');
    exibirOcultarElemento('informacoes-container', 'block');
    exibirOcultarElemento('zoomContainer', 'none');
}

function exibirOcultarElemento(id, displayValue) {
    var elemento = document.getElementById(id);
    if (elemento) {
        elemento.style.display = displayValue;
    }
}

function toggleIngressos(id) {
    var details = document.getElementById(id);
    if (details) {
        details.style.display = (details.style.display === "none") ? "block" : "none";
    }
}

function alterarQuantidade(quantidade, elementoQuantidade, tipoIngresso) {
    var quantidadeElemento = document.getElementById(elementoQuantidade);
    var quantidadeAtual = parseInt(quantidadeElemento.textContent) || 0;

    var totalIngressosElemento = document.getElementById('total-ingressos');
    var totalIngressos = parseInt(totalIngressosElemento.textContent) || 0;

    if (quantidadeAtual + quantidade < 0) {
        alert('A quantidade de ingressos não pode ser menor que 0.');
        return;
    }

    quantidadeAtual += quantidade;
    quantidadeElemento.textContent = quantidadeAtual;

    totalIngressos += quantidade;

    if (totalIngressos > 4) {
        alert('Você não pode selecionar mais de 4 ingressos por pedido.');
        quantidadeElemento.textContent = quantidadeAtual - quantidade; // Revert the quantity if it exceeds the limit
        return;
    }

    totalIngressosElemento.textContent = (totalIngressos === 1 || totalIngressos === 0) ?
        totalIngressos + ' Ingresso por' :
        totalIngressos + ' Ingressos por';

    // Atualizar o preço total na seção fixa (sticky section)

    // Atualizar o preço total
    atualizarTotalPrice();
}

function atualizarTotalPrice() {
    var totalIngressos = 0;

    // Obter os elementos e preços de cada tipo de ingresso dinamicamente
    var elementosPreco = document.getElementsByClassName('preco-ingresso');
    for (var i = 0; i < elementosPreco.length; i++) {
        var quantidade = parseInt(document.getElementById('quantidade' + (i + 1)).textContent) || 0;
        var precoTexto = elementosPreco[i].textContent;

        // Remover o 'R$ ' e converter para número
        var preco = parseFloat(precoTexto.replace('R$ ', ''));

        // Verificar se o preço é um número válido
        if (!isNaN(preco)) {
            totalIngressos += quantidade * preco;
        }
    }

    // Atualizar o elemento de preço total
    document.getElementById('total-price').textContent = 'R$ ' + totalIngressos.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
}

function obterClasseIngresso(numero) {
    switch (numero) {
        case 1:
            return 'pista-solidario';
        case 2:
            return 'pista';
        case 3:
            return 'frontstage-solidario';
        case 4:
            return 'frontstage';
        default:
            return '';
    }
}
