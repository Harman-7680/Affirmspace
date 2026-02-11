<!DOCTYPE html>
<html>

<head>
    <title>Registration Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>

    <script>
        var options = {
            key: "{{ config('services.razorpay.key') }}",
            order_id: "{{ $order_id }}",
            name: "18% GST applicable",
            handler: function(response) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('app.payment.success') }}";

                ['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature']
                .forEach(function(key) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = response[key];
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            },
            modal: {
                ondismiss: function() {
                    window.location.href = "{{ route('app.payment.cancel') }}";
                }
            }
        };

        new Razorpay(options).open();
    </script>

</body>

</html>
