// ============================================================
//                      CALL.JS (EVENTS FIXED)
// ============================================================

console.log('📞 call.js loaded - EVENTS FIXED');

// ---------- VARIABLES ----------
let localStream = null;
let remoteStream = null;
let peerConnection = null;
let isCallActive = false;
let callStartTime = null;
let callDurationInterval = null;
let ringtone = null;
let isRinging = false;
let callTimeout = null;
let pendingIceCandidates = [];

// ---------- STUN/TURN CONFIG ----------
const configuration = {
    iceServers: [
        { urls: 'stun:stun.l.google.com:19302' },
        { urls: 'stun:stun1.l.google.com:19302' },
        { urls: 'stun:stun2.l.google.com:19302' },
        {
            urls: 'turn:openrelay.metered.ca:80',
            username: 'openrelayproject',
            credential: 'openrelayproject'
        },
        {
            urls: 'turn:openrelay.metered.ca:443',
            username: 'openrelayproject',
            credential: 'openrelayproject'
        }
    ],
    iceCandidatePoolSize: 10
};

// ---------- RINGTONE ----------
function playRingtone() {
    if (isRinging) return;
    try {
        if (!ringtone) {
            ringtone = new Audio('/sounds/ring.mp3');
            ringtone.loop = true;
            ringtone.volume = 0.5;
        }
        ringtone.play().catch(e => console.warn('Ringtone play error:', e));
        isRinging = true;
        console.log('🔔 Ringtone started');
    } catch (e) {
        console.warn('Ringtone error:', e);
    }
}

function stopRingtone() {
    if (!isRinging) return;
    if (ringtone) {
        ringtone.pause();
        ringtone.currentTime = 0;
        isRinging = false;
        console.log('🔕 Ringtone stopped');
    }
}

// ---------- MEDIA FUNCTIONS ----------
async function getMedia(includeVideo = true) {
    const constraints = {
        audio: {
            echoCancellation: true,
            noiseSuppression: true,
            autoGainControl: true
        },
        video: includeVideo ? {
            width: { ideal: 640 },
            height: { ideal: 480 },
            frameRate: { ideal: 30 }
        } : false
    };
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        console.log('📷 Media stream obtained', stream.getTracks().map(t => t.kind));
        return stream;
    } catch (error) {
        console.error('❌ Media error:', error);
        alert('Camera/Microphone access denied. Please allow permissions.');
        throw error;
    }
}

// ---------- CREATE PEER CONNECTION ----------
function createPeerConnection(targetId, isCaller = true) {
    const pc = new RTCPeerConnection(configuration);
    console.log(`🔄 PeerConnection created (${isCaller ? 'caller' : 'receiver'})`);

    if (localStream) {
        localStream.getTracks().forEach(track => {
            pc.addTrack(track, localStream);
            console.log(`➕ Added ${track.kind} track`);
        });
    }

    pc.ontrack = (event) => {
        console.log('📥 Remote track received:', event.track.kind);
        if (!remoteStream) {
            remoteStream = new MediaStream();
        }
        remoteStream.addTrack(event.track);
        displayRemoteStream();
    };

    pc.onicecandidate = (event) => {
        if (event.candidate) {
            console.log('🧊 ICE candidate:', event.candidate.candidate.substring(0, 50) + '...');
            $.ajax({
                url: '/admin/calls/ice',
                method: 'POST',
                data: {
                    target_id: targetId,
                    candidate: JSON.stringify(event.candidate),
                    _token: csrfToken
                }
            });
        } else {
            console.log('✅ ICE gathering complete');
        }
    };

    pc.onconnectionstatechange = () => {
        console.log('🔗 Connection state:', pc.connectionState);
        if (pc.connectionState === 'connected') {
            console.log('✅ Call connected!');
            stopRingtone();
            if (callTimeout) clearTimeout(callTimeout);
        } else if (pc.connectionState === 'failed' || pc.connectionState === 'disconnected') {
            console.log('❌ Connection lost');
            stopRingtone();
            endCall(targetId);
        }
    };

    // Add pending ICE candidates only if remote description is set
    if (pendingIceCandidates.length > 0 && pc.remoteDescription) {
        console.log(`📦 Adding ${pendingIceCandidates.length} pending ICE candidates`);
        pendingIceCandidates.forEach(candidate => {
            pc.addIceCandidate(new RTCIceCandidate(candidate))
                .then(() => console.log('✅ Pending ICE added'))
                .catch(e => console.error('❌ Failed to add pending ICE:', e));
        });
        pendingIceCandidates = [];
    } else if (pendingIceCandidates.length > 0) {
        console.log('📦 Pending ICE candidates will be added when remote description is set');
    }

    return pc;
}

