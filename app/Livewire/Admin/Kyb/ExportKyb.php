<?php

namespace App\Livewire\Admin\Kyb;

use App\Models\Kyb;
use Livewire\Component;
use Illuminate\Support\Facades\Response;
use League\Csv\Writer;

class ExportKyb extends Component
{
    public $exportFormat = 'csv';
    public $dateFrom;
    public $dateTo;
    public $statusFilter = [];
    public $exportModalOpen = false;

    public function mount()
    {
        $this->dateFrom = now()->subMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
        $this->statusFilter = ['pending', 'approved', 'rejected', 'additional_info'];
    }

    public function openExportModal()
    {
        $this->exportModalOpen = true;
    }

    public function exportData()
    {
        $this->validate([
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date|after_or_equal:dateFrom',
            'statusFilter' => 'required|array|min:1',
        ]);

        $kybs = Kyb::with('user')
            ->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
            ->whereIn('status', $this->statusFilter)
            ->get();

        if ($kybs->isEmpty()) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'warning',
                'message' => __('No data found for the selected criteria.')
            ]);
            return;
        }

        $fileName = 'kyb_export_' . now()->format('Y-m-d_His');

        if ($this->exportFormat === 'csv') {
            return $this->exportToCsv($kybs, $fileName);
        } elseif ($this->exportFormat === 'json') {
            return $this->exportToJson($kybs, $fileName);
        }

        $this->exportModalOpen = false;
    }

    private function exportToCsv($kybs, $fileName)
    {
        $csv = Writer::createFromString('');

        // Add headers
        $csv->insertOne([
            'ID',
            'Business Name',
            'Registration Number',
            'Business Type',
            'Status',
            'User Email',
            'Submitted Date',
            'Last Updated',
        ]);

        // Add data
        foreach ($kybs as $kyb) {
            $csv->insertOne([
                $kyb->id,
                $kyb->legal_name,
                $kyb->registration_number,
                ucfirst(str_replace('_', ' ', $kyb->business_type)),
                ucfirst($kyb->status),
                $kyb->user->email,
                $kyb->created_at->format('Y-m-d H:i:s'),
                $kyb->updated_at->format('Y-m-d H:i:s'),
            ]);
        }

        $this->exportModalOpen = false;

        return response((string) $csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$fileName}.csv");
    }

    private function exportToJson($kybs, $fileName)
    {
        $data = $kybs->map(function ($kyb) {
            return [
                'id' => $kyb->id,
                'business_name' => $kyb->legal_name,
                'registration_number' => $kyb->registration_number,
                'business_type' => ucfirst(str_replace('_', ' ', $kyb->business_type)),
                'status' => ucfirst($kyb->status),
                'user_email' => $kyb->user->email,
                'submitted_date' => $kyb->created_at->format('Y-m-d H:i:s'),
                'last_updated' => $kyb->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        $this->exportModalOpen = false;

        return response()->json($data)
            ->header('Content-Disposition', "attachment; filename={$fileName}.json");
    }

    public function render()
    {
        return view('livewire.admin.kyb.export-kyb');
    }
}

