<b>Данное письмо сгенерировано автоматически, просьба на него не отвечать.</b><br />
<b>Для взаимодействия по заявке используйте контактные данные агента, указанные ниже.</b><br />
<b>Заявка закреплена за партнером Metr.club.</b><br />
<br />
Контакты агента:<br />
ФИО агента: {{$user_name}}<br />
Телефон агента: {{$user_telnumber}}<br />
E-mail: {{$user_email}}
<br />
@if ($demand->creditprogram == 5)
    Продукт: рефинансирование ипотеки<br />
    Рефинансирование ипотеки<br />
    Текущая процентная ставка: {{ $demand->refin_percent }}<br />
    Дата окончания ипотеки: {{ $demand->refin_date }}<br />
    Сколько осталось выплатить: {{ $demand->refin_balance }}<br />
@else
    <br />
    Продукт: ипотека<br />
    <br />
    Тип недвижимости: {{ $demand->type }}<br />
    Приблизительная стоимость: {{ $demand->estate_summ }}<br />
    Первоначальный взнос: {{ $demand->first_pay_summ }}<br />
    Возраст заёмщика: {{ $demand->age }}<br />
    <br />
    Общие данные:<br />
    ФИО: {{$demand->name}}<br />
    Телефон: {{$demand->contact_phone}}<br />
    Заявка от агента для банка: {{$demand->bank_name}}<br />
    AgentID: {{$demand->agent_id}}<br />
    uid: {{ $demand->uid }}<br />
    @if ($demand->estatetype == 1)
        Тип объекта: Первичка<br />
    @else
        Тип объекта: Вторичка<br />
    @endif
@endif
