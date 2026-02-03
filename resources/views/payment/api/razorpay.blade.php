<!DOCTYPE html>
<html>

<head>
    <title>Event Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>

    <script>
        var options = {
            key: "{{ config('services.razorpay.key') }}",
            amount: "{{ $amount * 100 }}",
            currency: "INR",
            order_id: "{{ $order_id }}",
            name: "Event Payment",
            description: "Event: {{ $event->name }}",

            handler: function(response) {
                fetch("{{ url('/api/verify-payment') }}", {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            event_id: "{{ $event->id }}"
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        window.location.href = data.success ?
                            "{{ route('api.events.success', $event->id) }}" :
                            "{{ route('api.events.cancel', $event->id) }}";
                    });
            },

            modal: {
                ondismiss: function() {
                    window.location.href =
                        "{{ route('api.events.cancel', $event->id) }}";
                }
            }
        };

        new Razorpay(options).open();
    </script>

</body>

</html>
