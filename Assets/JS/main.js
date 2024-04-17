// main.js
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('show-cadaster1').addEventListener('click', function() {
        var box = document.getElementById('cadaster1');
        if(box.style.display === 'none') {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });

    document.getElementById('show-cadaster2').addEventListener('click', function() {
        var box = document.getElementById('cadaster2');
        if(box.style.display === 'none') {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });
});