<?php

namespace App\Livewire\Admin\Kyb;

use App\Models\Kyb;
use App\Models\KybStatusHistory;
use App\Notifications\KybStatusUpdated;
use Livewire\Component;

class BulkActions extends Component
{
  public $selectedKybs = [];
  public $selectAll = false;
  public $bulkAction = '';
  public $comment = '';
  public $bulkModalOpen = false;

  protected $listeners = [
      'refreshKybList' => '$refresh',
      'addToSelection' => 'addToSelection',
      'removeFromSelection' => 'removeFromSelection',
      'checkSelection' => 'checkSelection',
  ];

  public function mount()
  {
      $this->resetSelections();
  }

  public function updatedSelectAll($value)
  {
      if ($value) {
          $this->selectedKybs = Kyb::where('status', 'pending')->pluck('id')->map(function ($id) {
              return (string) $id;
          })->toArray();
      } else {
          $this->resetSelections();
      }
  }

  public function resetSelections()
  {
      $this->selectedKybs = [];
      $this->selectAll = false;
  }

  public function addToSelection($kybId)
  {
      if (!in_array((string) $kybId, $this->selectedKybs)) {
          $this->selectedKybs[] = (string) $kybId;
      }
  }

  public function removeFromSelection($kybId)
  {
      $this->selectedKybs = array_filter($this->selectedKybs, function ($id) use ($kybId) {
          return $id !== (string) $kybId;
      });
  }

   public function checkSelection($kybId)
  {
      $isSelected = in_array((string) $kybId, $this->selectedKybs);
      $this->dispatch('setSelectionState', $isSelected)->to('admin.kyb.bulk-selection');
  }

  public function confirmBulkAction($action)
  {
      if (empty($this->selectedKybs)) {
          $this->dispatch('notify', [
              'type' => 'warning',
              'message' => __('Please select at least one application.')
          ]);
          return;
      }

      $this->bulkAction = $action;
      $this->bulkModalOpen = true;
  }

  public function executeBulkAction()
  {
      if (empty($this->selectedKybs)) {
          $this->dispatch('notify', [
              'type' => 'error',
              'message' => 'No applications selected'
          ]);
          return;
      }

      // Validate action type
      if (!in_array($this->bulkAction, ['approved', 'rejected', 'kiv'])) {
          $this->dispatch('notify', [
              'type' => 'error',
              'message' => 'Invalid action type'
          ]);
          return;
      }

      // Add validation for required comments
      if ($this->bulkAction === 'rejected' && empty($this->comment)) {
          $this->dispatch('notify', [
              'type' => 'error',
              'message' => 'Rejection reason is required'
          ]);
          return;
      }

      $this->bulkModalOpen = false;
      $count = 0;
      $status = $this->bulkAction;

      foreach ($this->selectedKybs as $kybId) {
          $kyb = Kyb::find($kybId);

          if (!$kyb || $kyb->status !== 'pending') {
              continue;
          }

          // Update KYB status
          $kyb->status = $status;

          if ($status === 'approved') {
              $kyb->approved_at = now();
              $kyb->approved_by = auth()->id();
          } elseif ($status === 'rejected') {
              $kyb->rejected_at = now();
              $kyb->rejected_by = auth()->id();
              $kyb->rejection_reason = $this->comment;
          }

          $kyb->save();

          // Create status history record
          KybStatusHistory::create([
              'kyb_id' => $kyb->id,
              'status' => $status,
              'comment' => $this->comment,
              'user_id' => auth()->id(),
          ]);

          // Notify the user
          $kyb->user->notify(new KybStatusUpdated($kyb));

          $count++;
      }

      $this->dispatch('notify', [
          'type' => 'success',
          'message' => __(':count applications have been :action.', [
              'count' => $count,
              'action' => $status === 'approved' ? 'approved' : 'rejected'
          ])
      ]);

      $this->resetForm();
      $this->dispatch('refreshKybList');
  }

  public function resetForm()
  {
      $this->resetSelections();
      $this->bulkAction = '';
      $this->comment = '';
      $this->bulkModalOpen = false;
  }

  public function render()
  {
      return view('livewire.admin.kyb.bulk-actions', [
          'selectedCount' => count($this->selectedKybs),
      ]);
  }
}

