<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hooks as Hooks;

class hooksController extends Controller
{
    public function fetchAll($vendor = null)
    {
        $hooks = Hooks::orderBy('id', 'DESC')->get();
        return response($hooks, 200);
    }

    public function fetch($id)
    {
        $hook = Hooks::where('id', $id)->get();
        if (count($hook) == 0){
            return response("Data not found!", 404);
        }
        return response($hook, 200);
    }
    
    public function create(Request $req)
    {
        for ($i=0; $i < count($req->request); $i++) {
            $hook = new Hooks;
            $hookAtributes = [
                "hook_vendor" => $req[$i]['hookVendor']  ,
                "hook_type"   => $req[$i]['hookType']  ,
                "hook_size"   => $req[$i]['hookSize']  ,
                "hook_price"  => $req[$i]['hookPrice'] ,
            ];
            $hook->hook_params = json_encode($hookAtributes, true);;
            $hook->save();
        }
        
        
        return response("New hook saved successfully!", 201);
    }

    public function delete($id)
    {
        $getModel = Hooks::where('id', $id);
        $getData  = $getModel->get();
        
        if(count($getData) == 0){
            return response("Cannot delete because hooks not found!", 404);
        }
        $getModel->delete();
        
        return response("New hook deleted successfully!", 204);
    }
}
