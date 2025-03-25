<?php

namespace App\Livewire\Admin\Countries;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class CountryList extends Component
{
    use WithPagination;

    public $search = '';
    public $region = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'region' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRegion()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function toggleCountryStatus($countryId)
    {
        $country = Country::findOrFail($countryId);
        $country->is_active = !$country->is_active;
        $country->save();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Country status updated successfully!'
        ]);
    }

    public function render()
    {
        $countries = Country::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('code_alpha2', 'like', '%' . $this->search . '%')
                      ->orWhere('currency_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->region, function ($query) {
                return $query->where('region', $this->region);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Get unique regions for filter
        $regions = Country::select('region')
            ->distinct()
            ->whereNotNull('region')
            ->orderBy('region')
            ->pluck('region');

        return view('livewire.admin.countries.country-list', [
            'countries' => $countries,
            'regions' => $regions
        ]);
    }
}

