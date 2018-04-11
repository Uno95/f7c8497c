<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WasteProgress as WasteProgress;
use App\ItemWaste as ItemWaste;
use App\SPK as SPK;

class itemWasteController extends Controller
{

    public function addWaste(Request $req)
    {
        $wasteProgress = WasteProgress::where('spk_id', $req->spkId)->get();

        if (count($wasteProgress) > 0){
            $this->updateSpkProgress($req->spkId);
        } else {
            $progress = new WasteProgress;
            $progress->spk_id = $req->spkId;
            $progress->save();
        }
        
        $detailSpk = new ItemWaste;
        $detailSpk->proses   = $req->proses ;
        $detailSpk->no_mesin = $req->noMesin ;
        $detailSpk->masuk    = $req->masuk ;
        $detailSpk->hasil    = $req->hasil ;
        $detailSpk->rusak    = $req->rusak ;
        $detailSpk->tanggal  = $req->tanggal ;
        $detailSpk->spk_id   = $req->spkId ;
        
        $result = $detailSpk->save();

        if ($req->proses == "Potong 1"){
            $spk = SPK::where([
                'id' => $req->spkId
            ]);

            $dataSpk = $spk->get();
            $amountTarget = (int) $dataSpk[0]->qty;

            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 

            $category = "potong_1";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);

        } 
        else if ($req->proses == "Grinding") {
            $wasteData = ItemWaste::where([
                'proses' => 'Potong 1',
                'spk_id' => $req->spkId
            ]);
            $amountTarget = $wasteData->sum('hasil'); 
            
            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 

            $category = "grinding";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);
        }
        else if ($req->proses == "Potong 2") {
            $wasteData = ItemWaste::where([
                'proses' => 'grinding',
                'spk_id' => $req->spkId
            ]);
            $amountTarget = $wasteData->sum('hasil'); 
            
            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 
            
            $category = "potong_2";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);
        }
        else if ($req->proses == "Auto") {
            $wasteData = ItemWaste::where([
                'proses' => 'Potong 2',
                'spk_id' => $req->spkId
            ]);
            $amountTarget = $wasteData->sum('hasil'); 
            
            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 
            
            $category = "auto";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);
        }
        else if ($req->proses == "Forged") {
            $wasteData = ItemWaste::where([
                'proses' => 'Auto',
                'spk_id' => $req->spkId
            ]);
            $amountTarget = $wasteData->sum('hasil'); 
            
            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 
            
            $category = "forged";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);
        }
        else if ($req->proses == "Bakar") {
            $wasteData = ItemWaste::where([
                'proses' => 'Forged',
                'spk_id' => $req->spkId
            ]);
            $amountTarget = $wasteData->sum('hasil'); 
            
            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 
            
            $category = "bakar";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);
        }
        else if ($req->proses == "Tempering") {
            $wasteData = ItemWaste::where([
                'proses' => 'Bakar',
                'spk_id' => $req->spkId
            ]);
            $amountTarget = $wasteData->sum('hasil'); 
            
            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 
            
            $category = "tempering";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);
        }
        else if ($req->proses == "Finishing") {
            $wasteData = ItemWaste::where([
                'proses' => 'Tempering',
                'spk_id' => $req->spkId
            ]);
            $amountTarget = $wasteData->sum('hasil'); 
            
            $wasteData = ItemWaste::where([
                'proses' => $req->proses,
                'spk_id' => $req->spkId
            ]);
            $sumWasteResult = $wasteData->sum('hasil'); 
            
            $category = "finishing";
            $this->addProgressWaste($sumWasteResult, $amountTarget, $req->spkId, $category);
        }

        $this->updateSpkProgress($req->spkId);
        
        if($result){
            return response("New Detail added successfully", 201);
        }
        return response("Failed add new Detail SPK", 500);
    }

    public function addProgressWaste($sumWasteResult, $amountTarget, $spkId, $category)
    {
        $persentase = ($sumWasteResult / $amountTarget) * 100;
        // dd($amountTarget);
        
        if ($persentase > 100) {
            $persentase = 100;
        }
            
        $updateDetailSpk = WasteProgress::where(['spk_id' => $spkId])
                         ->update([$category => $persentase]);
    }

    public function updateSpkProgress($spkId)
    {
        $wasteProgress = WasteProgress::where('spk_id', $spkId)->get();
        $totalWasteProgress = $wasteProgress[0]->potong_1 + 
                            $wasteProgress[0]->grinding + 
                            $wasteProgress[0]->potong_2 + 
                            $wasteProgress[0]->auto + 
                            $wasteProgress[0]->forged + 
                            $wasteProgress[0]->bakar + 
                            $wasteProgress[0]->tempering + 
                            $wasteProgress[0]->finishing;

        $spkProgress = $totalWasteProgress / 8;
        $spkProgress = number_format($spkProgress, 2, '.', '');

        $updateSpkProgress = SPK::where(['id' => $spkId])
                           ->update(['persentase_progress' => $spkProgress]);
    }

    public function fetchAllWaste()
    {
        $itemWaste = ItemWaste::with('Spk')->get();

        if(request()->wantsJson()){
            return response($itemWaste, 200);
        }
        
        return view('admin.production.detail_spk', [
            'detailSpk' => $itemWaste
        ]);
    }
    
    public function fetchWaste($id)
    {
        $itemWaste = ItemWaste::with('Spk')
                   ->where('spk_id', $id)
                   ->get();

        if(request()->wantsJson()){
            return response($itemWaste, 200);
        }
        
        return view('admin.production.detail_spk', [
            'detailSpk' => $itemWaste
        ]);
    }

    public function filterByCategory(Request $req)
    {
        $category = $req->category;

        $itemWaste = ItemWaste::with('Spk')
                     ->where('proses', $category)
                     ->get();

        if (count($itemWaste) > 0){
            if(request()->wantsJson()){
                return response($itemWaste, 200);
            }
            
            return view('admin.production.detail_spk', [
                'detailSpk' => $itemWaste
            ]);
        }

        return response("Data waste not found!", 404);
        
    }
}
