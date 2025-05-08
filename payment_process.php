<?php
header('Content-Type: application/json');

$apiKey = 'rzp_test_qsWJIMAXJe3Eul'; // Your test key
$apiSecret = 'sjNUv8uvI3K0kNvUMlW0JvxI'; // Your test secret

// Get data from frontend
$data = json_decode(file_get_contents('php://input'), true);
$amount = $data['amount'];

// Create order
$ch = curl_init('https://api.razorpay.com/v1/orders');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'amount' => $amount,
        'currency' => 'INR',
        'payment_capture' => 1
    ]),
    CURLOPT_USERPWD => "$apiKey:$apiSecret",
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response; // Returns order details to frontend
?>