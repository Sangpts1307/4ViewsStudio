<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hợp đồng</title>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>HỢP ĐỒNG DỊCH VỤ</h2>
    <p><strong>Tên khách hàng:</strong> {{ $user->name }}</p>
    <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
    <p><strong>Ngày:</strong> {{ \Carbon\Carbon::parse($contract->work_day)->format('d/m/Y') }}</p>
    <p><strong>Giá trị hợp đồng:</strong> {{ number_format($concept->price) }} VNĐ</p>
</body>
</html>
