<?php

namespace App\Services\Admin;

use App\Models\Reward;
use App\Models\RewardCredit;

class RewardService
{
    public function prepareData($data)
    {
        if(is_array($data)){
            foreach ($data as $key => $value) {
                if (isset($value)){
                    $data[$key] = strip_tags(str_ireplace(' ', '', $value)) == "" ? null : $value;
                }
            }
        } else {
            if (isset($data)) {
                $data = strip_tags(str_ireplace(' ', '', $data)) == "" ? null : $data;
            }
        }
        return $data;
    }

    public function saveDataToReward($data): Reward
    {
        $reward = new Reward();
        $this->saveData($data, $reward);
        return $reward;
    }

    public function saveImgToReward($data)
    {
        $files = $data->file('img');
        $name = $files->getClientOriginalName();
        $name = str_replace(' ', '-', $name);
        $files->move(public_path() . '/img/banks/', $name);
        return $name;
    }

    public function saveDataToRewardCredit($data): RewardCredit
    {
        $reward = new RewardCredit();
        $this->saveData($data, $reward);
        return $reward;
    }

    private function saveData($data, $reward){
        foreach ($data as $key => $value){
                $reward -> $key = $value;
        }
    }
}
