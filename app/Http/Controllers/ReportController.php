<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    public function index()
    {
        return view('report');
    }

    public function pdf()
    {
        return App::make('dompdf.wrapper')
            ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('report-pdf', [
                'data' => $this->getReportData()
            ])
            ->stream();
    }

    private function getReportData()
    {
        $sql = "select
        (select l.name from locations l where l.id = i.location_id and l.deleted_at is null) as location,
        (select c.name from categories c where c.id = i.parent_category_id and c.deleted_at is null) as parent_category,
        (select c.name from categories c where c.id = i.category_id and c.deleted_at is null) as category,
        i.location_id,
        i.category_id,
        i.parent_category_id,
        count(i.id) as total
        from items i 
        where i.deleted_at is null and i.price >= ?
        group by
        i.location_id,
        i.category_id,
        i.parent_category_id
        order by i.location_id";

        $result = DB::select(DB::raw($sql), [request()->get('price', 0)]);

        return is_array($result) ? $result : $result->get();
    }
}
