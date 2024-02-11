<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SearchForm extends Component
{
    public $search;
    public $include_deleted;
    public $limit;
    public $duration;
    public $is_search_period;
    public $is_deleted_show;
    public $is_search_show;
    public $is_search_component;
    protected $listeners = [
        'search',
    ];

    public function mount($search = null, $include_deleted = false, $limit = 10, $duration = null, $is_deleted_show = true)
    {
        $this->search = $search;
        $this->include_deleted = $include_deleted;
        $this->limit = $limit;
        $this->duration = $duration;
        $this->is_deleted_show = $is_deleted_show;
    }

    public function updatedSearch()
    {
        $this->dispatch('search', $this->search, $this->include_deleted, $this->limit, $this->duration);
    }

    public function updatedIncludeDeleted()
    {
        $this->dispatch('search', $this->search, $this->include_deleted, $this->limit, $this->duration);
    }

    public function updatedLimit()
    {
        $this->dispatch('search', $this->search, $this->include_deleted, $this->limit, $this->duration);
    }

    #[On('search-duration')]
    public function updatedDuration($duration)
    {
        $this->duration = $duration;
        $this->dispatch('search', $this->search, $this->include_deleted, $this->limit, $this->duration);
    }

    public function render()
    {
        return view('livewire.search-form');
    }
}
