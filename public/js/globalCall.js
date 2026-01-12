// globalCall.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
import { getDatabase, ref, set, onValue, push, remove } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-database.js";

// ---------- Firebase config ----------
const firebaseConfig = {
    apiKey: "AIzaSyA1ViQLOdWW9q7lEP45HuUdEnchTvY79m4",
    authDomain: "videocall-87dab.firebaseapp.com",
    databaseURL: "https://videocall-87dab-default-rtdb.firebaseio.com",
    projectId: "videocall-87dab",
    storageBucket: "videocall-87dab.firebasestorage.app",
    messagingSenderId: "733035921265",
    appId: "1:733035921265:web:0f2a5bd302701601b780d0",
    measurementId: "G-K9CSQY900B"
};

const app = initializeApp(firebaseConfig);
const db = getDatabase(app);

// ---------- Global variables ----------
const auth = { uid: "{{ auth()->id() }}" }; // Laravel Blade inject
let pc, localStream, currentCallId = null;
let audioEnabled = true, videoEnabled = true;

// ---------- Ringtone ----------
const ringtone = new Audio("https://actions.google.com/sounds/v1/alarms/phone_alerts_and_rings.ogg");
ringtone.loop = true;

// ---------- Incoming call popup ----------
const incomingPopup = document.createElement('div');
incomingPopup.id = 'incomingCallPopup';
incomingPopup.style.cssText = `
    position:fixed; top:-150px; right:20px; width:300px;
    background:#fff; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.3);
    padding:15px; z-index:10000; transition: top 0.5s ease; font-family:Arial,sans-serif;
`;
incomingPopup.innerHTML = `
    <p id="incomingText" style="font-weight:bold;margin-bottom:10px;"></p>
    <button id="acceptCall" style="background:#4CAF50;color:white;margin-right:5px;border:none;padding:5px 10px;border-radius:5px;cursor:pointer;">Accept</button>
    <button id="rejectCall" style="background:#f44336;color:white;border:none;padding:5px 10px;border-radius:5px;cursor:pointer;">Reject</button>
`;
document.body.appendChild(incomingPopup);
const incomingText = document.getElementById('incomingText');
const acceptBtn = document.getElementById('acceptCall');
const rejectBtn = document.getElementById('rejectCall');

// ---------- Fullscreen video popup ----------
const activePopup = document.createElement('div');
activePopup.id = 'activeCallPopup';
activePopup.style.cssText = `
    display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.9); z-index:9999; flex-direction:column;
    justify-content:center; align-items:center;
`;
activePopup.innerHTML = `
    <div style="position:absolute; top:20px; color:white; font-size:20px;">Video Call</div>
    <div style="display:flex; gap:10px; width:80%; max-width:900px;">
        <video id="localVideo" autoplay muted style="width:50%; background:#000;"></video>
        <video id="remoteVideo" autoplay style="width:50%; background:#000;"></video>
    </div>
    <div style="margin-top:15px;">
        <button id="muteBtn">🎤</button>
        <button id="cameraBtn">📷</button>
        <button id="endCallBtn">⛔</button>
    </div>
`;
document.body.appendChild(activePopup);
const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');
const muteBtn = document.getElementById('muteBtn');
const cameraBtn = document.getElementById('cameraBtn');
const endCallBtn = document.getElementById('endCallBtn');

// ---------- Helper functions ----------
function showIncoming(from){
    incomingText.innerText = "Incoming call from User " + from;
    incomingPopup.style.top = '200px';
    ringtone.play().catch(()=>{});
}

function hideIncoming(){
    incomingPopup.style.top = '-150px';
    ringtone.pause();
    ringtone.currentTime = 0;
}

function showActive(){
    activePopup.style.display = 'flex';
}

function hideActive(){
    activePopup.style.display = 'none';
}

// ---------- Create PeerConnection ----------
function createPeerConnection(){
    pc = new RTCPeerConnection({ iceServers:[{urls:"stun:stun.l.google.com:19302"}] });
    if(localStream) localStream.getTracks().forEach(track=>pc.addTrack(track, localStream));
    pc.ontrack = e => { remoteVideo.srcObject = e.streams[0]; };
    pc.onicecandidate = e=>{
        if(e.candidate && currentCallId) push(ref(db, `calls/${currentCallId}/candidates`), e.candidate.toJSON());
    };
    return pc;
}

