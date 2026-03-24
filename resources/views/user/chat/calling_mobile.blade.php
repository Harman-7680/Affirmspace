@php
    $callId = request('call_id');
    $roomName = request('room_name');
    $jwt = request('jwt');
    $senderId = request('sender_id');
    $receiverId = request('receiver_id');
    $senderName = request('sender_name');
    $currentUserId = request('sender_id');
@endphp

<!DOCTYPE html>
<html>

<head>
    <title>Calling...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>

<body>

    <style>
        .ringing-screen {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }

        .ring-circle {
            position: relative;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .ring-circle::before,
        .ring-circle::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.4);
            animation: ripple 1.6s infinite;
        }

        .ring-circle::after {
            animation-delay: .8s;
        }

        @keyframes ripple {
            0% {
                transform: scale(0.7);
                opacity: 1;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .ring-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #fff;
            color: #ff416c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            animation: bounce 1.4s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .ringing-text {
            font-size: 55px;
            font-weight: 600;
            letter-spacing: 1px;
            animation: fade 1.2s infinite;
        }

        @keyframes fade {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .ring-sub {
            margin-top: 6px;
            font-size: 44px;
            opacity: 0.85;
        }
    </style>

    {{-- CALL BUTTON (sirf sender ko dikhega) --}}
    @if ($currentUserId == $senderId)
        <div class="ringing-screen">
            <div class="ring-circle">
                <div class="ring-icon">
                    📞
                </div>
            </div>

            {{-- <div class="ringing-text">Ringing…</div>
            <div class="ring-sub">Waiting for answer</div> --}}
        </div>
        {{-- <button id="startCall" style="padding:12px 25px;font-size:18px;">
            Call User
        </button> --}}
    @endif

    {{-- INCOMING CALL POPUP (receiver ke liye) --}}
    <div id="call-popup"
        style="display:none;
     position:fixed;
     top:50%;left:50%;
     transform:translate(-50%,-50%);
     width:350px;
     background:#fff;
     padding:20px;
     text-align:center;
     border-radius:10px;
     z-index:9999;
     box-shadow:0 5px 20px rgba(0,0,0,.3);">

        <h3>Incoming Call</h3>
        <p id="caller-name"></p>

        <button id="acceptCall" style="padding:10px 20px;background:green;color:#fff;">
            Accept
        </button>

        <button id="rejectCall" style="padding:10px 20px;background:red;color:#fff;">
            Reject
        </button>
    </div>

    {{-- JITSI MODAL --}}
    <div id="jitsi-modal"
        style="display:none;
     position:fixed;
     top:0;left:0;
     width:100%;height:100%;
     background:#000;
     z-index:9999;">

        <div id="jitsi-container" style="width:100%;height:100%;"></div>

        <button id="endCall"
            style="position:absolute;top:10px;right:10px;
        padding:8px 15px;background:red;color:#fff;">
            End Call
        </button>
    </div>

    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-database-compat.js"></script>
    <script src='https://8x8.vc/vpaas-magic-cookie-3b7aa2c587234976b65a4c61a71fca76/external_api.js' async></script>

    <script>
        /* ================= VARIABLES ================= */
        const callId = @json($callId);
        const roomName = @json($roomName);
        const jwt = @json($jwt);
        const senderId = @json($senderId);
        const receiverId = @json($receiverId);
        const currentUserId = @json($currentUserId);
        const senderName = @json($senderName);

        let currentCallId = null;
        let jitsiApi = null;

        /* ================= FIREBASE INIT ================= */
        firebase.initializeApp({
            apiKey: "AIzaSyA1ViQLOdWW9q7lEP45HuUdEnchTvY79m4",
            authDomain: "videocall-87dab.firebaseapp.com",
            databaseURL: "https://videocall-87dab-default-rtdb.firebaseio.com",
            projectId: "videocall-87dab",
            storageBucket: "videocall-87dab.firebasestorage.app",
            messagingSenderId: "733035921265",
            appId: "1:733035921265:web:0f2a5bd302701601b780d0",
            measurementId: "G-K9CSQY900B"
        });

        const db = firebase.database();

        /* ================= JITSI OPEN ================= */
        function openJitsi(name) {
            document.getElementById('jitsi-modal').style.display = 'block';

            jitsiApi = new JitsiMeetExternalAPI("8x8.vc", {
                roomName: roomName,
                parentNode: document.getElementById('jitsi-container'),
                jwt: jwt,
                userInfo: {
                    displayName: senderName
                },
                configOverwrite: {
                    prejoinPageEnabled: false,
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
                    disableDeepLinking: true
                },
                interfaceConfigOverwrite: {
                    DISABLE_JOIN_LEAVE_NOTIFICATIONS: true
                }
            });
        }

        /* ================= SENDER: CALL BUTTON ================= */
        window.onload = function() {
            if (!callId || !senderId || !receiverId) {
                console.error('Missing call params');
                return;
            }

            currentCallId = callId;

            db.ref('calls/active/' + callId).set({
                senderId: senderId,
                senderName: senderName,
                receiverId: receiverId,
                status: 'calling',
                roomName: roomName,
                createdAt: Date.now()
            });

            console.log('Call initiated');

            // API call to send notification
            // fetch('/app/send-call-notification', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'Accept': 'application/json'
            //         },
            //         body: JSON.stringify({
            //             sender_id: senderId,
            //             sender_name: senderName,
            //             receiver_id: receiverId,
            //             room_name: roomName
            //         })
            //     })
            //     .then(res => res.json())
            //     .then(data => console.log('Notification:', data.message))
            //     .catch(err => console.error('Notification Error:', err));
        };


        /* ================= RECEIVER LISTENER ================= */
        db.ref('calls/active')
            .orderByChild('receiverId')
            .equalTo(currentUserId)
            .on('child_added', snap => {

                const call = snap.val();
                currentCallId = snap.key;

                document.getElementById('caller-name').innerText =
                    call.senderName + " is calling you";

                document.getElementById('call-popup').style.display = 'block';
            });

        /* ================= ACCEPT CALL ================= */
        document.getElementById('acceptCall').onclick = function() {
            db.ref('calls/active/' + currentCallId).update({
                status: 'accepted'
            });

            document.getElementById('call-popup').style.display = 'none';
            openJitsi(senderName);
        };

        /* ================= REJECT CALL ================= */
        document.getElementById('rejectCall').onclick = function() {
            db.ref('calls/active/' + currentCallId).remove();
            document.getElementById('call-popup').style.display = 'none';
        };

        /* ================= STATUS LISTENER ================= */
        db.ref('calls/active').on('child_changed', snap => {
            const call = snap.val();

            if (call.senderId == currentUserId && call.status === 'accepted') {
                openJitsi(senderName);
            }

            if (call.status === 'ended') {
                location.reload();
            }
        });

        /* ================= END CALL ================= */
        document.getElementById('endCall').onclick = function() {
            db.ref('calls/active/' + currentCallId).update({
                status: 'ended'
            });
        };
    </script>
</body>

</html>
