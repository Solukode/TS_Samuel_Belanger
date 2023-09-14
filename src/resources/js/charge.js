let stripe = Stripe ('pk_test_51BsGTfAZYQ5IkzsXYsdftzwIJKxcS4ZlqjlYySfjr4LDAG1huRpzUnWo8sC4usc8uEWwg2Tmzpymp7fllUwJqRZJ002BfglSuL')
let elements = stripe.elements();

var style = {
    base: {
        color: '#ffffff',
        lineHeight: '24px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'    
    }
};

let card = elements.create('card', {
    style: style,
    hidePostalCode: true
});

card.mount('#card-element');

card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var form = document.getElementById('checkout');
form.addEventListener('submit', function(event) {
    event.preventDefault();
stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            stripeTokenHandler(result.token);
        }
    });
});

// Send Stripe Token to Server
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('checkout');
// Add Stripe Token to hidden input
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
// Submit form
    form.submit();
}