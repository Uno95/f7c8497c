<?php

namespace App\Http\Controllers;

use App\Delivery;
use Illuminate\Http\Request;
use App\ConsumenOrder as ConsumenOrder;
use App\ItemOrder as ItemOrder;

class DeliveryController extends Controller
{

    public function fetchAll(Request $req, $status = null)
    {
        $getModel = "";
        if (is_null($status)){
            $getModel = ItemOrder::with('ConsumenOrder.Hook')
                      ->orderBy('id', 'desc')
                      ->get();
        }else {
            $getModel = ItemOrder::with('ConsumenOrder.Hook')
                      ->where('status', $status)
                      ->orderBy('id', 'desc')
                      ->get();
        }

        foreach ($getModel as $get) {
            $get->status = json_decode($get->status, true);
        }
    

        if(request()->wantsJson()){
            return response($getModel, 200);
        }

        return view('admin.marketing.daftar_order',[
            'data' => $getModel
        ]);
    }

    public function delivery(Request $req, $id)
    {
        $jlhOrder = $req->order;
        $item = ConsumenOrder::where([
            'order_parent_id' => $id,
            'hooks_id' => $req->hooksId
        ])->get();
        if(count($item) > 0){
            $orderQtyOld  = $item[0]->order_qty ;
            $orderLeftOld = $item[0]->order_left;
            if ($orderQtyOld <= 0 && $orderLeftOld <= 0 ) {
                return response("All product order already delivered!", 404);
            } else if ($orderQtyOld < $jlhOrder && $orderLeftOld < $jlhOrder) {
                return response("Jumlah delivery melebihi jumlah order!", 404);
            }
            $item = ConsumenOrder::where([
                        'order_parent_id' => $id,
                        'hooks_id' => $req->hooksId
                    ])->update([
                        'order_qty' => $orderQtyOld - $jlhOrder,
                        'order_left' => $orderLeftOld - $jlhOrder,
                    ]);
            $setDelivered = ItemOrder::where(['id' => $id])->update(['delivered' => 1]);
            if ($item == 1) {
                return response("Update Success", 200);
            }
        } else {
            return response("Product order not created yet!", 404);
        }
        
        if (request()->wantsJson()){
            return response($item, 200);
        }
        return redirect('/order');
    }
}
