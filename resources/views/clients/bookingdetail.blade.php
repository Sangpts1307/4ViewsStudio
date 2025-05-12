<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            font-size: 16px;
            margin: 10px 0;
        }

        input[type="hidden"] {
            display: none;
        }

        #paypal-button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="content">
        <h2>Thông tin cuộc hẹn</h2>
        <p><strong>Ngày chụp:</strong> {{ \Carbon\Carbon::parse($work_day)->format('d-m-Y') }}</p>
        <p><strong>Ca chụp:</strong> 
            {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - 
            {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }} 
        </p>
        <p><strong>Concept:</strong> {{ $concept->name }}</p>
        <p><strong>Tiền cọc:</strong> {{ number_format($concept->price * 0.3, 0, '.', '') }} VND</p>

        <!-- Các input ẩn để lấy dữ liệu -->
        <input type="hidden" id="_total_price" value="{{ $concept->price * 0.3 }}">
    

        <!-- Nút thanh toán của PayPal -->
        <div id="paypal-button-container"></div>
    </div>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AaYcCxAf-I2LCkPyfb6gFIu7wRIP20hxVhygp3eYj2Bm4TQk13_sWkqdpf0RcITnFBdtjzyJUWVAH6Ub"></script>
   <script>
    const shiftId = "{{ $shift->id }}";
    const workDay = "{{ $work_day }}";
    const conceptId = "{{ $concept->id }}";
    
    paypal.Buttons({
        createOrder: function(data, actions) {
            let totalPrice = document.getElementById('_total_price').value;
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalPrice 
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                window.location.href = "/clients/appointments?shift_id=" + shiftId + "&work_day=" + workDay + "&concept_id="+ conceptId;
            });
        },
        onError: function (err) {
            alert(err);
        }
    }).render('#paypal-button-container');
</script>

    

</body>
</html>
