<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán lương nhân viên</title>
    <!-- Bootstrap CSS để hỗ trợ giao diện đẹp -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .payment-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Các input ẩn để lấy dữ liệu -->
    <input type="hidden" id="_total_price" value="{{ $staff->total_salary }}">
    <input type="hidden" id="account_number" value="{{ $staff->account_number }}">
    <input type="hidden" id="staff_id" value="{{ $staff->user_id }}">

    <!-- Giao diện chính -->
    <div class="payment-container">
        <h2 class="text-center">Thanh Toán Lương Nhân Viên</h2>
        <p><strong>Nhân viên:</strong> {{ $staff->name ?? 'Không rõ' }}</p>
        <p><strong>Tổng lương:</strong> {{ number_format($staff->total_salary, 0, ',', '.') }} VND</p>

        <!-- Nút thanh toán của PayPal -->
        <div id="paypal-button-container" class="mt-4"></div>
    </div>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ $staff->account_number }}"></script>
    <script>
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
                    window.location.href = "http://4viewstudio.test/admin/pay-salary?month={{ $month }}&staff_id={{ $staff->user_id }}";
                });
            },
            onError: function(err) {
                alert("Đã xảy ra lỗi khi thanh toán: " + err);
            }
        }).render('#paypal-button-container');
    </script>

</body>
</html>
