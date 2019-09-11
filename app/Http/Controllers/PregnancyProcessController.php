<?php

namespace App\Http\Controllers;

use App\Events\NewBornEvent;
use App\Http\Resources\PregnancyProcessResource;
use App\Model\PregnancyProcess;
use Illuminate\Http\Request;

class PregnancyProcessController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $data =PregnancyProcess::with('detail')->latest()->get();
        return PregnancyProcessResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = 1;
        return broadcast(new NewBornEvent(route('pregnancyprocess.show', $id)))
            ? responseJson('event berhasil dikirim')
            : responseJson('event gagal dikirim') ;
    }


    /**
     * @param $id
     * @return PregnancyProcessResource
     */
    public function show($id)
    {
        return new PregnancyProcessResource(PregnancyProcess::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
