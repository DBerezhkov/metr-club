<template>
    <div class="row">
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button id="close_popup_x" type="button" class="close d-none" data-dismiss="modal" aria-label="Close" @click="closeModal()" style="margin-left: 92%; margin-top: 2%">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <div class="text-center mt-5 mb-5" id="waiting_send_demand">
                            <div class="cssload-loader">
                                <div class="cssload-inner cssload-one"></div>
                                <div class="cssload-inner cssload-two"></div>
                                <div class="cssload-inner cssload-three"></div>
                            </div>
                            <!--                                                </div>-->
                            <h3 class="modal-title text-center mt-3">Подождите...</h3>
                        </div>
                        <div class="d-none" id="success_send_demand">
                            <img src="/img/demands/logo.jpeg" class="mx-auto d-block" style="max-height: 120px">
                            <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Заявка успешно создана!</h3>
                        </div>

                    </div>
                    <div class="modal-footer d-none" id="button_close_modal">
                        <button id="closePopup" type="button" class="btn btn-primary mx-auto pl-5 pr-5" data-dismiss="modal" @click="closeModal()">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeInfoModal()" style="margin-left: 92%; margin-top: 2%">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <br>
                        <div class="modal-title text-center mt-3" id="exampleModalLabel" v-html="textForPopup"></div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mx-auto pl-5 pr-5" data-dismiss="modal" @click="closeInfoModal()">Отправить заявку в Тинькофф или ТКБ</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeErrorModal()" style="margin-left: 92%; margin-top: 2%">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <img src="/img/demands/Warning-icon-isolated-on-transparent-background-PNG.png" class="mx-auto d-block" style="max-height: 160px">
                        <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Пожалуйста, прикрепите сканы документов!</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mx-auto pl-5 pr-5" data-dismiss="modal" @click="closeErrorModal()">Я постараюсь!</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="alert alert-danger"  role="alert" v-if="isFailSend">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                <h4><i class="icon fa fa-exclamation"></i>Возникла ошибка, проверьте корректность заполненных полей!</h4>
            </div>
            <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="exampleInputPassword1">ФИО клиента</label>
                            <input type="text" class="form-control" placeholder="Введите ФИО клиента" ref="name" v-model="name"
                                   :class="{'is-invalid': ($v.name.$dirty && !$v.name.required)}">
                            <small class="invalid-feedback"
                                   v-if="$v.name.$dirty && !$v.name.required"
                            >Укажите ФИО клиента</small>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="exampleInputPassword1">Мобильный телефон</label>
                            <input type="text" class="form-control" id="clientphone" ref="clientphone" v-model="clientphone" placeholder="Введите телефон" required data-inputmask='"mask": "9 (999) 999-99-99"' data-mask
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
                            <label for="exampleInputPassword1">Сумма кредита</label>
                            <input type="text" class="form-control" id="estatesumm" ref="estatesumm" v-model="estatesumm" placeholder="Введите сумму"
                                   :class="{'is-invalid': ($v.estatesumm.$dirty && !$v.estatesumm.required) || ($v.estatesumm.$dirty && !$v.estatesumm.maxEstatetSumValidator)}"
                                   v-mask="currencyMask">
                            <small class="invalid-feedback"
                                   v-if="$v.estatesumm.$dirty && !$v.estatesumm.required"
                            >Укажите стоимость</small>
                            <small class="invalid-feedback"
                                   v-if="$v.estatesumm.$dirty && $v.estatesumm.required && !$v.estatesumm.maxEstatetSumValidator"
                            >Недопустимое число</small>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="exampleInputPassword1">Программа кредитования</label>
                            <select class="custom-select" size="1" ref="type" v-model="type"
                                    @change="setCreditProgram()"
                                    :class="{'is-invalid': ($v.type.$dirty && !$v.type.required)}">
                                <option :value="null" disabled>Выберите программу</option>
                                <option v-for="item in credit_programs" :value="item.id">{{item.title}}</option>
                            </select>
                            <small class="invalid-feedback"
                                   v-if="$v.type.$dirty && !$v.type.required"
                            >Выберите программу</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Комментарий к заявке:</label>
                        <textarea id="commentary" ref="commentary" v-model="commentary" class="form-control" rows="3" placeholder="При необходимости добавьте комментарий"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Выберите банки для отправки заявки:</label>
                        <div class="row">
                            <template v-for="bank in banks_list">
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline" v-tippy="{arrow : true, arrowType : 'round', animation : 'fade', allowHTML: true}" :content="bank.alt_contact_credit">
                                            <input type="checkbox" :id="bank.id" v-model="banks" v-bind:value='bank.id' @checked="isCheckedCheckboxes(bank.name, bank.max_files_size, bank.id)" @change="setBankData(bank.name, bank.max_files_size, bank.id)">
                                            <label :for="bank.id">
                                                {{bank.name}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <p style="color: #DC3543"  v-if="$v.banks.$dirty && !$v.banks.required">Выберите хотя бы один банк для отправки</p>
                    </div>
                    <div class="form-group">
                        <p v-html="max_file_size_text"></p>
                        <div class="text-bold mb-2">Прикрепите сканы документов.</div>
                        <DropZoneComponent ref="dropzoneComponent"></DropZoneComponent>
                        <transition name="fade">
                            <div class="alert alert-danger" id="redList" role="alert" v-if="Object.keys(this.banksMaxFileSizeError).length > 0 && dropzoneCountFiles > 0">
                                <h6><i class="icon fa fa-exclamation"></i>Заявка не будет отправлена в следующие банки, так как превышен объем вложений:</h6>
                                <div v-for="item in banksMaxFileSizeError">- {{item.name}} (Банк принимает максимум {{item.max_files_size}} МБ)</div>
                            </div>
                        </transition>
                        <transition name="fade">
                            <div class="alert alert-success mt-2" id="greenList" role="alert" v-if="Object.keys(this.banksGreenList).length > 0 && dropzoneCountFiles > 0">
                                <h6><i class="icon fa fa-check"></i>Заявка будет отправлена в следующие банки:</h6>
                                <div v-for="item in banksGreenList">- {{item.name}}</div>
                            </div>
                        </transition>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button @click.prevent="sendDemand()" id="btnSubmit" class="btn btn-primary">Отправить заявку</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import createNumberMask from 'text-mask-addons/dist/createNumberMask'
import Inputmask from 'inputmask';
import { required, minLength, requiredIf } from 'vuelidate/lib/validators'
import {helpers} from "@vuelidate/validators";
import IMask from 'imask';
import DropZoneComponent from "../../DropZoneComponent";
const telValidator = helpers.regex(/^(7|8) \(\d{3}\) \d{3}-\d{2}-\d{2}$/);
const maxEstatetSumValidator = (value) => parseInt(value.replace(/ /g,'')) < 999999999;
const dateValidator = helpers.regex(/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/
);

function firstPaySumCheck(value){
    let estatesummField = $('#estatesumm')
    let estatesummValue = parseInt(estatesummField.val().replace(/ /g,''))
    return estatesummValue > parseInt(value.replace(/ /g,''));
}

export default {
    components: {
        DropZoneComponent
    },

    data() {
        return{
            name: "",
            clientphone: "",
            type: null,
            estatesumm: "",
            credit_programs: null,
            commentary: "",
            banks: [],
            banks_list: null,
            resp: null,
            disabledCheckBoxes: null,
            dropzoneCountFiles:0,
            banksData: {},
            banksMaxFileSizeError: {},
            banksGreenList: {},
            filesServerError: null,
            max_file_size_text: "",
            textForPopup: "",
            currencyMask: createNumberMask({
                prefix: '',
                suffix: '',
                thousandsSeparatorSymbol: ' ',
                allowDecimal: true,
                decimalSymbol: '.',
                decimalLimit: 2,
            }),
            percentMask: createNumberMask({
                includeThousandsSeparator: false,
                decimalSymbol: '.',
                allowDecimal: true,
                integerLimit: 3,
                prefix: '',
                suffix: '%',
            })
        }
    },

    validations:{
        name:{required},
        clientphone:{ required, telValidator},
        estatesumm:{required, maxEstatetSumValidator},
        banks:{ required, minLength: minLength(1)},
        type: {required},
    },

    mounted() {
        this.getDataFromServer()
        let imPhone = new Inputmask("9 (999) 999-99-99");
        imPhone.mask(document.getElementById('clientphone'));
    },
    watch: {
        propertyBanksAndCountFiles() {
            this.banksMaxFileSizeError = {};
            this.banksGreenList = {};
            if(this.dropzoneCountFiles > 0 && this.banks.length > 0){
                if(Object.keys(this.banksMaxFileSizeError).length > 0){
                    const objCopy = this.banksMaxFileSizeError;
                    for(let key in objCopy){
                        if(!this.banksData.hasOwnProperty(key)){
                            delete this.banksMaxFileSizeError[key]
                            delete this.banksGreenList[key]
                        }
                    }
                }
                for (let key in this.banksData) {
                    if (this.banksData[key].max_files_size != null) {
                        if (this.$refs.dropzoneComponent.dropzoneTotalFilesize > this.banksData[key].max_files_size * 1000000) {
                            this.banksMaxFileSizeError[this.banksData[key].id] = {id:this.banksData[key].id, name: this.banksData[key].name, max_files_size: this.banksData[key].max_files_size}
                            delete this.banksGreenList[this.banksData[key].id]
                        } else{
                            delete this.banksMaxFileSizeError[this.banksData[key].id]
                            this.banksGreenList[this.banksData[key].id] = {id:this.banksData[key].id, name: this.banksData[key].name, max_files_size: this.banksData[key].max_files_size}
                        }
                    } else {
                        this.banksGreenList[this.banksData[key].id] = {id:this.banksData[key].id, name: this.banksData[key].name, max_files_size: this.banksData[key].max_files_size}
                    }
                }
            } else {
                this.banksMaxFileSizeError = {};
            }

            if(Object.keys(this.banksData).length > 0){
                if(Object.keys(this.banksGreenList).length < 1){
                    $("#btnSubmit").attr("disabled", true);
                } else {
                    $("#btnSubmit").attr("disabled", false);

                }
            }
        },
        infoForModalIsNotEmpty: {
            handler: function () {
                if(this.textForPopup !== "" && this.textForPopup !== null){
                    $('#modalInfo').modal('show');
                }
            }
        }
    },

    methods: {
        setCreditProgram() {
            this.banks_list.forEach( bank => {
                let checkbox = document.getElementById(bank['id'])
                if(!bank['programs_credit'].includes(this.type)) {
                    checkbox.disabled = true
                    checkbox.checked = false
                    if(this.banksData.hasOwnProperty(bank.id)){
                        delete this.banksData[bank.id]
                        delete this.banksMaxFileSizeError[bank.id]
                        delete this.banksGreenList[bank.id]
                    }
                }
                else {
                    if(!this.banksData.hasOwnProperty(bank.id) && checkbox.checked) {
                        this.banksData[id] = {id:bank.id, name: bank.name, max_files_size: bank.max_files_size}
                        this.banksGreenList[id] = {id:bank.id, name: bank.name, max_files_size: bank.max_files_size}
                    }
                    checkbox.disabled = false
                }
            })
        },
        isCheckedCheckboxes(name, max_files_size, id) {
            this.setBankData(name, max_files_size, id)
            return this.banks_list.id['programs_credit'].includes(this.type);
        },
        sendDemand(){
            if(this.$v.$invalid){
                this.$v.$touch()
                for (let key in Object.keys(this.$v)) {
                    const input = Object.keys(this.$v)[key];
                    if (input.includes("$")) return false;
                    if (this.$v[input].$error) {
                        if(this.$refs[input] != null){
                            this.$refs[input].focus();
                        }
                        break;
                    }
                }
                this.resp = null
                return;
            }

            if(this.$refs.dropzoneComponent.$refs.myVueDropzone.getRejectedFiles().length){
                this.$refs.dropzoneComponent.rejectedFiles = true;
                return;
            }

            if(!this.$refs.dropzoneComponent.$refs.myVueDropzone.getAcceptedFiles().length){
                $('#modalError').modal('show');
                return;
            }
            let totalSize = 0;
            let files = this.$refs.dropzoneComponent.$refs.myVueDropzone.getAcceptedFiles()
            files.forEach(file => {totalSize += file.size})
            const data = new FormData()

            if (totalSize > 30000000){
                return;
            }

            this.resp = null;

            for(let bank of this.banks){
                if(!this.banksMaxFileSizeError.hasOwnProperty(bank)){
                    data.append('banks[]',  bank )
                }
            }
            if(data.entries().next().done){
                return;
            }
            for (var ref in this.$refs) {
                this.$refs[ref].disabled = true;
            }
            //this.disabledCheckBoxes = true;
            this.banks_list.forEach( bank => {
                let checkbox = document.getElementById(bank['id'])
                    checkbox.disabled = true
                    console.log('Выключили')
            })
            $(".dz-hidden-input").prop("disabled",true);
            $("#btnSubmit").attr("disabled", true);
            $("#btnSubmit").html('Подождите...');

            document.getElementById('close_popup_x').classList.add('d-none');
            document.getElementById('waiting_send_demand').classList.remove('d-none');
            document.getElementById('success_send_demand').classList.add('d-none');
            document.getElementById('button_close_modal').classList.add('d-none');

            $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#myModal').modal('show');

            files.forEach(file => { data.append('scanfiles[]', file) })
            data.append('name', this.name)
            data.append('clientphone',  this.clientphone)
            data.append('type',  this.type )
            data.append('commentary',  this.commentary)
            data.append('estatesumm',  parseFloat(this.estatesumm.replace(/ /g,'')) )

            axios.post('/api/credits', data).then(response =>
            {
                document.getElementById('close_popup_x').classList.remove('d-none');
                document.getElementById('waiting_send_demand').classList.add('d-none');
                document.getElementById('success_send_demand').classList.remove('d-none');
                document.getElementById('button_close_modal').classList.remove('d-none');

                for (var ref in this.$refs) {
                    this.$refs[ref].disabled = false;
                }
                this.disabledCheckBoxes = null;
                $(".dz-hidden-input").prop("disabled",false);
                this.name = ""
                this.clientphone = ""
                this.type = null
                this.estatesumm = ""
                this.commentary = ""
                this.banksData = {}
                this.banksGreenList = {}
                this.banks = []
                this.resp = response.status
                this.filesServerError = null;
                this.$refs.dropzoneComponent.rejectedFiles = null;
                this.$v.$reset();
                this.$refs.dropzoneComponent.$refs.myVueDropzone.removeAllFiles();
                $("#btnSubmit").attr("disabled", false);
                $("#btnSubmit").html('Отправить заявку');
            })
                .catch(error => {
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
                    }

                    $("#btnSubmit").attr("disabled", false);
                    $("#btnSubmit").html('Отправить заявку');
                });
        },

        getDataFromServer(){
            axios.get('/api/credits/').then(response => {
                this.banks_list = response.data.banks;
                this.credit_programs = response.data.credit_programs;
                this.max_file_size_text = response.data.text;
                this.textForPopup = response.data.textForPopup;
            }).catch(error => {
                console.log(error);
            });
        },

        closeModal(){
            $('#myModal').modal('hide');
        },

        closeErrorModal(){
            $('#modalError').modal('hide');
        },

        closeInfoModal(){
            $('#modalInfo').modal('hide');
        },

        setBankData(name, max_files_size, id){
            if(this.banksData.hasOwnProperty(id)){
                delete this.banksData[id]
                delete this.banksGreenList[id]
            } else {
                this.banksData[id] = {id:id, name: name, max_files_size: max_files_size}
                this.banksGreenList[id] = {id:id, name: name, max_files_size: max_files_size}
            }
        },

        isBanksNotErrorMaxFiles(id){
            return !this.banksMaxFileSizeError.hasOwnProperty(id)
        },

        autoCompleteRegion(){
            if(this.deals_region === null){
                this.deals_region = this.pledges_region
            }
        }
    },
    computed:{
        isFailSend(){
            return this.resp === 422 || this.resp === 500;
        },
        isDisabledCheckBoxes(){
           return this.disabledCheckBoxes
        },
        propertyBanksAndCountFiles() {
            return `${this.dropzoneCountFiles}|${this.banks}`;
        },
        infoForModalIsNotEmpty(){
            return this.textForPopup;
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
        border-top: 3px solid  rgb(233, 144, 138);
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
