<?php

namespace App\Http\Controllers\Partner;


use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Demand;
use App\Models\Region;
use App\Models\Settings;
use App\Models\User;
use App\Services\Supervisor\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        $default_region = Region::find(1);
        $regions = Region::query()->where('id', '!=', 1)->orderBy('title')->get();
        $text_agr_send_pd = Settings::where('setting', 'agr_send_pd')->value('param');
        $contract_info_schema = Config::get('constants.props');
        $agent_registration_data = json_decode($user->agent_registration_data, true);
        $registration_data = Config::get('constants.registration_data');
        $supervisor = User::find($user->supervisor_id);
        return view('partner.profile.index', compact('user',
            'contract_info_schema', 'regions', 'default_region', 'text_agr_send_pd', 'agent_registration_data', 'registration_data', 'supervisor'));

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'profile_photo' => 'mimetypes:image/png,image/jpeg',
            'region_id' => 'exists:regions,id',
            //'agent_contract_props.agent_contract_type_id.email' => 'required|not_regex:/^[A-Za-z0-9._%+-]+@metr\.club$/gm'
        ]);
        $user = Auth::User();
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $extension = $file->extension();

            $src = '/profile-photos/' . md5($user->id) . '.' . $extension;
            $file->move(public_path() . '/profile-photos/', md5($user->id) . '.' . $extension);
            $user->update([
                'profile_photo_src' => $src
            ]);

            return redirect()->back()->withSuccess('Данные обновлены');
        }
        $agent_contract_type_id = $request->agent_contract_type_id;
        if (isset($agent_contract_type_id)) {
            $email = $request->agent_contract_props[$agent_contract_type_id]['email'];
            if (preg_match('/^[A-Za-z0-9._%+-]+@metr\.club$/m', $email)) {
                return redirect()->back()->with('error', 'Нельзя указывать почту на домене @metr.club в качестве контактной. Пожалуйста, укажите вашу личную почту!');
            }

            $user_data = $request->all();
            if (!$user->is_employee) {
                $user_data['agr_send_pd'] = $request->boolean('agr_send_pd') ?? 'false';
            }

            if (!$user->hasRole('supervisor')) {
                $user->is_supervisor = $request->boolean('is_supervisor');
                if ($user->is_supervisor) {
                    if (!$user->is_employee) {
                        $user->assignRole('supervisor');
                    }
                }
            }

            $user->update($user_data);
            $user->region_id = $request->region_id;
            $user->save();
            if($user->hasRole('supervisor')){
                EmployeeService::updateContractPropsForEmployee($user);
            }
        }
        return redirect()->back()->withSuccess('Данные обновлены');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
