<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ToyyibPayService
{
    protected $baseUrl;
    protected $apiKey;
    protected $categoryCode;

    public function __construct()
    {
        $this->baseUrl = config('toyyibpay.base_url', 'https://toyyibpay.com');
        $this->apiKey = config('toyyibpay.key');
        $this->categoryCode = config('toyyibpay.category');

        Log::info('ToyyibPay Service Initialized', [
            'baseUrl' => $this->baseUrl,
            'apiKey' => $this->apiKey ? 'Set (length: ' . strlen($this->apiKey) . ')' : 'Not Set',
            'categoryCode' => $this->categoryCode
        ]);
    }

    public function createBill(array $billData)
    {
        // Ensure the API key and category code are set
        $billData['userSecretKey'] = $this->apiKey;
        $billData['categoryCode'] = $this->categoryCode;

        Log::info('Creating ToyyibPay bill', [
            'endpoint' => "{$this->baseUrl}/index.php/api/createBill",
            'userSecretKey' => $this->apiKey,
            'categoryCode' => $this->categoryCode
        ]);

        return Http::asForm()->post("{$this->baseUrl}/index.php/api/createBill", $billData);
    }

    public function getBillPaymentStatus($billCode)
    {
        Log::info('Getting ToyyibPay bill status', [
            'billCode' => $billCode,
            'endpoint' => "{$this->baseUrl}/index.php/api/getBillTransactions",
            'userSecretKey' => $this->apiKey
        ]);

        $response = Http::asForm()->post("{$this->baseUrl}/index.php/api/getBillTransactions", [
            'billCode' => $billCode,
            'userSecretKey' => $this->apiKey
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Log::info('ToyyibPay bill status response', ['data' => $data]);
            return $data;
        }

        Log::error('ToyyibPay getBillPaymentStatus failed', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        throw new \Exception('Failed to get bill payment status: ' . $response->body());
    }
}

