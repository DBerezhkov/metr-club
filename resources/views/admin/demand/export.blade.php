<table>
    <thead>
    <tr>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>ФИО клиента</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Мобильный телефон</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Агент</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>E-mail агента</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Телефон агента</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Telegram агента</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Тип недвижимости</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Тип объекта</b></th>
        <th style="width: 200px; font-size: 14px; background-color: #00bc8c"><b>Программа кредитования</b></th>
        <th style="width: 130px; font-size: 14px; background-color: #00bc8c"><b>Сумма кредита</b></th>
        <th style="width: 150px; font-size: 14px; background-color: #00bc8c"><b>Стоимость объекта</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Банк</b></th>
        @if(auth()->user()->hasRole('admin'))
        <th style="font-size: 14px; background-color: #00bc8c"><b>Регион</b></th>
        @endif
        <th style="font-size: 14px; background-color: #00bc8c"><b>Дата создания</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($demands as $demand)
        <tr>
            <td style="font-size: 14px;">{{ $demand->name }}</td>
            <td style="font-size: 14px;">{{ $demand->contact_phone }}</td>
            <td style="font-size: 14px;">
                @if($demand->agent)
                {{ $demand->agent->name }}
                @endif
            </td>
            <td style="font-size: 14px;">
                @if($demand->agent)
                    {{ $demand->agent->email }}
                @endif
            </td>
            <td style="font-size: 14px;">
                @if($demand->agent)
                    @if(isset($demand->agent->agent_contract_type_id))
                    {{$demand->agent->agent_contract_props[$demand->agent->agent_contract_type_id]['phone']}}
                @endif
                @endif
            </td>
            <td style="font-size: 14px;">
                @if($demand->agent)
                    @if(isset($demand->agent->agent_registration_data))
                        {{ json_decode($demand->agent->agent_registration_data, true)['tglogin'] }}
                    @endif
                @endif
            </td>
            <td style="font-size: 14px;">{{ $demand->type }}</td>
            <td style="font-size: 14px;">
                @if($demand->estatetype == 1)Первичка
                @elseif($demand->estatetype == 2)Вторичка
                @elseif($demand->estatetype == 3)Загородная
                @endif
            </td>
            <td style="font-size: 14px;">
                @if($demand->creditprogram== 1)Стандарт
                @elseif($demand->creditprogram== 2)Семейная ипотека
                @elseif($demand->creditprogram== 3)Господдержка
                @elseif($demand->creditprogram== 4)По двум документам
                @elseif($demand->creditprogram== 5)Рефинансирование
                @endif
            </td>
            <td style="font-size: 14px;"> {{ $demand->estate_summ -  $demand->first_pay_summ}}</td>
            <td style="font-size: 14px;">{{ $demand->estate_summ }}</td>
            <td style="font-size: 14px;">{{ $demand->printBanksList($demand->banks_list)}}</td>
            @if(auth()->user()->hasRole('admin'))
            <td style="font-size: 14px;"> @if(isset($demand->regions_list)){{($demand->printRegionsList($demand->regions_list)) }}@endif</td>
            @endif
            <td style="font-size: 14px;"> {{ $demand->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

