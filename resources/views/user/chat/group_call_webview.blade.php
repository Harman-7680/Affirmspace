<!DOCTYPE html>
<html>

<head>

    <title>Group Call</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <style>
        html,
        body {

            margin: 0;

            padding: 0;

            width: 100%;

            height: 100%;

            overflow: hidden;

            background: #000;
        }

        #jitsi-container {

            width: 100%;

            height: 100%;
        }

        #endCall {

            position: fixed;

            top: 15px;

            right: 15px;

            z-index: 999999;

            background: red;

            color: white;

            border: none;

            padding: 10px 15px;

            border-radius: 8px;
        }
    </style>

</head>

<body>

    <div id="jitsi-container"></div>

    <button id="endCall">

        End

    </button>

    <script src="https://8x8.vc/vpaas-magic-cookie-3b7aa2c587234976b65a4c61a71fca76/external_api.js"></script>

    <script>
        const roomName = @json(request('room_name'));

        const jwt = @json(request('jwt'));

        const expiresAt = @json(request('expires_at'));

        let jitsiApi = null;

        // ================= CREATE MEETING =================

        jitsiApi = new JitsiMeetExternalAPI(
            "8x8.vc", {
                roomName: roomName,

                parentNode: document.getElementById('jitsi-container'),

                jwt: jwt,

                width: "100%",

                height: "100%",

                configOverwrite: {

                    prejoinPageEnabled: false,

                    startWithAudioMuted: false,

                    startWithVideoMuted: false,

                    disableDeepLinking: true
                }
            }
        );

        // ================= END MEETING FUNCTION =================

        function endMeeting(message = '') {

            if (message) {

                alert(message);
            }

            if (jitsiApi) {

                // leave meeting
                jitsiApi.executeCommand('hangup');

                // destroy iframe
                jitsiApi.dispose();

                jitsiApi = null;
            }

            // stop timer
            clearInterval(interval);

            // close webview page
            setTimeout(() => {

                window.location.href = "about:blank";

            }, 500);
        }

        // ================= AUTO ROOM EXPIRE =================

        const interval = setInterval(() => {

            const now = Math.floor(Date.now() / 1000);

            if (now >= expiresAt) {

                endMeeting('Room expired');
            }

        }, 1000);

        // ================= END BUTTON =================

        document.getElementById('endCall').onclick = function() {

            endMeeting();
        };

        // ================= IF USER CLOSES PAGE =================

        window.addEventListener('beforeunload', () => {

            if (jitsiApi) {

                jitsiApi.dispose();

                jitsiApi = null;
            }
        });
    </script>

</body>

</html>
