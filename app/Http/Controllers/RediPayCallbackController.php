<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RediPayCallbackController extends Controller
{
  /**
   * Handle RediPay callback (server-to-server)
   */
    public function handleCallback(Request $request)
    {
        Log::info('RediPay callback received', [
            'request_method' => $request->method(),
            'data' => $request->all()
        ]);

        // Process the payment data
        $result = $this->processPayment($request);

        // Always respond with success to RediPay
        return response()->json(['status' => 'success']);
    }

  /**
   * Handle RediPay redirect (user browser redirect)
   */
    public function handleRedirect(Request $request)
    {
        Log::info('RediPay redirect received', [
            'request_method' => $request->method(),
            'data' => $request->all(),
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
            'session_data' => [
                'payment_user_id' => session('payment_user_id'),
                'payment_wallet_id' => session('payment_wallet_id')
            ]
        ]);

        // Try to restore the user session
        if (!Auth::check()) {
            // First try to get user ID from session
            $userId = session('payment_user_id');

            if (!$userId) {
                // If not in session, try to get from request
                $userId = $request->input('user_id');
            }

            if (!$userId) {
                // If still not found, try to find from email in the request
                $email = $request->input('email');
                if ($email) {
                    $user = User::where('email', $email)->first();
                    if ($user) {
                        $userId = $user->id;
                        Log::info('Found user by email from RediPay redirect', [
                            'email' => $email,
                            'user_id' => $userId
                        ]);
                    }
                }
            }

            if (!$userId) {
                // If still not found, try to find from transaction
                $referenceNo = $request->input('reference_no');
                $trxNo = $request->input('trx_no');
                $billId = $request->input('bill_id');

                $referenceId = $referenceNo ?: ($trxNo ?: $billId);

                if ($referenceId) {
                    // Look for transaction with this reference ID and RediPay in metadata
                    $transaction = Transaction::where('reference_id', $referenceId)
                        ->where(function($query) {
                            $query->where('metadata->provider', 'redipay');
                        })
                        ->first();

                    if ($transaction) {
                        $userId = $transaction->user_id;
                        Log::info('Found user by transaction reference', [
                            'reference_id' => $referenceId,
                            'user_id' => $userId
                        ]);
                    }
                }
            }

            // If we found a user ID, log them in
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    Auth::login($user);
                    Log::info('User logged in for RediPay redirect', [
                        'user_id' => $user->id
                    ]);
                }
            }
        }

        // Extract reference information
        $referenceNo = $request->input('reference_no');
        $trxNo = $request->input('trx_no');
        $billId = $request->input('bill_id');
        $amount = $request->input('amount');
        $email = $request->input('email');
        $status = strtolower($request->input('status', ''));

        $referenceId = $referenceNo ?: ($trxNo ?: $billId);

        // If we're still not authenticated but have an email, try to process the payment anyway
        if (!Auth::check() && $email && $amount && $referenceId) {
            Log::info('Processing payment without authentication using email', [
                'email' => $email,
                'reference_id' => $referenceId
            ]);

            // Find the user by email
            $user = User::where('email', $email)->first();

            if ($user) {
                // Get the user's default wallet
                $wallet = $user->wallet();

                if ($wallet) {
                    // Check if payment was successful
                    $isPaid = ($status === 'paid' || $status === 'success' || $status === 'successful');

                    if ($isPaid) {
                        // Process the payment
                        try {
                            DB::beginTransaction();

                            // Use wallet service to process the deposit
                            $walletService = new WalletService();
                            $walletService->deposit(
                                $wallet,
                                (float)$amount,
                                "Deposit via RediPay",
                                'redipay',
                                $referenceId
                            );

                            DB::commit();

                            // Log the user in
                            Auth::login($user);

                            // Redirect to dashboard with success message
                            return redirect()->route('dashboard')->with('toast', [
                                'type' => 'success',
                                'message' => "Payment of MYR " . number_format($amount, 2) . " was successful!"
                            ]);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Log::error('RediPay redirect: Error processing payment', [
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString()
                            ]);
                        }
                    }
                }
            }
        }

        // If still not authenticated, redirect to login
        if (!Auth::check()) {
            Log::warning('RediPay redirect: Unable to restore user session', [
                'request_data' => $request->all()
            ]);

            // Store payment data in session for processing after login
            session(['pending_payment_data' => $request->all()]);

            return redirect()->route('login')->with('message', 'Please log in to complete your payment');
        }

        // Process the payment if this is a POST request
        if ($request->isMethod('post')) {
            $result = $this->processPayment($request);
        } else {
            // For GET requests, check if we have a transaction reference
            if ($referenceId) {
                // Check if we already processed this transaction
                $existingTransaction = Transaction::where('reference_id', $referenceId)
                    ->where(function($query) {
                        $query->where('metadata->provider', 'redipay');
                    })
                    ->first();

                if ($existingTransaction) {
                    $result = [
                        'success' => true,
                        'message' => 'Your payment has been processed successfully!'
                    ];
                } else {
                    // We don't have a transaction yet, but we have a reference
                    // Try to process it now if we have the amount
                    if ($amount) {
                        // Get wallet ID from session or request
                        $walletId = session('payment_wallet_id');
                        if (!$walletId) {
                            $walletId = $request->input('wallet_id');
                        }

                        if ($walletId) {
                            $wallet = Wallet::find($walletId);
                            if ($wallet) {
                                // Process the payment
                                try {
                                    DB::beginTransaction();

                                    // Use wallet service to process the deposit
                                    $walletService = new WalletService();
                                    $walletService->deposit(
                                        $wallet,
                                        (float)$amount,
                                        "Deposit via RediPay",
                                        'redipay',
                                        $referenceId
                                    );

                                    DB::commit();

                                    $result = [
                                        'success' => true,
                                        'message' => "Payment of MYR " . number_format($amount, 2) . " was successful!"
                                    ];
                                } catch (\Exception $e) {
                                    DB::rollBack();
                                    Log::error('RediPay redirect: Error processing payment', [
                                        'error' => $e->getMessage(),
                                        'trace' => $e->getTraceAsString()
                                    ]);

                                    $result = [
                                        'success' => false,
                                        'message' => 'Error processing payment: ' . $e->getMessage()
                                    ];
                                }
                            } else {
                                $result = [
                                    'success' => false,
                                    'message' => 'Wallet not found'
                                ];
                            }
                        } else {
                            // If we don't have a wallet ID, use the user's default wallet
                            $wallet = Auth::user()->wallet();

                            // Process the payment
                            try {
                                DB::beginTransaction();

                                // Use wallet service to process the deposit
                                $walletService = new WalletService();
                                $walletService->deposit(
                                    $wallet,
                                    (float)$amount,
                                    "Deposit via RediPay",
                                    'redipay',
                                    $referenceId
                                );

                                DB::commit();

                                $result = [
                                    'success' => true,
                                    'message' => "Payment of MYR " . number_format($amount, 2) . " was successful!"
                                ];
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Log::error('RediPay redirect: Error processing payment', [
                                    'error' => $e->getMessage(),
                                    'trace' => $e->getTraceAsString()
                                ]);

                                $result = [
                                    'success' => false,
                                    'message' => 'Error processing payment: ' . $e->getMessage()
                                ];
                            }
                        }
                    } else {
                        // We have a reference but no amount, wait for callback
                        $result = [
                            'success' => true,
                            'message' => 'Your payment is being processed. Please wait a moment.'
                        ];
                    }
                }
            } else {
                // No reference data, assume success but with a generic message
                $result = [
                    'success' => true,
                    'message' => 'Thank you for your payment. If your account is not credited within a few minutes, please contact support.'
                ];
            }
        }

        // Clear the session data
        session()->forget(['payment_user_id', 'payment_wallet_id', 'pending_payment_data']);

        // Redirect to dashboard with appropriate message
        return redirect()->route('dashboard')->with('toast', [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message']
        ]);
    }

    /**
     * Process payment data from RediPay
     */
    // private function processPayment(Request $request)
    // {
    //     // Extract data from the callback
    //     $trxNo = $request->input('trx_no');
    //     $billId = $request->input('bill_id');
    //     $amount = $request->input('amount');
    //     $referenceNo = $request->input('reference_no');
    //     $walletId = $request->input('wallet_id'); // Try to get wallet_id from the request
    //     $userId = $request->input('user_id'); // Try to get user_id from the request
    //     $email = $request->input('email'); // Get email from the request
    //     $timestamp = $request->input('timestamp');

    //     // Validate required data
    //     if (empty($amount) || (empty($referenceNo) && empty($trxNo) && empty($billId))) {
    //         Log::error('RediPay payment missing required data', [
    //             'data' => $request->all()
    //         ]);
    //         return [
    //             'success' => false,
    //             'message' => 'Missing required payment data'
    //         ];
    //     }

    //     try {
    //         // Use the reference number to identify the transaction
    //         $referenceId = $referenceNo ?: ($trxNo ?: $billId);

    //         // Check if we already processed this transaction
    //         $existingTransaction = Transaction::where('reference_id', $referenceId)
    //             ->where(function($query) {
    //                 $query->where('metadata->provider', 'redipay');
    //             })
    //             ->first();

    //         if ($existingTransaction) {
    //             Log::info('RediPay payment: Transaction already processed', [
    //                 'reference_id' => $referenceId,
    //                 'transaction_id' => $existingTransaction->id
    //             ]);

    //             return [
    //                 'success' => true,
    //                 'message' => 'Payment was already processed successfully'
    //             ];
    //         }



    //         // Find the wallet
    //         $wallet = null;

    //         // If wallet_id is provided in the request, use it
    //         if ($walletId) {
    //             $wallet = Wallet::find($walletId);
    //         }

    //         // If wallet not found by ID, try to find by user ID
    //         if (!$wallet && $userId) {
    //             $user = User::find($userId);
    //             if ($user) {
    //                 $wallet = $user->wallet();
    //             }
    //         }

    //         // If wallet still not found, try to find by user email or name
    //         if (!$wallet) {
    //             // Try to find the user from the email or name in the callback
    //             $email = $request->input('email');
    //             $name = $request->input('name');

    //             $user = null;
    //             if ($email) {
    //                 $user = User::where('email', $email)->first();
    //             } elseif ($name) {
    //                 $user = User::where('name', $name)->first();
    //             }

    //             if (!$user) {
    //                 Log::error('RediPay payment: Unable to identify user', [
    //                     'email' => $email,
    //                     'name' => $name,
    //                     'reference_id' => $referenceId
    //                 ]);

    //                 return [
    //                     'success' => false,
    //                     'message' => 'Unable to identify user account for this payment'
    //                 ];
    //             }

    //             // Get the user's default wallet
    //             $wallet = $user->wallet();
    //         }

    //         if (!$wallet) {
    //             Log::error('RediPay payment: Wallet not found', [
    //                 'wallet_id' => $walletId,
    //                 'reference_id' => $referenceId
    //             ]);

    //             return [
    //                 'success' => false,
    //                 'message' => 'Wallet not found'
    //             ];
    //         }

    //         // Process the deposit
    //         DB::beginTransaction();

    //         try {
    //             // Use wallet service to process the deposit
    //             $walletService = new WalletService();
    //             $result = $walletService->deposit(
    //                 $wallet,
    //                 (float)$amount,
    //                 "Deposit via RediPay",
    //                 'redipay',
    //                 $referenceId
    //             );

    //             DB::commit();

    //             // Calculate fee amount (5%)
    //             $feeAmount = (float)$amount * 0.05;
    //             $netAmount = (float)$amount - $feeAmount;

    //             Log::info("RediPay deposit successful", [
    //                 'wallet_id' => $wallet->id,
    //                 'user_id' => $wallet->user_id,
    //                 'gross_amount' => $amount,
    //                 'fee_amount' => $feeAmount,
    //                 'net_amount' => $netAmount,
    //                 'reference_id' => $referenceId
    //             ]);

    //             return [
    //                 'success' => true,
    //                 'message' => "Payment of MYR " . number_format($amount, 2) . " was successful! (Fee: MYR " . number_format($feeAmount, 2) . ", Net amount: MYR " . number_format($netAmount, 2) . ")"
    //             ];
    //         } catch (\Exception $e) {
    //             DB::rollBack();

    //             Log::error('RediPay payment: Error processing deposit', [
    //                 'error' => $e->getMessage(),
    //                 'trace' => $e->getTraceAsString(),
    //                 'reference_id' => $referenceId
    //             ]);

    //             return [
    //                 'success' => false,
    //                 'message' => 'Error processing deposit: ' . $e->getMessage()
    //             ];
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('RediPay payment: Unexpected error', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return [
    //             'success' => false,
    //             'message' => 'Unexpected error processing payment: ' . $e->getMessage()
    //         ];
    //     }
    // }
    // Update the processPayment method to check and update pending payments
    private function processPayment(Request $request)
    {
        // Extract data from the callback
        $trxNo = $request->input('trx_no');
        $billId = $request->input('bill_id');
        $amount = $request->input('amount');
        $referenceNo = $request->input('reference_no');
        $walletId = $request->input('wallet_id'); // Try to get wallet_id from the request
        $userId = $request->input('user_id'); // Try to get user_id from the request
        $email = $request->input('email'); // Get email from the request
        $timestamp = $request->input('timestamp');

        // Validate required data
        if (empty($amount) || (empty($referenceNo) && empty($trxNo) && empty($billId))) {
            Log::error('RediPay payment missing required data', [
                'data' => $request->all()
            ]);
            return [
                'success' => false,
                'message' => 'Missing required payment data'
            ];
        }

        try {
            // Use the reference number to identify the transaction
            $referenceId = $referenceNo ?: ($trxNo ?: $billId);

            // Check if we already processed this transaction
            $existingTransaction = Transaction::where('reference_id', $referenceId)
                ->where(function($query) {
                    $query->where('metadata->provider', 'redipay');
                })
                ->first();

            if ($existingTransaction) {
                Log::info('RediPay payment: Transaction already processed', [
                    'reference_id' => $referenceId,
                    'transaction_id' => $existingTransaction->id
                ]);

                // Update the pending payment status if it exists
                $pendingPayment = \App\Models\PendingPayment::where('reference_id', $referenceId)->first();
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'completed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'transaction_id' => $existingTransaction->id,
                            'completed_at' => now()->toIso8601String(),
                        ])
                    ]);
                }

                return [
                    'success' => true,
                    'message' => 'Payment was already processed successfully'
                ];
            }

            // Check if we have a pending payment record
            $pendingPayment = \App\Models\PendingPayment::where('reference_id', $referenceId)->first();

            // Find the wallet
            $wallet = null;

            // If we have a pending payment, use its wallet
            if ($pendingPayment) {
                $wallet = Wallet::find($pendingPayment->wallet_id);
                $userId = $pendingPayment->user_id;
            }

            // If wallet not found from pending payment, try other methods
            if (!$wallet) {
                // If wallet_id is provided in the request, use it
                if ($walletId) {
                    $wallet = Wallet::find($walletId);
                }

                // If wallet not found by ID, try to find by user ID
                if (!$wallet && $userId) {
                    $user = User::find($userId);
                    if ($user) {
                        $wallet = $user->wallet();
                    }
                }

                // If wallet still not found, try to find by user email or name
                if (!$wallet) {
                    // Try to find the user from the email or name in the callback
                    $email = $request->input('email');
                    $name = $request->input('name');

                    $user = null;
                    if ($email) {
                        $user = User::where('email', $email)->first();
                    } elseif ($name) {
                        $user = User::where('name', $name)->first();
                    }

                    if (!$user) {
                        Log::error('RediPay payment: Unable to identify user', [
                            'email' => $email,
                            'name' => $name,
                            'reference_id' => $referenceId
                        ]);

                        return [
                            'success' => false,
                            'message' => 'Unable to identify user account for this payment'
                        ];
                    }

                    // Get the user's default wallet
                    $wallet = $user->wallet();
                }
            }

            if (!$wallet) {
                Log::error('RediPay payment: Wallet not found', [
                    'wallet_id' => $walletId,
                    'reference_id' => $referenceId
                ]);

                return [
                    'success' => false,
                    'message' => 'Wallet not found'
                ];
            }

            // Process the deposit
            DB::beginTransaction();

            try {
                // Use wallet service to process the deposit
                $walletService = new WalletService();
                $result = $walletService->deposit(
                    $wallet,
                    (float)$amount,
                    "Deposit via RediPay",
                    'redipay',
                    $referenceId
                );

                // Update the pending payment if it exists
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'completed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'transaction_id' => $result['deposit']->id,
                            'completed_at' => now()->toIso8601String(),
                        ])
                    ]);
                }

                DB::commit();

                // Calculate fee amount (5%)
                $feeAmount = (float)$amount * 0.05;
                $netAmount = (float)$amount - $feeAmount;

                Log::info("RediPay deposit successful", [
                    'wallet_id' => $wallet->id,
                    'user_id' => $wallet->user_id,
                    'gross_amount' => $amount,
                    'fee_amount' => $feeAmount,
                    'net_amount' => $netAmount,
                    'reference_id' => $referenceId
                ]);

                return [
                    'success' => true,
                    'message' => "Payment of MYR " . number_format($amount, 2) . " was successful! (Fee: MYR " . number_format($feeAmount, 2) . ", Net amount: MYR " . number_format($netAmount, 2) . ")"
                ];
            } catch (\Exception $e) {
                DB::rollBack();

                // Update the pending payment with the error if it exists
                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'failed',
                        'last_checked_at' => now(),
                        'metadata' => array_merge($pendingPayment->metadata ?? [], [
                            'error' => $e->getMessage(),
                            'failed_at' => now()->toIso8601String(),
                        ])
                    ]);
                }

                Log::error('RediPay payment: Error processing deposit', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'reference_id' => $referenceId
                ]);

                return [
                    'success' => false,
                    'message' => 'Error processing deposit: ' . $e->getMessage()
                ];
            }
        } catch (\Exception $e) {
            Log::error('RediPay payment: Unexpected error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Unexpected error processing payment: ' . $e->getMessage()
            ];
        }
    }
}

