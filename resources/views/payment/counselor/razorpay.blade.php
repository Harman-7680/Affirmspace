<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        key: "{{ config('services.razorpay.key') }}",
        amount: "{{ $order['amount'] }}",
        currency: "INR",
        order_id: "{{ $order['id'] }}",
        name: "18% GST applicable",

        handler: function(response) {
            // Get values from form inputs
            let subject = document.querySelector('input[name="subject"]').value;
            let message = document.querySelector('textarea[name="message"]').value;
            let email = document.querySelector('input[name="email"]').value;
            let availabilityId = document.querySelector('select[name="availability_id"]').value;

            fetch("{{ route('appointment.payment.success') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(response)
                }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ url()->previous() }}?payment=success";
                    } else {
                        alert(data.error || "Payment processed but booking failed.");
                    }
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