// ---------- DISPLAY REMOTE STREAM ----------
function displayRemoteStream() {
    let remoteVideo = document.getElementById('remote-video');
    if (!remoteVideo) {
        remoteVideo = document.createElement('video');
        remoteVideo.id = 'remote-video';
        remoteVideo.autoplay = true;
        remoteVideo.playsInline = true;
        remoteVideo.style.width = '100%';
        remoteVideo.style.maxHeight = '300px';
        remoteVideo.style.background = '#000';
        remoteVideo.style.borderRadius = '8px';
        const chatBox = document.getElementById('chat-box');
        if (chatBox) {
            chatBox.prepend(remoteVideo);
        } else {
            document.body.prepend(remoteVideo);
        }
        console.log('🖥️ Remote video element created');
    }
    remoteVideo.srcObject = remoteStream;
    remoteVideo.muted = false;
    remoteVideo.volume = 1.0;
    remoteVideo.play().catch(e => console.warn('Remote video autoplay failed:', e));
}

// ---------- SHOW LOCAL PREVIEW ----------
function showLocalPreview() {
    let localVideo = document.getElementById('local-video');
    if (!localVideo) {
        localVideo = document.createElement('video');
        localVideo.id = 'local-video';
        localVideo.autoplay = true;
        localVideo.muted = true;
        localVideo.playsInline = true;
        localVideo.style.width = '150px';
        localVideo.style.position = 'fixed';
        localVideo.style.bottom = '20px';
        localVideo.style.right = '20px';
        localVideo.style.zIndex = '9999';
        localVideo.style.borderRadius = '8px';
        localVideo.style.border = '2px solid white';
        document.body.appendChild(localVideo);
        console.log('🖥️ Local video element created');
    }
    localVideo.srcObject = localStream;
    localVideo.play().catch(e => console.warn('Local video autoplay failed:', e));
}

// ---------- START CALL (Caller) ----------
async function startCall(receiverId, callType = 'video') {
    if (isCallActive) {
        console.warn('⚠️ Call already active');
        return;
    }
    console.log(`📞 Starting ${callType} call to User ${receiverId}`);

    try {
        const includeVideo = callType === 'video';
        localStream = await getMedia(includeVideo);
        showLocalPreview();
        playRingtone();

        peerConnection = createPeerConnection(receiverId, true);
        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        console.log('📤 Sending offer');

        $.ajax({
            url: '/admin/calls/offer',
            method: 'POST',
            data: {
                receiver_id: receiverId,
                offer: JSON.stringify(offer),
                call_type: callType,
                _token: csrfToken
            },
            success: function () {
                console.log('✅ Offer sent successfully');
            },
            error: function (xhr) {
                console.error('❌ Failed to send offer:', xhr);
                alert('Failed to initiate call. Please try again.');
                stopRingtone();
                endCall(receiverId);
            }
        });

        isCallActive = true;
        callStartTime = Date.now();
        callDurationInterval = setInterval(updateCallDuration, 1000);
        $('#end-call-btn').show();

        callTimeout = setTimeout(() => {
            if (isCallActive) {
                console.log('⏰ Call timeout – no answer');
                alert('No answer. Call ended.');
                stopRingtone();
                endCall(receiverId);
            }
        }, 30000);

    } catch (error) {
        console.error('❌ startCall error:', error);
        alert('Error starting call. Please check camera/mic permissions.');
        stopRingtone();
    }
}

