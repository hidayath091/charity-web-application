<?php
header('Content-Type: application/json');

$apiKey = 'rzp_test_qsWJIMAXJe3Eul';
$apiSecret = 'sjNUv8uvI3K0kNvUMlW0JvxI';

$paymentData = json_decode(file_get_contents('php://input'), true);
$paymentId = $paymentData['razorpay_payment_id'];

// Verify payment
$ch = curl_init("https://api.razorpay.com/v1/payments/$paymentId");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => "$apiKey:$apiSecret"
]);

$response = curl_exec($ch);
curl_close($ch);

// Log verification result (for demo purposes)
file_put_contents('payment_log.txt', $response, FILE_APPEND);
echo json_encode(['status' => 'verification_logged']);
?>