<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>4Views Studio - Gửi ảnh</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #e91e63;
            margin-bottom: 10px;
        }
        .intro {
            font-size: 16px;
            color: #333333;
            margin-bottom: 25px;
        }
        .section {
            text-align: left;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .section p {
            margin: 6px 0;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .image-link a {
            color: #2196f3;
            text-decoration: none;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">「4Views Studio」</div>
        <div class="intro">「4Views Studio」gửi tới bạn ảnh chụp!</div>

        <div class="section">
            <p><span class="label">👤 Người chụp:</span> {{ $staff }}</p>
            <p><span class="label">🎨 Concept:</span> {{ $concept }}</p>
            <p><span class="label">📅 Ngày chụp:</span> {{ $workDay }}</p>
            <p><span class="label">🕒 Ca chụp:</span> {{ $shift }}</p>
            <p class="image-link"><span class="label">📷 Link ảnh:</span> <a href="{{ $linkImage }}" target="_blank">Xem ảnh tại đây</a></p>
            <p><span class="label">📃 Lời nhắn của thợ:</span> {{ $reply }}</p>
        </div>

        <div class="footer">
            Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!
        </div>
    </div>
</body>
</html>
