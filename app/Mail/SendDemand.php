<?php

namespace App\Mail;

use App\Models\Bank;
use App\Models\CreditProgram;
use App\Models\DemandTemplate;
use App\Models\Region;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SendDemand extends Mailable
{
    use Queueable, SerializesModels;

    protected $dem;
    protected $bank_id;

    /**
     * SendDemand constructor.
     * @param $dem
     */
    public function __construct($dem, $bank_id)
    {
        $this->dem = $dem;
        $this->bank_id = $bank_id;
    }

    /**
     * Create a new message instance.
     *
     * @return void
     */



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template_tags =
            ['%user_name%',
                '%user_telnumber%',
                '%user_email%',
                '%demand_refin%',
                '%refin_percent%',
                '%refin_date%',
                '%refin_balance%',
                '%productipoteka%',
                '%credit_program%',
                '%demand_type%',
                '%demand_estate_summ%',
                '%demand_first_pay_summ%',
                '%demand_name%',
                '%demand_contact_phone%',
                '%demand_bank_name%',
                '%demand_estate_type%',
                '%agent_id%',
                '%demand_uid%',
                '%pledges_region%',
                '%deals_region%',
                '%demand_commentary%',
                '%url_registration%',
                '%variants_rate%',

            ];
        $demand = $this->dem;
        $user = User::find($demand->agent_id);
        $user_telnumber = $user->agr_send_pd == 1 ? $user->agent_contract_props[$user->agent_contract_type_id]['phone'] : '';
        $user_email = $user->agent_contract_props[$user->agent_contract_type_id]['email'];
        $user_name = $user->agr_send_pd == 1 ? $user->name : '';
        $bank = Bank::find($this->bank_id);
        if(isset($bank->demandTemplate)){
        $subject = $bank->demandTemplate->subject;
        $body = $bank->demandTemplate->body;
        $refin_body = $bank->demandTemplate->refin_body;
        } else {
            $subject = DemandTemplate::find(1)->subject;
            $body = DemandTemplate::find(1)->body;
            $refin_body = DemandTemplate::find(1)->refin_body;
        }

        $demand_estate_type = '';
        switch ($demand->estatetype) {
            case 1:
                $demand_estate_type = 'Первичка';
                break;
            case 2:
                $demand_estate_type = 'Вторичка';
                break;
            case 3:
                $demand_estate_type = 'Загородная';
                break;
        }

        $credit_program = CreditProgram::find($demand->creditprogram)->title;

        if($demand->creditprogram == 5){
            $body = $refin_body ?? DemandTemplate::find(1)->refin_body;

        }
        $pledges_region = Region::find($demand->pledges_region)->title;
        $deals_region = Region::find($demand->deals_region)->title;
        $url = json_decode($user->agent_registration_data, true)['url'] ?? '';

        $commentary = $demand->commentary ?? 'Отсутствует';
        $variants_rate = '';
        if(isset($demand->rate_list) && json_decode($demand->rate_list) != null){
            foreach(json_decode($demand->rate_list, true) as $item){
                foreach(json_decode($item) as $key => $rate){
                    if($key == $bank->id){
                        $variants_rate = $rate;
                    }
                }
            }
        }

        $replaces = [$user_name,
            $user_telnumber, $user_email, 'рефинансирование ипотеки',
            $demand->refin_percent, $demand->refin_date, $demand->refin_balance, 'ипотека', $credit_program, $demand->type,
            $demand->estate_summ, $demand->first_pay_summ, $demand->name, $demand->contact_phone, $bank->name,
            $demand_estate_type, $demand->agent_id, $demand->uid, $pledges_region, $deals_region, $commentary, $url, $variants_rate];

        $subject = preg_replace($template_tags, $replaces, $subject);
        $body = preg_replace($template_tags, $replaces, $body);

        $files = json_decode($this->dem->files);

        foreach ($files as $file) {
                $this->attach(public_path() . '/clients/' . $this->dem->uid . '/' . $file);
        }
        return $this->view('mail.send_demand', compact('demand', 'body'))
            ->subject($subject .'[' . $this->dem->uid . ']/'. $bank->id);
    }
}
