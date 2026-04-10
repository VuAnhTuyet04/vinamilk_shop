<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinamilk Store - Hệ thống sữa chuẩn quốc tế</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/client-style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        /* Màu chủ đạo Vinamilk */
        :root { 
            --vn-blue: #004b8d; 
            --vn-light: #f4f4f4;
        }
        body { margin: 0; padding: 0; background: var(--vn-light); font-family: Arial, sans-serif; }
        main { min-height: 600px; }
    </style>
</head>
<body>

    @include('layouts.partials.header')

    <main>
        <div class="container">
            @yield('content')
            @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 15px; margin: 20px; border: 1px solid #c3e6cb; border-radius: 4px; text-align: center;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin: 20px; border: 1px solid #f5c6cb; border-radius: 4px; text-align: center;">
        {{ session('error') }}
    </div>
@endif
        </div>
    </main>

    @include('layouts.partials.footer')

</body>
</html>