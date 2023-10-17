<table>
    <thead>
    <tr>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Имя</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>E-mail</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Номер телефона</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Дата создания</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Последний вход</b></th>
        @if(auth()->user()->hasRole('admin'))
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Оферта</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Вид сотрудничества</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Источник привлечения</b></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td style="font-size: 14px;">{{ $user->name }}</td>
            <td style="font-size: 14px;">{{ $user->email }}</td>
            <td style="font-size: 14px;">
                @if(isset($user->agent_contract_props[$user->agent_contract_type_id]['phone']))
                    {{$user->agent_contract_props[$user->agent_contract_type_id]['phone']}}
                @elseif(isset(json_decode($user->agent_registration_data, true)['telnumber']))
                    {{json_decode($user->agent_registration_data, true)['telnumber']}}
                @endif
            </td>
            <td style="font-size: 14px;">{{ $user->created_at }}</td>
            <td style="font-size: 14px;">{{ $user->active_at }}</td>
            @if(auth()->user()->hasRole('admin'))
            <td style="font-size: 14px;">
                @if($user->agreement)
                   Да
                @else
                   Нет
                @endif
            </td>
            <td style="font-size: 14px;">
                @if(isset($user->agent_contract_type_id))
                    {{$user->agentContractTypeIdName}}
                @else
                   {{$user->agentContractTypeIdName}}
                @endif
            </td>
            <td style="font-size: 14px;">
                @if(isset($user->agent_registration_data))
                    {{ json_decode($user->agent_registration_data, true)['how_know_about_us'] }}
                @endif
            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

