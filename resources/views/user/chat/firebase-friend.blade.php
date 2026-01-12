<div class="py-10 text-center text-sm lg:pt-8">
    <img src="{{ $receiver->image ? asset('storage/' . $receiver->image) : asset('images/avatars/avatar-1.jpg') }}"
        class="w-24 h-24 rounded-full mx-auto mb-3" alt="">
    <div class="mt-8">
        <div class="md:text-xl text-base font-medium text-black dark:text-white">
            {{ $receiver->first_name }} {{ $receiver->last_name }}
        </div>
    </div>
    {{-- <div class="mt-3.5">
                                    <a href="{{ route('user.profile', ['id' => $receiver->id]) }}"
                                        class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                                        View profile
                                    </a>
                                </div> --}}
    <div class="mt-3.5">
        @if ($receiver->role == 1)
            {{-- Counselor profile --}}
            <a href="{{ url('/counselor/' . $receiver->id) }}"
                class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                View profile
            </a>
        @else
            {{-- Counselee profile --}}
            <a href="{{ route('user.profile', ['id' => $receiver->id]) }}"
                class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                View profile
            </a>
        @endif
    </div>
</div>
<div id="chat-messages" class="text-sm font-medium space-y-6">
</div>

<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/10.3.1/firebase-app.js";
    import {
        getFirestore,
        collection,
        doc,
        addDoc,
        orderBy,
        query,
        onSnapshot,
        serverTimestamp
    } from "https://www.gstatic.com/firebasejs/10.3.1/firebase-firestore.js";

    const firebaseConfig = {
        apiKey: "AIzaSyDMQtL-8YAkyAWqFSxNaiqHphj-08TKs-0",
        authDomain: "chat-ca22a.firebaseapp.com",
        projectId: "chat-ca22a",
        storageBucket: "chat-ca22a.firebasestorage.app",
        messagingSenderId: "766199956984",
        appId: "1:766199956984:web:7b7fe890cdb6f2a937420d",
        measurementId: "G-LBGPM7H9PL"
    };

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    const senderId = {{ Auth::id() }};
    const receiverId = {{ $receiver->id }};
    const chatRoom = senderId < receiverId ?
        `${senderId}_${receiverId}` :
        `${receiverId}_${senderId}`;

    const messagesQuery = query(
        collection(db, "chats", chatRoom, "messages"),
        orderBy("timestamp")
    );

    onSnapshot(messagesQuery, (snapshot) => {
        snapshot.docChanges().forEach(change => {
            if (change.type === "added") {
                const msg = change.doc.data();
                const currentUserId = {{ Auth::id() }};
                const isSender = msg.sender_id == currentUserId;
                const html = isSender ?
                    `<div class="flex gap-2 flex-row-reverse items-end">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/avatars/avatar-1.jpg') }}"
                            alt="" class="w-5 h-5 rounded-full shadow">
                        <div class="px-4 py-2 rounded-[20px] max-w-sm bg-gradient-to-tr from-sky-500 to-blue-500 text-white shadow">
                            ${msg.message}
                        </div>
                    </div>` :
                    `<div class="flex gap-3">
                        <img src="{{ $receiver->image ? asset('storage/' . $receiver->image) : asset('images/avatars/avatar-1.jpg') }}"
                            alt="" class="w-9 h-9 rounded-full shadow">
                        <div class="px-4 py-2 rounded-[20px] max-w-sm bg-secondery">
                            ${msg.message}
                        </div>
                    </div>`;
                document.getElementById('chat-messages').innerHTML += html;
            }
        });
    });

    document.getElementById('sendButton').addEventListener('click', async () => {
        const input = document.getElementById('messageInput');
        const text = input.value.trim();
        if (text === '') return;

        await addDoc(collection(db, "chats", chatRoom, "messages"), {
            sender_id: senderId,
            receiver_id: receiverId,
            message: text,
            timestamp: serverTimestamp()
        });
        input.value = '';
    });
</script>
