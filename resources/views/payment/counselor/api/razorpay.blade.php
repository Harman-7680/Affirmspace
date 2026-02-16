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
                var url = "{{ url('/app/contact/success') }}" +
                    "?razorpay_order_id=" + response.razorpay_order_id +
                    "&razorpay_payment_id=" + response.razorpay_payment_id +
                    "&razorpay_signature=" + response.razorpay_signature;
                window.location.href = url;
            },

            "modal": {
                "ondismiss": function() {
                    window.location.href =
                        "{{ url('/app/contact/cancel') }}?razorpay_order_id={{ $order['id'] }}";
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
