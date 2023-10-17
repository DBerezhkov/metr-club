<?php

namespace App\Services\Admin;


use App\Models\Bank;
use Illuminate\Http\Request;

class BankService
{

    public static function updateBank(Request $request, Bank $bank)
    {
        if(isset($request->create_office)){
           return self::createOffice($request, $bank);
        }
        if(isset($request->update_office)){
            return self::updateOffice($request, $bank);
        }
        if(isset($request->delete_office)){
            return self::deleteOffice($request, $bank);
        }
    }

    public static function createOffice(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required',
            'emails' => 'required',
        ]);

        $office = json_decode($bank->offices, true) ?? [];

        $office[] = [
            'id' => uniqid(),
            'name' => $request->name,
            'emails' => $request->emails,
            'banks_name' => $bank -> name,
        ];
        $request->request->add(['offices' => json_encode($office)]);
        return $request->only('_token', '_method', 'offices');
    }
    public static function updateOffice(Request $request, Bank $bank)
    {
        $id = $request->office_id;
        $request->validate([
            'office_name'.'-'.$id => 'required',
            'office_emails'.'-'. $id => 'required',
        ]);

        $updated_office = [
            'id' => $id,
            'name' => $request->input('office_name' .'-'.$id),
            'emails' => $request->input('office_emails' .'-'.$id),
            'banks_name' => $bank -> name,
        ];

        $current_office = json_decode($bank->offices, true)[array_search($id, array_column(json_decode($bank->offices, true), 'id'))];
        $updated_office = array_replace($current_office, $updated_office);
        $all_offices = json_decode($bank->offices, true);
        $all_offices[array_search($id, array_column(json_decode($bank->offices, true), 'id'))] = $updated_office;
        $bank->offices = json_encode($all_offices);
        $bank->save();
        $request->request->add(['offices' => $bank->offices]);
        return $request->only('_token', '_method', 'offices', 'update_office');
    }

    public static function deleteOffice(Request $request, Bank $bank)
    {
        $all_offices = array_values(json_decode($bank->offices, true));
        $id = $request->office_id;
        unset($all_offices[array_search($id, array_column($all_offices, 'id'))]);
        $bank->offices = json_encode(array_values($all_offices));
        $bank->save();
        $request->request->add(['offices' => $bank->offices]);
        return $request->only('_token', '_method', 'offices', 'delete_office');
    }

}
