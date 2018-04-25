<?php

namespace App\Http\Controllers;

use App\Delivery;
use Illuminate\Http\Request;
use App\ConsumenOrder as ConsumenOrder;
use App\ItemOrder as ItemOrder;
use App\ItemDelivery as ItemDelivery;

class DeliveryController extends Controller
{

    public function fetchAll(Request $req, $status = null)
    {
        $getModel = "";
        if (is_null($status)){
            $getModel = ItemDelivery::with('ItemOrder.Hook')
                      ->orderBy('id', 'desc')
                      ->get();
        }else {
            $getModel = ItemDelivery::with('ItemOrder.Hook')
                      ->where('status', $status)
                      ->orderBy('id', 'desc')
                      ->get();
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
        $jlhDelivery = $req->delivery;
        $item = ConsumenOrder::where([
            'order_parent_id' => $id,
            'hooks_id' => $req->hooksId
        ])->get();
        
        if(count($item) > 0){
            $orderQtyOld  = $item[0]->order_qty ;
            $orderLeftOld = $item[0]->order_left;
            if ($orderQtyOld <= 0 && $orderLeftOld <= 0 ) {
                return response("All product order already delivered!", 404);
            } else if ($orderQtyOld < $jlhDelivery && $orderLeftOld < $jlhDelivery) {
                return response("Jumlah delivery melebihi jumlah order!", 404);
            }
            $updateItem = ConsumenOrder::where([
                        'order_parent_id' => $id,
                        'hooks_id' => $req->hooksId
                    ])->update([
                        'order_qty' => $orderQtyOld - $jlhDelivery,
                        'order_left' => $orderLeftOld - $jlhDelivery,
                    ]);
            $setDelivered = ItemOrder::where(['id' => $id])->update(['delivered' => 1]);
        } else {
            return response("Item order not found", 404);
        }

        // Create delivery data
        $delivery = $this->createDelivery($item, $jlhDelivery);
        
        if (request()->wantsJson()){
            return response($delivery, 200);
        }

        return redirect('/order');
    }

    public function createDelivery($item, $jlhDelivery)
    {
        $uniqId = uniqid();
        $status = [
            "transactionStatus" => "Open",
            "statusApproval" => "Belum disetujui"
        ];
        
        $delivery = new ItemDelivery;
        $delivery->delivery_number = $uniqId;
        $delivery->delivery_qty = $jlhDelivery;
        $delivery->status = json_encode($status, true);
        $delivery->item_order_id = $item[0]->id;
        $delivery->save();

        return $delivery;
    }
}
