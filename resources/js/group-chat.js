document.addEventListener("DOMContentLoaded", () => {
    const config = window.GroupChat;

    if (!config) {
        console.error("GroupChat configuration not found.");
        return;
    }

    const chatBox = document.getElementById("groupMessages");
    const form = document.getElementById("groupChatForm");
    const input = document.getElementById("groupMessageInput");
    const fileInput = document.getElementById("groupAttachment");
    const fileButton = document.getElementById("attachmentButton");
    const preview = document.getElementById("attachmentPreview");
    const sendButton = document.getElementById("groupSendButton");

    const renderedIds = new Set();

    let sending = false;

    // Attachment picker
    fileButton.addEventListener("click", () => {
        fileInput.click();
    });

    // Attachment preview
    fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];

        if (!file) {
            preview.classList.add("hidden");
            preview.textContent = "";
            return;
        }

        preview.textContent = "Selected file: " + file.name;
        preview.classList.remove("hidden");
    });

    // Scroll to bottom
    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Safe HTML elements
    function createElement(tag, className, text = "") {
        const element = document.createElement(tag);

        element.className = className;
        element.textContent = text;

        return element;
    }

    // Render message
    function renderMessage(msg) {
        if (renderedIds.has(String(msg.id))) {
            return;
        }

        renderedIds.add(String(msg.id));

        const isSender = Number(msg.user_id) === Number(config.userId);

        const row = createElement(
            "div",
            "flex gap-3 items-start " + (isSender ? "flex-row-reverse" : ""),
        );

        const avatar = document.createElement("img");

        avatar.src = isSender
            ? config.userImage
            : "/images/avatars/avatar-1.jpg";

        avatar.alt = "User";
        avatar.className = "w-9 h-9 rounded-full object-cover";

        const content = createElement(
            "div",
            "max-w-[80%] min-w-0 " + (isSender ? "text-right" : ""),
        );

        const name = createElement(
            "p",
            "text-xs text-gray-500 mb-1",
            isSender ? "You" : msg.user_tag || "affirm-" + msg.user_id,
        );

        const bubble = createElement(
            "div",
            "inline-block text-left px-4 py-3 rounded-2xl break-words " +
                (isSender
                    ? "bg-blue-500 text-white"
                    : "bg-gray-100 text-gray-800"),
        );

        if (msg.message) {
            const messageText = createElement(
                "div",
                "whitespace-pre-wrap break-words",
                msg.message,
            );

            bubble.appendChild(messageText);
        }

        // Compact attachment previews
        if (msg.attachment_url) {
            const mime = msg.attachment_mime || "";
            const attachmentUrl = msg.attachment_url;
            const fileName = msg.attachment_name || "Shared file";

            // Image preview
            if (mime.startsWith("image/")) {
                const image = document.createElement("img");

                image.src = attachmentUrl;
                image.alt = fileName;
                image.loading = "lazy";
                image.className =
                    "block mt-2 w-36 h-28 object-cover rounded-lg cursor-pointer";

                image.addEventListener("click", () => {
                    window.open(attachmentUrl, "_blank", "noopener,noreferrer");
                });

                bubble.appendChild(image);
            }

            // Video preview
            else if (mime.startsWith("video/")) {
                const video = document.createElement("video");

                video.src = attachmentUrl;
                video.controls = true;
                video.preload = "metadata";
                video.className =
                    "block mt-2 w-48 h-28 object-cover rounded-lg";

                bubble.appendChild(video);
            }

            // Audio preview
            else if (mime.startsWith("audio/")) {
                const audio = document.createElement("audio");

                audio.src = attachmentUrl;
                audio.controls = true;
                audio.preload = "metadata";
                audio.className = "block mt-2 w-48";

                bubble.appendChild(audio);
            }

            // Document and other files
            else {
                const fileCard = document.createElement("a");

                fileCard.href = attachmentUrl;
                fileCard.target = "_blank";
                fileCard.rel = "noopener noreferrer";
                fileCard.className =
                    "flex items-center gap-2 mt-2 p-2 rounded-lg bg-black/5 dark:bg-white/10 max-w-[220px] no-underline";

                const icon = document.createElement("span");
                icon.textContent = "📎";
                icon.className = "text-lg shrink-0";

                const fileLabel = document.createElement("span");
                fileLabel.textContent = fileName;
                fileLabel.className = "text-xs font-medium truncate";

                fileCard.appendChild(icon);
                fileCard.appendChild(fileLabel);

                bubble.appendChild(fileCard);
            }
        }

        const time = createElement(
            "p",
            "text-xs text-gray-400 mt-1",
            msg.created_at || "",
        );

        content.appendChild(name);
        content.appendChild(bubble);
        content.appendChild(time);

        row.appendChild(avatar);
        row.appendChild(content);

        chatBox.appendChild(row);

        scrollToBottom();
    }

    // Load previous messages
    async function loadMessages() {
        try {
            const response = await fetch(config.fetchUrl, {
                headers: {
                    Accept: "application/json",
                },
                credentials: "same-origin",
            });

            if (!response.ok) {
                throw new Error("Unable to load messages.");
            }

            const messages = await response.json();

            document.getElementById("loadingMessages")?.remove();

            messages.forEach(renderMessage);
            scrollToBottom();
        } catch (error) {
            console.error(error);

            const loading = document.getElementById("loadingMessages");

            if (loading) {
                loading.textContent = "Failed to load message.";
            }
        }
    }

    // Send text or attachment
    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        if (sending) return;

        const message = input.value.trim();
        const file = fileInput.files[0];

        if (!message && !file) {
            return;
        }

        sending = true;
        sendButton.disabled = true;

        try {
            const formData = new FormData();

            if (message) {
                formData.append("message", message);
            }

            if (file) {
                formData.append("attachment", file);
            }

            const response = await fetch(config.sendUrl, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": config.csrfToken,
                },
                credentials: "same-origin",
                body: formData,
            });

            const result = await response.json();

            if (!response.ok) {
                const errors = result.errors
                    ? Object.values(result.errors).flat().join("\n")
                    : result.message || "Message not sent.";

                throw new Error(errors);
            }

            // Render immediately for sender.
            renderMessage(result.data);

            input.value = "";
            fileInput.value = "";

            preview.textContent = "";
            preview.classList.add("hidden");
        } catch (error) {
            console.error(error);
            alert(error.message || "Message not sent.");
        } finally {
            sending = false;
            sendButton.disabled = false;
            input.focus();
        }
    });

    // Reverb real-time subscription
    function connectRealtime() {
        if (!window.Echo) {
            console.error("Laravel Echo is not loaded.");
            return;
        }

        window.Echo.private("group-chat." + config.roomId).listen(
            ".GroupMessageSent",
            (event) => {
                renderMessage(event.message);
            },
        );
    }

    loadMessages();
    connectRealtime();
});
