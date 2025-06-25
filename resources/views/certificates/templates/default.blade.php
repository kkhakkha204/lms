<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - Tech.era</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

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
            font-family: 'Inter', 'DejaVu Sans', Arial, sans-serif;
            background: #1c1c1c;
            width: 297mm;
            height: 210mm;
            position: relative;
            color: #1c1c1c;
        }

        .certificate-container {
            width: 100%;
            height: 100%;
            position: relative;
            background: white;
            overflow: hidden;
        }

        /* Modern geometric background */
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            background-image:
                linear-gradient(45deg, #7e0202 25%, transparent 25%),
                linear-gradient(-45deg, #7e0202 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #7e0202 75%),
                linear-gradient(-45deg, transparent 75%, #7e0202 75%);
            background-size: 30px 30px;
            background-position: 0 0, 0 15px, 15px -15px, -15px 0px;
        }

        /* Header with brand identity */
        .certificate-header {
            position: relative;
            padding: 40px 60px 30px;
            background: linear-gradient(135deg, #1c1c1c 0%, #2d2d2d 100%);
            color: white;
        }

        .header-accent {
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 100%;
            background: linear-gradient(135deg, #7e0202 0%, #ed292a 100%);
            clip-path: polygon(30% 0%, 100% 0%, 100% 100%, 0% 100%);
        }

        .brand-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ed292a 0%, #7e0202 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .institution-name {
            font-size: 28px;
            font-weight: 700;
            color: white;
            letter-spacing: -1px;
        }

        .tagline {
            font-size: 12px;
            color: #999;
            font-weight: 400;
            margin-top: 2px;
            letter-spacing: 0.5px;
        }

        .certificate-type {
            text-align: right;
            color: #ccc;
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Main content area */
        .certificate-content {
            padding: 50px 60px;
            position: relative;
            height: calc(100% - 140px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .certificate-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .title-main {
            font-size: 48px;
            font-weight: 300;
            color: #1c1c1c;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .title-accent {
            font-size: 16px;
            color: #7e0202;
            font-weight: 500;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        /* Student information */
        .student-section {
            text-align: center;
            margin: 40px 0;
        }

        .awarded-text {
            font-size: 18px;
            color: #666;
            font-weight: 300;
            margin-bottom: 20px;
        }

        .student-name {
            font-size: 42px;
            font-weight: 600;
            color: #1c1c1c;
            margin: 20px 0;
            position: relative;
            display: inline-block;
        }

        .student-name::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #7e0202 0%, #ed292a 100%);
            border-radius: 2px;
        }

        .completion-text {
            font-size: 18px;
            color: #666;
            font-weight: 300;
            margin: 25px 0 15px;
        }

        .course-name {
            font-size: 28px;
            font-weight: 500;
            color: #ed292a;
            margin: 20px 0;
            line-height: 1.3;
        }

        /* Course details grid */
        .course-details {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin: 40px 0;
            padding: 30px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .detail-item {
            text-align: center;
            position: relative;
        }

        .detail-label {
            font-size: 12px;
            color: #999;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 16px;
            color: #1c1c1c;
            font-weight: 500;
        }

        /* Score section */
        .score-section {
            text-align: center;
            margin: 30px 0;
        }

        .score-container {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: #f8f8f8;
            padding: 15px 25px;
            border-radius: 50px;
            border: 2px solid #ed292a;
        }

        .score-text {
            font-size: 16px;
            color: #666;
            font-weight: 400;
        }

        .score-value {
            font-size: 24px;
            font-weight: 700;
            color: #ed292a;
        }

        .grade-badge {
            background: linear-gradient(135deg, #7e0202 0%, #ed292a 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Footer */
        .certificate-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: #f8f8f8;
            padding: 25px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
        }

        .signature-section {
            text-align: center;
            flex: 1;
        }

        .signature-line {
            width: 150px;
            height: 1px;
            background: #ddd;
            margin: 0 auto 12px;
        }

        .signature-title {
            font-size: 11px;
            color: #999;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .signature-name {
            font-size: 14px;
            color: #1c1c1c;
            font-weight: 600;
        }

        .certificate-meta {
            text-align: center;
            flex: 1;
        }

        .meta-item {
            font-size: 11px;
            color: #666;
            margin: 2px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .meta-label {
            font-weight: 500;
            color: #999;
        }

        .verification-url {
            font-size: 9px;
            color: #999;
            margin-top: 8px;
            font-family: monospace;
        }

        /* Decorative elements */
        .corner-accent {
            position: absolute;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ed292a 0%, #7e0202 100%);
        }

        .corner-accent.top-left {
            top: 0;
            left: 0;
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }

        .corner-accent.top-right {
            top: 0;
            right: 0;
            clip-path: polygon(0 0, 100% 0, 100% 100%);
        }

        .side-accent {
            position: absolute;
            top: 140px;
            bottom: 60px;
            width: 4px;
            background: linear-gradient(180deg, #7e0202 0%, #ed292a 50%, #7e0202 100%);
        }

        .side-accent.left {
            left: 0;
        }

        .side-accent.right {
            right: 0;
        }
    </style>
</head>
<body>
<div class="certificate-container">
    <!-- Background Pattern -->
    <div class="background-pattern"></div>

    <!-- Decorative Accents -->
    <div class="corner-accent top-left"></div>
    <div class="corner-accent top-right"></div>
    <div class="side-accent left"></div>
    <div class="side-accent right"></div>

    <!-- Header -->
    <div class="certificate-header">
        <div class="header-accent"></div>
        <div class="brand-section">
            <div class="logo-container">
                <div class="logo">T</div>
                <div class="brand-text">
                    <div class="institution-name">Tech.era</div>
                    <div class="tagline">Excellence in Technology Education</div>
                </div>
            </div>
            <div class="certificate-type">Certificate of Achievement</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="certificate-content">
        <div class="certificate-title">
            <div class="title-main">Chứng Chỉ</div>
            <div class="title-accent">Certificate of Completion</div>
        </div>

        <div class="student-section">
            <div class="awarded-text">Chứng chỉ này được trao tặng cho</div>
            <div class="student-name">{{ $certificate->student->name }}</div>
            <div class="completion-text">đã xuất sắc hoàn thành khóa học</div>
            <div class="course-name">"{{ $certificate->course->title }}"</div>
        </div>

        <div class="course-details">
            <div class="detail-item">
                <div class="detail-label">Giảng viên</div>
                <div class="detail-value">{{ $certificate->instructor_name }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Danh mục</div>
                <div class="detail-value">{{ $certificate->course_details['category'] ?? 'Technology' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Thời lượng</div>
                <div class="detail-value">{{ $certificate->study_duration }} giờ</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Hoàn thành</div>
                <div class="detail-value">{{ $certificate->formatted_completed_date }}</div>
            </div>
        </div>

        @if($certificate->final_score)
            <div class="score-section">
                <div class="score-container">
                    <span class="score-text">Điểm số:</span>
                    <span class="score-value">{{ number_format($certificate->final_score, 1) }}%</span>
                    <span class="grade-badge">{{ $certificate->grade }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="certificate-footer">
        <div class="signature-section">
            <div class="signature-line"></div>
            <div class="signature-title">Giảng viên</div>
            <div class="signature-name">{{ $certificate->instructor_name }}</div>
        </div>

        <div class="certificate-meta">
            <div class="meta-item">
                <span class="meta-label">Mã chứng chỉ:</span>
                <span>{{ $certificate->certificate_number }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Ngày cấp:</span>
                <span>{{ $certificate->formatted_issued_date }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Xác thực:</span>
                <span>{{ $certificate->certificate_code }}</span>
            </div>
            <div class="verification-url">
                {{ config('app.url') }}/certificates/verify/{{ $certificate->certificate_code }}
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-line"></div>
            <div class="signature-title">Đại diện</div>
            <div class="signature-name">Tech.era Education</div>
        </div>
    </div>
</div>
</body>
</html>
