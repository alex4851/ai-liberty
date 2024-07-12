var margin = 100;

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
        const targetElement = document.getElementById('card_b');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('next_b').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('card_c');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('next_c').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('card_d');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('precedant_b').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('card_a');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('precedant_c').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('card_b');
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });

    document.getElementById('precedant_d').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (if any)
        const targetElement = document.getElementById('card_c');
        
 // Adjust this value to set the margin you want
        scrollToElementWithMargin(targetElement, margin);
    });
});

document.getElementsByClassName('precedant_imp').addEventListener('click', function(event) {
    event.preventDefault();
    location.href = "https://ai-liberty.fr/";
});
//test