// ---------- ANSWER CALL (Receiver) ----------
async function answerCall(callerId, offerSdp) {
    if (isCallActive) {
        console.warn('⚠️ Call already active');
        return;
    }
    console.log(`📞 Answering call from User ${callerId}`);
    stopRingtone();

    try {
        const includeVideo = offerSdp.sdp.includes('video');
        localStream = await getMedia(includeVideo);
        showLocalPreview();

        peerConnection = createPeerConnection(callerId, false);
        const offer = new RTCSessionDescription(offerSdp);
        await peerConnection.setRemoteDescription(offer);
        console.log('📥 Remote description set');

        // After remote description is set, add any pending ICE candidates
        if (pendingIceCandidates.length > 0) {
            console.log(`📦 Adding ${pendingIceCandidates.length} pending ICE candidates after remote description`);
            pendingIceCandidates.forEach(candidate => {
                peerConnection.addIceCandidate(new RTCIceCandidate(candidate))
                    .then(() => console.log('✅ Pending ICE added'))
                    .catch(e => console.error('❌ Failed to add pending ICE:', e));
            });
            pendingIceCandidates = [];
        }

        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        console.log('📤 Sending answer');

        $.ajax({
            url: '/admin/calls/answer',
            method: 'POST',
            data: {
                caller_id: callerId,
                answer: JSON.stringify(answer),
                _token: csrfToken
            },
            success: function () {
                console.log('✅ Answer sent successfully');
                stopRingtone();
            },
            error: function (xhr) {
                console.error('❌ Failed to send answer:', xhr);
                alert('Failed to answer call.');
                stopRingtone();
                endCall(callerId);
            }
        });

        isCallActive = true;
        callStartTime = Date.now();
        callDurationInterval = setInterval(updateCallDuration, 1000);
        $('#end-call-btn').show();
        if (callTimeout) clearTimeout(callTimeout);

    } catch (error) {
        console.error('❌ answerCall error:', error);
        alert('Error answering call. Please check camera/mic permissions.');
        stopRingtone();
    }
}

// ---------- END CALL ----------
function endCall(receiverId) {
    if (!isCallActive) {
        console.log('Call already ended');
        return;
    }
    console.log(`📞 Ending call with User ${receiverId}`);
    stopRingtone();

    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
        localStream = null;
    }
    if (remoteStream) {
        remoteStream.getTracks().forEach(track => track.stop());
        remoteStream = null;
    }
    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
        console.log('🔌 PeerConnection closed');
    }

    document.getElementById('local-video')?.remove();
    document.getElementById('remote-video')?.remove();

    clearInterval(callDurationInterval);
    if (callTimeout) clearTimeout(callTimeout);
    isCallActive = false;
    pendingIceCandidates = [];
    $('#end-call-btn').hide();

    const duration = Math.floor((Date.now() - callStartTime) / 1000);
    console.log(`⏱️ Call duration: ${duration} seconds`);

    $.ajax({
        url: '/admin/calls/end',
        method: 'POST',
        data: {
            receiver_id: receiverId,
            duration_seconds: duration,
            _token: csrfToken
        },
        success: function () { console.log('✅ Call logged successfully'); },
        error: function (xhr) { console.error('❌ Failed to log call:', xhr); }
    });
}

// ---------- UPDATE CALL DURATION ----------
function updateCallDuration() {
    if (callStartTime) {
        const seconds = Math.floor((Date.now() - callStartTime) / 1000);
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        const durationEl = document.getElementById('call-duration');
        if (durationEl) {
            durationEl.textContent = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }
    }
}

