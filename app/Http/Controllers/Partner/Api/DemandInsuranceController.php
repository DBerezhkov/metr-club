<?php

namespace App\Http\Controllers\Partner\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Http;
use Illuminate\Support\Collection;

class DemandInsuranceController extends Controller
{
    //public $url = 'https://mortgage.finuslugi.ru/api/v1.0';
    public $url = 'https://mortgage-dev1.inguru.dev/api/v1.0/';

    /**
     * @param $uri
     * @return Response
     */
    public function getData($uri) {
        return Http::get($this->url . $uri);
    }

    /**
     * @param $uri
     * @param $data
     * @return string
     */
    public function postData($uri, $data) {
        $res = Http::withBody(json_encode($data), 'application/json')
            ->post($this->url . $uri);
        return $res->body();
    }

    public function postDataWithAuth($uri, $data, $token) {
        $res = Http::withBody(json_encode($data), 'application/json')
            ->withHeaders(['Authorization' => 'ING ' . $token])
            ->post($this->url . $uri);
        return $res->body();
    }

    /**
     * @return string
     */
    public function partnerLogin() {
        $login_password = explode(" ", Settings::where('setting', 'finuslugi_auth')->value('param'));
        $data = [
            'email' => $login_password[0],
            'passwordMd5' => $login_password[1],
            'age' => 3600,
            'tokenIsPrivate' => true,
        ];
      //return $this->postData(__FUNCTION__, $data)['token'];
      return $this->postData(__FUNCTION__, $data);
    }

    public function companyUIData($id, Request $request) {
        $result = $this->getData(__FUNCTION__ . '/' . $id);
        $result = json_decode($result->body());
        $arr = collect();
        $bank = $request->bank;
        $sections = $request->sections;
        foreach ($result as $key=>$value) {
            foreach ($value as $k=>$v) {
                $v->value = '';
                $v->main_section = $key;
                if (((!isset($v->onlyForBanks)) || (in_array($bank, $v->onlyForBanks))) && ((in_array($key, $sections)) || ($key == 'common'))) {
                    $arr[] = $v;
                }
            }
        }
        $arr = $arr->groupBy('section');
        //dd($arr);
        foreach ($arr['nextcheck'] as $k=>$v) {
            $v->title = preg_replace('|#full_text\|(.*)#|Uis', '<a href="#">$1</a>', $v->title);
            $v->title = preg_replace('|#personal_data_confirmation\|(.*)#|Uis', '<a href="#">$1</a>', $v->title);
            $v->title = preg_replace('|#property_declaration\|(.*)#|Uis', '<a href="#">$1</a>', $v->title);
            $v->title = preg_replace('|#kid_property\|(.*)#|Uis', '<a href="#">$1</a>', $v->title);
            $v->title = preg_replace('|#policy_example_property\|(.*)#|Uis', '<a href="#">$1</a>', $v->title);
            $v->title = preg_replace('|#privacy_policy\|(.*)#|Uis', '<a href="#">$1</a>', $v->title);
            if (isset($v->text)) {
                $v->text = preg_replace('|#privacy_policy\|(.*)#|Uis', '<a href="#">$1</a>', $v->text);
            }
        }
        return $arr;
    }

    /**
     * @param Request $request
     * @return false
     */
    public function preCalcPolicyPrice($id, Request $request) {
        $token = json_decode($this->partnerLogin())->token;
        $params = $request->params;
        $params['ownershipRegistered'] = boolval($params['ownershipRegistered']);
        $params['woodenFloor'] = boolval($params['woodenFloor']);
        $params['buildingYear'] = intval($params['buildingYear']);
        $params['creditSum'] = intval($params['creditSum']);
        $params['birthDate'] = Carbon::createFromFormat('d.m.Y', $params['birthDate'])->format('Y-m-d');

        $res = $this->postDataWithAuth(__FUNCTION__ . '/' . $id, $params, $token);
        //$res = $this->postData(__FUNCTION__ . '/' . $id, $params);
        $data = json_decode($res, true);
        //dd($data);
        return (isset($data['total'])) ? $data['total'] : false;
    }

    public function calcPolicyPrice($id, Request $request) {
        $token = json_decode($this->partnerLogin())->token;
        $params = $request->data;
        $params = $this->getParams($params, $id);
        $res = $this->postDataWithAuth(__FUNCTION__ . '/' . $id, $params, $token);
        return json_decode($res, true);
    }

    public function issuePolicy($id, Request $request) {
        $token = json_decode($this->partnerLogin())->token;
        $params = $request->data;
        $params = $this->getParams($params, $id);
        $params['insurerPersonalData']['personDocument']['dateOfIssue'] = Carbon::createFromFormat('d.m.Y', ($params['insurerPersonalData']['personDocument']['dateOfIssue']))->format('Y-m-d');
        //dd($token);
        //$res = $this->postDataWithAuth(__FUNCTION__ . '/' . $id, $params, $token);
        //return json_decode($res, true);
        return $params;
    }

    /**
     * @return Response
     */
    public function bankList() {
        return $this->getData(__FUNCTION__);
    }

    /**
     * @return Response
     */
    public function companyList() {
        return $this->getData(__FUNCTION__);
    }

    /**
     * @param $params
     * @param $id
     * @return array
     */
    public function getParams($params, $id): array
    {
        $params['mortgageInfo']['creditAgreement'] = boolval($params['mortgageInfo']['creditAgreement']);
        $params['mortgageInfo']['creditSum'] = floatval($params['mortgageInfo']['creditSum']);
        $params['mortgageInfo']['birthDate'] = Carbon::createFromFormat('d.m.Y', ($params['mortgageInfo']['birthDate']))->format('Y-m-d');
        $params['requiredPolicy']['beginDate'] = Carbon::createFromFormat('d.m.Y', ($params['requiredPolicy']['beginDate']))->format('Y-m-d');
        $tmp = $params['additionalData'][$id];
        unset($params['additionalData'][$id]);

        foreach ($tmp as $section => $items) {
            foreach ($items as $item) {
                $params['additionalData'][$id][$item['name']] = match ($item['type']) {
                    'boolean' => boolval($item['value']),
                    'integer' => intval($item['value']),
                    'float' => floatval($item['value']),
                    'dateString' => Carbon::createFromFormat('d.m.Y', ($item['value']))->format('Y-m-d'),
                    default => $item['value'],
                };
            }
        }
        return $params;
    }

}
