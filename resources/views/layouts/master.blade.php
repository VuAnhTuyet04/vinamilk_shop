<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Vinamilk Shop - BTL</title>
    <style>
        /* Cấu hình chung */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f4f7f6; }
        
        /* Thanh Nav chính */
        nav { 
            background: #dc7fa1; 
            color: white; 
            display: flex; 
            align-items: center; 
            padding: 0 30px;
            height: 60px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-brand {
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 50px;
            white-space: nowrap; 
        }

        /* Danh sách Menu điều hướng */
        .nav-menu {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .nav-menu li {
            height: 100%;
        }

        .nav-menu li a {
            color: white;
            text-decoration: none;
            padding: 0 15px;
            display: flex;
            align-items: center;
            height: 100%;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            position: relative; /* Thêm để căn chỉnh badge */
        }

        /* Hiệu ứng khi di chuột qua menu */
        .nav-menu li a:hover {
            background: rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }

        /* Style cho Badge thông báo tin nhắn */
        .badge-unread {
            background-color: #ff0000;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            position: absolute;
            top: 10px;
            right: 2px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            font-weight: bold;
            display: none; /* Ẩn mặc định, chỉ hiện khi có tin nhắn */
        }

        /* Nội dung chính */
        .container { padding: 30px; }
    </style>
</head>
<body>

    <nav>
        <div class="nav-brand">VINAMILK WEB QUẢN LÝ</div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> &nbsp;Sản phẩm</a></li>
            <li><a href="{{ route('categories.index') }}"><i class="bi bi-list-ul"></i> &nbsp;Danh mục</a></li>
            <li><a href="{{ route('admin.orders.index') }}"><i class="bi bi-cart-check"></i> &nbsp;Đơn hàng</a></li>
            <li>
                <a class="nav-link" href="{{ route('admin.chat') }}">
                    <i class="fa fa-comments"></i> &nbsp;Liên hệ
                    <span id="unread-count-badge" class="badge-unread">0</span>
                </a>
            </li>
            <li><a href="{{ route('admin.dashboard') }}">Thống kê</a></li>
        </ul>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function checkUnreadMessages() {
            // Gọi đến route mà chúng ta đã tạo ở ChatController
            axios.get('/admin/unread-messages-count')
                .then(res => {
                    const count = res.data.unread_count;
                    const badge = document.getElementById('unread-count-badge');
                    
                    if (count > 0) {
                        badge.innerText = count > 99 ? '99+' : count;
                        badge.style.display = 'block';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.log("Chưa đăng nhập hoặc lỗi API thông báo");
                });
        }

        // Kiểm tra ngay khi tải trang
        checkUnreadMessages();

        // Tự động kiểm tra mỗi 10 giây để cập nhật số lượng mới
        setInterval(checkUnreadMessages, 10000);
    </script>
</body>
</html>