// ============================================================
//   SHOW INCOMING CALL MODAL
// ============================================================
function showIncomingModal(callerId, callType, offerData) {
    console.log('📞 showIncomingModal called with:', { callerId, callType });
    $('#incoming-call-modal').remove();

    const modalHtml = `
        <div id="incoming-call-modal" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:99999; display:flex; align-items:center; justify-content:center;">
            <div style="background:#fff; padding:40px; border-radius:16px; text-align:center; max-width:400px; width:90%; box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
                <i class="fa fa-user-circle fa-5x" style="font-size:80px; color:#28a745;"></i>
                <h3 class="mt-3" style="font-weight:600;">Incoming ${callType.charAt(0).toUpperCase() + callType.slice(1)} Call</h3>
                <p class="text-muted" style="font-size:1.2rem;">From: <strong>User ${callerId}</strong></p>
                <div class="mt-4">
                    <button id="accept-call-btn" class="btn btn-success btn-lg rounded-circle mr-3" style="width:70px; height:70px; border-radius:50%;">
                        <i class="fa fa-phone" style="font-size:28px;"></i>
                    </button>
                    <button id="reject-call-btn" class="btn btn-danger btn-lg rounded-circle" style="width:70px; height:70px; border-radius:50%;">
                        <i class="fa fa-phone-slash" style="font-size:28px;"></i>
                    </button>
                </div>
                <p style="margin-top:20px; font-size:0.9rem; color:#999;">Ringtone playing...</p>
            </div>
        </div>
    `;
    $('body').append(modalHtml);

    const modal = $('#incoming-call-modal');
    modal.data('offer', offerData);
    modal.data('callerId', callerId);
    modal.data('callType', callType);

    playRingtone();

    // Accept button
    $('#accept-call-btn').on('click', function () {
        console.log('✅ Accept button clicked');
        stopRingtone();
        const storedOffer = modal.data('offer');
        const storedCallerId = modal.data('callerId');
        modal.remove();

        if (!storedOffer) {
            console.error('❌ Offer data missing!');
            alert('Error: Call offer data missing.');
            return;
        }

        try {
            const offer = JSON.parse(storedOffer);
            console.log('📤 Parsed offer, answering...');
            answerCall(storedCallerId, offer);
        } catch (e) {
            console.error('❌ Failed to parse offer:', e);
            alert('Error parsing call offer.');
        }
    });

    // Reject button
    $('#reject-call-btn').on('click', function () {
        console.log('❌ Reject button clicked');
        const storedCallerId = modal.data('callerId');
        modal.remove();
        stopRingtone();

        if (storedCallerId) {
            $.ajax({
                url: '/admin/calls/end',
                method: 'POST',
                data: {
                    receiver_id: storedCallerId,
                    duration_seconds: 0,
                    _token: csrfToken
                },
                success: function () { console.log('✅ Rejection logged'); }
            });
        }
    });
}

