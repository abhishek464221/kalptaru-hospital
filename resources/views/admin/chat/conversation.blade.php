@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Chat with {{ $user->name }}</h4>
                <a href="{{ route('admin.chats.index') }}" class="btn btn-secondary mb-3">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('uploads/users/'.$user->image) }}" alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                            <div class="ml-2">
                                <h5 class="mb-0">{{ $user->name }}</h5>
                                <small class="text-muted" id="user-status">
                                    <span id="status-dot" class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #6c757d;"></span>
                                    <span id="status-text">Offline</span>
                                    <span id="last-seen-text" class="text-muted"></span>
                                </small>
                            </div>
                            {{-- === CALL BUTTONS === --}}
                            <div class="ml-auto">
                                <button id="audio-call-btn" class="btn btn-success btn-sm mr-1" title="Audio Call">
                                    <i class="fa fa-phone"></i>
                                </button>
                                <button id="video-call-btn" class="btn btn-info btn-sm mr-1" title="Video Call">
                                    <i class="fa fa-video-camera"></i>
                                </button>
                                <a href="{{ route('admin.calls.history') }}" class="btn btn-secondary btn-sm" title="Call History">
                                    <i class="fa fa-history"></i>
                                </a>
                            </div>
                            {{-- === END CALL BUTTONS === --}}
                        </div>
                    </div>
                    <div class="card-body chat-box" id="chat-box" style="height: 400px; overflow-y: auto;">
                        @forelse($messages as $message)
                            <div class="message {{ $message->sender_id == Auth::id() ? 'message-right' : 'message-left' }} mb-3" data-message-id="{{ $message->id }}">
                                <div class="d-flex {{ $message->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="message-content p-2 rounded {{ $message->sender_id == Auth::id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 70%;">
                                        
                                        @if($message->message)
                                            <div>{{ $message->message }}</div>
                                        @endif

                                        @if($message->attachment && is_array($message->attachment))
                                            <div class="mt-2">
                                                @foreach($message->attachment as $index => $path)
                                                    @php
                                                        $url = asset('storage/' . $path);
                                                        $mime = $message->attachment_type[$index] ?? '';
                                                    @endphp
                                                    <div class="attachment-item mb-1">
                                                        @if(str_starts_with($mime, 'image/'))
                                                            <img src="{{ $url }}" alt="Image" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                                                        @elseif(str_starts_with($mime, 'video/'))
                                                            <video controls style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                                                                <source src="{{ $url }}" type="{{ $mime }}">
                                                            </video>
                                                        @else
                                                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fa fa-file"></i> Download File
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <br>
                                        <small class="{{ $message->sender_id == Auth::id() ? 'text-white-50' : 'text-muted' }}">
                                            {{ $message->created_at->format('h:i A') }}
                                            @if($message->sender_id == Auth::id())
                                                @if($message->status == 'seen')
                                                    <i class="fa fa-check-double text-primary"></i>
                                                @elseif($message->status == 'delivered')
                                                    <i class="fa fa-check-double text-muted"></i>
                                                @else
                                                    <i class="fa fa-check text-muted"></i>
                                                @endif
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="fa fa-comment-o fa-2x"></i>
                                <p class="mt-2">No messages yet. Start the conversation!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Footer – Message Form with multiple file input --}}
                    <div class="card-footer">
                        <form id="message-form" class="d-flex flex-column">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                            <div class="d-flex align-items-center w-100">
                                <input type="text" name="message" class="form-control" placeholder="Type your message..." id="message-input" style="flex:1;">
                                
                                {{-- file upload button --}}
                                <label for="file-input" class="file-upload-btn position-relative">
                                    <i class="fa fa-paperclip upload-icon" style="font-size: 20px; line-height: 1; color: #495057;"></i>
                                    <span class="file-count-badge" id="file-count" style="position: absolute; top: -6px; right: -6px; background: #dc3545; color: #fff; border-radius: 50%; font-size: 10px; padding: 2px 5px; min-width: 18px; text-align: center;">0</span>
                                </label>
                                <input type="file" name="attachments[]" id="file-input" style="display: none;" multiple>
                                
                                <button type="submit" class="btn btn-primary ml-2">
                                    <i class="fa fa-send"></i> Send
                                </button>

                                {{-- === END CALL BUTTON === --}}
                                <button type="button" id="end-call-btn" class="btn btn-danger ml-2" style="display:none;">
                                    <i class="fa fa-phone"></i> End Call <span id="call-duration">0:00</span>
                                </button>
                            </div>
                            {{-- Preview area for selected files --}}
                            <div id="file-preview-container" class="mt-2 d-flex flex-wrap"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ---------- Pusher ----------
    @if(env('PUSHER_APP_KEY'))
    const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: { headers: { 'X-CSRF-TOKEN': csrfToken } }
    });
    const userId = {{ Auth::id() }};
    const chatUserId = {{ $user->id }};
    const channel = pusher.subscribe('private.chat.' + userId);
    channel.bind('new-message', function(data) {
        if (data.sender_id == chatUserId || data.receiver_id == chatUserId) {
            if (data.sender_id == chatUserId) {
                appendMessage(data, false);
                markAsRead(data.sender_id);
            } else if (data.receiver_id == chatUserId) {
                updateMessageStatus(data.id, 'delivered');
            }
        }
    });
    channel.bind('message-seen', function(data) {
        if (data.sender_id == userId && data.receiver_id == chatUserId) {
            updateMessageStatus(data.message_id, 'seen');
        }
    });
    @endif

    // ---------- Chat Functions ----------
    function appendMessage(data, isMine) {
        const chatBox = $('#chat-box');
        let attachmentHtml = '';
        if (data.attachment && Array.isArray(data.attachment) && data.attachment.length > 0) {
            attachmentHtml = '<div class="mt-2">';
            data.attachment.forEach((path, idx) => {
                const url = '{{ asset("storage") }}/' + path;
                const mime = data.attachment_type[idx] || '';
                if (mime.startsWith('image/')) {
                    attachmentHtml += `<div class="attachment-item mb-1"><img src="${url}" style="max-width:100%; max-height:200px; border-radius:8px;"></div>`;
                } else if (mime.startsWith('video/')) {
                    attachmentHtml += `<div class="attachment-item mb-1"><video controls style="max-width:100%; max-height:200px; border-radius:8px;"><source src="${url}" type="${mime}"></video></div>`;
                } else {
                    attachmentHtml += `<div class="attachment-item mb-1"><a href="${url}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa fa-file"></i> Download File</a></div>`;
                }
            });
            attachmentHtml += '</div>';
        }
        const messageHtml = `
            <div class="message ${isMine ? 'message-right' : 'message-left'} mb-3" data-message-id="${data.id}">
                <div class="d-flex ${isMine ? 'justify-content-end' : 'justify-content-start'}">
                    <div class="message-content p-2 rounded ${isMine ? 'bg-primary text-white' : 'bg-light'}" style="max-width: 70%;">
                        ${data.message ? '<div>' + data.message + '</div>' : ''}
                        ${attachmentHtml}
                        <br>
                        <small class="${isMine ? 'text-white-50' : 'text-muted'}">
                            ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            ${isMine ? '<i class="fa fa-check text-muted"></i>' : ''}
                        </small>
                    </div>
                </div>
            </div>
        `;
        chatBox.append(messageHtml);
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    function updateMessageStatus(messageId, status) {
        let icon = '';
        if (status == 'seen') icon = '<i class="fa fa-check-double text-primary"></i>';
        else if (status == 'delivered') icon = '<i class="fa fa-check-double text-muted"></i>';
        else icon = '<i class="fa fa-check text-muted"></i>';
        const messageEl = $('.message[data-message-id="' + messageId + '"]');
        if (messageEl.length) {
            const smallEl = messageEl.find('.message-content small');
            smallEl.html(function() {
                return $(this).html().replace(/<i class="fa[^>]*><\/i>/, icon);
            });
        }
    }

    function markAsRead(senderId) {
        $.ajax({
            url: '{{ route("admin.chats.mark-read") }}',
            method: 'POST',
            data: { user_id: senderId, _token: csrfToken },
            error: function(xhr) { console.log('Error marking read:', xhr); }
        });
    }

    // ---------- Multiple file preview ----------
    let selectedFiles = [];

    function renderPreviews() {
        const container = $('#file-preview-container');
        container.empty();
        if (selectedFiles.length === 0) {
            $('#file-count').text('0');
            return;
        }
        $('#file-count').text(selectedFiles.length);
        selectedFiles.forEach((file, index) => {
            const wrapper = $('<div class="file-preview-wrapper mr-2 mb-2 position-relative" style="display:inline-block;"></div>');
            const removeBtn = $('<button type="button" class="btn btn-danger btn-sm position-absolute" style="top:2px; right:2px; border-radius:50%; line-height:1; padding:0 4px; font-size:14px;">×</button>');
            removeBtn.on('click', function() {
                selectedFiles.splice(index, 1);
                const input = $('#file-input')[0];
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(f => dataTransfer.items.add(f));
                input.files = dataTransfer.files;
                renderPreviews();
            });
            wrapper.append(removeBtn);

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    wrapper.append(`<img src="${e.target.result}" style="height:80px; width:80px; object-fit:cover; border-radius:4px;">`);
                };
                reader.readAsDataURL(file);
            } else {
                wrapper.append(`<div style="height:80px; width:80px; background:#f0f0f0; border-radius:4px; display:flex; align-items:center; justify-content:center; font-size:12px; text-align:center; padding:4px; word-break:break-word;">${file.name}</div>`);
            }
            container.append(wrapper);
        });
    }

    $('#file-input').on('change', function() {
        const files = Array.from(this.files);
        const remaining = 5 - selectedFiles.length;
        if (files.length > remaining) {
            alert('You can select maximum 5 files total.');
            this.value = '';
            return;
        }
        selectedFiles = selectedFiles.concat(files);
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(f => dataTransfer.items.add(f));
        this.files = dataTransfer.files;
        renderPreviews();
        this.value = '';
    });

    $('#message-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const messageInput = form.find('input[name="message"]');
        const receiverId = form.find('input[name="receiver_id"]').val();

        const hasMessage = messageInput.val().trim() !== '';
        const hasFiles = selectedFiles.length > 0;
        if (!hasMessage && !hasFiles) return;

        const formData = new FormData();
        formData.append('receiver_id', receiverId);
        if (hasMessage) formData.append('message', messageInput.val().trim());
        selectedFiles.forEach((file) => {
            formData.append('attachments[]', file);
        });
        formData.append('_token', csrfToken);

        $.ajax({
            url: '{{ route("admin.chats.send") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    appendMessage(response.message, true);
                    messageInput.val('');
                    selectedFiles = [];
                    $('#file-input')[0].files = new DataTransfer().files;
                    renderPreviews();
                }
            },
            error: function(xhr) {
                console.log('Error:', xhr);
                alert('Error sending message. Please try again.');
            }
        });
    });

    // ---------- Online status ----------
    function updateOnlineStatus() {
        $.get('{{ route("admin.chats.online-status") }}', { user_id: chatUserId }, function(data) {
            if (data.online) {
                $('#status-dot').css('background', '#28a745');
                $('#status-text').text('Online');
                $('#last-seen-text').text('');
            } else {
                $('#status-dot').css('background', '#6c757d');
                $('#status-text').text('Offline');
                if (data.last_seen) $('#last-seen-text').text(' (Last seen: ' + data.last_seen + ')');
            }
        }).fail(function() { console.log('Error getting online status'); });
    }
    updateOnlineStatus();
    setInterval(updateOnlineStatus, 30000);

    $(document).ready(function() {
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });

    // ---------- Load Call Logic from external file ----------
    // Path: public/admin/assets/js/call.js
    const callScript = document.createElement('script');
    callScript.src = "{{ asset('admin/assets/js/call.js') }}";
    document.head.appendChild(callScript);

</script>
@endpush