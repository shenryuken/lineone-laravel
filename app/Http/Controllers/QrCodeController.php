<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QrCodeController extends Controller
{
    /**
     * Process a QR code payment
     */
    public function processQrPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'recipient_id' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:0.01',
                'note' => 'nullable|string|max:255',
            ]);
            
            $sender = Auth::user();
            $recipient = User::findOrFail($validated['recipient_id']);
            
            // Check if sender has enough balance
            if ($sender->wallet_balance < $validated['amount']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance'
                ], 400);
            }
            
            // Process the payment (in a real app, this would be in a transaction)
            $sender->wallet_balance -= $validated['amount'];
            $recipient->wallet_balance += $validated['amount'];
            
            $sender->save();
            $recipient->save();
            
            // Create transaction record
            // $transaction = Transaction::create([...]);
            
            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'transaction' => [
                    'amount' => $validated['amount'],
                    'recipient' => $recipient->name,
                    'date' => now()->toDateTimeString(),
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('QR payment error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Generate a QR code for the authenticated user
     */
    public function generateQrCode()
    {
        $user = Auth::user();
        
        $data = [
            'user_id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'timestamp' => now()->timestamp
        ];
        
        // In a real app, you might want to encrypt this data or use a more secure method
        $jsonData = json_encode($data);
        
        return response()->json([
            'qr_data' => $jsonData,
            'qr_url' => "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($jsonData)
        ]);
    }
    
    /**
     * Validate a scanned QR code
     */
    public function validateQrCode(Request $request)
    {
        try {
            $validated = $request->validate([
                'qr_data' => 'required|string',
            ]);
            
            $data = json_decode($validated['qr_data'], true);
            
            if (!$data || !isset($data['user_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code'
                ], 400);
            }
            
            $recipient = User::find($data['user_id']);
            
            if (!$recipient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipient not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'recipient' => [
                    'id' => $recipient->id,
                    'name' => $recipient->name,
                    'phone' => $recipient->phone,
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('QR validation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to validate QR code'
            ], 500);
        }
    }
}
