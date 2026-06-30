# eSewa PHP Integration

This project integrates eSewa payment gateway using PHP.

## Features
- Secure HMAC-SHA256 signature generation
- Redirect-based payment system
- Success and failure handling

## How it works
1. User clicks Pay
2. Request goes to pay.php
3. Signature is generated
4. Redirect to eSewa
5. After payment → return to success/failure page

## Files
- payment.php → UI
- pay.php → payment processing
- esewa-config.php → configuration
- payment-success.php → success page
- failure.php → failure page

## Note
This is using eSewa sandbox (EPAYTEST)

## Author
Beauty Parlour Management System