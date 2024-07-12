var margin = 0;

function scrollToElementWithMargin(element, margin) {
    const elementPosition = element.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = elementPosition - margin;

    window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
    }); 
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('next_a').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('container_b');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('next_b').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('container_c');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('next_c').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('container_d');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('precedant_b').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('container_a');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('precedant_c').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('container_b');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('precedant_d').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('container_c');
        
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });
});

