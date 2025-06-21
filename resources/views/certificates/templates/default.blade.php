<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 297mm;
            height: 210mm;
            position: relative;
            color: #333;
        }

        .certificate-container {
            width: 100%;
            height: 100%;
            padding: 15mm;
            position: relative;
            background: white;
            border: 8px solid #2c3e50;
            border-radius: 15px;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: #3498db;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .institution-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .certificate-title {
            font-size: 32px;
            font-weight: bold;
            color: #e74c3c;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 20px 0;
        }

        .certificate-body {
            text-align: center;
            margin: 30px 0;
            line-height: 1.6;
        }

        .awarded-text {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

        .student-name {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            text-decoration: underline;
            margin: 15px 0;
            text-transform: uppercase;
        }

        .completion-text {
            font-size: 16px;
            color: #7f8c8d;
            margin: 15px 0;
        }

        .course-name {
            font-size: 22px;
            font-weight: bold;
            color: #3498db;
            margin: 15px 0;
            font-style: italic;
        }

        .course-details {
            display: flex;
            justify-content: space-around;
            margin: 25px 0;
            font-size: 14px;
        }

        .detail-item {
            text-align: center;
        }

        .detail-label {
            font-weight: bold;
            color: #2c3e50;
            display: block;
        }

        .detail-value {
            color: #7f8c8d;
            margin-top: 5px;
        }

        .certificate-footer {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
        }

        .signature-section {
            text-align: center;
            flex: 1;
        }

        .signature-line {
            width: 200px;
            border-bottom: 2px solid #2c3e50;
            margin: 0 auto 10px;
            height: 40px;
        }

        .signature-label {
            font-size: 12px;
            color: #7f8c8d;
            font-weight: bold;
        }

        .certificate-info {
            text-align: center;
            flex: 1;
        }

        .certificate-number {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .verification-code {
            font-size: 10px;
            color: #95a5a6;
            font-family: monospace;
        }

        .decorative-border {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            pointer-events: none;
        }

        .corner-decoration {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 3px solid #3498db;
        }

        .corner-decoration.top-left {
            top: 25px;
            left: 25px;
            border-right: none;
            border-bottom: none;
        }

        .corner-decoration.top-right {
            top: 25px;
            right: 25px;
            border-left: none;
            border-bottom: none;
        }

        .corner-decoration.bottom-left {
            bottom: 25px;
            left: 25px;
            border-right: none;
            border-top: none;
        }

        .corner-decoration.bottom-right {
            bottom: 25px;
            right: 25px;
            border-left: none;
            border-top: none;
        }

        .grade-badge {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="certificate-container">
    <!-- Decorative Elements -->
    <div class="decorative-border"></div>
    <div class="corner-decoration top-left"></div>
    <div class="corner-decoration top-right"></div>
    <div class="corner-decoration bottom-left"></div>
    <div class="corner-decoration bottom-right"></div>

    <!-- Header -->
    <div class="certificate-header">
        <div class="logo">LMS</div>
        <div class="institution-name">Learning Management System</div>
        <div class="certificate-title">Chứng Chỉ Hoàn Thành</div>
    </div>

    <!-- Body -->
    <div class="certificate-body">
        <div class="awarded-text">Chứng chỉ này được trao tặng cho</div>

        <div class="student-name">{{ $certificate->student->name }}</div>

        <div class="completion-text">
            đã hoàn thành xuất sắc khóa học
        </div>

        <div class="course-name">"{{ $certificate->course->title }}"</div>

        <div class="course-details">
            <div class="detail-item">
                <span class="detail-label">Giảng viên</span>
                <div class="detail-value">{{ $certificate->instructor_name }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Danh mục</span>
                <div class="detail-value">{{ $certificate->course_details['category'] ?? 'N/A' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Thời gian học</span>
                <div class="detail-value">{{ $certificate->study_duration }} giờ</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Ngày hoàn thành</span>
                <div class="detail-value">{{ $certificate->formatted_completed_date }}</div>
            </div>
        </div>

        @if($certificate->final_score)
            <div class="completion-text">
                với điểm số <strong>{{ number_format($certificate->final_score, 1) }}%</strong>
                <div class="grade-badge">{{ $certificate->grade }}</div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="certificate-footer">
        <div class="signature-section">
            <div class="signature-line"></div>
            <div class="signature-label">Giảng viên</div>
            <div style="font-size: 14px; margin-top: 5px; font-weight: bold;">
                {{ $certificate->instructor_name }}
            </div>
        </div>

        <div class="certificate-info">
            <div class="certificate-number">
                Số chứng chỉ: {{ $certificate->certificate_number }}
            </div>
            <div class="certificate-number">
                Ngày cấp: {{ $certificate->formatted_issued_date }}
            </div>
            <div class="verification-code">
                Mã xác thực: {{ $certificate->certificate_code }}
            </div>
            <div style="font-size: 10px; color: #bdc3c7; margin-top: 10px;">
                Xác thực tại: {{ config('app.url') }}/certificates/verify/{{ $certificate->certificate_code }}
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-line"></div>
            <div class="signature-label">Người đại diện</div>
            <div style="font-size: 14px; margin-top: 5px; font-weight: bold;">
                LMS Education
            </div>
        </div>
    </div>
</div>
</body>
</html>