// ============================================================
//   PUSHER EVENT BINDINGS (FIXED CONDITIONS)
// ============================================================
function bindCallEvents() {
    console.log('🔍 bindCallEvents called...');

    if (typeof channel === 'undefined') {
        console.warn('⚠️ Pusher channel not defined. Retrying in 1s...');
        setTimeout(bindCallEvents, 1000);
        return;
    }

    console.log('✅ Pusher channel found:', channel);

    // ---- Call Offer ----
    channel.bind('call-offer', function (data) {
        console.log('📨📨📨 CALL OFFER RECEIVED!', data);
        if (data.receiver_id != userId) {
            console.log(`⏭️ Ignoring - not for me (target: ${data.receiver_id}, me: ${userId})`);
            return;
        }
        if (isCallActive) {
            console.log('⏭️ Already in a call, ignoring');
            return;
        }
        showIncomingModal(data.caller_id, data.call_type, data.offer);
    });

    // ---- Call Answer (FIXED: check caller_id) ----
    channel.bind('call-answer', function (data) {
        console.log('📨📨📨 CALL ANSWER RECEIVED!', data);
        // The answer is meant for the caller, so check if data.caller_id matches me
        if (data.caller_id != userId) {
            console.log(`⏭️ Ignoring answer - not for me (caller: ${data.caller_id}, me: ${userId})`);
            return;
        }
        if (peerConnection && isCallActive) {
            try {
                const answer = JSON.parse(data.answer);
                peerConnection.setRemoteDescription(new RTCSessionDescription(answer))
                    .then(() => {
                        console.log('✅ Remote description set from answer');
                        stopRingtone();
                        if (callTimeout) clearTimeout(callTimeout);
                    })
                    .catch(e => console.error('❌ Failed to set remote description:', e));
            } catch (e) {
                console.error('❌ Failed to parse answer:', e);
            }
        } else {
            console.warn('⚠️ No active peerConnection to handle answer');
        }
    });

    // ---- Call ICE ----
    channel.bind('call-ice', function (data) {
        console.log('🧊 ICE candidate received:', data);
        if (data.target_id != userId) {
            console.log(`⏭️ Ignoring ICE not for me (target: ${data.target_id}, me: ${userId})`);
            return;
        }
        try {
            const candidate = JSON.parse(data.candidate);
            if (peerConnection && isCallActive) {
                // Check if remote description is set before adding
                if (peerConnection.remoteDescription) {
                    peerConnection.addIceCandidate(new RTCIceCandidate(candidate))
                        .then(() => console.log('✅ ICE candidate added'))
                        .catch(e => console.error('❌ Failed to add ICE candidate:', e));
                } else {
                    console.log('📦 ICE candidate queued (remote description not set yet)');
                    pendingIceCandidates.push(candidate);
                }
            } else {
                console.log('📦 ICE candidate queued (peerConnection not ready)');
                pendingIceCandidates.push(candidate);
            }
        } catch (e) {
            console.error('❌ Invalid ICE candidate:', e);
        }
    });

    // ---- Call End ----
    channel.bind('call-end', function (data) {
        console.log('📨📨📨 CALL END RECEIVED!', data);
        // The end event is sent to the receiver, so check if receiver_id matches me
        if (data.receiver_id != userId) {
            console.log(`⏭️ Ignoring end - not for me (receiver: ${data.receiver_id}, me: ${userId})`);
            return;
        }
        if (isCallActive) {
            console.log('📞 Remote user ended the call');
            stopRingtone();
            endCall(data.sender_id);
        }
    });

    // ---- Subscription Success ----
    channel.bind('pusher:subscription_succeeded', function () {
        console.log('✅✅✅ Subscribed to private.chat.' + userId + ' ✅✅✅');
    });

    channel.bind('pusher:subscription_error', function (err) {
        console.error('❌❌❌ Subscription error:', err);
    });

    console.log('✅ All call events bound!');
}

// ---------- UI BUTTON BINDINGS ----------
$(document).on('click', '#audio-call-btn', function () {
    console.log('🔊 Audio call button clicked');
    if (typeof chatUserId === 'undefined') {
        alert('User ID not found. Please refresh.');
        return;
    }
    startCall(chatUserId, 'audio');
});

$(document).on('click', '#video-call-btn', function () {
    console.log('📹 Video call button clicked');
    if (typeof chatUserId === 'undefined') {
        alert('User ID not found. Please refresh.');
        return;
    }
    startCall(chatUserId, 'video');
});

$(document).on('click', '#end-call-btn', function () {
    console.log('🔴 End call button clicked');
    if (typeof chatUserId === 'undefined') {
        alert('User ID not found.');
        return;
    }
    stopRingtone();
    endCall(chatUserId);
});

// ---------- INITIALIZE ----------
$(document).ready(function () {
    console.log('🚀 call.js initialized - EVENTS FIXED');

    if (typeof pusher !== 'undefined') {
        pusher.connection.bind('connected', function () {
            console.log('✅ Pusher connected!');
        });
        pusher.connection.bind('disconnected', function () {
            console.log('⚠️ Pusher disconnected');
        });
        pusher.connection.bind('error', function (err) {
            console.error('❌ Pusher error:', err);
        });
    }

    setTimeout(bindCallEvents, 500);
    $('#end-call-btn').hide();
});