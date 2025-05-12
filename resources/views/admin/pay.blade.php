<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Payment</title>
</head>
<body>

    <!-- Các input ẩn để lấy dữ liệu -->
    <input type="hidden" id="_total_price" value="{{ $staff->total_salary }}">
    <input type="hidden" id="account_number"  value="{{ $staff->account_number }}">
<input type="hidden" id="staff_id" value="{{ $staff->user_id }}">
    <!-- Nút thanh toán của PayPal -->
    <h1>hehehe</h1>
    <div id="paypal-button-container"></div>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ $staff->account_number  }}"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                let totalPrice = document.getElementById('_total_price').value;
                // This function sets up the details of the transacti on, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            /**
                             * Using ajax call API and get to value amount here
                             */
                            value: totalPrice 
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                
                return actions.order.capture().then(function(details) {
                    window.location.href = "http://4viewstudio.test/admin/pay-salary?month={{ $month }}&staff_id={{ $staff->user_id }}"
                });
            },
            onError: function (err) {
                /**
                 * For example, redirect to a specific error page
                 * Handle error transaction
                 */
                alert(err);
            }
        }).render('#paypal-button-container');
        //This function displays Smart Payment Buttons on your web page.
    </script>
    
</body>
</html>
