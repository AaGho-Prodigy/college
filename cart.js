    // Get the close button and cartTab element
    const closeButton = document.querySelector('.cartbtn .close');
    const cartTab = document.querySelector('.cartTab');

    // Add click event listener to the close button
    closeButton.addEventListener('click', function() {
        // Hide the cartTab by setting display to 'none'
        cartTab.style.display = 'none';
        
    });