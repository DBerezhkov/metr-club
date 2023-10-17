<?php

namespace App\Http\Controllers\Supervisor;


use App\Filters\Supervisor\EmployeeFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Supervisor\Employee\StoreRequest;
use App\Models\User;
use App\Services\Admin\RegisterService;
use App\Services\Supervisor\EmployeeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;


class EmployeeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function index(UserRequest $request)
    {
        $users = EmployeeFilter::filter_field($request)->get()->where('supervisor_id', Auth::id());
        $users_count = $users->count();
        EmployeeService::setActiveUserAndOnlineCount($users);
        $users_active = EmployeeService::getUsersActive();
        $online_count = EmployeeService::getOnlineCount();
        return view('supervisor.employees.index', compact('users', 'online_count', 'users_active', 'users_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('supervisor.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function store(StoreRequest $request)
    {
        $usersData = $request->all();
        unset($usersData['_token']);
        $usersData = EmployeeService::prepareRegistrationData($usersData);
        EmployeeService::sendNotificationToTelegramAboutNewUser($usersData);
        EmployeeService::addUserToGoogleSheet($usersData);
        $registerService = new RegisterService();
        $user = $registerService->registerNewUser(Role::findById(3), ['name' => $usersData['name'] . ' ' . $usersData['surname'], 'email' => $usersData['login']]);
        $user = EmployeeService::prepareUsersData($user, $usersData);
        $user->save();
        return redirect()->route('employees.create')->withSuccess('Новый агент успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function show($id)
    {
       if(Auth::id() == $id){
           return redirect()->route('profile.index');
       }
       if(!Auth::user()->employees->contains('id', $id)){
           return abort(404);
       }
        $user = User::find($id);
        $user->whatsapp_phone = preg_replace('/[^\d]/', '', $user->agent_contract_props[$user->agent_contract_type_id]['phone']);
        $user->phone = $user->agent_contract_props[$user->agent_contract_type_id]['phone'];
        $user->contract_email = $user->agent_contract_props[$user->agent_contract_type_id]['email'];
        $user->tglogin = isset($user->agent_registration_data) ? ltrim(json_decode($user->agent_registration_data)->tglogin, '@') : null;
        return view('supervisor.employees.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->employees->contains('id', $id)){
            return abort(404);
        }
        $user = User::find($id);
        $contract_props = $user->agent_contract_props;
        $contract_props[$user->agent_contract_type_id]['phone'] = $request->agent_contract_props[$user->agent_contract_type_id]['phone'];
        $contract_props[$user->agent_contract_type_id]['email'] = $request->agent_contract_props[$user->agent_contract_type_id]['email'];
        $user->agent_contract_props = $contract_props;
        $user->save();
        return redirect()->back()->with('success', 'Данные обновлены!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->employees->contains('id', $id)){
            return abort(404);
        }
        $user = User::find($id);
        $user->delete();
            return redirect()->route('employees.index')->withSuccess('Пользователь удалён!');
    }
}
