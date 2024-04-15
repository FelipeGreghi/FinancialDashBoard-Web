// main.js
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('show-cadaster').addEventListener('click', function() {
        var box = document.getElementById('cadaster');
        if(box.style.display === 'none') {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });
});