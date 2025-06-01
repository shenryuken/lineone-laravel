# Redicash Payment Integration Guide

## Overview
This guide shows how to integrate Redicash as a payment method on your website or application, similar to how you would integrate Stripe or PayPal.

## Quick Start

### 1. Get API Credentials
1. Register as a merchant on [redicash.ai](https://redicash.ai)
2. Complete KYB verification
3. Generate API keys (test and live)

### 2. Include the SDK
\`\`\`html
<script src="https://redicash.ai/js/ewallet-sdk.js"></script>
\`\`\`

### 3. Initialize Payment
\`\`\`javascript
const redicash = new EWalletSDK('your_api_key', {
    baseUrl: 'https://redicash.ai',
    mode: 'popup', // or 'redirect', 'embed'
    onSuccess: (payment) => {
        console.log('Payment successful:', payment);
    },
    onError: (error) => {
        console.error('Payment failed:', error);
    }
});

// Create payment
redicash.createPayment({
    amount: 99.00,
    currency: 'MYR',
    description: 'Premium Subscription',
    customer_email: 'customer@example.com',
    return_url: 'https://yoursite.com/success',
    webhook_url: 'https://yoursite.com/webhooks/redicash'
});
\`\`\`

## Integration Methods

### 1. Popup Integration
Opens payment in a popup window - best for desktop.

\`\`\`javascript
const redicash = new EWalletSDK('your_api_key', {
    baseUrl: 'https://redicash.ai',
    mode: 'popup',
    onSuccess: (payment) => {
        // Handle successful payment
        window.location.href = '/success?payment_id=' + payment.payment_id;
    }
});
\`\`\`

### 2. Redirect Integration
Redirects user to payment page - best for mobile.

\`\`\`javascript
const redicash = new EWalletSDK('your_api_key', {
    baseUrl: 'https://redicash.ai',
    mode: 'redirect'
});
\`\`\`

### 3. Embedded Integration
Embeds payment form in your page - best for seamless UX.

\`\`\`html
<div id="redicash-widget"></div>

<script>
const redicash = new EWalletSDK('your_api_key', {
    baseUrl: 'https://redicash.ai',
    mode: 'embed'
});
</script>
\`\`\`

## API Reference

### Create Payment
\`\`\`
POST https://redicash.ai/api/widget/payments/initialize
\`\`\`

**Headers:**
- `X-API-Key`: Your API key
- `X-Signature`: Request signature
- `X-Timestamp`: Unix timestamp

**Body:**
\`\`\`json
{
    "amount": 99.00,
    "currency": "MYR",
    "description": "Product description",
    "customer_email": "customer@example.com",
    "customer_name": "John Doe",
    "merchant_order_id": "ORDER_123",
    "return_url": "https://yoursite.com/success",
    "cancel_url": "https://yoursite.com/cancel",
    "webhook_url": "https://yoursite.com/webhooks/redicash",
    "metadata": {
        "product_id": "123",
        "user_id": "456"
    }
}
\`\`\`

**Response:**
\`\`\`json
{
    "success": true,
    "data": {
        "payment_id": "RDC_ABC123",
        "checkout_url": "https://redicash.ai/widget/checkout/RDC_ABC123",
        "widget_url": "https://redicash.ai/widget/embed/RDC_ABC123",
        "amount": 99.00,
        "currency": "MYR",
        "expires_at": "2024-01-01T12:00:00Z"
    }
}
\`\`\`

### Check Payment Status
\`\`\`
GET https://redicash.ai/api/widget/payments/{payment_id}/status
\`\`\`

**Response:**
\`\`\`json
{
    "success": true,
    "data": {
        "payment_id": "RDC_ABC123",
        "status": "paid",
        "amount": 99.00,
        "currency": "MYR",
        "paid_at": "2024-01-01T10:30:00Z",
        "created_at": "2024-01-01T10:00:00Z",
        "expires_at": "2024-01-01T11:00:00Z"
    }
}
\`\`\`

## Webhooks

### Webhook Events
Your webhook endpoint will receive notifications for:
- `payment.completed` - Payment was successful
- `payment.failed` - Payment failed
- `payment.cancelled` - Payment was cancelled
- `payment.expired` - Payment expired

### Webhook Payload
\`\`\`json
{
    "event": "payment.completed",
    "timestamp": "2024-01-01T10:30:00Z",
    "data": {
        "payment_id": "RDC_ABC123",
        "merchant_order_id": "ORDER_123",
        "status": "paid",
        "amount": 99.00,
        "currency": "MYR",
        "customer_email": "customer@example.com",
        "customer_name": "John Doe",
        "description": "Premium Subscription",
        "payment_method": "wallet",
        "paid_at": "2024-01-01T10:30:00Z",
        "metadata": {
            "product_id": "123",
            "user_id": "456"
        }
    }
}
\`\`\`

### Webhook Verification
Verify webhook authenticity using the signature:

\`\`\`php
$signature = $_SERVER['HTTP_X_WEBHOOK_SIGNATURE'];
$payload = file_get_contents('php://input');
$expected = hash_hmac('sha256', $payload, $your_secret_key);

if (!hash_equals($signature, $expected)) {
    http_response_code(401);
    exit('Invalid signature');
}
\`\`\`

## Security

### API Authentication
All API requests require:
1. **API Key** in `X-API-Key` header
2. **Signature** in `X-Signature` header
3. **Timestamp** in `X-Timestamp` header

### Signature Generation
\`\`\`javascript
function generateSignature(payload, secretKey, timestamp) {
    const data = timestamp + JSON.stringify(payload);
    return CryptoJS.HmacSHA256(data, secretKey).toString();
}
\`\`\`

## Testing

### Test Credentials
- Test API Key: `test_pk_...`
- Test Secret Key: `test_sk_...`

### Test Wallet Accounts
For testing, use these credentials:
- Email: `test@redicash.ai`
- Password: `password123`
- Test wallet with MYR 1000.00 balance

## Error Handling

### Common Error Codes
- `400` - Bad Request (validation errors)
- `401` - Unauthorized (invalid API key)
- `404` - Payment not found
- `410` - Payment expired
- `422` - Validation failed
- `429` - Rate limit exceeded

### Error Response Format
\`\`\`json
{
    "success": false,
    "error": "Insufficient wallet balance",
    "details": {
        "required": 99.00,
        "available": 50.00
    }
}
\`\`\`

## Best Practices

1. **Always verify webhooks** - Check signatures to prevent fraud
2. **Handle timeouts** - Set appropriate timeouts for API calls
3. **Implement retry logic** - For failed webhook deliveries
4. **Store payment IDs** - For reconciliation and support
5. **Use HTTPS** - All communication must be encrypted
6. **Validate amounts** - Always verify payment amounts match your records

## Support

- **Documentation**: https://redicash.ai/docs
- **API Reference**: https://redicash.ai/api-docs
- **Support Email**: support@redicash.ai
- **Developer Portal**: https://redicash.ai/developers

## Migration from Other Providers

### From Stripe
\`\`\`javascript
// Stripe
const stripe = Stripe('pk_...');
stripe.redirectToCheckout({...});

// Redicash equivalent
const redicash = new EWalletSDK('your_api_key', {
    baseUrl: 'https://redicash.ai'
});
redicash.createPayment({...});
\`\`\`

### From PayPal
\`\`\`javascript
// PayPal
paypal.Buttons({...}).render('#paypal-button');

// Redicash equivalent
const redicash = new EWalletSDK('your_api_key', {
    baseUrl: 'https://redicash.ai',
    mode: 'embed'
});
redicash.createPayment({...});
\`\`\`

## Example Integration

Here's a complete example of integrating Redicash payments:

\`\`\`html
<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Your Store</title>
    <script src="https://redicash.ai/js/ewallet-sdk.js"></script>
</head>
<body>
    <div id="checkout">
        <h1>Complete Your Purchase</h1>
        <div class="product">
            <h3>Premium Plan</h3>
            <p>MYR 99.00/month</p>
        </div>
        
        <button id="pay-with-redicash">
            Pay with Redicash
        </button>
        
        <div id="redicash-widget"></div>
    </div>

    <script>
        // Initialize Redicash
        const redicash = new EWalletSDK('your_api_key_here', {
            baseUrl: 'https://redicash.ai',
            mode: 'embed',
            onSuccess: (payment) => {
                alert('Payment successful! ID: ' + payment.payment_id);
                window.location.href = '/success';
            },
            onError: (error) => {
                alert('Payment failed: ' + error);
            }
        });

        // Handle payment button click
        document.getElementById('pay-with-redicash').onclick = () => {
            redicash.createPayment({
                amount: 99.00,
                currency: 'MYR',
                description: 'Premium Plan - Monthly Subscription',
                customer_email: 'customer@example.com',
                merchant_order_id: 'ORDER_' + Date.now(),
                return_url: window.location.origin + '/success',
                webhook_url: window.location.origin + '/webhooks/redicash'
            });
        };
    </script>
</body>
</html>
\`\`\`

## WordPress Plugin

For WordPress users, we provide a ready-to-use plugin:

\`\`\`php
// Download from: https://redicash.ai/downloads/wordpress-plugin
// Or install via WordPress admin: Search "Redicash Payment Gateway"
\`\`\`

## Shopify App

For Shopify stores:

\`\`\`
1. Visit Shopify App Store
2. Search "Redicash"
3. Install and configure with your API keys
\`\`\`

---

**Ready to get started?** [Sign up for a merchant account](https://redicash.ai/merchant/register) and start accepting payments today!
