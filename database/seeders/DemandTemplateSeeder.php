<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemandTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('demand_templates')->insert(
            [
                'name' => 'Шаблон по умолчанию',
                'subject' => '_МетрКлаб_',
                'body' => '<b>Данное письмо сгенерировано автоматически, просьба на него не отвечать.</b><br/>
<b>Для взаимодействия по заявке используйте контактные данные агента, указанные ниже.</b><br/>
<b>Заявка закреплена за партнером Metr.club.</b><br />
<br/>
Контакты агента:<br />
ФИО агента: user_name<br/>
Телефон агента: user_telnumber<br/>
E-mail: user_email<br/>
<br/>
    Продукт: ipoteka<br/>
    <br/>
    Программа кредитования: credit_program<br/>
    Тип недвижимости: demand_type<br/>
    Приблизительная стоимость: demand_estate_summ<br/>
    Первоначальный взнос: demand_first_pay_summ<br/>
    Возраст заёмщика: demand_age<br/>
    <br/>
    Общие данные:<br/>
    ФИО: demand_name<br/>
    Телефон: demand_contact_phone<br/>
    Заявка от агента для банка: demand_bank_name<br/>
    AgentID: agent_id<br/>
    uid: demand_uid<br/>
    Тип объекта: demand_estate_type<br/>',
                'refin_body' => '<b>Данное письмо сгенерировано автоматически, просьба на него не отвечать.</b><br/>
<b>Для взаимодействия по заявке используйте контактные данные агента, указанные ниже.</b><br/>
<b>Заявка закреплена за партнером Metr.club.</b><br />
<br/>
Контакты агента:<br />
ФИО агента: user_name<br/>
Телефон агента: user_telnumber<br/>
E-mail: user_email<br/>
<br/>
    Продукт: demand_refin<br/>
    Текущая процентная ставка: refin_percent<br/>
    Дата окончания ипотеки: refin_date<br/>
    Сколько осталось выплатить: refin_balance<br/>
    <br/>
    <br/>
    Общие данные:<br/>
    ФИО: demand_name<br/>
    Телефон: demand_contact_phone<br/>
    Возраст заёмщика: demand_age<br/>
    Заявка от агента для банка: demand_bank_name<br/>
    AgentID: agent_id<br/>
    uid: demand_uid<br/>
    Тип объекта: demand_estate_type<br/>',],
        );
    }
}
