<!-- Tạo trang test riêng: resources/views/test-video.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Video Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8">
<h1 class="text-2xl font-bold mb-6">YouTube Embed Test</h1>

<!-- Test basic embed -->
<div class="mb-8">
    <h2 class="text-lg font-semibold mb-2">Test 1: Basic Embed</h2>
    <div class="w-full h-64 bg-black">
        <iframe
            src="https://www.youtube.com/watch?v=dQw4w9WgXcQ"
            class="w-full h-full"
            frameborder="0"
            allowfullscreen>
        </iframe>
    </div>
</div>

<!-- Test nocookie -->
<div class="mb-8">
    <h2 class="text-lg font-semibold mb-2">Test 2: No-Cookie Embed</h2>
    <div class="w-full h-64 bg-black">
        <iframe
            src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ"
            class="w-full h-full"
            frameborder="0"
            allowfullscreen>
        </iframe>
    </div>
</div>

<!-- Test với video ID từ lesson -->
<div class="mb-8">
    <h2 class="text-lg font-semibold mb-2">Test 3: Your Video ID</h2>
    <div class="w-full h-64 bg-black">
        <iframe
            src="https://www.youtube.com/embed/CdRUg6jiizc"
            class="w-full h-full"
            frameborder="0"
            allowfullscreen>
        </iframe>
    </div>
</div>

<script>
    // Check all iframes
    document.querySelectorAll('iframe').forEach((iframe, index) => {
        iframe.onload = () => console.log(`Iframe ${index + 1} loaded`);
        iframe.onerror = () => console.error(`Iframe ${index + 1} failed`);
    });
</script>
</body>
</html>

<!-- Thêm route test trong web.php -->
Route::get('/test-video', function () {
return view('test-video');
});
