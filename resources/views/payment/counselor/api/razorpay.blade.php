<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        key: "{{ config('services.razorpay.key') }}",
        amount: "{{ $order['amount'] }}",
        currency: "{{ $order['currency'] }}",
        name: "{{ config('country_pricing.gst_rate') }}% GST applicable",
        order_id: "{{ $order['id'] }}",

        handler: function(response) {

            var form = document.createElement("form");
            form.method = "POST";
            form.action = "{{ url('/app/contact/success') }}";

            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
                <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
                <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
            `;

            document.body.appendChild(form);
            form.submit();
        },

        modal: {
            ondismiss: function() {
                window.location.href =
                    "{{ url('/app/contact/cancel') }}?razorpay_order_id={{ $order['id'] }}";
            }
        }
    };

    new Razorpay(options).open();
</script>
