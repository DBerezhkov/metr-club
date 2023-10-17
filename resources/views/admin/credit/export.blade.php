<table>
    <thead>
    <tr>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>ФИО клиента</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Мобильный телефон</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Агент</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>E-mail агента</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Телефон агента</b></th>
        <th style="width: 160px; font-size: 14px; background-color: #00bc8c"><b>Telegram агента</b></th>
        <th style="width: 200px; font-size: 14px; background-color: #00bc8c"><b>Программа кредитования</b></th>
        <th style="width: 130px; font-size: 14px; background-color: #00bc8c"><b>Сумма кредита</b></th>
        <th style="width: 120px; font-size: 14px; background-color: #00bc8c"><b>Банк</b></th>
        <th style="font-size: 14px; background-color: #00bc8c"><b>Дата создания</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($credits as $credit)
        <tr>
            <td style="font-size: 14px;">{{ $credit->name }}</td>
            <td style="font-size: 14px;">{{ $credit->phone }}</td>
            <td style="font-size: 14px;">
                @if($credit->agent)
                {{ $credit->agent->name }}
                @endif
            </td>
            <td style="font-size: 14px;">
                @if($credit->agent)
                    {{ $credit->agent->email }}
                @endif
            </td>
            <td style="font-size: 14px;">
                @if($credit->agent)
                    @if(isset($credit->agent->agent_contract_type_id))
                    {{$credit->agent->agent_contract_props[$credit->agent->agent_contract_type_id]['phone']}}
                @endif
                @endif
            </td>
            <td style="font-size: 14px;">
                @if($credit->agent)
                    @if(isset($credit->agent->agent_registration_data))
                        {{ json_decode($credit->agent->agent_registration_data, true)['tglogin'] }}
                    @endif
                @endif
            </td>
            <td style="font-size: 14px;">
                @if(isset($credit->credit_program->title))
             {{$credit->credit_program->title}}
                @endif
            </td>
            <td style="font-size: 14px;">{{ $credit->price }}</td>
            <td style="font-size: 14px;">{{ $credit->printBanksList($credit->banks_list)}}</td>
            <td style="font-size: 14px;"> {{ $credit->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

