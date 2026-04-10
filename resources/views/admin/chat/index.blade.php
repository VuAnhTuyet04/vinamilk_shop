@extends('layouts.master')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">QUẢN LÝ TIN NHẮN KHÁCH HÀNG</h2>
    <div class="card">
        <div class="row no-gutters" style="height: 500px;">
            <div class="col-md-4 border-right">
                <div class="bg-primary text-white p-3">Danh sách khách hàng</div>
                <div id="user-list" class="list-group list-group-flush overflow-auto" style="height: 440px;">
                    </div>
            </div>

            <div class="col-md-8 d-flex flex-column">
                <div id="chat-header" class="p-3 border-bottom bg-light font-weight-bold">
                    Chọn một khách hàng để xem tin nhắn
                </div>
                <div id="admin-chat-body" class="p-3 flex-grow-1 overflow-auto bg-white d-flex flex-column" style="gap: 10px;">
                    </div>
                <div class="p-3 border-top d-flex">
                    <input type="text" id="admin-input" class="form-control" placeholder="Nhập câu trả lời..." onkeypress="if(event.key==='Enter') adminSend()">
                    <button class="btn btn-primary ml-2" onclick="adminSend()">Gửi</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .unread-badge {
        background: #ff0000;
        color: white;
        border-radius: 50%;
        padding: 2px 7px;
        font-size: 11px;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .user-item { cursor: pointer; border-bottom: 1px solid #eee; padding: 15px; }
    .user-item:hover { background: #f0f7ff; }
    .user-active { background: #e7f3ff !important; border-left: 5px solid #0056b3; }
    .msg-u { align-self: flex-start; background: #f1f0f0; padding: 8px 15px; border-radius: 15px; max-width: 70%; }
    .msg-a { align-self: flex-end; background: #0056b3; color: white; padding: 8px 15px; border-radius: 15px; max-width: 70%; }
</style>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let currentChatUserId = null;

    function loadUsers() {
        axios.get('/admin/get-chat-users').then(res => {
            const list = document.getElementById('user-list');
            list.innerHTML = '';
            res.data.forEach(user => {
                list.innerHTML += `<div class="user-item" id="user-${user.id}" onclick="selectUser(${user.id}, '${user.name}')">
                    <strong>${user.name}</strong> <br> <small>ID: #${user.id}</small>
                </div>`;
            });
        });
    }

    function selectUser(id, name) {
        currentChatUserId = id;
        document.querySelectorAll('.user-item').forEach(el => el.classList.remove('user-active'));
        document.getElementById('user-' + id).classList.add('user-active');
        document.getElementById('chat-header').innerText = "Đang hỗ trợ: " + name;
        loadMessages();
    }

    function loadMessages() {
        if(!currentChatUserId) return;
        axios.get(`/messages/${currentChatUserId}`).then(res => {
            const body = document.getElementById('admin-chat-body');
            body.innerHTML = '';
            res.data.forEach(m => {
                const div = document.createElement('div');
                div.className = m.is_from_admin ? 'msg-a' : 'msg-u';
                div.innerText = m.message;
                body.appendChild(div);
            });
            body.scrollTop = body.scrollHeight;
        });
    }

    function adminSend() {
        const input = document.getElementById('admin-input');
        if(!currentChatUserId || !input.value.trim()) return;

        axios.post('/messages', {
            user_id: currentChatUserId,
            message: input.value
        }).then(() => {
            input.value = '';
            loadMessages();
        });
    }

    loadUsers();
    setInterval(() => { if(currentChatUserId) loadMessages(); }, 5000);
</script>
@endsection