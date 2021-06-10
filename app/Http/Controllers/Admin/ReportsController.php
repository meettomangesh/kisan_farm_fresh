<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ReportsController extends Controller
{
    public function salesItemwise()
    {
        abort_if(Gate::denies('report_sales_itemwise_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesItemsData = DB::table('customer_orders AS co')
            ->leftJoin('customer_order_details AS cod', 'co.id', '=', 'cod.order_id')
            ->leftJoin('products AS p', 'p.id', '=', 'cod.products_id')
            ->leftJoin('product_units AS pu', 'pu.id', '=', 'cod.product_units_id')
            ->leftJoin('unit_master AS um', 'um.id', '=', 'pu.unit_id');

        $salesItemsData->select([
            DB::raw('co.id AS order_id'),
            DB::raw('p.product_name'),
            DB::raw('um.unit'),
            DB::raw('cod.item_quantity'),
            DB::raw('cod.selling_price'),
            DB::raw('cod.special_price'),
            DB::raw('DATE(cod.created_at) AS order_date'),
            DB::raw('cod.is_basket'),
            DB::raw('IF(cod.is_basket = 0, "", (
                SELECT GROUP_CONCAT(CONCAT(pn.product_name, " (", umn.unit, ")")) FROM customer_order_details_basket AS codb
                JOIN products AS pn ON pn.id = codb.products_id
                JOIN product_units AS pun ON pun.id = codb.product_units_id
                JOIN unit_master AS umn ON umn.id = pun.unit_id
                WHERE codb.order_id = cod.order_id AND codb.order_details_id = cod.id
            )) AS basket_products'),
            /* DB::raw('CASE 
                    WHEN cod.order_status = 0 THEN "Pending"
                    WHEN cod.order_status = 1 THEN "Placed"
                    WHEN cod.order_status = 2 THEN "Picked"
                    WHEN cod.order_status = 3 THEN "Out for delivery"
                    WHEN cod.order_status = 4 THEN "Delivered"
                    WHEN cod.order_status = 5 THEN "Cancelled"
                    ELSE "" END AS order_status
                    ') */
            DB::raw('cod.order_status'),
        ]);

        // $salesItemsData->where('pmer.expiry_date', '>=', $expiryDate . "");
        
        $salesItemsData = collect($salesItemsData->get());
        // print_r($salesItemsData); exit;
        $srNo = 1;
        return view('admin.reports.sales_itemwise', compact('srNo','salesItemsData'));
    }
}
