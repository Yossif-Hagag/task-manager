<!-- filepath: /mnt/work/laravel/task-manager/resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> <!-- إضافة ملف أنماط مخصص -->
    <script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}" defer></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- الشريط الجانبي -->
        @include('layouts.sidebar')

        <!-- محتوى الصفحة -->
        <div class="content-wrapper">
            <section class="content p-3">
                @yield('content')
            </section>
        </div>
    </div>
    <footer class="main-footer text-center"> <!-- إضافة تذييل -->
        <strong>حقوق النشر &copy; 2025 <a href="#">اسم شركتك</a>.</strong> جميع الحقوق محفوظة.
    </footer>
</body>

</html>
