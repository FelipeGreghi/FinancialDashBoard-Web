// main.js
document.addEventListener('DOMContentLoaded', function() {
    var box1 = document.getElementById('cadaster1');
    var box2 = document.getElementById('cadaster2');

    // Check the localStorage for the display state of the boxes
    box1.style.display = localStorage.getItem('displayCadaster1') || 'none';
    box2.style.display = localStorage.getItem('displayCadaster2') || 'none';

    document.getElementById('show-cadaster1').addEventListener('click', function() {
        if(box1.style.display === 'none') {
            box1.style.display = 'block';
            box2.style.display = 'none'; // Hide the other box
            localStorage.setItem('displayCadaster1', 'block');
            localStorage.setItem('displayCadaster2', 'none'); // Store the state of the other box
            box1.scrollIntoView({behavior: "smooth"}); // Scroll to the box
        } else {
            box1.style.display = 'none';
            localStorage.setItem('displayCadaster1', 'none');
        }
    });

    document.getElementById('show-cadaster2').addEventListener('click', function() {
        if(box2.style.display === 'none') {
            box2.style.display = 'block';
            box1.style.display = 'none'; // Hide the other box
            localStorage.setItem('displayCadaster2', 'block');
            localStorage.setItem('displayCadaster1', 'none'); // Store the state of the other box
            box2.scrollIntoView({behavior: "smooth"}); // Scroll to the box
        } else {
            box2.style.display = 'none';
            localStorage.setItem('displayCadaster2', 'none');
        }
    });
});