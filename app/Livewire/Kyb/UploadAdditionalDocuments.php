<?php

namespace App\Livewire\Kyb;

use App\Models\Kyb;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadAdditionalDocuments extends Component
{
    use WithFileUploads;

    public Kyb $kyb;
    public $additional_document;
    public $additional_document_type = 'supporting_document';
    public $additional_info_response;
    public $documents = [];

    public function mount(Kyb $kyb)
    {
        $this->kyb = $kyb;
        $this->additional_info_response = $kyb->additional_info_response;
    }

    protected function rules()
    {
        return [
            'additional_document' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
            'additional_document_type' => 'required|string|max:255',
            'additional_info_response' => 'required|string|max:1000',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addDocument()
    {
        $this->validate([
            'additional_document' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
            'additional_document_type' => 'required|string|max:255',
        ]);

        $document = [
            'file' => $this->additional_document,
            'type' => $this->additional_document_type,
            'name' => $this->additional_document->getClientOriginalName(),
        ];

        $this->documents[] = $document;

        // Reset form
        $this->additional_document = null;
        $this->additional_document_type = 'supporting_document';

        $this->dispatch('document-added');
    }

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents);
    }

    public function submit()
    {
        $this->validate([
            'additional_info_response' => 'required|string|max:1000',
        ]);

        if (empty($this->documents)) {
            $this->addError('additional_document', 'Please add at least one document.');
            return;
        }

        try {
            $folderPath = 'kyb_documents/' . $this->kyb->user_id . '/additional';
            $storedDocuments = [];

            foreach ($this->documents as $document) {
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9.]/', '_', $document['name']);
                $path = $document['file']->storeAs($folderPath, $filename, 'public');

                $storedDocuments[] = [
                    'type' => $document['type'],
                    'path' => $path,
                    'name' => $document['name'],
                    'uploaded_at' => now()->toDateTimeString(),
                ];
            }

            // Store response and documents in the database
            $this->kyb->additional_info_response = $this->additional_info_response;
            $this->kyb->additional_info_responded_at = now();

            // Save additional documents as JSON
            $existingDocs = json_decode($this->kyb->additional_documents, true) ?: [];
            $this->kyb->additional_documents = json_encode(array_merge($existingDocs, $storedDocuments));

            // Reset status to pending if it was in KIV
            if ($this->kyb->status === 'kiv') {
                $this->kyb->status = 'pending';
                $this->kyb->verification_status = 'pending';
            }

            $this->kyb->save();

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Additional documents uploaded successfully.'
            ]);

            return redirect()->route('kyb.dashboard');

        } catch (\Exception $e) {
            Log::error('KYB document upload error: ' . $e->getMessage());
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'There was an error uploading your documents. Please try again.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.kyb.upload-additional-documents');
    }
}

