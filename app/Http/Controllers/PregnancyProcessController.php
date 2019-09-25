<?php

namespace App\Http\Controllers;

use App\Events\NewBornEvent;
use App\Http\Resources\PregnancyProcessResource;
use App\Model\PregnancyProcess;
use Illuminate\Http\Request;

class PregnancyProcessController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $search = $request->search;
        if(!$status){
            return responseJson('status belum di set');
        }
        $data = PregnancyProcess::with(['detail', 'bidan'])
            ->where("pp_status", $status);
        if($search){
            $data = $data
                ->where('pp_code', 'like' , "%$search%")
                ->orwhere('pp_nama_ibu', 'like' , "%$search%")
                ->orWhere('pp_nama_ayah', 'like' , "%$search%");
        }
        return PregnancyProcessResource::collection($data->paginate());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $id = 1;
        return broadcast(new NewBornEvent(route('pregnancyprocess.show', $id)))
            ? responseJson('event berhasil dikirim')
            : responseJson('event gagal dikirim') ;
    }

    public function show($id)
    {
        return new PregnancyProcessResource(PregnancyProcess::find($id));
    }

    public function update(Request $request, $id)
    {
        $db = PregnancyProcess::find($id);
        $db = $this->updateProcess($db, $request);
        return $db->save() ? responseJson('Status berhasil diupdate') : responseJson('Status gagal diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function updateProcess($db, $request)
    {
        $s = $request->pp_status;
        $db->pp_status = $s;
        if($s == 'born'){
            $db->update_to_done = now();
        }elseif ($s == 'send'){
            $db->update_to_send = now();
        }
        return $db;
    }
}
