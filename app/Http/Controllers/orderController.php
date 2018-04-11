<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ConsumenOrder as ConsumenOrder;
use App\ItemOrder as ItemOrder;

class orderController extends Controller
{

    public function fetchAll(Request $req, $status = null)
    {
        $getModel = "";
        if (is_null($status)){
            $getModel = ItemOrder::with('ConsumenOrder.Hook')
                      ->orderBy('id', 'desc')->get();
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

    public function fetch($id)
    {   
        $getModel = ItemOrder::with('ConsumenOrder')
                  ->where('id', $id)->get();

        if (request()->wantsJson()){
            if (count($getModel) == 0){
                return response("Order data not found!", 404);
            }
            $getModel[0]->status = json_decode($getModel[0]->status, true);
            return response($getModel, 200);
        }
        return view('admin.marketing.detail_order', [
            'detailOrder' => $getModel
        ]);
    }
    
    public function create(Request $req)
    {         
        $uniqId = uniqid();
        $inc    = count($req->itemOrder);
        
        $status = [
            "transactionStatus" => "Open",
            "statusApproval" => "Belum disetujui"
        ];

        $order  = new ItemOrder;
        $order->order_number = $uniqId;
        $order->consumen = $req->consumenName;
        $order->order_date = $req->orderDate;
        $order->status = json_encode($status, true);
        $order->save();
        
        for ($i = 0; $i < $inc; $i++){
            $item  = new ConsumenOrder;
            $item->order_qty  = $req->itemOrder[$i]['orderQty'];
            $item->order_left = $req->itemOrder[$i]['orderQty'];
            $item->hooks_id   = $req->itemOrder[$i]['hooksId'];
            $item->price      = $req->itemOrder[$i]['price'];
            $item->order_parent_id = $order->id;
            $item->save();
        }
        
        if(request()->wantsJson()){
            return response("Order saved successfully!", 201);
        }
        return redirect('/order');
    }

    public function reOrder(Request $req, $id)
    {
        $jlhOrder = $req->order;
        $item = ConsumenOrder::where('hooks_id', $req->hooksId)->get();
        if(count($item) > 0){
            $orderQtyOld  = $item[0]->order_qty ;
            $orderLeftOld = $item[0]->order_left;
            $item = ConsumenOrder::where('hooks_id', $req->hooksId)
                  ->update([
                      'order_qty' => $orderQtyOld + $jlhOrder,
                      'order_left' => $orderLeftOld + $jlhOrder,
                  ]);
            if ($item->save()) {
                return response("Update Success", 200);
            }
        } else {
            $item  = new ConsumenOrder;
            $item->order_qty  = $req->order;
            $item->order_left = $req->order;
            $item->hooks_id   = $req->hooksId;
            $item->order_parent_id = $id;
            $item->save();
        }
        
        if (request()->wantsJson()){
            return response($item, 200);
        }
        return redirect('/order');
    }

    public function closeOrder($id)
    {
        $getModel = ConsumenOrder::where('id', $id)
                    ->update(['status' => 'Close']);

        if($getModel){
            return response($getModel, 200);
        }
        
        if(request()->wantsJson()){
            return response("Cannot close the order", 403);
        }
        return redirect('/order');
    }

    public function delete($id)
    {
        $getModel = ConsumenOrder::where('id', $id);
        $order    = $getModel->get();

        if (count($order) == 0){
            return response ("Data order not found", 404);
        }
        $getModel->delete();

        if(request()->wantsJson()){
            return response("No Content", 204);
        }
        return redirect('/order');
    }

    public function orderApproval(Request $req, $id)
    {
        $approval = $req->approved;
        
        $approved = $approval == 1 ? "approved" : "rejected";

        if ($approval == 1) {
            $status = [
                "transactionStatus" => "Open",
                "statusApproval" => "Disetujui"
            ];
        } else {
            $status = [
                "transactionStatus" => "Closed",
                "statusApproval" => "Ditolak"
            ];
        }
        
        $getModel = ItemOrder::where('id', $id)
                    ->update([
                        'status' => json_encode($status, true),
                        'approved' => $approval
                    ]);

        if($getModel){
            return response("Order ". $approved ."!", 200);
        }
        
        if(request()->wantsJson()){
            return response("Cannot close the order", 403);
        }
        return redirect('/order');
    }
}
