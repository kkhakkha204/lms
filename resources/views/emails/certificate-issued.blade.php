<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate Issued</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3498db; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .button { background: #e74c3c; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0; }
        .footer { padding: 20px; text-align: center; color: #666; font-size: 14px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎉 Chúc mừng {{ $studentName }}!</h1>
        <p>Bạn đã hoàn thành xuất sắc khóa học</p>
    </div>

    <div class="content">
        <h2>Chứng chỉ hoàn thành khóa học</h2>
        <p>Chúng tôi rất vui mừng thông báo rằng bạn đã hoàn thành thành công khóa học:</p>

        <h3 style="color: #3498db;">"{{ $courseName }}"</h3>

        <p>Chứng chỉ của bạn đã được cấp với thông tin:</p>
        <ul>
            <li><strong>Số chứng chỉ:</strong> {{ $certificateNumber }}</li>
            <li><strong>Ngày cấp:</strong> {{ now()->format('d/m/Y') }}</li>
            <li><strong>Trạng thái:</strong> Hợp lệ</li>
        </ul>

        <p>Bạn có thể tải xuống chứng chỉ hoặc xác thực tính hợp lệ:</p>

        <a href="{{ $downloadUrl }}" class="button">📄 Tải xuống chứng chỉ</a>
        <a href="{{ $verificationUrl }}" class="button" style="background: #2ecc71;">✅ Xác thực chứng chỉ</a>

        <p style="margin-top: 20px;">
            <small><strong>Lưu ý:</strong> Chứng chỉ này có thể được xác thực công khai tại liên kết xác thực ở trên.</small>
        </p>
    </div>

    <div class="footer">
        <p>Cảm ơn bạn đã tin tướng và học tập cùng LMS!</p>
        <p><small>Email này được gửi tự động, vui lòng không trả lời.</small></p>
    </div>
</div>
</body>
</html>
