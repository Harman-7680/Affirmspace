// document.addEventListener("DOMContentLoaded", () => {
//     if (!window.Echo) {
//         console.error("Echo not loaded");
//         return;
//     }

//     const senderId = window.Chat.senderId;
//     const receiverId = window.Chat.receiverId;

//     const currentUserImage = window.Chat.currentUserImage;
//     const receiverImage = window.Chat.receiverImage;

//     const chatRoom =
//         senderId < receiverId
//             ? `${senderId}_${receiverId}`
//             : `${receiverId}_${senderId}`;

//     const chatBox = document.getElementById("chat-messages");

//     function scrollToBottom(force = false) {
//         const isNearBottom =
//             chatBox.scrollTop + chatBox.clientHeight >=
//             chatBox.scrollHeight - 50;

//         if (force || isNearBottom) {
//             chatBox.scrollTop = chatBox.scrollHeight;
//         }
//     }

//     // RENDER MESSAGE
//     function renderMessage(message, isSender, id = null) {
//         if (id && document.querySelector(`[data-id="${id}"]`)) return;

//         // remove temp when real message arrives
//         if (id) {
//             const temp = document.querySelector(`[data-temp="true"]`);
//             if (temp) temp.remove();
//         }

//         const html = isSender
//             ? `
//         <div data-id="${id ?? ""}" class="flex gap-2 flex-row-reverse items-end">
//             <img src="${currentUserImage}" class="w-5 h-5 rounded-full shadow">
//             <div class="px-4 py-2 rounded-[20px] max-w-sm bg-gradient-to-tr from-sky-500 to-blue-500 text-white shadow">
//                 ${message}
//             </div>
//         </div>`
//             : `
//         <div data-id="${id ?? ""}" class="flex gap-3">
//             <img src="${receiverImage}" class="w-9 h-9 rounded-full shadow">
//             <div class="px-4 py-2 rounded-[20px] max-w-sm bg-secondery">
//                 ${message}
//             </div>
//         </div>`;

//         chatBox.insertAdjacentHTML("beforeend", html);
//         scrollToBottom();
//     }

//     // LOAD OLD
//     fetch(`/fetch-messages/${receiverId}`)
//         .then((res) => res.json())
//         .then((data) => {
//             data.forEach((msg) => {
//                 renderMessage(msg.message, msg.sender_id == senderId, msg.id);
//             });
//             scrollToBottom(true);
//         });

//     // REALTIME
//     window.Echo.channel("chat." + chatRoom).listen(".MessageSent", (e) => {
//         renderMessage(e.message, e.sender_id == senderId, e.id);
//     });

//     // SEND MESSAGE
//     document
//         .getElementById("sendButton")
//         .addEventListener("click", async () => {
//             const input = document.getElementById("messageInput");
//             const text = input.value.trim();

//             if (!text) return;

//             try {
//                 // TEMP MESSAGE (ONLY HERE)
//                 chatBox.insertAdjacentHTML(
//                     "beforeend",
//                     `
//                 <div data-temp="true" class="flex gap-2 flex-row-reverse items-end">
//                     <img src="${currentUserImage}" class="w-5 h-5 rounded-full shadow">
//                     <div class="px-4 py-2 rounded-[20px] max-w-sm bg-gradient-to-tr from-sky-500 to-blue-500 text-white shadow opacity-70">
//                         ${text}
//                     </div>
//                 </div>`,
//                 );

//                 scrollToBottom();

//                 await fetch("/chat/send", {
//                     method: "POST",
//                     headers: {
//                         "Content-Type": "application/json",
//                         "X-CSRF-TOKEN": document.querySelector(
//                             'meta[name="csrf-token"]',
//                         ).content,
//                     },
//                     body: JSON.stringify({
//                         receiver_id: receiverId,
//                         message: text,
//                     }),
//                 });

//                 // notification API
//                 await fetch("/send-message", {
//                     method: "POST",
//                     headers: {
//                         "Content-Type": "application/json",
//                         "X-CSRF-TOKEN": document.querySelector(
//                             'meta[name="csrf-token"]',
//                         ).content,
//                     },
//                     body: JSON.stringify({
//                         receiver_id: receiverId,
//                         message: text,
//                     }),
//                 });

//                 input.value = "";
//             } catch (err) {
//                 console.error(err);
//             }
//         });
// });

