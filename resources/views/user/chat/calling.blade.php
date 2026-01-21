{{-- <button id="startCall" style="padding:10px 20px; font-size:16px;">Call
                                    {{ $receiver->first_name }}</button> --}}

<!-- Receiver Accept/Reject Popup -->
<div id="call-popup"
    style="display:none; width:400px; height:250px; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; border:2px solid #333; padding:20px; z-index:9999; text-align:center; box-shadow:0 8px 20px rgba(0,0,0,0.4); border-radius:12px; margin-top:200px">
    <h2>Incoming Call</h2>
    <p><span id="caller-name" style="font-weight:bold;"></span> is calling you...</p>
    <button id="acceptCall"
        style="padding:10px 25px; margin-right:20px; font-size:16px; background-color:#28a745; color:#fff; border:none; border-radius:8px; cursor:pointer;">Accept</button>
    <button id="rejectCall"
        style="padding:10px 25px; font-size:16px; background-color:#dc3545; color:#fff; border:none; border-radius:8px; cursor:pointer;">Reject</button>
</div>

<!-- Jitsi Video Call Modal -->
<div id="jitsi-modal"
    style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); width:700px; height:500px; z-index:9999; background:#000; border-radius:10px; overflow:hidden; margin-top:300px;">
    <div id="jitsi-container" style="width:100%; height:100%;"></div>
    <button id="endCall"
        style="position:absolute; top:10px; right:10px; z-index:1000; padding:5px 10px; background:#dc3545; color:#fff; border:none; border-radius:5px; cursor:pointer;">End
        Call</button>
</div>

<!-- Firebase & Jitsi -->
<script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-database-compat.js"></script>
<script src='https://8x8.vc/vpaas-magic-cookie-3b7aa2c587234976b65a4c61a71fca76/external_api.js' async></script>

<script>
    const senderId = "{{ $senderId }}";
    const senderName = "{{ auth()->user()->first_name }}";
    const callId = "{{ $callId }}";
    const roomName = "{{ $roomName }}";
    const receiverId = "{{ $receiver->id }}";

    const currentUserId = "{{ auth()->id() }}";
    let jitsiApi = null;
    let currentCallId = null;

    // Initialize Firebase
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

    // --- Open Jitsi ---
    function openJitsiModal(userName) {
        document.getElementById('jitsi-modal').style.display = 'block';

        if (jitsiApi) {
            jitsiApi.dispose();
            jitsiApi = null;
        }

        jitsiApi = new JitsiMeetExternalAPI(
            "8x8.vc", {
                roomName: "{{ $roomName }}",
                parentNode: document.getElementById('jitsi-container'),
                jwt: "{{ $jwt }}",
                userInfo: {
                    displayName: userName
                },
                configOverwrite: {
                    prejoinPageEnabled: false,
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
                    disableDeepLinking: true
                }
            }
        );
    }

    // --- Close Jitsi ---
    function closeJitsi() {
        const modal = document.getElementById("jitsi-modal");
        modal.style.display = 'none';
        if (jitsiApi) {
            jitsiApi.dispose();
            jitsiApi = null;
        }
        // if (currentCallId) {
        //     db.ref('calls/active/' + currentCallId).remove();
        // }
    }

    // --- Sender: Start Call ---
    document.getElementById("startCall").onclick = function() {
        currentCallId = callId;
        openJitsiModal(senderName);

        // Save call to Firebase
        const callData = {
            senderId: senderId,
            senderName: senderName,
            receiverId: receiverId,
            status: 'calling',
            roomName: roomName
        };
        db.ref('calls/active/' + callId).set(callData);
    };

    // --- Receiver Listener ---
    function receiverListener() {
        db.ref('calls/active').on('child_added', snap => {
            const call = snap.val();
            call.callId = snap.key;

            if (call.receiverId == currentUserId && call.status == 'calling') {
                currentCallId = call.callId;
                document.getElementById("caller-name").innerText = call.senderName;
                document.getElementById("call-popup").style.display = 'block';
            }
        });
    }
    receiverListener();

    // --- Receiver Accept ---
    document.getElementById("acceptCall").onclick = function() {
        db.ref('calls/active/' + currentCallId).update({
            status: 'accepted'
        });
        document.getElementById("call-popup").style.display = 'none';
        openJitsiModal("{{ auth()->user()->first_name }}");
    };

    // --- Receiver Reject ---
    document.getElementById("rejectCall").onclick = function() {
        db.ref('calls/active/' + currentCallId).update({
            status: 'rejected'
        });
        document.getElementById("call-popup").style.display = 'none';
    };

    // --- Listen for status changes ---
    db.ref('calls/active').on('child_changed', snap => {
        const call = snap.val();
        if (!call) return;

        // If the logged-in user is sender
        if (call.senderId == currentUserId) {
            if (call.status == 'accepted') {
                console.log("Receiver accepted the call");
            }
            if (call.status == 'rejected') {
                alert("Receiver rejected the call");
                closeJitsi();
            }
            if (call.status == 'ended') {
                closeJitsi();
            }
        }

        // If the logged-in user is receiver
        if (call.receiverId == currentUserId && call.status == 'ended') {
            closeJitsi();
        }
    });

    // --- End Call ---
    document.getElementById("endCall").onclick = function() {
        if (!currentCallId) return;

        db.ref('calls/active/' + currentCallId).update({
            status: 'ended'
        });
    };
</script>
