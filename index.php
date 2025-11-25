<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شاشة ديناميكية مع معرض صور PHP</title>
    <style>
        /* ... (تنسيقات CSS كما هي) ... */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: right;
            direction: rtl;
        }
        .header-icons {
            position: absolute;
            top: 15px;
            left: 15px;
        }
        .header-icons a {
            margin-left: 10px;
            text-decoration: none;
            font-size: 24px;
            color: #333;
        }
        .welcome-message {
            margin-top: 100px;
            padding: 20px;
            font-size: 20px;
            color: #555;
            text-align: center;
        }
        /* --- تنسيق معرض الصور --- */
        #gallery {
            padding: 20px;
            text-align: center;
            display: none;
        }
        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .gallery-item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            cursor: pointer;
            border: 1px solid #ddd;
            transition: transform 0.2s;
        }
        .gallery-item img:hover {
            transform: scale(1.05);
        }

        /* --- تنسيق شاشة التكبير (Lightbox) --- */
        .lightbox {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }
        .lightbox-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            max-height: 90vh;
            object-fit: contain;
        }
        .lightbox-content, .caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="header-icons">
        <a href="#" id="openGallery" title="ملف الصور">
            &#128247;
        </a>
        <a href="#admin" title="لوحة الأدمن">
            &#128100;
        </a>
        <a href="https://wa.me/XXXXXXXXXX" target="_blank" title="تواصل عبر واتساب">
            &#9990;
        </a>
    </div>

    <div class="main-content">
        <div class="welcome-message">
            <h1>مرحباً بك!</h1>
            <p>شاشتك الرئيسية فارغة وجاهزة لاستقبال المحتوى.</p>
        </div>
    </div>

    <div id="gallery">
        <h2>معرض الصور</h2>
        <div class="gallery-container">
            <?php
            // المسار إلى مجلد الصور
            $image_dir = 'images/';
            
            // ** 🚀 السطر الجديد الذي يضيف خاصية إنشاء المجلد تلقائياً **
            // يتم إنشاء المجلد إذا لم يكن موجوداً
            if (!is_dir($image_dir)) {
                // 0755 هي صلاحيات المجلد. true تعني إنشاء المجلدات المتداخلة إذا كانت مطلوبة.
                mkdir($image_dir, 0755, true); 
            }

            // قراءة محتويات المجلد
            $files = scandir($image_dir);
            
            // قائمة أنواع الملفات المقبولة (امتدادات الصور)
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            // المرور على كل ملف
            foreach ($files as $file) {
                // التأكد من أنه ليس مجلد رئيسي أو فرعي (.) أو (..)
                if ($file != '.' && $file != '..') {
                    // الحصول على مسار الملف كاملاً
                    $file_path = $image_dir . $file;
                    
                    // استخراج امتداد الملف
                    $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                    
                    // التحقق من أن الملف هو صورة
                    if (in_array(strtolower($file_ext), $allowed_extensions)) {
                        // إنشاء وسم HTML للصورة تلقائياً
                        echo '<div class="gallery-item">';
                        echo '  <img src="' . $file_path . '" alt="' . $file . '" onclick="openLightbox(this)">';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
    </div>

    <div id="myLightbox" class="lightbox" onclick="closeLightbox()">
        <span class="close">&times;</span>
        <img class="lightbox-content" id="img01">
    </div>

    <script>
        // دالة لفتح/إغلاق المعرض عند الضغط على أيقونة الصور
        document.getElementById('openGallery').onclick = function(e) {
            e.preventDefault();
            var gallery = document.getElementById('gallery');
            var welcome = document.querySelector('.welcome-message');

            if (gallery.style.display === 'block') {
                gallery.style.display = 'none';
                welcome.style.display = 'block';
            } else {
                gallery.style.display = 'block';
                welcome.style.display = 'none';
            }
        };

        // دالة فتح شاشة التكبير (Lightbox)
        function openLightbox(imgElement) {
            var lightbox = document.getElementById("myLightbox");
            var lightboxImg = document.getElementById("img01");

            lightbox.style.display = "block";
            lightboxImg.src = imgElement.src;
        }

        // دالة إغلاق شاشة التكبير (Lightbox)
        function closeLightbox() {
            var lightbox = document.getElementById("myLightbox");
            lightbox.style.display = "none";
        }
    </script>

</body>
</html>
