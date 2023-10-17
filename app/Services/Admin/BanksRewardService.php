<?php

namespace App\Services\Admin;


use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BanksRewardService
{
    public static function update(Request $request, Bank $bank)
    {

        if($request->has('delete_file_from_reward')){
            $files = json_decode($bank->files, true);
            unset($files[array_search($request->file_name, $files)]);
            unlink(public_path() . "/files/banks/" . $bank->id . "/" . $request->file_name);
            $bank->files = json_encode(array_values($files));
        }
        else if($request->has('update_contact_to_reward')){
            $contact_id = $request->contact_id;
            $request->validate([
                'contacts_name' .'-'. $contact_id => 'required',
                'contacts_phone'.'-'. $contact_id => 'required',
                'contacts_email' .'-'. $contact_id => 'required',
                'contacts_city' .'-'. $contact_id => 'required',
            ]);
            $updated_contact = [
                'contacts_name' => $request->input('contacts_name' .'-'.$contact_id),
                'contacts_phone' => $request->input('contacts_phone' .'-'.$contact_id),
                'contacts_email' => $request->input('contacts_email' .'-'.$contact_id),
                'contacts_city' => $request->input('contacts_city' .'-'.$contact_id),
                'is_contact_has_color' => $request->boolean('is_contact_has_color' .'-'.$contact_id) ?? 'false',
            ];

            $current_contact = json_decode($bank->contacts, true)[array_search($contact_id, array_column(json_decode($bank->contacts, true), 'id'))];
            $updated_contact = array_replace($current_contact, $updated_contact);
            $all_contacts = json_decode($bank->contacts, true);
            $all_contacts[array_search($contact_id, array_column(json_decode($bank->contacts, true), 'id'))] = $updated_contact;
            $bank->contacts = json_encode($all_contacts);
            $bank->save();

            $request->request->remove('contacts_name' .'-'. $contact_id);
            $request->request->remove('contacts_phone'.'-'. $contact_id);
            $request->request->remove('contacts_email' .'-'. $contact_id);
            $request->request->remove('contacts_city' .'-'. $contact_id);
            $request->request->remove('is_contact_has_color' .'-'. $contact_id);

        }
        else if($request->has('delete_contact_from_reward')){
            $all_contacts = array_values(json_decode($bank->contacts, true));
            $contact_id = $request->contact_id;
            unset($all_contacts[array_search($contact_id, array_column($all_contacts, 'id'))]);
            $bank->contacts = json_encode(array_values($all_contacts));
            $bank->save();
        }else {
            $request->validate([
                'is_has_reward' => 'required|boolean',
                'type_percent' => 'required|string',
                'max_size_reward' => 'nullable|numeric',
                'short_list_programs' => 'required',
                'full_list_programs' => 'required',
                'files.*' => 'mimetypes:image/png,image/jpeg,application/pdf,image/tiff,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/x-rar-compressed,application/vnd.rar,application/zip,application/octet-stream,application/x-zip-compressed,multipart/x-zip,application/x-rar,
            application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:20000',
            ]);

            if (isset($request->banksFiles)){
                $files = $request->file('banksFiles');
                $data = json_decode($bank->files, true) ?? [];
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $name = str_replace(' ', '-', $name);
                    $file->move(public_path() . "/files/banks/" . $bank->id . "/", $name);
                    $data[] = $name;
                }
                $bank->files = json_encode(array_unique($data));
                $bank->save();
            }


            $enabled_reward = $request->boolean('enabled_reward') ?? 'false';
            if (!isset($request->enabled_reward)) {
                $request->request->add(['enabled_reward' => $enabled_reward]);
            }

            $reward_is_integer = $request->boolean('reward_is_integer') ?? 'false';
            if (!isset($request->reward_is_integer)) {
                $request->request->add(['reward_is_integer' => $reward_is_integer]);
            }

            if (isset($request->contacts_name)
                && isset($request->contacts_phone)
                && isset($request->contacts_email)
                && isset($request->contacts_city)
            ) {

                $contacts = json_decode($bank->contacts, true) ?? [];
                $contacts[] = [
                    'id' => uniqid(),
                    'contacts_name' => $request->contacts_name,
                    'contacts_phone' => $request->contacts_phone,
                    'contacts_email' => $request->contacts_email,
                    'contacts_city' => $request->contacts_city,
                    'is_contact_has_color' => $request->boolean('is_contact_has_color') ?? 'false',
                ];

                $bank->contacts = json_encode($contacts);
                $bank->save();

            }
        }


        return $request->except(['reward_submit', 'contacts_name', 'contacts_phone', 'contacts_email', 'contacts_city', 'is_contact_has_color',
            'banks_logo', 'banksFiles', 'enabled', "delete_file_from_reward", "file_name", "update_contact_to_reward", "contact_id", "delete_contact_from_reward"]);
    }
}
