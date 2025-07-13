<?php

namespace App\DataTables;

use App\Models\BukuTamu;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BukuTamuDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d F Y H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('d F Y H:i:s');
            })
            ->addColumn('action', function ($row) {
                $action = '';
                $action = '<button type="button" data-id=' . $row->id . ' data-jenis="edit" class="btn btn-warning btn-sm me-1 action"><i class="bi bi-pencil text-white"></i></button>';
                if ($row->status === 0) {
                    $action .= '<button type="button" data-id=' . $row->id . ' data-jenis="status" class="btn btn-success btn-sm me-1 action"><i class="bi bi-check2 text-white"></i></button>';
                } elseif ($row->status === 1) {
                    $action .= '<button type="button" data-id=' . $row->id . ' data-jenis="status" class="btn btn-secondary btn-sm me-1 action"><i class="bi bi-check2 text-white"></i></button>';
                }
                $action .= '<button type="button" data-id=' . $row->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="bi bi-trash"></i></button>';

                return $action;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(BukuTamu $model): QueryBuilder
    {
        return $model->newQuery()->with('staf')->latest()->whereDate('created_at', Carbon::today());
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('table table-bordered table-striped mb-0')
            ->setTableId('bukutamu-table')
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
            Column::make('nama')->addClass('align-middle'),
            Column::make('telepon')->addClass('text-center align-middle'),
            Column::make('instansi')->addClass('text-center align-middle'),
            Column::make('staf.nama')->title('Ingin Bertemu')->addClass('text-center align-middle'),
            Column::make('created_at')->addClass('text-center align-middle'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BukuTamu_' . date('YmdHis');
    }
}
