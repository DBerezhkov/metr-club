<?php

namespace App\Http\Controllers\Admin;

use App\Filters\AdminUserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Landing;
use App\Models\Region;
use App\Models\Settings;
use App\Models\User;
use App\Services\Admin\SupervisorService;
use App\Services\Supervisor\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use PhpOffice\PhpWord\TemplateProcessor;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(UserRequest $request)
    {
        $users = AdminUserFilter::filter_field($request)->orderBy('created_at', 'desc')->paginate(100)->withQueryString();
        $users_count = $users->total();
        $users_active = [];
        $online_count = 0;

        foreach ($users as $user) {
            if( Carbon::parse($user->active_at)->diffInMinutes(now()) < 5) {
                $users_active[$user['id']] = true;
                $online_count++;
            }
            else {
                $users_active[$user['id']] = false;
            }

            $phone = null;
            if(isset($user->agent_registration_data)) {
                $phone = preg_replace('/[^\d]/', '', json_decode($user->agent_registration_data)->telnumber);
            }
            else if(isset($user->agent_contract_props[$user->agent_contract_type_id]['phone'])) {
                $phone = preg_replace('/[^\d]/', '', $user->agent_contract_props[$user->agent_contract_type_id]['phone']);
            }

            $user->phone = $phone;
            $user->tglogin = isset($user->agent_registration_data) ? ltrim(json_decode($user->agent_registration_data)->tglogin, '@') : null;
        }
        $regions = Region::query()->select('id', 'title')->get();
        $landings = Landing::query()->select('id', 'title')->get();
        $supervisors = User::query()->where('is_supervisor', 1)->get();
        $subagents = User::query()->where('is_employee', 1)->get();
        return view('admin.users.index', compact('users', 'users_active', 'online_count', 'users_count', 'regions', 'landings', 'supervisors', 'subagents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'fname' => 'required|string',
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $response = Http::asForm()->withHeaders([
            'PddToken' => 'OB7U6ZPZPERS5B3RXWQROBKNV6VFUTO6VJKBRWRQYBFVL6L5N3EA'
        ])->post('https://pddimp.yandex.ru/api2/admin/email/add', [
            'domain' => 'metr.club',
            'login' => $request->input('login'),
            'password' => $request->input('password'),
            'iname' => $request->input('name'),
            'fname' => $request->input('fname'),
        ]);
        if ($response->successful()) {
            $json = json_decode($response->body() , true);
            if ((isset($json['error'])) && ($json['error'] === 'occupied')) {
                logger($json);
                return redirect()->back()->withError('Такой пользователь уже есть в Яндекс почте! Обратитесь к администратору для решения проблемы.');
            }
            else if ((isset($json['success'])) && ($json['success'] === 'ok')){
                $email = $request->input('login') . '@metr.club';
                if (User::where('email', $email)->exists()) {
                    logger($email);
                    return redirect()->back()->withError('Такой пользователь уже есть в CRM!');
                }
                $user = User::create([
                    'name' => $request->input('name') . ' ' . $request->input('fname'),
                    'email' => $email,
                    'password' => Hash::make($request->input('password')),
                    'agr_send_pd_is_read' => 1
                ]);
                $user->assignRole('partner');

                $template = Settings::where('setting', 'tg_text')->value('param');
                //$template = $template->param;
                $res = preg_replace(['%USERNAME%', '%LOGIN%', '%PASSWORD%'], [$user->name, $email, $request->input('password')], $template);

                return view('admin.users.create')->with(['template' => $res]);

            }
            else {
                logger($json);
                return redirect()->back()->withError('Неизвестная ошибка');
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $default_region = Region::find(1);
        $regions = Region::query()->where('id', '!=', 1)->orderBy('title')->get();
        $supervisors = User::query()->where('id', '!=', $user->id)->where('is_supervisor', true)->get();
        $supervisor = User::find($user->supervisor_id);
        $phone = null;
        if(isset($user->agent_registration_data)) {
            $phone = json_decode($user->agent_registration_data)->telnumber;
        }
        else if(isset($user->agent_contract_props[$user->agent_contract_type_id]['phone'])) {
            $phone = $user->agent_contract_props[$user->agent_contract_type_id]['phone'];
        }

        $user->phone = $phone;
        $user->tglogin = isset($user->agent_registration_data) ? ltrim(json_decode($user->agent_registration_data)->tglogin, '@') : null;
        return view('admin.users.show', [
            'user' => $user,
            'contract_info_schema' => Config::get('constants.props'),
            'regions' => $regions,
            'agent_registration_data' => json_decode($user->agent_registration_data, true),
            'registration_data' => Config::get('constants.registration_data'),
            'default_region' => $default_region,
            'supervisors' => $supervisors,
            'supervisor' => $supervisor,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $user = User::find($id);
//        dd($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($request->has('registration_data')){
            $data = $request->except('_token', '_method', 'registration_data');
            $user->agent_registration_data = json_encode($data);
            $user->save();
        } else {
            $request->validate([
                'region_id' => 'exists:regions,id',
            ]);
            if(isset($request -> password)){
                $password = $request -> password;
                $user->password = Hash::make($request -> password);
                $user->save();
                return Redirect::to(URL::previous() . "#info")->with('password_is_changed', $password);
            }
            $user->region_id = $request -> region_id;

            if($request->has('registration_data')){
                $data = $request->except('_token', '_method');
                $user->agent_registration_data = json_encode($data);
            }
            $user->is_supervisor = $request->boolean('is_supervisor');
            if ($user->is_supervisor){
                if (!$user->is_employee){
                    $user->assignRole('supervisor');
                }
                elseif (!User::withTrashed()->find($user->supervisor_id)->hasRole('supervisor')){
                    User::withTrashed()->find($user->supervisor_id)->employees()->withTrashed()->update(['supervisor_id' => $user->id]);
                    $user->assignRole('supervisor');
                    $user->is_employee = 0;
                    $user->supervisor_id = null;
                }
                else {
                    return redirect()->back()->withError('Нельзя назначить данного агента руководитедем, так как у него есть действующий руководитель.');
                }
            } else {
                $user->removeRole('supervisor');
            }
            if($request->has('set_supervisor')){
                    SupervisorService::setSupervisor($request, $user);
            }

            $user->save();
            $user->update($request->all());
            if($user->hasRole('supervisor')){
                EmployeeService::updateContractPropsForEmployee($user);
            }
        }

        return redirect()->back()->withSuccess('Данные обновлены');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->hasRole('supervisor')){
            $user->removeRole('supervisor');
            $user->is_supervisor = 0;
        }
        $user->delete();
        if ($user->hasRole('user')) {
            return redirect('/admin_panel/users?role=1')->with('success', 'Пользователь удалён!');
        } else {
            return redirect('/admin_panel/users')->with('success', 'Пользователь удалён!');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function createContract($id)
    {
        $userArray = User::find($id);
        $contractTypeId = $userArray->agent_contract_type_id;

        $fieldsToFill = $userArray->agent_contract_props[$userArray->agent_contract_type_id];
        $arr = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        ];
        $month = date('n')-1;
        $fieldsToFill['frmt_m'] = $arr[$month];
        $fieldsToFill['frmt_d'] = date("j");
        $fieldsToFill['frmt_y'] = date("Y");
        $c_template = new TemplateProcessor(resource_path('contract_templates/'.$contractTypeId.'.docx'));
        foreach ($fieldsToFill as $key => $value){
            $c_template->setValue($key, $value);
        }
        $docName = 'Договор '  . $fieldsToFill['full_name'] . '.docx';
        try{
            $c_template->saveAs(resource_path($docName));
        }
        catch (Exception $e){
            //handle exception
        }
        return response()->download(resource_path($docName))->deleteFileAfterSend(true);

    }
}
