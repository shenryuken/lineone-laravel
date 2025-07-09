<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transfer Receipt - {{ $transaction->reference }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .receipt-title {
            font-size: 18px;
            color: #666;
        }
        .transaction-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .status {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }
        .status.completed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .status.failed {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .security-note {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">RediCash</div>
        <div class="receipt-title">Transfer Receipt</div>
    </div>

    <div class="transaction-info">
        <div class="info-row">
            <span class="label">Transaction Reference:</span>
            <span class="value">{{ $transaction->reference }}</span>
        </div>
        <div class="info-row">
            <span class="label">Date & Time:</span>
            <span class="value">{{ $transaction->created_at->format('F j, Y \a\t g:i A') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Transaction Type:</span>
            <span class="value">{{ $transaction->type_display }}</span>
        </div>
        @if($transaction->isUserSender($user->id))
            <div class="info-row">
                <span class="label">From:</span>
                <span class="value">{{ $user->name }} ({{ $user->email }})</span>
            </div>
            <div class="info-row">
                <span class="label">To:</span>
                <span class="value">{{ $transaction->recipient ? $transaction->recipient->name : 'Unknown' }} 
                    @if($transaction->recipient)
                        ({{ $transaction->recipient->email }})
                    @endif
                </span>
            </div>
        @else
            <div class="info-row">
                <span class="label">From:</span>
                <span class="value">{{ $transaction->sender ? $transaction->sender->name : 'Unknown' }}
                    @if($transaction->sender)
                        ({{ $transaction->sender->email }})
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="label">To:</span>
                <span class="value">{{ $user->name }} ({{ $user->email }})</span>
            </div>
        @endif
        @if($transaction->description)
            <div class="info-row">
                <span class="label">Description:</span>
                <span class="value">{{ $transaction->description }}</span>
            </div>
        @endif
        @if($transaction->payment_method)
            <div class="info-row">
                <span class="label">Payment Method:</span>
                <span class="value">{{ ucfirst($transaction->payment_method) }}</span>
            </div>
        @endif
    </div>

    <div class="amount">
        {{ $transaction->isUserSender($user->id) ? '-' : '+' }}RM {{ $transaction->formatted_amount }}
        @if($transaction->fee > 0)
            <div style="font-size: 14px; color: #666; margin-top: 5px;">
                Fee: RM {{ number_format($transaction->fee, 2) }}
            </div>
        @endif
    </div>

    <div class="status {{ $transaction->status }}">
        Status: {{ $transaction->status_display }}
        @if($transaction->processed_at)
            <br>
            <small>Processed: {{ $transaction->processed_at->format('F j, Y \a\t g:i A') }}</small>
        @endif
    </div>

    @if($transaction->batchTransfer)
        <div class="transaction-info">
            <div class="info-row">
                <span class="label">Batch Transfer:</span>
                <span class="value">{{ $transaction->batchTransfer->title }}</span>
            </div>
        </div>
    @endif

    <div class="security-note">
        <strong>Security Notice:</strong> This receipt is generated electronically and serves as proof of your transaction. 
        Please keep this receipt for your records. If you notice any discrepancies, please contact our support team immediately.
    </div>

    <div class="footer">
        <p>RediCash E-Wallet Platform</p>
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>For support, visit https://redicash.ai/support</p>
    </div>
</body>
</html>
