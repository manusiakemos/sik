<?php

namespace App\Http\Controllers;

use App\Http\Resources\RewardResource;
use App\Model\Reward;
use App\Repositories\QueryRepository;
use Illuminate\Http\Request;

class RewardController extends Controller
{

    /**
     * @param $bidan_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($bidan_id)
    {
        $data = QueryRepository::sortRewardByBidan($bidan_id)->get();
        return RewardResource::collection($data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'bidan_id' => 'required',
            'reward_point' => 'required',
            'reward_date' => 'required'
        ]);

        $db = new Reward;
        $db->bidan_id = $request->bidan_id;
        $db->reward_point = $request->reward_point;
        $db->reward_date = $request->reward_date;
        return $db->save() ? responseJson('Reward berhasil ditambahkan') : '';
    }


    /**
     * @param $id
     * @return RewardResource
     */
    public function show($id)
    {
        return new RewardResource(Reward::findOrFail($id));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'bidan_id' => 'required',
            'reward_point' => 'required',
            'reward_date' => 'required'
        ]);

        $db = Reward::findOrFail($id);
        $db->bidan_id = $request->bidan_id;
        $db->reward_point = $request->reward_point;
        $db->reward_date = $request->reward_date;
        return $db->save() ? responseJson('Reward berhasil diupdate') : '';
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     */
    public function destroy($id)
    {
        $db = Reward::find($id)->delete();
        return $db ? responseJson('Reward berhasil dihapus') : '';
    }
}
