<!DOCTYPE html>
<html>
<head>
    <title>Charity Jet | Donate (Test Mode)</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .donate-form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, button {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        button {
            background: #3399cc;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Your Navbar Here -->

    <div class="donate-form">
        <h2>Donate (Test Mode)</h2>
        <p>This is a simulation. No real money will be charged.</p>

        <form id="donationForm">
            <div class="form-group">
                <label>Amount (₹):</label>
                <input type="number" id="amount" min="10" value="100" required>
            </div>
            <div class="form-group">
                <label>Name:</label>
                <input type="text" id="name" value="Test Donor" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="email" value="test@example.com" required>
            </div>
            <button type="button" onclick="initiatePayment()">Donate Now</button>
        </form>

        <p class="test-note"><strong>Note:</strong> Use test card <code>4111 1111 1111 1111</code>.</p>
    </div>

    <script>
        function initiatePayment() {
            const amount = document.getElementById('amount').value * 100; // Convert to paise
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;

            // Create order via PHP backend
            fetch('payment_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ amount: amount, name: name, email: email })
            })
            .then(response => response.json())
            .then(order => {
                // Open Razorpay checkout
                const options = {
                    key: "rzp_test_qsWJIMAXJe3Eul", // Your test key
                    amount: order.amount,
                    currency: "INR",
                    name: "Charity Jet",
                    description: "Test Donation",
                    order_id: order.id,
                    handler: function(response) {
                        alert("Test Payment Successful!\nPayment ID: " + response.razorpay_payment_id);
                        // Optional: Verify payment on your server
                        verifyPayment(response);
                    },
                    prefill: { name: name, email: email },
                    theme: { color: "#3399cc" }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            });
        }

        // Optional verification function
        function verifyPayment(response) {
            fetch('payment_verify.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(response)
            });
        }
    </script>
</body>
</html>