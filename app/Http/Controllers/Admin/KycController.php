<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Services\KycService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class KycController extends Controller
{
    protected $kycService;

    public function __construct(KycService $kycService)
    {
        $this->kycService = $kycService;
    }

    public function index()
    {
        if (Gate::denies('viewAny', Kyc::class)) {
            abort(403);
        }

        $kycs = Kyc::with('user')->latest()->paginate(10);
        return view('admin.kyc.index', compact('kycs'));
    }

    public function show(Kyc $kyc)
    {
        if (Gate::denies('view', $kyc)) {
            abort(403);
        }

        return view('admin.kyc.show', compact('kyc'));
    }

    public function updateVerificationStatus(Request $request, Kyc $kyc)
    {
        if (Gate::denies('verify', $kyc)) {
            abort(403);
        }

        $request->validate([
            'verification_status' => 'required|in:pass,fail',
            'verification_notes' => 'nullable|string|max:500',
        ]);

        $this->kycService->updateVerificationStatus(
            $kyc,
            $request->verification_status,
            $request->verification_notes
        );

        return redirect()
            ->route('admin.kyc.show', $kyc)
            ->with('success', 'KYC verification status updated successfully.');
    }

    public function approve(Request $request, Kyc $kyc)
    {
        if (Gate::denies('approve', $kyc)) {
            abort(403);
        }

        $request->validate([
            'approval_note' => 'nullable|string|max:500',
        ]);

        $this->kycService->approveKyc($kyc, $request->approval_note);

        return redirect()
            ->route('admin.kyc.index')
            ->with('success', 'KYC application approved successfully.');
    }

    public function reject(Request $request, Kyc $kyc)
    {
        if (Gate::denies('reject', $kyc)) {
            abort(403);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $this->kycService->rejectKyc($kyc, $request->rejection_reason);

        return redirect()
            ->route('admin.kyc.index')
            ->with('success', 'KYC application rejected successfully.');
    }

    public function kiv(Request $request, Kyc $kyc)
    {
        if (Gate::denies('kiv', $kyc)) {
            abort(403);
        }

        $request->validate([
            'kiv_reason' => 'required|string|max:500',
        ]);

        $this->kycService->kivKyc($kyc, $request->kiv_reason);

        return redirect()
            ->route('admin.kyc.index')
            ->with('success', 'KYC application marked as KIV successfully.');
    }

    public function requestAdditionalInfo(Request $request, Kyc $kyc)
    {
        if (Gate::denies('kiv', $kyc)) {
            abort(403);
        }

        $request->validate([
            'request_details' => 'required|string|max:500',
        ]);

        $this->kycService->requestAdditionalInfo($kyc, $request->request_details);

        return redirect()
            ->route('admin.kyc.index')
            ->with('success', 'Additional information requested successfully.');
    }
}

