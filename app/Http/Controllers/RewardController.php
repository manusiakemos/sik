<?php

namespace App\Http\Controllers;

use App\Http\Resources\RewardResource;
use App\Model\Reward;
use App\Repositories\QueryRepository;
use Illuminate\Http\Request;

class RewardController extends Controller
{

    public function index($bidan_id)
    {
        $data = QueryRepository::sortRewardByBidan($bidan_id)->get();
        return RewardResource::collection($data);
    }

    public function store(Request $request)
    {
        //
    }


    /**
     * @param $id
     * @return RewardResource
     */
    public function show($id)
    {
        return new RewardResource(Reward::find($id));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
