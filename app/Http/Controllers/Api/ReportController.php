<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return response($this->getReportData());
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
