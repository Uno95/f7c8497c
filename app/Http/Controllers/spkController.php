<?php

namespace App\Http\Controllers;

use QrCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SPK as SPK;
use App\Hook as Hook;
use App\Owner as Owner;
use App\Visitor as Visitor;
use App\ItemWaste as ItemWaste;
use App\WasteProgress as WasteProgress;

class spkController extends Controller
{ 
    public function index(){
        return view('admin.production.daftar_spk');
    }

    public function fetchAll()
    {
        $spk = SPK::with(['Hooks', 'WasteProgress'])
             ->orderBy('id', 'DESC')
             ->get();

        return response($spk, 200);
    }

    public function fetch($id)
    {
        $spk = SPK::with(['Hooks', 'WasteProgress'])
             ->where(['id' => $id])
             ->get();

        return response($spk, 200);
    }

    public function create(Request $req)
    {
        $spk = new SPK;
        $wasteProgress = new WasteProgress;
        
        $spk->spk_num = $req->spkNum; 
        $spk->hooks   = $req->hooks;
        $spk->qty     = $req->qty;
        $spk->status  = $req->status;
        $spk->persentase_progress = 0;
        $result = $spk->save();

        $wasteProgress->spk_id = $spk->id;
        $createWaste = $wasteProgress->save();

        if($result && $createWaste){
            return response("New SPK created successfully", 201);
        }
        return response("Failed create new SPK", 500);
    }

    public function searchByDate(Request $req)
    {
        $start = $req->start;
        $end   = $req->end;
        
        $spk = SPK::with('Hooks')
                  ->whereDate('created_at', '>=', $start)
                  ->whereDate('created_at', '<=', $end)
                  ->get();
        
        if (count($spk) == 0){
            return response('Data not found!', 404);
        }

        return response($spk, 200);
    }

    public function filterByHook(Request $req)
    {
        $hookId = $req->hook;

        $spk = SPK::with('Hooks')
                  ->whereHas('Hooks', function($q) use ($hookId){
                        $q->where('id', $hookId);
                  })->get();

        if (count($spk) == 0){
            return response('Data not found!', 404);
        }
        
        return response($spk, 200);
    }

    public function qrcode($stringQr)
    {
        $path = public_path('img\qrcode.png');
        $qrcode = QrCode::format('png')
                ->size(500)
                ->generate($stringQr, $path);

        return view('qrcode');
    }

    public function createVisitorLog(Request $req)
    {
        $visitorLog = new Visitor;

        $stringQr = str_random(64);
        $qrcode = $this->qrcode($stringQr);

        $visitorLog->owner_id = $req->ownerId;
        $visitorLog->name     = $req->name;
        $visitorLog->relation = $req->relation;
        $visitorLog->plat     = $req->plate;
        $visitorLog->address  = $req->address;
        $visitorLog->purpose  = $req->purpose;
        $visitorLog->qrcode   = $stringQr;
        
        $visitorLog->save();

        if(!$visitorLog->save()){
            return response ("Gagal membuat log", 500);
        }
        return response ("Log berhasil disimpan", 201);
    }

    public function fetchAllVisitorLog()
    {
        $visitorLog = Visitor::with('Owner')->orderBy('id', 'desc')->get();
        return $visitorLog;
    }

    public function fetchVisitorlog($id)
    {
        $visitorLog = Visitor::where('id',$id)
                    ->with('owner')
                    ->get();
        $visitorQrcode = $visitorLog[0]->qrcode;
        $this->qrcode($visitorQrcode);
        return $visitorLog;
    }

    public function emptyTable()
    {
        Visitor::truncate();
        return response("No Content", 204);
    }
}
