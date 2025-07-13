<?php

namespace App\DataTables;

use App\Models\Staf;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StafDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('foto', function ($row) {
                $fotoPath = $row->foto ? asset('storage/' . $row->foto) : asset('assets/img/avatar.png');

                return '<img src="' . $fotoPath . '"  class="img-fluid avatar avatar-sm" alt="Foto ' . $row->nama . '">';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d F Y H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('d F Y H:i:s');
            })
            ->addColumn('action', function ($row) {
                $action = '';
                $showUrl = route('staf.show', $row->id);
                $action = '<a href="' . $showUrl . '" class="btn btn-info btn-sm me-1" title="Detail"><i class="text-white bi bi-eye-fill"></i></a>';
                $action .= '<button type="button" data-id=' . $row->id . ' data-jenis="edit" class="btn btn-warning btn-sm me-1 action"><i class="text-white bi bi-pencil"></i></button>';
                $action .= '<button type="button" data-id=' . $row->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="bi bi-trash"></i></button>';

                return $action;
            })
            ->rawColumns(['action', 'foto'])
            ->setRowId('id');
    }

    public function query(Staf $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('table table-bordered table-striped mb-0')
            ->setTableId('staf-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->language([
                'search' => '_INPUT_',
                'searchPlaceholder' => 'Cari...',
                'lengthMenu' => '_MENU_ Data Per Halaman',
                'info' => 'Menampilkan _START_ Sampai _END_ Dari _TOTAL_ Data',
                'infoEmpty' => 'Menampilkan 0 Sampai 0 Dari 0 Data',
                'infoFiltered' => '(Disaring Dari _MAX_ total Data)',
                'emptyTable' => 'Tidak Ada Data Yang Tersedia',
            ])
            ->orderBy(1)
            ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->addClass('text-center align-middle')->width(1),
            Column::make('foto')->title('Foto')->addClass('text-center align-middle')->width(80)->searchable(false)->orderable(false),
            Column::make('nama')->addClass('align-middle'),
            Column::make('telepon')->addClass('text-center align-middle'),
            Column::make('kelamin')->title('Jenis Kelamin')->addClass('text-center align-middle'),
            Column::make('created_at')->title('Terdaftar')->addClass('text-center align-middle'),
            Column::make('updated_at')->title('Diperbaharui')->addClass('text-center align-middle'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(125)
                ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Staf_' . date('YmdHis');
    }
}