document.addEventListener("DOMContentLoaded", () => {
    if (!window.Echo || !window.Chat) {
        console.error("Echo or Chat configuration not found.");
        return;
    }

    const config = window.Chat;

    const senderId = Number(config.senderId);
    const receiverId = Number(config.receiverId);

    const chatBox = document.getElementById("chat-messages");
    const input = document.getElementById("messageInput");
    const sendButton = document.getElementById("sendButton");

    const fileInput = document.getElementById("friendAttachment");
    const fileButton = document.getElementById("friendAttachmentButton");
    const filePreview = document.getElementById("friendAttachmentPreview");
    const fileName = document.getElementById("friendAttachmentName");
    const removeFileButton = document.getElementById("friendRemoveAttachment");

    if (!chatBox || !input || !sendButton) {
        console.error("Friend chat elements not found.");
        return;
    }

    const renderedIds = new Set();
    const tempIds = new Set();

    let sending = false;

    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]',
    )?.content;

    const chatRoom =
        senderId < receiverId
            ? `${senderId}_${receiverId}`
            : `${receiverId}_${senderId}`;

    // Scroll only when the user is already near the bottom.
    function scrollToBottom(force = false) {
        const nearBottom =
            chatBox.scrollTop + chatBox.clientHeight >=
            chatBox.scrollHeight - 80;

        if (force || nearBottom) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }

    function createElement(tag, className = "", text = "") {
        const element = document.createElement(tag);

        element.className = className;
        element.textContent = text;

        return element;
    }

    function formatFileSize(bytes) {
        if (!bytes || bytes <= 0) return "";

        if (bytes < 1024) {
            return `${bytes} B`;
        }

        if (bytes < 1024 * 1024) {
            return `${(bytes / 1024).toFixed(1)} KB`;
        }

        return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    // Render attachment safely using DOM elements.
    // Render compact attachment previews like group chat.
    function renderAttachment(bubble, msg) {
        if (!msg.attachment_url) return;

        const mime = msg.attachment_mime || "";
        const url = msg.attachment_url;
        const name = msg.attachment_name || "Shared file";

        // Compact image preview
        if (mime.startsWith("image/")) {
            const image = document.createElement("img");

            image.src = url;
            image.alt = name;
            image.loading = "lazy";
            image.className =
                "block mt-2 w-36 h-28 object-cover rounded-lg cursor-pointer";

            image.addEventListener("click", () => {
                window.open(url, "_blank", "noopener,noreferrer");
            });

            bubble.appendChild(image);
        }

        // Compact video preview
        else if (mime.startsWith("video/")) {
            const video = document.createElement("video");

            video.src = url;
            video.controls = true;
            video.preload = "metadata";
            video.className = "block mt-2 w-48 h-28 object-cover rounded-lg";

            bubble.appendChild(video);
        }

        // Compact audio player
        else if (mime.startsWith("audio/")) {
            const audio = document.createElement("audio");

            audio.src = url;
            audio.controls = true;
            audio.preload = "metadata";
            audio.className = "block mt-2 w-48";

            bubble.appendChild(audio);
        }

        // Compact document and other file preview
        else {
            const fileCard = document.createElement("a");

            fileCard.href = url;
            fileCard.target = "_blank";
            fileCard.rel = "noopener noreferrer";
            fileCard.className =
                "flex items-center gap-2 mt-2 p-2 rounded-lg bg-black/5 dark:bg-white/10 max-w-[220px] no-underline";

            const icon = document.createElement("span");
            icon.textContent = "📎";
            icon.className = "text-lg shrink-0";

            const fileNameElement = document.createElement("span");
            fileNameElement.textContent = name;
            fileNameElement.className = "text-xs font-medium truncate";

            fileCard.appendChild(icon);
            fileCard.appendChild(fileNameElement);

            bubble.appendChild(fileCard);
        }

        // File size
        const size = formatFileSize(Number(msg.attachment_size));

        if (size) {
            bubble.appendChild(
                createElement("p", "text-xs mt-1 opacity-75", size),
            );
        }
    }

    // Render a message from history, HTTP response or Reverb.
    function renderMessage(msg) {
        if (!msg || msg.id == null) return;

        const id = String(msg.id);

        if (renderedIds.has(id)) {
            return;
        }

        renderedIds.add(id);

        const isSender = Number(msg.sender_id) === senderId;

        const row = createElement(
            "div",
            `flex gap-2 items-end ${isSender ? "flex-row-reverse" : ""}`,
        );

        row.dataset.id = id;

        const avatar = document.createElement("img");

        avatar.src = isSender ? config.currentUserImage : config.receiverImage;

        avatar.alt = "User";
        avatar.className = "w-8 h-8 rounded-full object-cover shrink-0";

        const content = createElement(
            "div",
            `min-w-0 max-w-[80%] ${isSender ? "text-right" : "text-left"}`,
        );

        const bubble = createElement(
            "div",
            `inline-block text-left px-4 py-2 rounded-[20px] break-words ${
                isSender
                    ? "bg-gradient-to-tr from-sky-500 to-blue-500 text-white"
                    : "bg-secondery"
            }`,
        );

        if (msg.message) {
            bubble.appendChild(
                createElement(
                    "div",
                    "whitespace-pre-wrap break-words",
                    msg.message,
                ),
            );
        }

        renderAttachment(bubble, msg);

        content.appendChild(bubble);

        if (msg.created_at) {
            content.appendChild(
                createElement(
                    "p",
                    "text-xs text-gray-400 mt-1",
                    msg.created_at,
                ),
            );
        }

        row.appendChild(avatar);
        row.appendChild(content);

        chatBox.appendChild(row);

        scrollToBottom();
    }

    // File picker.
    if (fileButton && fileInput) {
        fileButton.addEventListener("click", () => {
            fileInput.click();
        });

        fileInput.addEventListener("change", () => {
            const file = fileInput.files?.[0];

            if (!file) {
                clearSelectedFile();
                return;
            }

            if (file.size > 50 * 1024 * 1024) {
                alert("File size cannot exceed 50 MB.");
                clearSelectedFile();
                return;
            }

            fileName.textContent = file.name;
            filePreview.classList.remove("hidden");
        });
    }

    function clearSelectedFile() {
        if (fileInput) {
            fileInput.value = "";
        }

        if (fileName) {
            fileName.textContent = "";
        }

        if (filePreview) {
            filePreview.classList.add("hidden");
        }
    }

    if (removeFileButton) {
        removeFileButton.addEventListener("click", clearSelectedFile);
    }

    // Load existing conversation.
    async function loadMessages() {
        try {
            const response = await fetch(`/fetch-messages/${receiverId}`, {
                headers: {
                    Accept: "application/json",
                },
                credentials: "same-origin",
            });

            if (!response.ok) {
                throw new Error("Unable to load chat history.");
            }

            const messages = await response.json();

            messages.forEach(renderMessage);

            scrollToBottom(true);
        } catch (error) {
            console.error("Chat history error:", error);
        }
    }

    // Send a text message, attachment, or both.
    async function sendMessage() {
        if (sending) return;

        const text = input.value.trim();
        const file = fileInput?.files?.[0] || null;

        if (!text && !file) return;

        if (!csrfToken) {
            alert("CSRF token not found. Please reload the page.");
            return;
        }

        sending = true;
        sendButton.disabled = true;

        if (fileButton) {
            fileButton.disabled = true;
        }

        try {
            const formData = new FormData();

            formData.append("receiver_id", receiverId);

            if (text) {
                formData.append("message", text);
            }

            if (file) {
                formData.append("attachment", file);
            }

            const response = await fetch("/chat/send", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                credentials: "same-origin",
                body: formData,
            });

            const result = await response.json();

            if (!response.ok) {
                const errors = result.errors
                    ? Object.values(result.errors).flat().join("\n")
                    : result.message || "Message could not be sent.";

                throw new Error(errors);
            }

            // Render immediately. Reverb may deliver the same message too;
            // renderedIds prevents duplicates.
            renderMessage(result.data);

            input.value = "";
            clearSelectedFile();

            // Preserve the existing text notification flow.
            // Do not call this endpoint for file-only messages because its
            // validation requirements have not been provided.
            if (text) {
                try {
                    const notificationResponse = await fetch("/send-message", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            Accept: "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            message: text,
                        }),
                    });

                    if (!notificationResponse.ok) {
                        console.warn("Message notification was not sent.");
                    }
                } catch (notificationError) {
                    console.error("Notification error:", notificationError);
                }
            }
        } catch (error) {
            console.error("Send message error:", error);
            alert(error.message || "Message could not be sent.");
        } finally {
            sending = false;
            sendButton.disabled = false;

            if (fileButton) {
                fileButton.disabled = false;
            }

            input.focus();
        }
    }

    sendButton.addEventListener("click", sendMessage);

    input.addEventListener("keydown", (event) => {
        if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    });

    // Real-time friend chat.
    window.Echo.channel("chat." + chatRoom).listen(".MessageSent", (event) => {
        renderMessage(event);
    });

    loadMessages();
});
