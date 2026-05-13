<?php

namespace App\Livewire;

use App\Models\orderapprovedtable;
use Livewire\Component;
use Livewire\WithPagination;

class Adminorderhistory extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $approvedata = orderapprovedtable::query()
            ->whereNull('approveuserid')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoiceno', 'like', '%' . $this->search . '%')
                        ->orWhere('invoicedate', 'like', '%' . $this->search . '%')
                        ->orWhere('framname', 'like', '%' . $this->search . '%')
                        ->orWhere('gstnumber', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('contactno', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('region', 'like', '%' . $this->search . '%')
                        ->orWhere('address', 'like', '%' . $this->search . '%')
                        ->orWhere('productname', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.adminorderhistory', [
            'approve' => $approvedata
        ])->layout('layouts.header');
    }
}