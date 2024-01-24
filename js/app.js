// Suponha que você tenha as seguintes variáveis
var pricePista = document.querySelector('.preco-pista').textContent;
var priceFrontstage = document.querySelector('.preco-frontstage').textContent;
var capacity = 100;
var available = "sim";

// Selecione os elementos
var pistaDiv = document.querySelector('.pista-div');
var frontstageDiv = document.querySelector('.frontstage-div');

// Crie uma função para mostrar as informações quando o mouse passar sobre a div
function showInfo(event) {
    var info = "Valor do ingresso: R$" + price + "\nCapacidade: " + capacity + "\nDisponível: " + available;

    // Criação do elemento div com estilos melhorados
    var pseudoElement = document.createElement('div');
    pseudoElement.style.position = 'absolute';
    pseudoElement.style.top = '50%';
    pseudoElement.style.transform = 'translateY(-50%)';
    pseudoElement.style.backgroundColor = 'white';
    pseudoElement.style.color = 'black';
    pseudoElement.style.padding = '10px';
    pseudoElement.style.whiteSpace = 'pre';
    pseudoElement.style.border = '1px solid black';
    pseudoElement.style.borderRadius = '10px'; // Adiciona border radius
    pseudoElement.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)'; // Adiciona uma sombra

    // Adiciona estilos específicos para o valor do ingresso
    var valueStyle = document.createElement('span');
    valueStyle.style.color = 'green';
    valueStyle.style.fontWeight = 'bold';
    valueStyle.textContent = "Valor do ingresso: R$" + price;

    // Adiciona estilos específicos para a capacidade
    var capacityStyle = document.createElement('span');
    capacityStyle.style.display = 'block'; // Garante que a capacidade apareça abaixo do valor do ingresso
    capacityStyle.textContent = "Capacidade: " + capacity + "\nDisponível: " + available;

    // Adiciona os elementos de estilo ao pseudoElement
    pseudoElement.appendChild(valueStyle);
    pseudoElement.appendChild(capacityStyle);

    // Verifica a classe da div para determinar a posição
    if (event.target.classList.contains('pista-div')) {
        pseudoElement.style.right = '100%'; // Para div com classe pista-div
    } else if (event.target.classList.contains('frontstage-div')) {
        pseudoElement.style.left = '100%'; // Para div com classe frontstage-div
    }

    event.target.appendChild(pseudoElement);
}

// Adicione o evento de mouseover aos elementos
pistaDiv.addEventListener('mouseover', showInfo);
frontstageDiv.addEventListener('mouseover', showInfo);

// Crie uma função para remover as informações quando o mouse sair da div
function hideInfo(event) {
    var pseudoElement = event.target.querySelector('div');
    if (pseudoElement) {
        event.target.removeChild(pseudoElement);
    }
}

// Adicione o evento de mouseout aos elementos
pistaDiv.addEventListener('mouseout', hideInfo);
frontstageDiv.addEventListener('mouseout', hideInfo);