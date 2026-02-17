<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        key: "{{ config('services.razorpay.key') }}",
        amount: "{{ $order['amount'] }}",
        currency: "INR",
        order_id: "{{ $order['id'] }}",
        name: "18% GST applicable",

        handler: function(response) {

            var form = document.createElement("form");
            form.method = "POST";
            form.action = "{{ route('appointment.payment.success') }}";

            form.innerHTML = `
                @csrf
                <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
                <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
                <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
            `;

            document.body.appendChild(form);
            form.submit();
        },

        modal: {
            ondismiss: function() {
                window.location.href = "{{ url()->previous() }}?payment=cancel";
            }
        }
    };

    new Razorpay(options).open();
</script>
