<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSupplierController extends Controller
{
    private function getHeadersValuesTable() : Array
    {
        $headers = [
            (object) [ 'key' => 'id', 'label' => 'Código' ],
            (object) [ 'key' => 'product_name', 'label' => 'Produto' ],
            (object) [ 'key' => 'description', 'label' => 'Descrição' ],
            (object) [ 'key' => 'amount', 'label' => 'Quantidade' ]
        ];

        $query = <<<SQL
            select distinct s."name"
            from products p
            join product_supplier ps on ps.product_id = p.id
            join suppliers s on s.id = ps.supplier_id
        SQL;

        $data = DB::select($query);

        foreach ($data as $key => $value) {
            $headers[] = (object) [
                'key' => $value->name,
                'label' => $value->name
            ];
        }

        return $headers;
    }

    public function valuesTable() : JsonResponse
    {
        $headers = $this->getHeadersValuesTable();

        $query = <<<SQL
            select
                p.id,
                p."name" as product_name,
                p.description,
                p.amount,
                ps.supplier_id,
                s."name" as supplier_name,
                ps.value,
                ps.is_winner
            from products p
            join product_supplier ps on ps.product_id = p.id
            join suppliers s on s.id = ps.supplier_id
        SQL;

        $data = DB::select($query);

        $collect = collect($data)->groupBy('product_name');

        $transformedProducts = $collect->map(function($group) {
            $base = [
                'id' => $group->first()->id,
                'product_name' => $group->first()->product_name,
                'description' => $group->first()->description,
                'amount' => $group->first()->amount,
            ];

            $suppliers = [];

            foreach ($group as $item) {
                $suppliers[$item->supplier_name] = (object) [
                    'value' => $item->value,
                    'supplier_id' => $item->supplier_id,
                    'is_winner' => $item->is_winner
                ];
            }

            return array_merge($base, $suppliers);
        });

        $transformedProducts = $transformedProducts->sortBy('id')->all();

        return response()->json(['values_table' => $transformedProducts, 'headers' => $headers]);
    }

    public function updateValueSupplier(Request $request) : JsonResponse
    {
        $product_id = $request->item['id'];
        $supplier_id = $request->item[$request->item['col']]['supplier_id'];
        $supplier_value = $request->value;

        $update = DB::table('product_supplier')
            ->where([
                ['product_id', $product_id],
                ['supplier_id', $supplier_id]
            ])
            ->update(['value' => $supplier_value]);

        return response()->json([]);
    }

    public function updateIsWinnerSupplier(Request $request) : JsonResponse
    {
        DB::table('product_supplier')
            ->where('product_id', $request->product_id)
            ->update(['is_winner' => false]);

        DB::table('product_supplier')
            ->where([
                'supplier_id' => $request->supplier_id,
                'product_id' => $request->product_id
            ])
            ->update(['is_winner' => $request->is_winner]);

        return response()->json([]);
    }

    public function selectedSuppliers() : JsonResponse
    {
        $query = <<<SQL
            select
                p.id,
                p."name" as product_name,
                p.description,
                p.amount,
                ps.supplier_id,
                s."name" as supplier_name,
                ps.value,
                to_char(p.amount * ps.value, 'FM9,999,999.00') as total,
                ps.is_winner
            from products p
            join product_supplier ps on ps.product_id = p.id
            join suppliers s on s.id = ps.supplier_id
            where ps.is_winner is true
            order by p.id
        SQL;

        $data = DB::select($query);

        return response()->json(['values_table' => $data]);
    }
}