// ---------- Start call ----------
async function startCall(targetUserId){
    try {
        localStream = await navigator.mediaDevices.getUserMedia({ audio:true, video:true });
        localVideo.srcObject = localStream;
    } catch(e){
        localStream = await navigator.mediaDevices.getUserMedia({ audio:true });
        localVideo.srcObject = null;
    }
    pc = createPeerConnection();
    showActive();
    currentCallId = push(ref(db,'calls')).key;
    await set(ref(db, `calls/${currentCallId}`), { from: auth.uid, to: targetUserId, status:'calling' });

    onValue(ref(db, `calls/${currentCallId}/status`), async snap=>{
        if(snap.val()==='accepted'){
            const offer = await pc.createOffer();
            await pc.setLocalDescription(offer);
            await set(ref(db, `calls/${currentCallId}/offer`), offer.toJSON());
        }
        if(snap.val()==='ended'){
            endCallUI();
        }
    });

    onValue(ref(db, `calls/${currentCallId}/answer`), s=>{
        if(s.val()) pc.setRemoteDescription(s.val());
    });

    onValue(ref(db, `calls/${currentCallId}/candidates`), s=>{
        if(s.val()) Object.values(s.val()).forEach(c=>pc.addIceCandidate(c));
    });
}

// ---------- Listen incoming call ----------
function listenIncomingCall(){
    onValue(ref(db,'calls'), snap=>{
        const calls = snap.val();
        if(!calls) return;
        Object.entries(calls).forEach(([id,call])=>{
            if(call.to===auth.uid && call.status==='calling' && currentCallId===null){
                currentCallId = id;
                showIncoming(call.from);

                acceptBtn.onclick = async ()=>{
                    hideIncoming();
                    try {
                        localStream = await navigator.mediaDevices.getUserMedia({ audio:true, video:true });
                        localVideo.srcObject = localStream;
                    } catch(e){
                        localStream = await navigator.mediaDevices.getUserMedia({ audio:true });
                        localVideo.srcObject = null;
                    }
                    pc = createPeerConnection();
                    await set(ref(db, `calls/${id}/status`), 'accepted');

                    onValue(ref(db, `calls/${id}/offer`), async s=>{
                        if(s.val()){
                            await pc.setRemoteDescription(s.val());
                            const answer = await pc.createAnswer();
                            await pc.setLocalDescription(answer);
                            await set(ref(db, `calls/${id}/answer`), answer.toJSON());
                        }
                    });

                    onValue(ref(db, `calls/${id}/candidates`), s=>{
                        if(s.val()) Object.values(s.val()).forEach(c=>pc.addIceCandidate(c));
                    });

                    showActive();
                };

                rejectBtn.onclick = ()=>{
                    hideIncoming();
                    remove(ref(db, `calls/${id}`));
                    currentCallId = null;
                };
            }

            // End call handling
            if(call && call.status==='ended' && currentCallId===id){
                endCallUI();
            }
        });
    });
}

// ---------- End call ----------
function endCallUI(){
    if(localStream) localStream.getTracks().forEach(t=>t.stop());
    if(pc) pc.close();
    hideActive();
    hideIncoming();
    currentCallId=null;
}

// ---------- Buttons ----------
endCallBtn.onclick = async ()=>{
    if(currentCallId) await set(ref(db, `calls/${currentCallId}/status`),'ended');
    endCallUI();
};

muteBtn.onclick = ()=>{
    if(localStream){
        localStream.getAudioTracks().forEach(t=>t.enabled = !t.enabled);
        audioEnabled = !audioEnabled;
        muteBtn.textContent = audioEnabled ? "🎤" : "🔇";
    }
};

cameraBtn.onclick = ()=>{
    if(localStream && localVideo){
        localStream.getVideoTracks().forEach(t=>t.enabled = !t.enabled);
        videoEnabled = !videoEnabled;
        cameraBtn.textContent = videoEnabled ? "📷" : "❌";
        localVideo.style.display = videoEnabled ? "block" : "none";
    }
};

// ---------- Start call manually ----------
window.startCall = (targetUserId)=>{
    startCall(targetUserId);
};

// ---------- Init listener ----------
listenIncomingCall();
