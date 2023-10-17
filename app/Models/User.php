<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_src',
        'agent_contract_props',
        'agent_contract_type_id',
        'active_at',
        'agr_send_pd',
        'agr_send_pd_is_read',
        'rating',
        'old_email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'agent_contract_props' => 'array'
    ];

    public function getAgentContractTypeIdNameAttribute($id) {
        return [
            null => 'Не заполнено',
            '1' => 'Самозанятый',
            '2' => 'ИП',
            '3' => 'ООО',][$this->agent_contract_type_id];
    }

    public function region(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'supervisor_id', 'id');
    }

    public function demands(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Demand::class, 'agent_id', 'id');
    }

    public function credits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Credit::class, 'agent_id', 'id');
    }

    public function evaluations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Evaluation::class, 'agent_id', 'id');
    }

//    public static $agent_contract_props =
//        [
//
//            1 =>
//                [[
//                    "key" => "full_name",
//                    "field_name" => "ФИО полностью"
//                ],[
//
//                    "key" => "certificate_number",
//                    "field_name" => "Номер свидетельства"
//                ],[
//                    "key" => "ogrn",
//                    "field_name" => "ОГРН"
//                ],[
//                    "key" => "inn",
//                    "field_name" => "ИНН"
//                ],[
//                    "key" => "business_address",
//                    "field_name" => "Юридический адрес"
//                ],[
//                    "key" => "physical_address",
//                    "field_name" => "Фактический адрес"
//                ],[
//                    "key" => "bank_name",
//                    "field_name" => "Наименование банка"
//                ],[
//                    "key" => "bank_account_number",
//                    "field_name" => "Расчетный счет"
//                ],[
//                    "key" => "bik",
//                    "field_name" => "БИК"
//                ],[
//                    "key" => "bank_corr_account_number",
//                    "field_name" => "Корреспондентский счет банка"
//                ],[
//                    "key" => "phone",
//                    "field_name" => "Телефон/Факс"
//                ],[
//                    "key" => "contact_name",
//                    "field_name" => "Контактное лицо"
//                ],[
//                    "key" => "email",
//                    "field_name" => "E-mail для переписки"
//                ]],
//            2 =>
//                [[
//                    "key" => "full_name",
//                    "field_name" => "Полное наименование"
//                ],[
//                    "key" => "certificate_number",
//                    "field_name" => "Номер свидетельства"
//
//                ],[
//                    "key" => "ogrn",
//                    "field_name" => "ОГРН"
//                ],[
//                    "key" => "inn",
//                    "field_name" => "ИНН"
//                ],[
//                    "key" => "business_address",
//                    "field_name" => "Юридический адрес"
//                ],[
//                    "key" => "physical_address",
//                    "field_name" => "Фактический адрес"
//                ],[
//                    "key" => "bank_name",
//                    "field_name" => "Наименование банка"
//                ],[
//                    "key" => "bank_account_number",
//                    "field_name" => "Расчетный счет"
//                ],[
//                    "key" => "bik",
//                    "field_name" => "БИК"
//                ],[
//                    "key" => "bank_corr_account_number",
//                    "field_name" => "Корреспондентский счет банка"
//                ],[
//                    "key" => "tax_mode",
//                    "field_name" => "Режим налогообложения стороны"
//                ],[
//                    "key" => "phone",
//                    "field_name" => "Телефон"
//                ],[
//                    "key" => "contact_name",
//                    "field_name" => "Контактное лицо"
//                ],[
//                    "key" => "email",
//                    "field_name" => "E-mail для переписки"
//                ]],
//
//            3 =>
//                [[
//                    "key" => "full_name",
//                    "field_name" => "Полное наименование"
//                ],[
//                    "key" => "ogrn",
//                    "field_name" => "ОГРН/КПП"
//                ],[
//                    "key" => "inn",
//                    "field_name" => "ИНН"
//                ],[
//                    "key" => "business_address",
//                    "field_name" => "Юридический адрес"
//                ],[
//                    "key" => "physical_address",
//                    "field_name" => "Фактический адрес"
//                ],[
//                    "key" => "bank_name",
//                    "field_name" => "Наименование банка"
//                ],[
//                    "key" => "bank_account_number",
//                    "field_name" => "Расчетный счет"
//                ],[
//                    "key" => "bik",
//                    "field_name" => "БИК"
//                ],[
//                    "key" => "bank_corr_account_number",
//                    "field_name" => "Корреспондентский счет банка"
//                ],[
//                    "key" => "tax_mode",
//                    "field_name" => "Режим налогообложения стороны"
//                ],[
//                    "key" => "phone",
//                    "field_name" => "Телефон/Факс"
//                ],[
//                    "key" => "contact_name",
//                    "field_name" => "Контактное лицо"
//                ],[
//                    "key" => "email",
//                    "field_name" => "E-mail для переписки"
//                ]]
//        ];
//
//    public static function getAgentContractPropsMap(){
//        return this->::agent_contract_props;
//    }
}
