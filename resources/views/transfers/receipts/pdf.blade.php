<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaction Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .receipt-details { margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .amount { font-size: 24px; font-weight: bold; color: #059669; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RediCash Transaction Receipt</h1>
        <p>{{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <div class="receipt-details">
        <div class="detail-row">
            <strong>Transaction ID:</strong>
            <span>{{ $receiptData['transaction_id'] }}</span>
        </div>
        <div class="detail-row">
            <strong>Reference:</strong>
            <span>{{ $receiptData['reference_id'] }}</span>
        </div>
        <div class="detail-row">
            <strong>Type:</strong>
            <span>{{ ucfirst($receiptData['type']) }}</span>
        </div>
        <div class="detail-row">
            <strong>Description:</strong>
            <span>{{ $receiptData['description'] }}</span>
        </div>
        <div class="detail-row">
            <strong>Amount:</strong>
            <span class="amount">{{ number_format(abs($receiptData['amount']), 2) }} {{ $receiptData['currency'] }}</span>
        </div>
        <div class="detail-row">
            <strong>Status:</strong>
            <span>{{ ucfirst($receiptData['status']) }}</span>
        </div>
        <div class="detail-row">
            <strong>Date:</strong>
            <span>{{ $receiptData['created_at']->format('Y-m-d H:i:s') }}</span>
        </div>
        <div class="detail-row">
            <strong>Account:</strong>
            <span>{{ $receiptData['wallet']['account_number'] }}</span>
        </div>
    </div>

    <div class="footer">
        <p>This is an automatically generated receipt from RediCash E-Wallet System.</p>
        <p>For support, please contact our customer service.</p>
    </div>
</body>
</html>
