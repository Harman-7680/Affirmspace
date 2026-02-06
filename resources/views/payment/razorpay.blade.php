<!DOCTYPE html>
<html>

<head>
    <title>Pay for Event</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>

    <script>
        var options = {
            "key": "{{ config('services.razorpay.key') }}",
            "amount": "{{ $order->amount }}",
            "currency": "INR",
            "name": "Event Payment",
            "description": "Event: {{ $event->name }} | 18% GST applicable",
            "order_id": "{{ $order->id }}",

            "handler": function(response) {

                var form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('event.verify') }}";

                form.innerHTML = `
            @csrf
            <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
            <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
            <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
            <input type="hidden" name="event_id" value="{{ $event->id }}">
        `;

                document.body.appendChild(form);
                form.submit();
            },

            "modal": {
                "ondismiss": function() {
                    window.location.href =
                        "{{ route('event.cancel', $event->id) }}";
                }
            },

            "prefill": {
                "name": "{{ auth()->user()->name ?? '' }}",
                "email": "{{ auth()->user()->email ?? '' }}"
            },

            "theme": {
                "color": "#dd2476"
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    </script>
</body>

</html>
