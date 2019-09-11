<?php

namespace App\Http\Controllers;

use App\Http\Resources\RewardResource;
use App\Model\Reward;
use App\Repositories\QueryRepository;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class RewardController extends Controller
{

    public function getRewardSetting()
    {
        return QueryRepository::rewardSetting()->first();
    }

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
        ]);

        $settingReward = $this->getRewardSetting()->setting_value;

        $db = new Reward;
        $db->bidan_id = $request->bidan_id;
        $db->reward_point = $settingReward;

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
}
