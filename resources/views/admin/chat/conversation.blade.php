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
    // ============================================================
    //  1. ग्लोबल वेरिएबल्स (एक बार परिभाषित)
    // ============================================================
    window.csrfToken  = window.csrfToken  || document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    window.userId     = window.userId     || {{ Auth::id() }};
    window.chatUserId = window.chatUserId || {{ $user->id }};

    console.log('🌍 Globals set:', { csrfToken: window.csrfToken, userId: window.userId, chatUserId: window.chatUserId });

    // ============================================================
    //  2. Pusher सेटअप (ग्लोबल)
    // ============================================================
    @if(env('PUSHER_APP_KEY'))
    window.pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': window.csrfToken
            }
        }
    });

    // ---- सब्सक्राइब अपने private चैनल पर ----
    const myChannelName = 'private.chat.' + window.userId;
    window.channel = window.pusher.subscribe(myChannelName);
    console.log('📡 Subscribed to ' + myChannelName);

    // ---- चैट इवेंट्स (जो पहले से काम कर रहे हैं) ----
    window.channel.bind('new-message', function(data) {
        if (data.sender_id == window.chatUserId || data.receiver_id == window.chatUserId) {
            if (data.sender_id == window.chatUserId) {
                appendMessage(data, false);
                markAsRead(data.sender_id);
            } else if (data.receiver_id == window.chatUserId) {
                updateMessageStatus(data.id, 'delivered');
            }
        }
    });

    window.channel.bind('message-seen', function(data) {
        if (data.sender_id == window.userId && data.receiver_id == window.chatUserId) {
            updateMessageStatus(data.message_id, 'seen');
        }
    });

    // ---- सब्सक्रिप्शन स्टेटस ----
    window.channel.bind('pusher:subscription_succeeded', function() {
        console.log('✅✅✅ Subscribed to ' + myChannelName + ' ✅✅✅');
    });
    window.channel.bind('pusher:subscription_error', function(err) {
        console.error('❌❌❌ Subscription error:', err);
    });

    // ---- Pusher कनेक्शन स्टेटस ----
    window.pusher.connection.bind('connected', function() {
        console.log('✅ Pusher connected!');
    });
    window.pusher.connection.bind('disconnected', function() {
        console.log('⚠️ Pusher disconnected');
    });
    window.pusher.connection.bind('error', function(err) {
        console.error('❌ Pusher error:', err);
    });

    @endif

    // ============================================================
    //  3. चैट फंक्शन्स (appendMessage, updateMessageStatus, markAsRead)
    // ============================================================
    function appendMessage(data, isMine) {
        // ... (वही कोड जो पहले था – यहाँ स्पेस बचाने के लिए नहीं लिख रहे, पर आपके पास है)
        // सुनिश्चित करें कि इसमें window.csrfToken का इस्तेमाल हो।
    }

    function updateMessageStatus(messageId, status) {
        // ... (वही कोड)
    }

    function markAsRead(senderId) {
        $.ajax({
            url: '{{ route("admin.chats.mark-read") }}',
            method: 'POST',
            data: { user_id: senderId, _token: window.csrfToken },
            error: function(xhr) { console.log('Error marking read:', xhr); }
        });
    }

    // ============================================================
    //  4. फाइल अटैचमेंट प्रीव्यू + मैसेज सबमिट (आपका मौजूदा कोड)
    // ============================================================
    // ... (आपका मौजूदा code for file upload and message send)
    // बस यह ध्यान दें कि सभी जगह window.csrfToken का उपयोग हो।

    // ============================================================
    //  5. ऑनलाइन स्टेटस अपडेट
    // ============================================================
    function updateOnlineStatus() {
        $.get('{{ route("admin.chats.online-status") }}', { user_id: window.chatUserId }, function(data) {
            // ... (आपका मौजूदा कोड)
        });
    }
    updateOnlineStatus();
    setInterval(updateOnlineStatus, 30000);

    $(document).ready(function() {
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });

    // ============================================================
    //  6. call.js को डायनामिक रूप से लोड करें (सुनिश्चित करें कि यह अंत में आए)
    // ============================================================
    // पहले से मौजूद call.js को हटा दें (यदि कोई हो) और नया लोड करें
    document.querySelectorAll('script[src*="call.js"]').forEach(el => el.remove());
    const callScript = document.createElement('script');
    callScript.src = "{{ asset('admin/assets/js/call.js') }}?v=" + Date.now(); // cache bust
    callScript.onload = function() {
        console.log('📞 call.js loaded successfully');
    };
    callScript.onerror = function() {
        console.error('❌ Failed to load call.js');
    };
    document.head.appendChild(callScript);

</script>
@endpush