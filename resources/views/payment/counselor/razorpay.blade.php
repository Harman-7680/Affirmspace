<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        key: "{{ config('services.razorpay.key') }}",
        amount: "{{ $order['amount'] }}",
        currency: "INR",
        order_id: "{{ $order['id'] }}",
        name: "Appointment Booking",
        description: "18% GST applicable",

        handler: function(response) {
            fetch("{{ route('appointment.payment.success') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(response)
            }).then(() => {
                window.location.href = "{{ url()->previous() }}?payment=success";
            });
        },

        modal: {
            ondismiss: function() {
                fetch("{{ route('appointment.payment.cancel') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }).then(() => {
                    window.location.href = "{{ url()->previous() }}?payment=cancel";
                });
            }
        }
    };

    new Razorpay(options).open();
</script>
