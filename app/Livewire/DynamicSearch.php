<?php

namespace App\Livewire;

use App\Models\Movie;
use App\Models\Song;
use Livewire\Component;
use Livewire\WithPagination;
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
    protected $paginationTheme = 'tailwind';

    public function mount($model, $columns = [])
    {
        $this->model = $model;
        $this->columns = $columns;
    }

    public function updatingQuery()
    {
        $this->resetPage();
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

        $selectColumns = array_merge(['id'], $this->columns);

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
            ->orderByDesc('created_at')
            ->paginate(10);


        return view('livewire.dynamic-search', [
            'records' => $results,
        ]);
    }
}
