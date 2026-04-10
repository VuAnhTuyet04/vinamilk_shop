@extends('layouts.client')

@section('content')
<style>
    /* 1. CSS cho Banner Slider */
    .home-banner-section {
        max-width: 1100px;
        margin: 15px auto;
        padding: 0 15px;
        display: flex;
        gap: 10px;
        height: 300px;
    }

    .banner-main {
        flex: 2;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .swiper { width: 100%; height: 100%; }
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .banner-sub {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .banner-sub-item {
        flex: 1;
        border-radius: 8px;
        overflow: hidden;
    }

    .banner-sub-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* 2. CSS cho Bố cục chính */
    .main-layout {
        display: flex; 
        gap: 20px; 
        max-width: 1200px; 
        margin: 20px auto; 
        padding: 0 15px;
        align-items: flex-start;
    }

    .sidebar { 
        width: 250px; 
        flex-shrink: 0; 
        background: #fff; 
        border: 1px solid #ddd; 
        border-radius: 4px; 
    }

    .sidebar-title {
        background: #0056b3; 
        color: white; 
        padding: 12px 15px; 
        margin: 0; 
        font-size: 16px; 
        text-transform: uppercase;
        font-weight: bold;
    }

    .sidebar ul { list-style: none; padding: 0; margin: 0; }
    .sidebar ul li { border-bottom: 1px solid #eee; }
    .sidebar ul li a {
        display: block; 
        padding: 12px 15px; 
        text-decoration: none; 
        color: #333; 
        font-size: 14px;
        transition: 0.3s;
    }
    .sidebar ul li a:hover { background: #f8f9fa; color: #0056b3; padding-left: 20px; }

    .content { flex-grow: 1; }
    
    .section-header { 
        border-bottom: 2px solid #0056b3; 
        margin-bottom: 20px; 
        margin-top: 30px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    .section-header:first-child { margin-top: 0; }
    .section-header h2 { font-size: 18px; color: #333; margin: 0; padding-bottom: 5px; text-transform: uppercase; }

    /* 3. Grid Sản phẩm */
    .product-grid { 
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 15px; 
    }

    .product-card {
        border: 1px solid #eee;
        padding: 10px;
        text-align: center;
        transition: 0.3s;
        background: #fff;
        position: relative;
    }
    .product-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .product-img img { width: 100%; height: 160px; object-fit: contain; }
    .discount {
        position: absolute; top: 5px; left: 5px; background: red; color: white;
        font-size: 11px; padding: 2px 5px; border-radius: 3px; z-index: 10;
    }

    /* CSS cho số thông báo trên nút Chat của Khách */
    .chat-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff0000;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: none; /* Ẩn khi không có tin nhắn */
        justify-content: center;
        align-items: center;
        font-size: 11px;
        font-weight: bold;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        z-index: 10000;
    }

    /* 4. CSS cho Khung Chat */
    #chat-toggle-btn {
        position: fixed; bottom: 20px; right: 20px;
        width: 60px; height: 60px; background: #0056b3;
        color: white; border-radius: 50%; display: flex;
        justify-content: center; align-items: center;
        font-size: 24px; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        z-index: 9999;
        position: fixed;
    }
    #chat-container {
        position: fixed; bottom: 90px; right: 20px;
        width: 320px; height: 400px; background: white;
        border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        display: none; flex-direction: column; z-index: 9999; overflow: hidden;
    }
    .chat-header { background: #0056b3; color: white; padding: 12px; font-weight: bold; display: flex; justify-content: space-between; }
    .chat-body { flex: 1; padding: 10px; overflow-y: auto; background: #f4f7f6; display: flex; flex-direction: column; gap: 8px; }
    .msg-u { align-self: flex-end; background: #0056b3; color: white; padding: 7px 12px; border-radius: 12px 12px 0 12px; max-width: 85%; font-size: 13px; }
    .msg-a { align-self: flex-start; background: #e2e2e2; color: #333; padding: 7px 12px; border-radius: 12px 12px 12px 0; max-width: 85%; font-size: 13px; }
    .chat-footer { padding: 10px; border-top: 1px solid #eee; display: flex; gap: 5px; background: #fff; }
    #chat-input-text { flex: 1; border: 1px solid #ddd; border-radius: 4px; padding: 6px 10px; outline: none; }
    .btn-send { background: #0056b3; color: white; border: none; padding: 5px 12px; border-radius: 4px; cursor: pointer; }

    @media (max-width: 992px) { .product-grid { grid-template-columns: repeat(2, 1fr); } }
</style>

<div class="home-banner-section">
    <div class="banner-main">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{ asset('images/bn111.jpg') }}"></div>
                <div class="swiper-slide"><img src="{{ asset('images/bn222.jpg') }}"></div>
                <div class="swiper-slide"><img src="{{ asset('images/bn333.jpg') }}"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next" style="color: #fff; transform: scale(0.5);"></div>
            <div class="swiper-button-prev" style="color: #fff; transform: scale(0.5);"></div>
        </div>
    </div>

    <div class="banner-sub">
        <div class="banner-sub-item"><img src="{{ asset('images/bn1.jpg') }}"></div>
        <div class="banner-sub-item"><img src="{{ asset('images/bn22.jpg') }}"></div>
        <div class="banner-sub-item"><img src="{{ asset('images/bn3.jpg') }}"></div>
    </div>
</div>

<div class="main-layout">
    <aside class="sidebar">
        <h3 class="sidebar-title"><i class="fa fa-bars"></i> DANH MỤC</h3>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('client.category', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <div class="content">
        <div class="section-header">
            <h2>SẢN PHẨM BÁN CHẠY</h2>
        </div>
        <div class="product-grid">
            @foreach($bestSellers as $product)
            <div class="product-card">
                @if($product->discount_price > 0)
                    @php $percent = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                    <span class="discount">-{{ $percent }}%</span>
                @endif
                <div class="product-img">
                   <img src="{{ asset('images/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                </div>
                <h3 style="font-size: 14px; margin: 10px 0; height: 35px; overflow: hidden; color: #333;">{{ $product->name }}</h3>
                <div class="price-box">
                    @if($product->discount_price > 0)
                        <span class="price" style="color: red; font-weight: bold;">{{ number_format($product->discount_price, 0, ',', '.') }}đ</span>
                        <br><span class="old-price" style="text-decoration: line-through; color: #999; font-size: 11px;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                    @else
                        <span class="price" style="color: red; font-weight: bold;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                    @endif
                </div>
                <a href="{{ route('client.product_detail', $product->slug) }}" class="btn-buy" style="display: block; margin-top: 10px; padding: 5px; background: #0056b3; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">
                    Xem chi tiết
                </a>
            </div>
            @endforeach
        </div>

        <div class="section-header">
            <h2>SẢN PHẨM MỚI</h2>
        </div>
        <div class="product-grid">
            @foreach($newProducts as $product)
            <div class="product-card">
                @if($product->discount_price > 0)
                    @php $percent = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                    <span class="discount">-{{ $percent }}%</span>
                @endif
                <div class="product-img">
                   <img src="{{ asset('images/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                </div>
                <h3 style="font-size: 14px; margin: 10px 0; height: 35px; overflow: hidden; color: #333;">{{ $product->name }}</h3>
                <div class="price-box">
                    @if($product->discount_price > 0)
                        <span class="price" style="color: red; font-weight: bold;">{{ number_format($product->discount_price, 0, ',', '.') }}đ</span>
                        <br><span class="old-price" style="text-decoration: line-through; color: #999; font-size: 11px;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                    @else
                        <span class="price" style="color: red; font-weight: bold;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                    @endif
                </div>
                <a href="{{ route('client.product_detail', $product->slug) }}" class="btn-buy" style="display: block; margin-top: 10px; padding: 5px; background: #0056b3; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">
                    Xem chi tiết
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="chat-toggle-btn" onclick="toggleChatBox()">
    <i class="fa fa-comments"></i>
    <span id="chat-unread-count" class="chat-badge">0</span>
</div>

<div id="chat-container">
    <div class="chat-header">
        <span>Hỗ trợ trực tuyến</span>
        <span onclick="toggleChatBox()" style="cursor:pointer">&times;</span>
    </div>
    <div id="chat-body" class="chat-body"></div>
    <div class="chat-footer">
        <input type="text" id="chat-input-text" placeholder="Nhập tin nhắn..." onkeypress="if(event.key==='Enter') sendChat()">
        <button class="btn-send" onclick="sendChat()">Gửi</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Khởi tạo Swiper
        if (typeof Swiper !== 'undefined') {
            var swiper = new Swiper(".mySwiper", {
                loop: true,
                autoplay: { delay: 3000, disableOnInteraction: false },
                pagination: { el: ".swiper-pagination", clickable: true },
                navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            });
        }
        
        // Luôn chạy kiểm tra tin nhắn khi tải trang
        updateClientUnreadCount();
    });

    const chatBox = document.getElementById('chat-container');
    const chatBody = document.getElementById('chat-body');
    const userId = "{{ Auth::id() ?? '' }}"; 

    function toggleChatBox() {
        if (!userId || userId === '') {
            alert('Vui lòng đăng nhập để chat với hỗ trợ Vinamilk!');
            return;
        }
        
        chatBox.style.display = chatBox.style.display === 'flex' ? 'none' : 'flex';
        
        if (chatBox.style.display === 'flex') {
            // Khi mở chat, ẩn badge và load tin nhắn
            document.getElementById('chat-unread-count').style.display = 'none';
            loadMsgs();
        }
    }

    function loadMsgs() {
        if (!userId) return;

        axios.get(`/messages/${userId}`)
            .then(res => {
                chatBody.innerHTML = '';
                res.data.forEach(m => {
                    const d = document.createElement('div');
                    // m.is_from_admin == 1 thì là admin gửi
                    d.className = m.is_from_admin == 1 ? 'msg-a' : 'msg-u';
                    d.innerText = m.message;
                    chatBody.appendChild(d);
                });
                chatBody.scrollTop = chatBody.scrollHeight;
            })
            .catch(err => {
                console.error("Lỗi khi tải tin nhắn:", err);
            });
    }

    function sendChat() {
        const input = document.getElementById('chat-input-text');
        const message = input.value.trim();
        
        if (!message) return;

        axios.post('/messages', { 
            user_id: userId, 
            message: message 
        })
        .then(() => {
            input.value = '';
            loadMsgs(); 
        })
        .catch(err => {
            alert("Không thể gửi tin nhắn. Vui lòng thử lại!");
        });
    }

    // Hàm đếm tin nhắn chưa đọc từ Admin gửi cho Khách
    function updateClientUnreadCount() {
        if (!userId || userId === '') return;

        axios.get(`/messages/${userId}`)
            .then(res => {
                // Đếm tin nhắn từ Admin (is_from_admin == 1) mà chưa đọc (is_read == 0)
                const unreadMessages = res.data.filter(m => m.is_from_admin == 1 && m.is_read == 0);
                const badge = document.getElementById('chat-unread-count');
                
                // Chỉ hiện badge nếu khung chat đang đóng và có tin mới
                if (unreadMessages.length > 0 && chatBox.style.display !== 'flex') {
                    badge.innerText = unreadMessages.length;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            });
    }

    // Tự động kiểm tra mỗi 5 giây
    setInterval(() => { 
        if(userId) {
            if(chatBox.style.display === 'flex') {
                loadMsgs(); 
            } else {
                updateClientUnreadCount();
            }
        }
    }, 5000);
</script>
@endsection