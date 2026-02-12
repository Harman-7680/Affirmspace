<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complete Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Segoe UI', sans-serif;
        }

        .payment-card {
            background: #fff;
            padding: 30px;
            width: 360px;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .payment-card h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .payment-card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
        }

        .amount {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 20px;
        }

        #payBtn {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            background: #4f46e5;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }

        #payBtn:hover {
            background: #4338ca;
        }

        .back-btn {
            margin-top: 15px;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #f9fafb;
            color: #333;
            cursor: pointer;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #f1f5f9;
        }

        .gst-note {
            font-size: 16px;
            color: #3f434a;
            margin-top: 2px;
        }
    </style>
</head>

<body>

    <div class="payment-card">
        <h2>Complete Your Registration</h2>
        <p>Please complete the payment to activate your account</p>

        <div class="amount">₹ {{ $amount }}</div>
        <div class="gst-note">
            + GST @18% (₹ {{ number_format($amount * 0.18, 2) }})
        </div>

        <button id="payBtn">Pay Now</button>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="back-btn">
                ⬅ Back to Login
            </button>
        </form>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.getElementById('payBtn').onclick = async function() {
            try {
                const res = await fetch("{{ route('registration.order') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    }
                });

                const data = await res.json();

                if (!data.order_id) {
                    alert('Order create failed');
                    return;
                }

                const options = {
                    key: data.key,
                    order_id: data.order_id,
                    name: "Registration Fee",
                    description: "One-time registration payment",
                    handler: function(response) {

                        fetch("{{ route('registration.success') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature
                            })
                        }).then(() => {
                            window.location.href = "{{ route('verification.notice') }}";
                        });

                    }
                };

                new Razorpay(options).open();

            } catch (e) {
                console.error(e);
                alert('Something went wrong');
            }
        };
    </script>

</body>

</html>
