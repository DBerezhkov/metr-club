<template>
    <div class="row">
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button id="close_popup_x" type="button" class="close d-none" data-dismiss="modal"
                            aria-label="Close" @click="closeModal()" style="margin-left: 92%; margin-top: 2%">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <div class="text-center mt-5 mb-5" id="waiting_send_demand">
                            <div class="cssload-loader">
                                <div class="cssload-inner cssload-one"></div>
                                <div class="cssload-inner cssload-two"></div>
                                <div class="cssload-inner cssload-three"></div>
                            </div>
                            <h3 class="modal-title text-center mt-3">Подождите...</h3>
                        </div>
                        <div class="d-none" id="success_send_demand">
                            <img src="/img/demands/logo.jpeg" class="mx-auto d-block" style="max-height: 120px">
                            <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Заявка успешно создана!</h3>
                        </div>
                        <div class="d-none" id="error_from_server">
                            <img src="/img/demands/Warning-icon-isolated-on-transparent-background-PNG.png"
                                 class="mx-auto d-block" style="max-height: 160px">
                            <h4 class="modal-title text-center mt-3" id="exampleModalLabel">{{errorFromServer}}</h4>
                        </div>

                    </div>
                    <div class="modal-footer d-none" id="button_close_modal">
                        <button id="closePopup" type="button" class="btn btn-primary mx-auto pl-5 pr-5"
                                data-dismiss="modal" @click="closeModal()">Закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            @click="closeErrorModal()" style="margin-left: 92%; margin-top: 2%">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <img src="/img/demands/Warning-icon-isolated-on-transparent-background-PNG.png"
                             class="mx-auto d-block" style="max-height: 160px">
                        <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Пожалуйста, прикрепите сканы
                            документов!</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mx-auto pl-5 pr-5" data-dismiss="modal"
                                @click="closeErrorModal()">Я постараюсь!
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="alert alert-danger" role="alert" v-if="isFailSend">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                <h4><i class="icon fa fa-exclamation"></i>{{errorFromServer}}
                </h4>
            </div>
            <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="exampleInputPassword1">ФИО клиента</label>
                            <input v-mask="'Я'.repeat(100)" type="text" class="form-control"
                                   placeholder="Введите ФИО клиента" id="name" ref="name" v-model="name"
                                   @keyup="replaceSymbolsForNameInput()"
                                   :class="{'is-invalid': ($v.name.$dirty && !$v.name.required)}">
                            <small class="invalid-feedback"
                                   v-if="$v.name.$dirty && !$v.name.required"
                            >Укажите ФИО клиента</small>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="exampleInputPassword1">Мобильный телефон</label>
                            <input v-mask="'# (###) ###-##-##'" type="text" inputmode="numeric" class="form-control"
                                   id="clientphone" ref="clientphone" v-model="clientphone"
                                   placeholder="Введите телефон" required
                                   :class="{'is-invalid': ($v.clientphone.$dirty && !$v.clientphone.required) || ($v.clientphone.$dirty && !$v.clientphone.telValidator)}">
                            <small class="invalid-feedback"
                                   v-if="$v.clientphone.$dirty && !$v.clientphone.required"
                            >Укажите телефон клиента</small>
                            <small class="invalid-feedback"
                                   v-else-if="$v.clientphone.$dirty && !$v.clientphone.telValidator"
                            >Укажите корректный номер телефона</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="exampleInputPassword1">Стоимость объекта</label>
                            <vue-autonumeric type="text" inputmode="decimal" class="form-control" id="estatesumm"
                                             ref="estatesumm" v-model="estatesumm" placeholder="Введите сумму"
                                             :class="{'is-invalid': ($v.estatesumm.$dirty && !$v.estatesumm.required)
                                                                           || ($v.estatesumm.$dirty && !$v.estatesumm.maxEstatetSumValidator)
                                                                    || ($v.estatesumm.$dirty && !$v.estatesumm.estatesummValidator)}"
                                             :options="{
                                                                                      digitGroupSeparator: ' ',
                                                                                      decimalCharacter: '.',
                                                                                      allowDecimalPadding: false,
                                                                                      decimalCharacterAlternative: ',',
                                                                                      minimumValue: '0',
                                                                                      modifyValueOnWheel: false}">
                            </vue-autonumeric>
                            <small class="invalid-feedback"
                                   v-if="($v.estatesumm.$dirty && !$v.estatesumm.required)
                                                                           || ($v.estatesumm.$dirty && !$v.estatesumm.estatesummValidator)"
                            >Укажите стоимость</small>
                            <small class="invalid-feedback"
                                   v-if="$v.estatesumm.$dirty && $v.estatesumm.required && !$v.estatesumm.maxEstatetSumValidator"
                            >Недопустимое число</small>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="exampleInputPassword1">Первый взнос</label>
                            <vue-autonumeric type="text" inputmode="decimal" class="form-control" id="firstpaysumm"
                                             ref="firstpaysumm" v-model="firstpaysumm" placeholder="Введите сумму"
                                             :class="{'is-invalid': ($v.firstpaysumm.$dirty && !$v.firstpaysumm.required)
                                                                           || ($v.firstpaysumm.$dirty && !$v.firstpaysumm.firstPaySumCheck)
                                                                     || ($v.firstpaysumm.$dirty && !$v.firstpaysumm.firstpaysummValidator)}"
                                             :options="{
                                                                                      digitGroupSeparator: ' ',
                                                                                      decimalCharacter: '.',
                                                                                      allowDecimalPadding: false,
                                                                                      decimalCharacterAlternative: ',',
                                                                                      minimumValue: '0',
                                                                                      modifyValueOnWheel: false}">
                            </vue-autonumeric>
                            <small class="invalid-feedback"
                                   v-if="($v.firstpaysumm.$dirty && !$v.firstpaysumm.required)
                                                                           || ($v.firstpaysumm.$dirty && !$v.firstpaysumm.firstpaysummValidator)"
                            >Укажите первый взнос</small>
                            <small class="invalid-feedback"
                                   v-if="$v.firstpaysumm.$dirty && $v.firstpaysumm.required && !$v.firstpaysumm.firstPaySumCheck"
                            >Первый взнос не может быть больше или равен стоимости объекта</small>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="exampleInputPassword1">Тип недвижимости</label>
                            <select class="custom-select" size="1" ref="type" v-model="type"
                                    :class="{'is-invalid': ($v.type.$dirty && !$v.type.required)}">
                                <option :value="null" disabled>Выберите тип недвижимости</option>
                                <option value="Квартира">Квартира</option>
                                <option value="Апартаменты">Апартаменты</option>
                                <option value="Комната/доля">Комната/доля</option>
                                <option value="Дом">Дом</option>
                                <option value="Земельный участок">Земельный участок</option>
                                <option value="Дом+земельный участок">Дом+земельный участок</option>
                                <option value="Таунхаус">Таунхаус</option>
                                <option value="Машиноместо">Машиноместо</option>
                                <option value="Коммерция">Коммерция</option>
                            </select>
                            <small class="invalid-feedback"
                                   v-if="$v.type.$dirty && !$v.type.required"
                            >Выберите тип недвижимости</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <label for="exampleInputPassword1">Цель кредитования</label>
                            <select class="custom-select" size="1" ref="estatetype" v-model="estatetype"
                                    :class="{'is-invalid': ($v.estatetype.$dirty && !$v.estatetype.required)}">
                                <option :value="null" disabled>Выберите цель</option>
                                <option value="1">Первичка</option>
                                <option value="2">Вторичка</option>
                                <option value="3">Загородная</option>
                            </select>
                            <small class="invalid-feedback"
                                   v-if="$v.estatetype.$dirty && !$v.estatetype.required"
                            >Выберите цель кредитования</small>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="exampleInputPassword1">Программа</label>
                            <select class="custom-select" size="1" ref="creditprogram" v-model="creditprogram"
                                    :class="{'is-invalid': ($v.creditprogram.$dirty && !$v.creditprogram.required)}"
                                    @change="setCreditProgram(creditprogram)">
                                <option :value="null" disabled>Выберите программу</option>
                                <option v-for="item in creditProgramsList" :value="item.id">{{item.title}}</option>
                            </select>
                            <small class="invalid-feedback"
                                   v-if="$v.creditprogram.$dirty && !$v.creditprogram.required"
                            >Выберите программу кредитования</small>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label for="exampleInputPassword1">Регион залога</label>
                            <select class="custom-select" size="1" ref="pledges_region" v-model="pledges_region"
                                    :class="{'is-invalid': ($v.pledges_region.$dirty && !$v.pledges_region.required)}"
                                    @change="autoCompleteRegion()">
                                <option :value="null" disabled>Выберите регион</option>
                                <option v-bind:value="defaultRegion.id">{{defaultRegion.title}}</option>
                                <template v-for="region in regions">
                                    <option v-bind:value="region.id">{{region.title}}</option>
                                </template>
                            </select>
                            <small class="invalid-feedback"
                                   v-if="$v.pledges_region.$dirty && !$v.pledges_region.required"
                            >Выберите регион</small>
                        </div>

                        <div class="col-sm-3 mb-3">
                            <label for="exampleInputPassword1">Регион сделки</label>
                            <select class="custom-select" size="1" ref="deals_region" v-model="deals_region"
                                    :class="{'is-invalid': ($v.deals_region.$dirty && !$v.deals_region.required)}" @change="hideOfficesForOtherRegions()">
                                <option :value="null" disabled>Выберите регион</option>
                                <option v-bind:value="defaultRegion.id">{{defaultRegion.title}}</option>
                                <template v-for="region in regions">
                                    <option v-bind:value="region.id">{{region.title}}</option>
                                </template>
                            </select>
                            <small class="invalid-feedback"
                                   v-if="$v.deals_region.$dirty && !$v.deals_region.required"
                            >Выберите регион</small>
                        </div>
                    </div>


                    <transition name="fade">
                        <div v-if="creditprogramIsrefin" class="form-group" id="refinparams">
                            <label for="exampleInputPassword1">Параметры текущего кредита:</label>
                            <div class="row">

                                <div class="col-sm-4 mb-3">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">

                                        <label for="exampleInputPassword1">Ставка</label>
                                        <vue-autonumeric type="text" class="form-control" inputmode="decimal"
                                                         id="refinpercent" v-model="refinpercent"
                                                         placeholder="Введите текущую ставку"
                                                         :class="{'is-invalid': ($v.refinpercent.$dirty && !$v.refinpercent.required)
                                                                                                ||  ($v.refinpercent.$dirty && !$v.refinpercent.refinpercentValidator)}"
                                                         :options="{
                                                                                                                 digitGroupSeparator: '',
                                                                                                                 decimalCharacter: '.',
                                                                                                                 allowDecimalPadding: false,
                                                                                                                 decimalCharacterAlternative: ',',
                                                                                                                 suffixText: '%',
                                                                                                                 modifyValueOnWheel: false,
                                                                                                                 minimumValue: 0,
                                                                                                                 maximumValue: 100,
                                                                                                                 }"
                                                         :disabled="refinInputsIsDisabled">
                                        </vue-autonumeric>
                                        <small class="invalid-feedback"
                                               v-if="($v.refinpercent.$dirty && !$v.refinpercent.required)
                                                                                                   ||  ($v.refinpercent.$dirty && !$v.refinpercent.refinpercentValidator)"
                                        >Укажите текущую ставку</small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">

                                        <label for="exampleInputPassword1">Дата окончания</label>
                                        <input type="text" class="form-control" inputmode="decimal" id="refindate"
                                               v-model="refindate" placeholder="Введите дату"
                                               :class="{'is-invalid': ($v.refindate.$dirty && !$v.refindate.required) || ($v.refindate.$dirty && !$v.refindate.dateValidator)}"
                                               v-mask="'##.##.####'" :disabled="refinInputsIsDisabled">
                                        <small class="invalid-feedback"
                                               v-if="$v.refindate.$dirty && !$v.refindate.required"
                                        >Укажите дату окончания</small>
                                        <small class="invalid-feedback"
                                               v-if="$v.refindate.$dirty && $v.refindate.required && !$v.refindate.dateValidator"
                                        >Укажите корректную дату</small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">

                                        <label for="exampleInputPassword1">Остаток задолженности</label>
                                        <vue-autonumeric type="text" inputmode="decimal" class="form-control"
                                                         id="refinbalance" v-model="refinbalance"
                                                         placeholder="Введите остаток задолженности"
                                                         :disabled="refinInputsIsDisabled"
                                                         :class="{'is-invalid': ($v.refinbalance.$dirty && !$v.refinbalance.required) || ($v.refinbalance.$dirty && !$v.refinbalance.refinbalanceValidator)}"
                                                         autocomplete="off"
                                                         :options="{
                                                                                                                  digitGroupSeparator: ' ',
                                                                                                                  decimalCharacter: '.',
                                                                                                                  allowDecimalPadding: false,
                                                                                                                  decimalCharacterAlternative: ',',
                                                                                                                  minimumValue: '0',
                                                                                                                  modifyValueOnWheel: false}">
                                        </vue-autonumeric>
                                        <small class="invalid-feedback"
                                               v-if="($v.refinbalance.$dirty && !$v.refinbalance.required) || ($v.refinbalance.$dirty && !$v.refinbalance.refinbalanceValidator)"
                                        >Укажите остаток задолженности</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Комментарий к заявке:</label>
                        <textarea id="commentary" ref="commentary" v-model="commentary" class="form-control" rows="3"
                                  placeholder="При необходимости добавьте комментарий"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Выберите банки для отправки заявки:</label>
                        <div class="row">
                            <template v-for="bank in banks_list">
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline"
                                             v-tippy="{arrow : true, arrowType : 'round', animation : 'fade', allowHTML: true}"
                                             :content="creditprogram != null && !bank.programs_demand.includes(creditprogram) ? showTooltip(bank) : bank.alt_contact">
                                            <input type="checkbox" :id="bank.id" v-model="banks" v-bind:value='bank.id'
                                                   :disabled="disableCheckBox(bank) || countBanksMoreThenFive(bank) || isDisabledCheckBoxes"
                                                   @change="setBankData(bank.name, bank.max_files_size, bank.id)">
                                            <label :for="bank.id">
                                                {{bank.name}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <p style="color: #DC3543" v-if="$v.banks.$dirty && !$v.banks.required">Выберите хотя бы один
                            банк для отправки</p>
                        <p style="color: #DC3543" v-if="banks.length == max_count_banks_for_demand">Максимальное количество банков для отправки заявки - {{max_count_banks_for_demand}}</p>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1" v-if="Object.keys(offices).length > 0">Выберите офисы
                            банков:</label>
                        <transition name="fade">
                            <div class="row" v-if="Object.keys(offices).length > 0">
                                <template v-for="bank in banks_list">
                                    <transition name="fade">
                                        <div class="col-sm-3" v-if="bank.offices !== null && bank.offices !== '[]' && banks.includes(bank.id)
                        && deals_region === 1 && offices.hasOwnProperty(bank.id)">
                                            <div class="form-group clearfix">
                                                <label for="exampleInputPassword1">{{bank.name}}</label>
                                                <select :id="bank.id" class="custom-select" size="1" :ref="bank.id"
                                                        v-model="offices[bank.id]">
                                                    <option v-for="(office, index) in JSON.parse(bank.offices)" :value="{
                        offices_id: office.id,
                        offices_name:  office.name,
                        emails: office.emails,
                        banks_name: office.banks_name,
                    }" :selected="index === 0">{{office.name}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </transition>
                                </template>
                            </div>
                        </transition>
                    </div>

                    <div class="form-group">
                        <div v-if="Object.keys(variants_rate).length > 0">
                            <div>Размер комиссии зависит от ставки для клиента. Инфо по <a href="/reward" target="_blank">ссылке.</a></div>
                            <label for="exampleInputPassword1">Ставка для клиента:</label>
                        </div>
                        <transition name="fade">
                        <div class="row"  v-if="Object.keys(variants_rate).length > 0">
                            <template v-for="bank in banks_list">
                                <transition name="fade">
                                    <div class="col-sm-3" v-if="bank.variants_rate_enable === 1 && bank.variants_rate !== null && banks.includes(bank.id) && variants_rate.hasOwnProperty(bank.id)">
                                        <div class="form-group clearfix">
                                            <label for="exampleInputPassword1">{{bank.name}}</label>
                                            <select :id="bank.id" class="custom-select" size="1" v-model="variants_rate[bank.id]">
                                                <option v-for="(rate, index) in bank.variants_rate.split(';')" :selected="index === 0">{{rate}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </transition>
                            </template>
                        </div>
                        </transition>
                    </div>

                    <div class="form-group">
                        <p v-if="max_file_size_text !== null || max_file_size_text !== ''"
                           v-html="max_file_size_text"></p>
                        <div class="text-bold  mb-2">Прикрепите сканы документов. <span
                            style="    color: rgb(255, 0, 0);">Не забудьте прикрепить анкеты и СОПД по форме выбранных банков!</span></div>
                        <DropZoneComponent ref="dropzoneComponent"></DropZoneComponent>
                        <transition name="fade">
                            <div class="alert alert-danger" id="redList" role="alert"
                                 v-if="Object.keys(this.banksMaxFileSizeError).length > 0 && dropzoneCountFiles > 0">
                                <h6><i class="icon fa fa-exclamation"></i>Заявка не будет отправлена в следующие банки,
                                    так как превышен объем вложений:</h6>
                                <div v-for="item in banksMaxFileSizeError">- {{item.name}} (Банк принимает максимум
                                    {{item.max_files_size}} МБ)
                                </div>
                            </div>
                        </transition>
                        <transition name="fade">
                            <div class="alert alert-success mt-2" id="greenList" role="alert"
                                 v-if="Object.keys(this.banksGreenList).length > 0 && dropzoneCountFiles > 0">
                                <h6><i class="icon fa fa-check"></i>Заявка будет отправлена в следующие банки:</h6>
                                <div v-for="item in banksGreenList">- {{item.name}}</div>
                            </div>
                        </transition>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button @click.prevent="sendDemand()" id="btnSubmit" class="btn btn-primary">Отправить заявку
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import createNumberMask from 'text-mask-addons/dist/createNumberMask'
import Inputmask from 'inputmask';
import {required, minLength, requiredIf} from 'vuelidate/lib/validators'
import {helpers} from "@vuelidate/validators";
import VueAutonumeric from 'vue-autonumeric/dist/vue-autonumeric';
import VueMask from 'v-mask';
import IMask from 'imask';
import DropZoneComponent from "../../DropZoneComponent";
import Vue from "vue";

const telValidator = helpers.regex(/^(7|8) \(\d{3}\) \d{3}-\d{2}-\d{2}$/);
const estatesummValidator = (value) => parseFloat(value) > 0;
const firstpaysummValidator = (value) => parseFloat(value) >= 0;
const refinpercentValidator = (value) => parseFloat(value) > 0;
const refinbalanceValidator = (value) => parseFloat(value) > 0;
const maxEstatetSumValidator = (value) => parseFloat(value) < 999999999;
const dateValidator = helpers.regex(/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/
);

Vue.use(VueMask, {
    placeholders: {
        'A': null,
        Я: /[А-Яа-яЁёA-Za-z\s\-\–\{\[\}\]\;\:\'\"\,\<\.\>]$/,
    }
});

function firstPaySumCheck(value) {
    let estatesummField = $('#estatesumm')
    let estatesummValue = estatesummField.val().replaceAll(/ /g, '')
    return parseFloat(estatesummValue) > parseFloat(value);
}

export default {
    components: {
        DropZoneComponent,
        VueAutonumeric,
    },

    data() {
        return {
            name: "",
            clientphone: "",
            estatetype: null,
            creditprogram: null,
            refinpercent: null,
            refindate: "",
            refinbalance: "",
            type: null,
            estatesumm: "",
            firstpaysumm: "",
            pledges_region: null,
            deals_region: null,
            commentary: "",
            banks: [],
            banks_list: null,
            creditProgramId: null,
            resp: null,
            disabledCheckBoxes: null,
            dropzoneCountFiles: 0,
            banksData: {},
            banksMaxFileSizeError: {},
            banksGreenList: {},
            filesServerError: null,
            max_file_size_text: "",
            regions: {},
            defaultRegion: {},
            disableRefinPersent: false,
            disableRefinDate: false,
            disableRefinBalance: false,
            creditProgramsList: null,
            offices: {},
            variants_rate: {},
            max_count_banks_for_demand: null,
            errorFromServer: 'Возникла ошибка, проверьте корректность заполненных полей!',
        }
    },

    validations: {
        name: {required},
        clientphone: {required, telValidator},
        estatesumm: {required, maxEstatetSumValidator, estatesummValidator},
        firstpaysumm: {required, firstPaySumCheck, firstpaysummValidator},
        banks: {required, minLength: minLength(1)},

        refinpercent: {
            required: requiredIf(function () {
                return this.creditprogram === 5;
            }),
            refinpercentValidator: requiredIf(function () {
                return !refinpercentValidator;
            })
        },
        refindate: {
            required: requiredIf(function () {
                return this.creditprogram === 5;
            }), dateValidator
        },
        refinbalance: {
            required: requiredIf(function () {
                return this.creditprogram === 5;
            }),
            refinbalanceValidator: {
                required: requiredIf(function () {
                    return !refinbalanceValidator;
                })
            }

        },
        pledges_region: {required},
        deals_region: {required},
        estatetype: {required},
        type: {required},
        creditprogram: {required},
    },

    mounted() {
        this.getDataFromServer()
    },
    watch: {
        propertyBanksAndCountFiles() {
            this.banksMaxFileSizeError = {};
            this.banksGreenList = {};
            if (this.dropzoneCountFiles > 0 && this.banks.length > 0) {
                if (Object.keys(this.banksMaxFileSizeError).length > 0) {
                    const objCopy = this.banksMaxFileSizeError;
                    for (let key in objCopy) {
                        if (!this.banksData.hasOwnProperty(key)) {
                            delete this.banksMaxFileSizeError[key]
                            delete this.banksGreenList[key]
                        }
                    }
                }
                for (let key in this.banksData) {
                    if (this.banksData[key].max_files_size != null) {
                        if (this.$refs.dropzoneComponent.dropzoneTotalFilesize > this.banksData[key].max_files_size * 1000000) {
                            this.banksMaxFileSizeError[this.banksData[key].id] = {
                                id: this.banksData[key].id,
                                name: this.banksData[key].name,
                                max_files_size: this.banksData[key].max_files_size
                            }
                            delete this.banksGreenList[this.banksData[key].id]
                        } else {
                            delete this.banksMaxFileSizeError[this.banksData[key].id]
                            this.banksGreenList[this.banksData[key].id] = {
                                id: this.banksData[key].id,
                                name: this.banksData[key].name,
                                max_files_size: this.banksData[key].max_files_size
                            }
                        }
                    } else {
                        this.banksGreenList[this.banksData[key].id] = {
                            id: this.banksData[key].id,
                            name: this.banksData[key].name,
                            max_files_size: this.banksData[key].max_files_size
                        }
                    }
                }
            } else {
                this.banksMaxFileSizeError = {};
            }

            if (Object.keys(this.banksData).length > 0) {
                if (Object.keys(this.banksGreenList).length < 1) {
                    $("#btnSubmit").attr("disabled", true);
                } else {
                    $("#btnSubmit").attr("disabled", false);

                }
            }
        },
    },

    methods: {
        sendDemand() {

            if (this.$v.$invalid) {
                this.$v.$touch()
                for (let key in Object.keys(this.$v)) {
                    const input = Object.keys(this.$v)[key];
                    if (input.includes("$")) return false;
                    if (this.$v[input].$error) {
                        if (this.$refs[input] != null) {
                            if (!this.$refs[input]._isVue) {
                                this.$refs[input].focus();
                            } else {
                                this.$refs[input].$el.focus();
                            }
                        }
                        if (input === 'refinpercent' || input === 'refindate' || input === 'refinbalance') {
                            document.querySelector('#' + input).focus();
                        }
                        console.log(input)
                        console.log(this.$v[input].$error)
                        break;
                    }
                }
                this.resp = null
                return;
            }

            if (this.$refs.dropzoneComponent.$refs.myVueDropzone.getRejectedFiles().length) {
                this.$refs.dropzoneComponent.rejectedFiles = true;
                return;
            }

            if (!this.$refs.dropzoneComponent.$refs.myVueDropzone.getAcceptedFiles().length) {
                $('#modalError').modal('show');
                return;
            }
            let totalSize = 0;
            let files = this.$refs.dropzoneComponent.$refs.myVueDropzone.getAcceptedFiles()
            files.forEach(file => {
                totalSize += file.size
            })
            const data = new FormData()

            if (totalSize > 30000000) {
                return;
            }

            this.resp = null;

            for (let bank of this.banks) {
                if (!this.banksMaxFileSizeError.hasOwnProperty(bank)) {
                    data.append('banks[]', bank)
                }
            }
            if (data.entries().next().done) {
                return;
            }
            for (var ref in this.$refs) {
                this.$refs[ref].disabled = true;
            }
            this.disableRefinPersent = true;
            this.disableRefinDate = true;
            this.disableRefinBalance = true;
            this.disabledCheckBoxes = true;
            $(".dz-hidden-input").prop("disabled", true);
            $("#btnSubmit").attr("disabled", true);
            $("#btnSubmit").html('Подождите...');


            document.getElementById('close_popup_x').classList.add('d-none');
            document.getElementById('waiting_send_demand').classList.remove('d-none');
            document.getElementById('success_send_demand').classList.add('d-none');
            document.getElementById('button_close_modal').classList.add('d-none');
            document.getElementById('error_from_server').classList.add('d-none');
            $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#myModal').modal('show');

            this.refinbalance = this.refinbalance === '' ? '' : parseFloat(this.refinbalance)

            files.forEach(file => {
                data.append('scanfiles[]', file)
            })
            data.append('name', this.name)
            data.append('clientphone', this.clientphone)
            data.append('estatetype', this.estatetype)
            data.append('creditprogram', this.creditprogram)
            if (this.refinpercent != null && this.refinpercent != '') {
                data.append('refinpercent', parseFloat(this.refinpercent))
            }
            data.append('refindate', this.refindate)
            data.append('refinbalance', this.refinbalance)
            data.append('type', this.type)
            data.append('pledges_region', this.pledges_region)
            data.append('deals_region', this.deals_region)
            data.append('commentary', this.commentary)
            data.append('estatesumm', parseFloat(this.estatesumm))
            data.append('firstpaysumm', parseFloat(this.firstpaysumm))

            for (let office in this.offices) {
                if (this.offices[office].offices_id != null && !this.banksMaxFileSizeError.hasOwnProperty(office)) {
                    data.append('offices[]', JSON.stringify(this.offices[office]))
                }
            }
            if (this.variants_rate != null) {
            for (let rate in this.variants_rate) {
                let item = {};
                item[rate] = this.variants_rate[rate];
                if(!this.banksMaxFileSizeError.hasOwnProperty(rate)){
                    data.append('variants_rate[]', JSON.stringify(item))
                }
                }
            }

            axios.post('/api/demands', data).then(response => {
                console.log(response)
                document.getElementById('close_popup_x').classList.remove('d-none');
                document.getElementById('waiting_send_demand').classList.add('d-none');
                document.getElementById('success_send_demand').classList.remove('d-none');
                document.getElementById('button_close_modal').classList.remove('d-none');

                for (var ref in this.$refs) {
                    this.$refs[ref].disabled = false;
                }
                this.disableRefinPersent = false;
                this.disableRefinDate = false;
                this.disableRefinBalance = false;
                this.disabledCheckBoxes = null;
                $(".dz-hidden-input").prop("disabled",false);
                this.name = ""
                this.clientphone = ""
                this.estatetype = null
                this.creditprogram = null
                this.creditProgramId = null
                this.type = null
                this.refinpercent = null
                this.refindate = ""
                this.refinbalance = ""
                this.estatesumm = ""
                this.firstpaysumm = ""
                this.pledges_region = null
                this.deals_region = null
                this.commentary = ""
                this.banksData = {}
                this.banksGreenList = {}
                this.banks = []
                this.resp = response.status
                this.filesServerError = null;
                this.$refs.dropzoneComponent.rejectedFiles = null;
                this.$v.$reset();
                this.$refs.dropzoneComponent.$refs.myVueDropzone.removeAllFiles();
                this.offices = {}
                this.variants_rate = {}
                $("#btnSubmit").attr("disabled", false);
                $("#btnSubmit").html('Отправить заявку');

            })
                .catch(error => {
                    document.getElementById('close_popup_x').classList.remove('d-none');
                    document.getElementById('waiting_send_demand').classList.add('d-none');
                    document.getElementById('error_from_server').classList.remove('d-none');
                    document.getElementById('button_close_modal').classList.remove('d-none');
                    for (var ref in this.$refs) {
                        this.$refs[ref].disabled = false;
                    }
                    $(".dz-hidden-input").prop("disabled",false);
                    this.disabledCheckBoxes = null;
                    console.log(error);
                    console.log(error.response);
                    console.log(error.response.status);
                    this.$refs['name'].focus();
                    this.resp = error.response.status
                    if(error.response.data.errors.hasOwnProperty('scanfiles')){
                        this.filesServerError = true;
                    }
                    for(let key in error.response.data.errors){
                        if(key.match(/^scanfiles.\d*/)) {
                            this.filesServerError = true;
                        }
                        if(key == 'banks'){
                            this.errorFromServer = error.response.data.errors[key][0]
                        } else {
                            this.errorFromServer = 'Возникла ошибка, проверьте корректность заполненных полей!';
                        }
                    }

                    $("#btnSubmit").attr("disabled", false);
                    $("#btnSubmit").html('Отправить заявку');
                });
        },
        getDataFromServer(){
            axios.get('/api/demands/').then(response => {
                this.banks_list = response.data.banks;
                this.max_file_size_text = response.data.text;
                this.regions = response.data.regions;
                this.defaultRegion = response.data.defaultRegion;
                this.creditProgramsList = response.data.creditPrograms;
                this.max_count_banks_for_demand = response.data.max_count_banks_for_demand;
            }).catch(error => {
                console.log(error);
            });
        },

        setCreditProgram(id) {
            this.creditProgramId = id;
            this.showOfficesForOtherPrograms();
        },

        closeModal(){
            $('#myModal').modal('hide');
        },

        closeErrorModal(){
            $('#modalError').modal('hide');
        },

        setOffices(id) {
            let bank = this.banks_list.find(
                bank => {
                    return bank.id === id;
                }
            )

            if (bank.offices !== null && bank.offices !== '[]') {
                if (this.offices.hasOwnProperty(id)) {
                    delete this.offices[id]
                } else {
                    this.addOffice(bank);
                }
            }

            if(bank.emails_for_different_programs !== null && this.creditprogram === 7){
                delete this.offices[id];
            }

            if(this.deals_region !== 1){
                delete this.offices[id];
            }
        },

        setVariantsRate(id){
            let bank = this.banks_list.find(
                bank => {
                    return bank.id === id;
                }
            )

            if (bank.variants_rate !== null && bank.variants_rate_enable === 1) {
                if (this.variants_rate.hasOwnProperty(bank.id)) {
                    delete this.variants_rate[bank.id]
                } else {
                    this.variants_rate[bank.id] = bank.variants_rate.split(';')[0];
                }
            }
        },

        setBankData(name, max_files_size, id){
            if(this.banksData.hasOwnProperty(id)){
                delete this.banksData[id]
                delete this.banksGreenList[id]
            } else {
                this.banksData[id] = {id:id, name: name, max_files_size: max_files_size}
                this.banksGreenList[id] = {id:id, name: name, max_files_size: max_files_size}
            }

            this.setOffices(id);
            this.setVariantsRate(id);
        },
        isBanksNotErrorMaxFiles(id){
            return !this.banksMaxFileSizeError.hasOwnProperty(id)
        },

        autoCompleteRegion(){
            if(this.deals_region === null){
                this.deals_region = this.pledges_region
            }
            this.hideOfficesForOtherRegions();
        },

        showOfficesForOtherPrograms(){
            const banks = this.banks_list;
            for (let bank of banks) {
                if (this.banks.includes(bank.id) && this.deals_region === 1 && bank.offices !== null && bank.offices !== '[]') {
                   if(this.creditprogram === 7 && bank.emails_for_different_programs !== null){
                        if (this.offices.hasOwnProperty(bank.id)) {
                                        delete this.offices[bank.id]
                                    }
                    } else {
                       if (!this.offices.hasOwnProperty(bank.id)) {
                           this.addOffice(bank);
                       }
                   }
                }
            }
        },

        hideOfficesForOtherRegions(){
                const banks = this.banks_list;
                for (let bank of banks) {
                    if (this.banks.includes(bank.id) && bank.offices !== null && bank.offices !== '[]') {
                       if(this.deals_region !== 1){
                           if (this.offices.hasOwnProperty(bank.id)) {
                           delete this.offices[bank.id]
                        }
                       } else {
                            if (!this.offices.hasOwnProperty(bank.id)) {
                               this.addOffice(bank);
                            }
                        }
                        if(this.creditprogram === 7 && bank.emails_for_different_programs !== null){
                            if (this.offices.hasOwnProperty(bank.id)) {
                                delete this.offices[bank.id]
                            }
                        }
                    }
                }
        },

        addOffice(bank){
            this.offices[bank.id] = {
                offices_id: JSON.parse(bank.offices)[0].id,
                offices_name: JSON.parse(bank.offices)[0].name,
                emails: JSON.parse(bank.offices)[0].emails,
                banks_name: JSON.parse(bank.offices)[0].banks_name,
            }
        },

        countBanksMoreThenFive(bank){
            if(this.max_count_banks_for_demand != null){
                return this.banks.length >= this.max_count_banks_for_demand && !this.banks.includes(bank.id)
            } else {
                return false;
            }
        },

        disableCheckBox(bank){
            let disable = false;
            if(this.creditprogram !== null){
                if(!bank.programs_demand.includes(this.creditprogram)){
                    disable = true
                    if(this.banksData.hasOwnProperty(bank.id) && this.banks.indexOf(bank.id) !== -1){
                        delete this.banksData[bank.id]
                        this.banks.splice(this.banks.indexOf(bank.id), 1);
                    }
                    if(this.offices.hasOwnProperty(bank.id)){
                        delete this.offices[bank.id]
                    }
                    if(this.variants_rate.hasOwnProperty(bank.id)){
                        delete this.variants_rate[bank.id]
                    }
                }
            }
            return disable;
        },

        showTooltip(bank){
            let result = 'Банк не принимает заявки по программам: ';
            if(!bank.programs_demand.includes(this.creditprogram)){
                for(let k in this.creditProgramsList){
                    if(!bank.programs_demand.includes(this.creditProgramsList[k].id)){
                        result += this.creditProgramsList[k].title + ', '
                    }
                }
            }
            result = result.substring(0, result.length - 2)
            return result;
        },

        replaceSymbolsForNameInput(){
            var map = {
                'q' : 'й', 'w' : 'ц', 'e' : 'у', 'r' : 'к', 't' : 'е', 'y' : 'н', 'u' : 'г', 'i' : 'ш', 'o' : 'щ',
                'p' : 'з', '[' : 'х', ']' : 'ъ', 'a' : 'ф', 's' : 'ы', 'd' : 'в', 'f' : 'а', 'g' : 'п', 'h' : 'р',
                'j' : 'о', 'k' : 'л', 'l' : 'д', ';' : 'ж', '\'' : 'э', 'z' : 'я', 'x' : 'ч', 'c' : 'с', 'v' : 'м',
                'b' : 'и', 'n' : 'т', 'm' : 'ь', ',' : 'б', '.' : 'ю','Q' : 'Й', 'W' : 'Ц', 'E' : 'У', 'R' : 'К',
                'T' : 'Е', 'Y' : 'Н', 'U' : 'Г', 'I' : 'Ш', 'O' : 'Щ', 'P' : 'З', '{' : 'Х', '}' : 'Ъ', 'A' : 'Ф',
                'S' : 'Ы', 'D' : 'В', 'F' : 'А', 'G' : 'П', 'H' : 'Р', 'J' : 'О', 'K' : 'Л', 'L' : 'Д', ':' : 'Ж',
                '\"' : 'Э', 'Z' : 'Я', 'X' : 'Ч', 'C' : 'С', 'V' : 'М', 'B' : 'И', 'N' : 'Т', 'M' : 'Ь', '<' : 'Б',
                '>' : 'Ю',
            };
            let input = $("#name")[0];
            let startPos = input.selectionStart;
            let endPos = input.selectionEnd;
            let str = this.name;
            let r = '';
            for (let i = 0; i < str.length; i++) {
                r += map[str.charAt(i)] || str.charAt(i);
                r = r.toLowerCase()
                r = r.replace(/(^|\s)\S/g, function(a) {
                    return a.toUpperCase()
                })
                r = r.replace(/\s\s/g, ' ');
            }
            this.name = r;
            setTimeout(() =>  input.setSelectionRange(startPos, endPos))
        },

    },
    computed:{

        isFailSend(){
            return this.resp === 422 || this.resp === 500;
        },
        isDisabledCheckBoxes(){
            return this.disabledCheckBoxes;
        },
        propertyBanksAndCountFiles() {
            return `${this.dropzoneCountFiles}|${this.banks}`;
        },

        creditprogramIsrefin(){
            return this.creditprogram === 5;
        },

        refinInputsIsDisabled(){
            return this.disableRefinPersent &&  this.disableRefinDate && this.disableRefinBalance;
        },

    },

}
</script>

<style lang="scss">
.cssload-loader {
    position: relative;
    left: calc(50% - 50px);
    width: 100px;
    height: 100px;
    perspective: 780px;
}

.cssload-inner {
    position: absolute;
    width: 100%;
    height: 100%;
    box-sizing: border-box;
    -o-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    border-radius: 50%;
    -o-border-radius: 50%;
    -ms-border-radius: 50%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    &.cssload-one {
        left: 0%;
        top: 0%;
        animation: cssload-rotate-one 1.15s linear infinite;
        -o-animation: cssload-rotate-one 1.15s linear infinite;
        -ms-animation: cssload-rotate-one 1.15s linear infinite;
        -webkit-animation: cssload-rotate-one 1.15s linear infinite;
        -moz-animation: cssload-rotate-one 1.15s linear infinite;
        border-bottom: 3px solid #5C5EDC;
    }
    &.cssload-two {
        right: 0%;
        top: 0%;
        animation: cssload-rotate-two 1.15s linear infinite;
        -o-animation: cssload-rotate-two 1.15s linear infinite;
        -ms-animation: cssload-rotate-two 1.15s linear infinite;
        -webkit-animation: cssload-rotate-two 1.15s linear infinite;
        -moz-animation: cssload-rotate-two 1.15s linear infinite;
        border-right: 3px solid rgba(76, 70, 101, 0.99);
    }
    &.cssload-three {
        right: 0%;
        bottom: 0%;
        animation: cssload-rotate-three 1.15s linear infinite;
        -o-animation: cssload-rotate-three 1.15s linear infinite;
        -ms-animation: cssload-rotate-three 1.15s linear infinite;
        -webkit-animation: cssload-rotate-three 1.15s linear infinite;
        -moz-animation: cssload-rotate-three 1.15s linear infinite;
        border-top: 3px solid rgb(233, 144, 138);
    }

}

@keyframes cssload-rotate-one {
    0% {
        transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
    }
    100% {
        transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
    }
}

@-o-keyframes cssload-rotate-one {
    0% {
        -o-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
    }
    100% {
        -o-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
    }
}

@-ms-keyframes cssload-rotate-one {
    0% {
        -ms-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
    }
    100% {
        -ms-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
    }
}

@-webkit-keyframes cssload-rotate-one {
    0% {
        -webkit-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
    }
    100% {
        -webkit-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
    }
}

@-moz-keyframes cssload-rotate-one {
    0% {
        -moz-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
    }
    100% {
        -moz-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
    }
}

@keyframes cssload-rotate-two {
    0% {
        transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
    }
    100% {
        transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
    }
}

@-o-keyframes cssload-rotate-two {
    0% {
        -o-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
    }
    100% {
        -o-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
    }
}

@-ms-keyframes cssload-rotate-two {
    0% {
        -ms-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
    }
    100% {
        -ms-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
    }
}

@-webkit-keyframes cssload-rotate-two {
    0% {
        -webkit-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
    }
    100% {
        -webkit-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
    }
}

@-moz-keyframes cssload-rotate-two {
    0% {
        -moz-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
    }
    100% {
        -moz-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
    }
}

@keyframes cssload-rotate-three {
    0% {
        transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
    }
    100% {
        transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
    }
}

@-o-keyframes cssload-rotate-three {
    0% {
        -o-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
    }
    100% {
        -o-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
    }
}

@-ms-keyframes cssload-rotate-three {
    0% {
        -ms-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
    }
    100% {
        -ms-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
    }
}

@-webkit-keyframes cssload-rotate-three {
    0% {
        -webkit-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
    }
    100% {
        -webkit-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
    }
}

@-moz-keyframes cssload-rotate-three {
    0% {
        -moz-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
    }
    100% {
        -moz-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
    }
}
</style>
