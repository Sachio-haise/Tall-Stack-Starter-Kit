<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;
    #[Locked]
    public $id;
    public $field = ['id', 'name', 'created_at', 'updated_at', 'deleted_at'];

    // Show search and controls
    public $is_search;
    public $is_search_period = false;
    public $is_search_show = false;

    // search
    public $search = '';
    public $include_deleted;

    // Pagination
    public $limit = 10;
    public $duration = '';
    public $sortField = 'id';
    public $sortAsc = true;

    // Other assistant
    public $permission;
    public $livePermission;
    public $breadcrumbs;
    public $title;
    public $total;
    public $super_admin;

    public function mount()
    {
        $this->super_admin = $this->checkSuperAdmin();
        $this->title = 'Roles';
        $this->getUserBy();
    }

    #[On('search')]
    public function getSearchData($search, $include_deleted, $limit, $duration)
    {
        $this->search = $search;
        $this->include_deleted = $include_deleted;
        $this->limit = $limit;
        $this->duration = $duration;
        $this->resetPage();
    }

    #[On('dispatch-roles-create')]
    #[On('dispatch-roles-update')]
    public function render()
    {
        $lists = $this->getLists();
        $permission = $this->permission;
        return view('livewire.role.index', compact('lists', 'permission'));
    }

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    protected function getLists()
    {
        $query = Role::select($this->field)
            ->when($this->search, fn ($query) => $this->applySearchConditions($query))
            ->when($this->include_deleted == 1, fn ($query) => $query->withTrashed())
            ->when($this->duration, fn ($query) => $this->applyDurationConditions($query))
            ->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc');
        return $query->paginate($this->limit);
    }

    protected function applySearchConditions($query)
    {
        return $query->where(function ($query) {
            $query->where('name', 'LIKE', "%$this->search%");
        });
    }

    protected function applyDurationConditions($query)
    {
        $today = now()->startOfDay();
        switch ($this->duration) {
            case 'today':
                $query->whereDate('created_at', $today);
                break;
            case 'this week':
                $query->whereBetween('created_at', [$today->startOfWeek(), $today->endOfWeek()]);
                break;
            case 'this month':
                $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
                break;
            case 'this year':
                $query->whereYear('created_at', now()->year);
                break;
        }
        return $query;
    }

    protected function checkSuperAdmin()
    {
        return auth()
            ->user()
            ->hasRole('root');
    }

    protected function checkPermission(array $permission, $data = null)
    {
        if (in_array($data, $permission)) {
            return true;
        } else {
            return false;
        }
    }

    protected function getUserBy()
    {
        $permission = $this->checkPermission($this->livePermission, 'roles_status');
        if ($permission) {
            $this->field[] = 'created_by';
            $this->field[] = 'updated_by';
        }
    }
}
