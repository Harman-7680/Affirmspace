<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complete Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .loader {
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Redirecting to payment…</h2>
        <p class="loader">Please wait, do not close this window</p>
    </div>

    <script>
        var options = {
            "key": "{{ config('services.razorpay.key') }}",
            "amount": "{{ $order['amount'] }}",
            "currency": "INR",
            "name": "18% GST applicable",
            "description": "Counselor Appointment",
            "order_id": "{{ $order['id'] }}",

            "handler": function(response) {
                window.location.href = "{{ url('/app/contact/success') }}";
            },

            "modal": {
                "ondismiss": function() {
                    window.location.href = "{{ url('/app/contact/cancel') }}";
                }
            },

            "theme": {
                "color": "#6366f1"
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    </script>

</body>

</html>
