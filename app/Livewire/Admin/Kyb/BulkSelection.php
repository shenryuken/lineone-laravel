<?php

namespace App\Livewire\Admin\Kyb;

use Livewire\Component;

class BulkSelection extends Component
{
  public $kybId;
  public $isSelected = false;

  protected $listeners = ['selectAll' => 'selectItem', 'deselectAll' => 'deselectItem'];

  public function mount()
  {
        //$this->isSelected = in_array((string) $this->kybId, $this->getSelectedKybs());
        $this->dispatch('checkSelection', $this->kybId)->to('admin.kyb.bulk-actions');
  }

//   public function updatedIsSelected()
//   {
//       $selectedKybs = $this->getSelectedKybs();

//       if ($this->isSelected) {
//           if (!in_array((string) $this->kybId, $selectedKybs)) {
//               $selectedKybs[] = (string) $this->kybId;
//           }
//       } else {
//           $selectedKybs = array_filter($selectedKybs, function ($id) {
//               return $id !== (string) $this->kybId;
//           });
//       }

//       $this->dispatch('setSelectedKybs', $selectedKybs)->to('admin.kyb.bulk-actions');
//   }
  public function updatedIsSelected()
  {
      if ($this->isSelected) {
          $this->dispatch('addToSelection', $this->kybId)->to('admin.kyb.bulk-actions');
      } else {
          $this->dispatch('removeFromSelection', $this->kybId)->to('admin.kyb.bulk-actions');
      }
  }

  public function selectItem()
  {
      $this->isSelected = true;
  }

  public function deselectItem()
  {
      $this->isSelected = false;
  }

   public function setSelectionState($isSelected)
  {
      $this->isSelected = $isSelected;
  }

  private function getSelectedKybs()
  {
      return $this->dispatch('getSelectedKybs')->to('admin.kyb.bulk-actions');
  }

  public function render()
  {
      return view('livewire.admin.kyb.bulk-selection');
  }
}

