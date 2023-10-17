<?php

namespace App\Http\Controllers;

use App\Services\Admin\RewardService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $rewardService;

     public function __construct(RewardService $service)
     {
         $this->rewardService = $service;
     }
}
