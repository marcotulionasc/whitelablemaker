var scale = 0.3;
var container = document.getElementById('zoomContainer');
var zoomInButton = document.getElementById('zoomIn');
var zoomOutButton = document.getElementById('zoomOut');
var pos = { top: 0, left: 0, x: 0, y: 0 };

zoomInButton.addEventListener('click', function() {
    scale += 0.1;
    container.style.transform = 'scale(' + scale + ')';
});

zoomOutButton.addEventListener('click', function() {
    scale -= 0.1;
    container.style.transform = 'scale(' + scale + ')';
});

container.addEventListener('mousedown', function(e) {
    pos = {
        left: container.scrollLeft,
        top: container.scrollTop,
        x: e.clientX,
        y: e.clientY,
    };

    document.addEventListener('mousemove', mouseMoveHandler);
    document.addEventListener('mouseup', stopMouseMovement, {once: true});
});

function stopMouseMovement() {
    document.removeEventListener('mousemove', mouseMoveHandler);
}

function mouseMoveHandler(e) {
    const dx = (e.clientX - pos.x) / scale; // Ajuste de escala
    const dy = (e.clientY - pos.y) / scale; // Ajuste de escala
    container.scrollTop = pos.top - dy;
    container.scrollLeft = pos.left - dx;
}
