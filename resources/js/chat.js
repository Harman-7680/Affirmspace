document.addEventListener("DOMContentLoaded", () => {
    if (!window.Echo) {
        console.error("Echo not loaded");
        return;
    }

    const senderId = window.Chat.senderId;
    const receiverId = window.Chat.receiverId;

    const currentUserImage = window.Chat.currentUserImage;
    const receiverImage = window.Chat.receiverImage;

    const chatRoom =
        senderId < receiverId
            ? `${senderId}_${receiverId}`
            : `${receiverId}_${senderId}`;

    const chatBox = document.getElementById("chat-messages");

    function scrollToBottom(force = false) {
        const isNearBottom =
            chatBox.scrollTop + chatBox.clientHeight >=
            chatBox.scrollHeight - 50;

        if (force || isNearBottom) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }

    // RENDER MESSAGE
    function renderMessage(message, isSender, id = null) {
        if (id && document.querySelector(`[data-id="${id}"]`)) return;

        // remove temp when real message arrives
        if (id) {
            const temp = document.querySelector(`[data-temp="true"]`);
            if (temp) temp.remove();
        }

        const html = isSender
            ? `
        <div data-id="${id ?? ""}" class="flex gap-2 flex-row-reverse items-end">
            <img src="${currentUserImage}" class="w-5 h-5 rounded-full shadow">
            <div class="px-4 py-2 rounded-[20px] max-w-sm bg-gradient-to-tr from-sky-500 to-blue-500 text-white shadow">
                ${message}
            </div>
        </div>`
            : `
        <div data-id="${id ?? ""}" class="flex gap-3">
            <img src="${receiverImage}" class="w-9 h-9 rounded-full shadow">
            <div class="px-4 py-2 rounded-[20px] max-w-sm bg-secondery">
                ${message}
            </div>
        </div>`;

        chatBox.insertAdjacentHTML("beforeend", html);
        scrollToBottom();
    }

    // LOAD OLD
    fetch(`/fetch-messages/${receiverId}`)
        .then((res) => res.json())
        .then((data) => {
            data.forEach((msg) => {
                renderMessage(msg.message, msg.sender_id == senderId, msg.id);
            });
            scrollToBottom(true);
        });

    // REALTIME
    window.Echo.channel("chat." + chatRoom).listen(".MessageSent", (e) => {
        renderMessage(e.message, e.sender_id == senderId, e.id);
    });

    // SEND MESSAGE
    document
        .getElementById("sendButton")
        .addEventListener("click", async () => {
            const input = document.getElementById("messageInput");
            const text = input.value.trim();

            if (!text) return;

            try {
                // TEMP MESSAGE (ONLY HERE)
                chatBox.insertAdjacentHTML(
                    "beforeend",
                    `
                <div data-temp="true" class="flex gap-2 flex-row-reverse items-end">
                    <img src="${currentUserImage}" class="w-5 h-5 rounded-full shadow">
                    <div class="px-4 py-2 rounded-[20px] max-w-sm bg-gradient-to-tr from-sky-500 to-blue-500 text-white shadow opacity-70">
                        ${text}
                    </div>
                </div>`,
                );

                scrollToBottom();

                await fetch("/chat/send", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: text,
                    }),
                });

                // notification API
                await fetch("/send-message", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: text,
                    }),
                });

                input.value = "";
            } catch (err) {
                console.error(err);
            }
        });
});
