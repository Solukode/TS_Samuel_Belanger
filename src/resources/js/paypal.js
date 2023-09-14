let total = parseFloat(document.getElementById('cart_total').getAttribute('data-total'));
console.log(total);
paypal.Buttons({
    style : {
        color: 'blue',
        shape: 'pill'
    },
    createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units : [{
                amount: {
                    value: total
                }
            }]
        });
    },
    onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
            console.log(details)
            window.location.replace("http://localhost/?msg=success")
        })
    },
    onCancel: function (data) {
        window.location.replace("http://localhost/?msg=failed")
    }
}).render('#paypal-payment-button');
