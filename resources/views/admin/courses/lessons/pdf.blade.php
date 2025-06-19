<!DOCTYPE html>
<html>
<head>
    <title>{{ $lesson->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #1f2937; }
        p { color: #4b5563; }
    </style>
</head>
<body>
<h1>{{ $lesson->title }}</h1>
<p>{{ $lesson->content }}</p>
@if ($lesson->summary)
    <h2>Tóm tắt</h2>
    <p>{{ $lesson->summary }}</p>
@endif
</body>
</html>
