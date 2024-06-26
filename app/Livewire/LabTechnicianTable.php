<?php

namespace App\Livewire;

use App\Models\LabTechnician;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\Lazy;

#[Lazy]
class LabTechnicianTable extends LivewireTableComponent
{
    public $showButtonOnHeader = true;

    public $showFilterOnHeader = true;

    public $paginationIsEnabled = true;

    public $buttonComponent = 'lab_technicians.templates.button.add-button';

    public $FilterComponent = ['lab_technicians.templates.button.filter-button', LabTechnician::FILTER_STATUS_ARR];

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

    protected $model = LabTechnician::class;

    // public function resetPage($pageName = 'page')
    // {
    //     $rowsPropertyData = $this->getRows()->toArray();
    //     $prevPageNum = $rowsPropertyData['current_page'] - 1;
    //     $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
    //     $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

    //     $this->setPage($pageNum, $pageName);
    // }

    public function changeFilter($status)
    {
        $this->resetPage($this->getComputedPageName());
        $this->statusFilter = $status;
        $this->setBuilder($this->builder());
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('lab_technicians.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function placeholder()
    {
        return view('livewire.skeleton_files.common_skeleton_af');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.lab_technicians'), 'user.first_name')
                ->sortable()
                ->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                })
                ->view('lab_technicians.templates.column.lab_technicians'),
            Column::make('email','user.email')->searchable()->hideIf(1),
            Column::make(__('messages.user.designation'), 'user.designation')
                ->view('lab_technicians.templates.column.designation')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.status'), 'id')
                ->searchable()
                ->view('lab_technicians.templates.column.status'),
            Column::make(__('messages.common.action'), 'id')
                ->view('lab_technicians.templates.button.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = LabTechnician::whereHas('user')->with('user')->select('lab_technicians.*');

        $query->when(isset($this->statusFilter), function (Builder $q) {
            $q->whereHas('user', function (Builder $query) {
                if ($this->statusFilter == 1) {
                    $query->where('status', LabTechnician::ACTIVE);
                }
                if ($this->statusFilter == 2) {
                    $query->where('status', LabTechnician::INACTIVE);
                }
            });
        });

        return $query;
    }
}
