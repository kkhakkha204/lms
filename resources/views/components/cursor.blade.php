{{-- resources/views/components/cursor.blade.php --}}
<div id="custom-cursor" class="fixed pointer-events-none z-[9999] transition-all duration-150 ease-out opacity-100">
    <div class="w-[1.1rem] h-[1.1rem] bg-white border-[2px] border-[#1c1c1c] rounded-full shadow-lg"></div>
</div>

<style>
    /* Ẩn hoàn toàn cursor mặc định */
    *, *::before, *::after {
        cursor: none !important;
    }

    html, body {
        cursor: none !important;
    }

    /* Override tất cả các loại cursor */
    a, button, input, textarea, select, [role="button"], .cursor-pointer,
    a:hover, button:hover, input:hover, textarea:hover, select:hover,
    [role="button"]:hover, .cursor-pointer:hover,
    a:focus, button:focus, input:focus, textarea:focus, select:focus,
    [role="button"]:focus, .cursor-pointer:focus,
    a:active, button:active, input:active, textarea:active, select:active,
    [role="button"]:active, .cursor-pointer:active {
        cursor: none !important;
    }

    /* Đảm bảo không có cursor nào xuất hiện */
    input[type="text"], input[type="email"], input[type="password"],
    input[type="search"], input[type="url"], input[type="tel"],
    textarea, [contenteditable="true"] {
        cursor: none !important;
    }

    /* Override Tailwind CSS cursor classes */
    .cursor-auto, .cursor-default, .cursor-pointer, .cursor-wait,
    .cursor-text, .cursor-move, .cursor-help, .cursor-not-allowed,
    .cursor-none, .cursor-context-menu, .cursor-progress,
    .cursor-cell, .cursor-crosshair, .cursor-vertical-text,
    .cursor-alias, .cursor-copy, .cursor-no-drop, .cursor-grab,
    .cursor-grabbing, .cursor-all-scroll, .cursor-col-resize,
    .cursor-row-resize, .cursor-n-resize, .cursor-e-resize,
    .cursor-s-resize, .cursor-w-resize, .cursor-ne-resize,
    .cursor-nw-resize, .cursor-se-resize, .cursor-sw-resize,
    .cursor-ew-resize, .cursor-ns-resize, .cursor-nesw-resize,
    .cursor-nwse-resize, .cursor-zoom-in, .cursor-zoom-out {
        cursor: none !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cursor = document.getElementById('custom-cursor');

        // Chỉ áp dụng cho desktop
        if (window.innerWidth > 768) {
            let mouseX = window.innerWidth / 2; // Bắt đầu ở giữa màn hình
            let mouseY = window.innerHeight / 2;
            let cursorX = mouseX;
            let cursorY = mouseY;

            // Đặt vị trí ban đầu cho cursor
            cursor.style.transform = `translate(${cursorX - 8}px, ${cursorY - 8}px)`;
            cursor.style.opacity = '1';

            // Theo dõi vị trí chuột
            document.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                cursor.style.opacity = '1'; // Đảm bảo cursor luôn hiển thị khi di chuyển chuột
            });

            // Giữ cursor hiển thị
            document.addEventListener('mouseenter', function() {
                cursor.style.opacity = '1';
            });

            // Ẩn cursor khi chuột rời khỏi window (tùy chọn)
            document.addEventListener('mouseleave', function() {
                cursor.style.opacity = '0.3'; // Làm mờ thay vì ẩn hoàn toàn
            });

            // Animation mượt mà
            function animateCursor() {
                const speed = 0.90;
                cursorX += (mouseX - cursorX) * speed;
                cursorY += (mouseY - cursorY) * speed;

                cursor.style.transform = `translate(${cursorX - 8}px, ${cursorY - 8}px)`;
                requestAnimationFrame(animateCursor);
            }

            animateCursor();

            // Hiệu ứng khi hover vào các element có thể click
            const clickableElements = 'a, button, input, textarea, select, [role="button"], .cursor-pointer, [onclick]';

            document.addEventListener('mouseover', function(e) {
                if (e.target.matches(clickableElements) || e.target.closest(clickableElements)) {
                    cursor.querySelector('div').style.transform = 'scale(1.3)';
                    cursor.querySelector('div').style.backgroundColor = '#ffffff';
                    cursor.querySelector('div').style.borderColor = '#1c1c1c';
                }
            });

            document.addEventListener('mouseout', function(e) {
                if (e.target.matches(clickableElements) || e.target.closest(clickableElements)) {
                    cursor.querySelector('div').style.transform = 'scale(1)';
                    cursor.querySelector('div').style.backgroundColor = 'white';
                    cursor.querySelector('div').style.borderColor = 'black';
                }
            });

            // Thêm hiệu ứng click
            document.addEventListener('mousedown', function(e) {
                cursor.querySelector('div').style.transform = 'scale(0.8)';
            });

            document.addEventListener('mouseup', function(e) {
                const isClickable = e.target.matches(clickableElements) || e.target.closest(clickableElements);
                cursor.querySelector('div').style.transform = isClickable ? 'scale(1.3)' : 'scale(1)';
            });
        } else {
            // Ẩn custom cursor trên mobile và hiện lại cursor mặc định
            cursor.style.display = 'none';
            const style = document.createElement('style');
            style.textContent = `
            *, *::before, *::after, html, body,
            a, button, input, textarea, select {
                cursor: auto !important;
            }
        `;
            document.head.appendChild(style);
        }
    });
</script>
