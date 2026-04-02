<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class DynamicSearch extends Component
{
    use WithPagination;

    public $query = '';
    public $isSearching = false;
    public $model = '';
    public $modelRoute = 'App\\Models\\';
    public $columns = [];
    public $isFrontend = false;
    public $viewType = 'table'; // 'table' or 'grid'
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    protected $paginationTheme = 'tailwind';

    public function mount($model, $columns = [], $isFrontend = false, $viewType = 'table')
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->isFrontend = $isFrontend;
        $this->viewType = session()->get('admin_view_type_' . $model, $viewType);
    }

    public function setViewType($type)
    {
        $this->viewType = $type;
        session()->put('admin_view_type_' . $this->model, $type);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearSearch()
    {
        $this->query = '';
        $this->resetPage();
    }

    public function render()
    {
        $this->isSearching = strlen($this->query) > 0;

        $modelClass = $this->modelRoute . $this->model;

        $selectColumns = array_unique(array_merge(['id', 'slug', 'created_at'], $this->columns));

        $results = $modelClass::query()
            ->select($selectColumns)
            ->when($this->isSearching, function ($q) {
                $q->where(function ($sub) {
                    foreach ($this->columns as $col) {
                        if (!str_contains($col, 'image')) {
                            $sub->orWhere($col, 'like', '%' . $this->query . '%');
                        }
                    }
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->viewType === 'grid' ? 12 : 10);


        return view('livewire.dynamic-search', [
            'records' => $results,
        ]);
    }
}
