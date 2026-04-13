<header class="main-header">
    <div class="top-bar">
        <div class="container-header">
            <span>Chào mừng bạn đến với cửa hàng sữa Vinamilk chính hãng</span>
            <div class="top-links">
                {{-- PHẦN XỬ LÝ NÚT TÀI KHOẢN THÔNG MINH --}}
                @guest
                    {{-- Khi chưa đăng nhập: Di chuột vào hiện Đăng nhập & Đăng ký --}}
                    <div class="user-dropdown">
                        <a href="javascript:void(0)"><i class="fa fa-user"></i> Tài khoản <i class="fa fa-caret-down"></i></a>
                        <div class="dropdown-content">
                            <a href="{{ route('login') }}">Đăng nhập</a>
                            <a href="{{ route('register') }}">Đăng ký thành viên</a>
                        </div>
                    </div>
                @else
                    {{-- Khi đã đăng nhập: Hiện tên và quyền tương ứng --}}
                    <div class="user-dropdown">
                        <a href="javascript:void(0)" style="font-weight: bold;">
                            <i class="fa fa-user-circle"></i> Chào, {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                        </a>
                        <div class="dropdown-content">
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" style="color: #008d81 !important; font-weight: bold;">Trang Quản Trị</a>
                            @endif
                            <a href="{{ route('client.profile') }}">Thông tin tài khoản</a>
                            <a href="{{ route('logout') }}" onclick="return confirm('Bạn có muốn đăng xuất không?')">Đăng xuất</a>
                        </div>
                    </div>
                @endguest
            
                <a href="{{ route('client.products') }}"><i class="fa fa-shopping-bag"></i> Sản phẩm</a>
                <a href="#"><i class="fa fa-map-marker"></i> Hệ thống cửa hàng</a>
            </div>
        </div>
    </div>

    <div class="header-middle">
        <div class="container-header">
            <div class="logo">
                <a href="/" style="text-decoration: none;">
                    <h1 style="color: white; margin: 0;">Vinamilk<span>.vn</span></h1>
                </a>
                <small>Sữa tươi chuẩn quốc tế</small>
            </div>

          <div class="search-box">
    {{-- Đảm bảo route('search') đã được định nghĩa trong web.php --}}
    <form action="{{ route('search') }}" method="GET">
        <select name="category">
            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>Tất cả</option>
            {{-- Kiểm tra nếu có danh mục thì mới lặp để tránh lỗi --}}
            @if(isset($categories))
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            @endif
        </select>
        <input type="text" name="query" value="{{ request('query') }}" placeholder="Tìm kiếm sản phẩm sữa...">
        
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</div>
            <div class="header-contact">
                <div class="contact-item">
                    <i class="fa fa-phone"></i>
                    <span>Gọi đặt hàng<br><strong>0962.774.320</strong></span>
                </div>
                <div class="contact-item">
                    <i class="fa fa-headphones"></i>
                    <span>Gọi tư vấn<br><strong>039.465.8880</strong></span>
                </div>
            </div>
        </div>
    </div>

    <nav class="main-nav">
        <div class="container-header">
            <ul class="nav-list">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Trang chủ</a></li>
              <li><a href="{{ route('client.about') }}">Giới thiệu</a></li>
                <li><a href="{{ route('client.products') }}" class="{{ request()->is('san-pham*') ? 'active' : '' }}">Sản phẩm</a></li>
            </ul>
            {{-- Giỏ hàng hiển thị số lượng từ Session --}}
            <a href="{{ route('client.cart') }}" class="mini-cart" style="text-decoration: none; color: white;">
                <i class="fa fa-shopping-cart"></i> 
                <span>Giỏ hàng ({{ Session::has('cart') ? count(Session::get('cart')) : 0 }})</span>
            </a>
        </div>
    </nav>
</header>

<style>
/* CSS để menu Tài khoản hoạt động mượt mà */
.user-dropdown {
    display: inline-block;
    position: relative;
}

.user-dropdown > a {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #ffffff;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    z-index: 1000;
    border-radius: 4px;
    overflow: hidden;
}

.dropdown-content a {
    color: #333 !important;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-size: 14px;
    text-align: left;
    border-bottom: 1px solid #f1f1f1;
    transition: 0.3s;
}

.dropdown-content a:last-child {
    border-bottom: none;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
    color: #008d81 !important;
}

.user-dropdown:hover .dropdown-content {
    display: block;
}

/* Hiệu ứng mũi tên khi hover */
.user-dropdown:hover > a {
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
}
</style>