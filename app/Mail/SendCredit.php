<?php

namespace App\Mail;

use App\Models\Bank;
use App\Models\CreditProgram;
use App\Models\DemandTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendCredit extends Mailable
{
    use Queueable, SerializesModels;

    protected $cred;
    protected $bank_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cred, $bank_id)
    {
        $this->cred = $cred;
        $this->bank_id = $bank_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template_tags =
            [
                '%user_name%',
                '%user_telnumber%',
                '%user_email%',
                '%credit_program%',
                '%credit_summ%',
                '%credit_name%',
                '%credit_contact_phone%',
                '%credit_bank_name%',
                '%agent_id%',
                '%credit_uid%',
                '%credit_commentary%',
                '%url_registration%',
            ];
        $user = User::find(Auth::id());
        $user_telnumber = $user->agr_send_pd == 1 ? $user->agent_contract_props[$user->agent_contract_type_id]['phone'] : '';
        $user_email = $user->agent_contract_props[$user->agent_contract_type_id]['email'];
        $credit = $this->cred;
        $user_name = $user->agr_send_pd == 1 ? $credit->agent->name : '';
        $bank = Bank::find($this->bank_id);

        if(isset($bank->demandTemplateCredit)){
            $subject = $bank->demandTemplateCredit->subject;
            $body = $bank->demandTemplateCredit->body;
        } else {
            $subject = DemandTemplate::find(1)->subject;
            $body = DemandTemplate::find(1)->body;
        }
        $credit_program = CreditProgram::find($credit->type)->title;
        $url = json_decode($user->agent_registration_data, true)['url'] ?? '';
        $replaces = [
            $user_name,
            $user_telnumber,
            $user_email,
            $credit_program,
            $credit->price,
            $credit->name,
            $credit->phone,
            $bank->name,
            Auth::id(),
            $credit->uid,
            $credit->commentary,
            $url,
        ];

        $subject = preg_replace(
            $template_tags,
            $replaces,
            $subject);

        $body = preg_replace(
            $template_tags,
            $replaces,
            $body);

        $files = json_decode($this->cred->files);

        foreach ($files as $file) {
            $this->attach(public_path() . '/clients/credits/' . $this->cred->uid . '/' . $file);
        }
        return $this->view('mail.send_credit', compact('credit', 'body'))
            ->subject($subject);
    }
}
