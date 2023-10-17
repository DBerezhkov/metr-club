<?php

namespace App\Http\Controllers\Partner\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\Api\SendNewFilesRequest;
use App\Jobs\Partner\SendDemandJob;
use App\Models\Bank;
use App\Models\Demand;
use App\Models\User;
use App\Services\Partner\SendDemandService;


class SendNewFilesToDemandController extends Controller
{

    public function sendNewFiles(SendNewFilesRequest $request)
    {
        $new_demand = json_decode($request->demand);
        $new_demand->banks_list = json_encode($request->banks);
        $new_demand->commentary = "Отправка дополнительных файлов к ранее направленной заявке";
        $files = $request->file('scanfiles');
        $mergedFiles = json_decode(Demand::find($new_demand->id)->files);


        foreach ($files as $key => $file) {
            $name = $file->getClientOriginalName();
            $name = $key . '-' . str_replace(' ', '-', $name);
            $file->move(public_path() . '/clients/' . $new_demand->uid, $name);
            $mergedFiles[] = $name;
            $data[] = $name;
        }

        $dem = Demand::find($new_demand->id);
        $dem->update([
            'files' => json_encode($mergedFiles),
        ]);


        $new_demand->files = json_encode($data);

        $user = User::find($new_demand->agent_id);

        foreach ($request->banks as $bank) {
            $tmp = Bank::find($bank);
            $new_demand -> bank_name = $tmp->name;
            $new_demand -> bank_id = $tmp->id;
            $tmp->variant_copy_for_processing = 3;
            $emails = SendDemandService::sendDemand($user->region_id, $new_demand, $tmp);
            SendDemandJob::dispatch($emails, $new_demand, $tmp->toArray())->onQueue('SendDemand');
        }
        return response()->json('Файлы успешно отправлены!');

    }

    public function getDemandFiles($id){
       $files = Demand::find($id)->files;

        $data = [
            'files' => json_decode($files),
        ];

        return $data;
    }

}
