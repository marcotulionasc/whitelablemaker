document.addEventListener("DOMContentLoaded", function () {
    var stickySection = document.getElementById("sticky-section");

    window.onscroll = function () {
        stickySection.style.bottom = "0";
    };
});

window.onload = function() {
// Verifica se a hora da primeira visita já está armazenada
var firstVisitTime = localStorage.getItem('firstVisitTime');
if (!firstVisitTime) {
// Se não, armazena a hora atual como a hora da primeira visita
firstVisitTime = new Date().getTime();
localStorage.setItem('firstVisitTime', firstVisitTime);
}

// Define o tempo de duração do cronômetro (15 minutos)
var countdownDuration = 15 * 60 * 1000; // 15 minutos em milissegundos

// Atualiza o cronômetro a cada segundo
var intervalId = setInterval(function() {
var currentTime = new Date().getTime();
var timeElapsed = currentTime - firstVisitTime;
var timeRemaining = countdownDuration - timeElapsed;

// Se o tempo restante é menor ou igual a zero, para o cronômetro
if (timeRemaining <= 0) {
    clearInterval(intervalId);
    document.getElementById('counter').textContent = 'Sua reserva expirou';
    alert('Sua sessão expirou. Você será redirecionado para a página inicial.');
    localStorage.removeItem('firstVisitTime'); // Zera o cronômetro
    location.href = '/'; // Redireciona para a página inicial
    return;
}

// Converte o tempo restante em minutos e segundos
var minutes = Math.floor(timeRemaining / (60 * 1000));
var seconds = Math.floor((timeRemaining % (60 * 1000)) / 1000);

// Atualiza o contador na página
var counter = document.getElementById('counter');
counter.textContent = 'Sua reserva irá expirar em ' + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
}, 1000);

// Altera a cor de fundo do contador com base no tempo restante
if (minutes < 1) {
    counter.style.backgroundColor = 'red';
} else if (minutes < 5) {
    counter.style.backgroundColor = 'yellow';
} else {
    counter.style.backgroundColor = 'transparent';
}
}, 1000;
