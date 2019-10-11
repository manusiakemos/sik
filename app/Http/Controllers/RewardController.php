<?php

namespace App\Http\Controllers;

use App\Http\Resources\RewardResource;
use App\Model\Bidan;
use App\Model\PregnancyProcessDetail;
use App\Model\Reward;
use App\Repositories\QueryRepository;
use Illuminate\Http\Request;

class RewardController extends Controller
{

    public function index()
    {
        $data = QueryRepository::sortRewardByStatus('request')->get();
        return RewardResource::collection($data);
    }

    public function getRewardSetting()
    {
        return QueryRepository::rewardSetting()->first();
    }

    /**
     * @param $bidan_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function rewardBidan($bidan_id)
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
        ]);

        $settingReward = $this->getRewardSetting()->setting_value;

        $db = new Reward;
        $db->bidan_id = $request->bidan_id;
        $db->reward_point = $settingReward;

        return $db->save() ? responseJson('Reward berhasil ditambahkan') : '';
    }

    public function update(Request $request, $id)
    {
        $db = Reward::find($id);
        $db->reward_status = $request->reward_status;
        $db->save();

        switch ($request->reward_status) {
            case 'cancel':
                $msg = 'Ditolak';
                break;
            case 'verify':
                $msg = 'Diterima';
                break;
        }
        return responseJson('Reward berhasil '.$msg);
    }


    /**
     * @param $id
     * @return RewardResource
     */
    public function show($id)
    {
        return new RewardResource(Reward::findOrFail($id));
    }

    public function cash($bidan_id)
    {
        $data = QueryRepository::poinRewardCash($bidan_id)->first();
        return $data;
    }

    public function balance($bidan_id)
    {
        $data = QueryRepository::poinRewardBalance($bidan_id)->first();
        return $data;
    }

    public function history()
    {
        /* $bidan = Bidan::all();
         foreach ($bidan as $value){
             return $this->getHistory(1,$value->bidan_id);
         }*/
    }

    public function getHistory($page, $bidan_id)
    {

        $data = QueryRepository::getHistory($page, $bidan_id);

        return $data;

    }
}
