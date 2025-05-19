<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="contract-container">
        <h3>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h3>
        <h3>Độc lập - Tự do - Hạnh phúc</h3>
        <h3>* * *</h3>
        <h3>HỢP ĐỒNG DỊCH VỤ CHỤP HÌNH</h3>

        <div class="contract-info">
            <p><strong>Tên khách hàng:</strong> {{ $user->name }}</p>
            <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
            <p><strong>Ngày thực hiện:</strong> {{ \Carbon\Carbon::parse($contract->appointment->work_day)->format('d/m/Y') }}</p>
            <p><strong>Concept chụp:</strong> {{ $concept->name }}</p>
            <p><strong>Giá trị hợp đồng:</strong> {{ number_format($concept->price, 0, ',', '.') }} VNĐ</p>
            <p><strong>Đã cọc:</strong> {{ number_format($concept->price * \App\Models\Contract::SCALE_DEPOSIT, 0, ',', '.') }} VNĐ</p>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <b>Đại diện bên cung cấp</b>
                <p>Ký & ghi rõ họ tên</p>
            </div>
            <div class="signature-box">
                <b>Khách hàng</b>
                <p>Ký & ghi rõ họ tên</p>
            </div>
        </div>
    </div>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 0;
        }

        .contract-container {
            padding: 30px 40px;
            line-height: 1.2;
        }

        h3 {
            text-align: center;
        }

        .contract-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .contract-info strong {
            width: 180px;
            color: black;
        }

        .signature-section {
            margin-top: 60px;
        }

        .signature-box {
            width: 45%;
            text-align: center;
            float: left;
            margin-left: 2%;
            margin-right: 3%;
        }

        .signature-box p {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-style: italic;
        }
    </style>
</body>

</html>