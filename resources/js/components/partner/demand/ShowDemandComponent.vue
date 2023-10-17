<template>
    <div>
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()" style="margin-left: 92%; margin-top: 2%">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <img src="/img/demands/logo.jpeg" class="mx-auto d-block" style="max-height: 120px">
                        <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Файлы успешно отправлены!</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mx-auto pl-5 pr-5" data-dismiss="modal" @click="closeModal()">Закрыть</button>
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
        <div class="modal fade" id="modalСontacts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeContactModal()" style="margin-left: 92%; margin-top: 2%">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body">
                        <h5 class="modal-title text-center mt-3 mb-3" id="exampleModalLabel">Свяжитесь с нами для уточнения статуса заявки</h5>
                        <div class="d-flex justify-content-center">
                            <a href="https://api.whatsapp.com/send/?phone=79934882433&type=phone_number&app_absent=0" target="_blank">
                                <img class="contacts_logo mr-3" src="/img/whatsapp.png" alt="whatsapp_logo"></a>
                            <a href="https://t.me/Metrclub_zayavka" target="_blank"><img class="contacts_logo mr-3" src="/img/telegram.png" alt="telegram_logo"></a>
                            <a href="mailto: zayavka@metr.club" target="_blank"><img class="contacts_logo" src="/img/email.png" alt="email_logo"></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mx-auto pl-5 pr-5" data-dismiss="modal" @click="closeContactModal()">Я ВСЁ ПОНЯЛ</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-danger"  role="alert" v-if="isFailSend">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
            <h4><i class="icon fa fa-exclamation"></i>Возникла ошибка, проверьте корректность заполненных полей!</h4>
        </div>
        <div class="row">
            <div class="col-sm-6 mb-3">
                <label for="exampleInputPassword1">ФИО клиента</label>
                <input type="text" class="form-control" id="clientname" :value="demand.name" disabled>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="exampleInputPassword1">Мобильный телефон</label>
                <input type="text" class="form-control" id="email-copy-bank" :value="demand.contact_phone" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 mb-3">
                <label for="exampleInputPassword1">Стоимость объекта</label>
                <input type="text" class="form-control" id="email-copy-bank" :value="demand.estate_summ" disabled>
            </div>
            <div class="col-sm-4 mb-3">
                <label for="exampleInputPassword1">Первый взнос</label>
                <input type="text" class="form-control" id="email-copy-bank" :value="demand.first_pay_summ" disabled>
            </div>
            <div class="col-sm-4 mb-3">
                <label for="exampleInputPassword1">Тип недвижимости</label>
                <select class="custom-select" disabled>
                    <option selected>{{ demand.type }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 mb-3">
                <label for="exampleInputPassword1">Цель кредитования</label>
                <select disabled class="custom-select" v-model="estatetype">
                    <option value="1">Первичка</option>
                    <option value="2">Вторичка</option>
                    <option value="3">Загородная</option>
                </select>
            </div>
            <div class="col-sm-3 mb-3">
                <label for="exampleInputPassword1">Программа</label>
                <select disabled class="custom-select" v-model="creditprogram">
                    <option value="1">Стандарт</option>
                    <option value="2">Семейная ипотека</option>
                    <option value="3">Господдержка</option>
                    <option value="4">По двум документам</option>
                    <option value="5">Рефинансирование</option>
                    <option value="6">IT-ипотека</option>
                    <option value="7">Под залог недвижимости</option>
                    <option value="8">Военная ипотека</option>
                </select>
            </div>
            <div class="col-sm-3 mb-3">
                <label for="exampleInputPassword1">Регион залога</label>
                <select disabled class="custom-select">
                    <option selected>{{ pledges_region }}</option>
                </select>
            </div>
            <div class="col-sm-3 mb-3">
                <label for="exampleInputPassword1">Регион сделки</label>
                <select disabled class="custom-select">
                    <option selected>{{ deals_region }}</option>
                </select>
            </div>
        </div>
        <div class="form-group" id="refinparams" v-if="demand.creditprogram === 5">
            <label for="exampleInputPassword1">Параметры текущего кредита:</label>
            <div class="row">

                <div class="col-sm-4 mb-3">
                    <div class="form-group clearfix">

                        <label for="exampleInputPassword1">Ставка</label>
                        <input type="text" class="form-control" id="refinpercent" disabled
                               :value="demand.refin_percent">

                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <div class="form-group clearfix">

                        <label for="exampleInputPassword1">Дата окончания</label>
                        <input type="text" class="form-control" id="refindate" disabled :value="demand.refin_date">

                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <div class="form-group clearfix">

                        <label for="exampleInputPassword1">Остаток задолженности</label>
                        <input type="text" class="form-control" id="refinbalance" disabled
                               :value="demand.refin_balance">

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Комментарий к заявке:</label>
            <textarea id="commentary" class="form-control" rows="3" disabled> {{ demand.commentary }} </textarea>
        </div>

        <div class="form-group mt-3">
            <label for="exampleInputPassword1" v-if="!show">Заявка отправлена в банки</label>
            <div v-if="!show">Нажмите на логотип, чтобы узнать статус</div>
            <label for="exampleInputPassword1" v-if="show" class="text-danger">Пожалуйста, укажите в какие банки
                необходимо отправить дополнительные файлы</label>
            <div class="row">
                <template v-for="bank in banks_list">
                    <div class="col-sm-3 d-flex align-items-center" v-if="isBanksListContainsBanksId(bank.id)">
                        <!-- checkbox -->
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-flex" :class="{'my-top': bank.banks_logo != null}">
                                <input type="checkbox" :id="bank.id" v-bind:value='bank.id' @change="setBankData(bank.name, bank.max_files_size, bank.id)"
                                       :disabled="!showElementsForAddingNewFiles || (showElementsForAddingNewFiles && !isBanksListContainsBanksId(bank.id)) || isDisabledCheckBoxes" v-model="banksForSendingNewFiles">
                                <label :for="bank.id" class="d-none align-items-center" v-if="!show">
                                </label>
                                <div class="d-flex align-items-center" v-if="!show">
                                        <a :href="'/reward/'+ bank.id +'/contacts'" target="_blank" v-if="bank.banks_logo != null && bank.email !== 'zayavka@metr.club'"><img :src="'/img/banks/' + bank.id + '/' + bank.banks_logo" :alt="bank.name" style="width: 140px"></a>
                                        <a :href="'/reward/'+ bank.id +'/contacts'" target="_blank" v-if="bank.banks_logo === null && bank.email !== 'zayavka@metr.club'"><div class="text-bold text-dark">{{bank.name}}</div></a>
                                    <a type="button" @click="openContactModal()" v-if="bank.banks_logo != null && bank.email === 'zayavka@metr.club'"><img :src="'/img/banks/' + bank.id + '/' + bank.banks_logo" :alt="bank.name" style="width: 140px"></a>
                                    <a  type="button" @click="openContactModal()" v-if="bank.banks_logo === null && bank.email === 'zayavka@metr.club'"><div class="text-bold text-dark">{{bank.name}}</div></a>
                                    </div>
                                <label :for="bank.id" class="d-flex align-items-center" v-else>
                                    <img :src="'/img/banks/' + bank.id + '/' + bank.banks_logo" :alt="bank.name" style="width: 140px" v-if="bank.banks_logo != null">
                                   <div v-else>{{bank.name}}</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <p style="color: #DC3543"  v-if="$v.banksForSendingNewFiles.$dirty && !$v.banksForSendingNewFiles.required">Выберите хотя бы один банк для отправки</p>
        </div>
       <div class="form-group">
           <label for="exampleInputPassword1" v-if="offices != null">Офисы банков:</label>
           <div class="row" v-if="offices != null">
               <template v-for="office in offices">
                   <div class="col-sm-3">
                       <div class="form-group clearfix">
                           <label for="exampleInputPassword1">{{JSON.parse(office).banks_name}}</label>
                           <select  class="custom-select" size="1" disabled>
                               <option>{{JSON.parse(office).offices_name}}</option>
                           </select>
                       </div>
                   </div>
               </template>
           </div>
       </div>

        <div class="form-group">
            <label for="exampleInputPassword1" v-if="rates != null && banks_list != null">Ставка для клиента:</label>
            <div class="row" v-if="rates != null && banks_list != null">
                <template v-for="rate in rates">
                    <div class="col-sm-3">
                        <div class="form-group clearfix">
                            <label for="exampleInputPassword1">{{ banks_list.filter(x => x.id === parseInt(Object.keys(JSON.parse(rate))))[0].name}}</label>
                            <select  class="custom-select" size="1" disabled>
                                <option>{{Object.values(JSON.parse(rate)).toString()}}</option>
                            </select>
                        </div>
                    </div>
                </template>
            </div>
        </div>


        <div class="form-group">
            <button type="button" id="addNewFilesBtn" class="btn btn-primary" @click="setShow()">Отправить
                дополнительные файлы в банк
            </button>
        </div>
        <transition name="slide-fade">
            <div v-if="show">
                <p v-html="max_file_size_text"></p>
                <DropZoneComponent ref="dropzoneComponent"></DropZoneComponent>
                <transition-group name="fade">
                <div class="alert alert-danger" id="redList" role="alert" v-if="Object.keys(this.banksMaxFileSizeError).length > 0 && dropzoneCountFiles > 0" :key="1">
                    <h6><i class="icon fa fa-exclamation"></i>Файлы не будут отправлены в следующие банки, так как превышен объем вложений:</h6>
                    <div v-for="item in banksMaxFileSizeError">- {{item.name}} (Банк принимает максимум {{item.max_files_size}} МБ)</div>
                </div>
                <div class="alert alert-success mt-2" id="greenList" role="alert" v-if="Object.keys(this.banksGreenList).length > 0 && dropzoneCountFiles > 0" :key="2">
                    <h6><i class="icon fa fa-check"></i>Файлы будут отправлены в следующие банки:</h6>
                    <div v-for="item in banksGreenList">- {{item.name}}</div>
                </div>
                </transition-group>
                <button id="btnSubmit" class="btn btn-primary mt-3" @click.prevent="sendNewFiles()">Отправить</button>
            </div>
        </transition>

        <div class="form-group">
            <label for="exampleFormControlFile1">Отправленные файлы</label>
            <div class="form-group">
                <button type="button" id="downloadBtn" class="btn btn-success" @click="downloadFiles()">Скачать все файлы архивом</button>
            </div>

            <div>
                <div class="form-group clearfix mb-0" v-for="(item, index) in files_list">
                    <div>
                        <a :href="/clients/ + demand.uid + '/' + filesList[index]" target="_blank">
                            <div class="file-preview file-image-preview">
                                <div class="file-image">
                                    <img :id="filesList[index] + index" :src="/clients/ + demand.uid + '/' + filesList[index]" alt="" style="height: 100%; width: 100%; object-fit: cover;"
                                         onerror="this.src='/img/dropzone/default.png'">
                                </div>
                                <div class="file-details">
                                    <div class="file-filename">
                                            <div class="file-filename__name">{{filesList[index]}}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import DropZoneComponent from "../../DropZoneComponent";
import {required, minLength, requiredIf} from 'vuelidate/lib/validators'
import {helpers} from "@vuelidate/validators";

export default {
    props: ['demand', 'pledges_region', 'deals_region'],
    components: {
        DropZoneComponent
    },

    data() {
        return {
            banks_list: null,
            files_list: null,
            max_file_size_text: "",
            estatetype: this.demand.estatetype,
            creditprogram: this.demand.creditprogram,
            banks: this.demand.banks_list.toString().replaceAll('"', '').replace('[', '').replace(']', '').split(','),
            offices: JSON.parse(this.demand.offices_list),
            rates: JSON.parse(this.demand.rate_list),
            banksForSendingNewFiles: [],
            banksMaxFileSizeError: {},
            disabledCheckBoxes: null,
            regions: {},
            show: false,
            filesServerError: null,
            banksGreenList: {},
            banksData: {},
            dropzoneCountFiles:0,
            resp: null,
            attributesForDownloadFiles: {
                clientname: this.demand.name,
                uid: this.demand.uid
            },
        }
    },

    validations: {
        banksForSendingNewFiles: {
            required: requiredIf(function () {
                return this.show;
            }), minLength: minLength(1)
        },
    },

    mounted() {
        this.getDataFromServer()
        this.getFilesNameFromServer()
        for(let bank of this.banks){
            this.banksForSendingNewFiles.push(bank)
        }
    },
    watch: {
        propertyBanksAndCountFiles() {
            this.banksMaxFileSizeError = {};
            this.banksGreenList = {};
            if(this.dropzoneCountFiles > 0 && this.banksForSendingNewFiles.length > 0){
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
    },

    methods: {
        getDataFromServer() {
            axios.get('/api/demands/').then(response => {
                this.banks_list = response.data.banks;
                this.max_file_size_text = response.data.text;
                this.regions = response.data.regions;
                this.defaultRegion = response.data.defaultRegion;
            }).catch(error => {
                console.log(error);
            });
        },

        getFilesNameFromServer() {
            axios.get('/api/demands/send_new_files/' + this.demand.id).then(
                response => {
                    this.files_list = response.data.files;
                    this.setIconForUploadFile(response.data.files);
                }
            ).catch(error => {
                console.log(error);
            });
        },

        isBanksListContainsBanksId(id) {
            return this.banks.includes(id.toString());
        },

        setShow() {
            this.show = !this.show
            this.banksForSendingNewFiles = []
            if (!this.show) {
                $("#addNewFilesBtn").html('Отправить дополнительные файлы в банк');
                for(let bank of this.banks){
                    this.banksForSendingNewFiles.push(bank)
                }
            } else {
                $("#addNewFilesBtn").html('Не отправлять дополнительные файлы в банк');
            }
        },

        setBanksForSendingNewFiles(id){
            this.banksForSendingNewFiles = id
        },

        sendNewFiles() {
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

            for(let bank of this.banksForSendingNewFiles){
                if(!this.banksMaxFileSizeError.hasOwnProperty(bank)){
                    data.append('banks[]',  bank )
                }
            }
            if(data.entries().next().done){
                return;
            }
            this.disabledCheckBoxes = true;
            $(".dz-hidden-input").prop("disabled",true);
            $("#btnSubmit").attr("disabled", true);
            $("#btnSubmit").html('Подождите...');

            files.forEach(file => { data.append('scanfiles[]', file) })
            data.append('demand', JSON.stringify(this.demand))

            axios.post('/api/demands/send_new_files', data).then(response =>
            {
                $('#myModal').modal('show');
                console.log(response.data)
                this.banksGreenList = {};
                this.banksMaxFileSizeError = {};
                this.banksForSendingNewFiles = [];
                this.banksData = {};
                this.resp = response.status;
                this.filesServerError = null;
                this.disabledCheckBoxes = null;
                $(".dz-hidden-input").prop("disabled",false);
                this.show = false;
                this.$refs.dropzoneComponent.rejectedFiles = null;
                this.$v.$reset();
                this.$refs.dropzoneComponent.$refs.myVueDropzone.removeAllFiles();
                $("#btnSubmit").attr("disabled", false);
                $("#btnSubmit").html('Отправить');
                $("#addNewFilesBtn").html('Отправить дополнительные файлы в банк');
                for(let bank of this.banks){
                    this.banksForSendingNewFiles.push(bank)
                }
                this.getFilesNameFromServer();
            })
                .catch(error => {

                    $(".dz-hidden-input").prop("disabled",false);
                    this.disabledCheckBoxes = null;
                    this.resp = error.response.status
                    console.log(error);
                    console.log(error.response.status);
                    console.log(error.response);
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
        closeErrorModal(){
            $('#modalError').modal('hide');
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

        downloadFiles(){
            $("#downloadBtn").attr("disabled", true);
            $("#downloadBtn").html("Подождите...");
            axios.post('/api/download', this.attributesForDownloadFiles,  { responseType: 'application/zip' }).then(response => {
                window.location.href = response.data;
                $("#downloadBtn").attr("disabled", false);
                $("#downloadBtn").html("Скачать все файлы архивом");
            }).catch(error => {
                console.log('Внимание! произошла ошибка:' + error);
                $("#downloadBtn").attr("disabled", false);
                $("#downloadBtn").html("Скачать все файлы архивом");
            })
        },

        closeModal(){
            $('#myModal').modal('hide');
        },

        openContactModal(){
            $('#modalСontacts').modal('show');
        },

        closeContactModal(){
            $('#modalСontacts').modal('hide');
        },

        setIconForUploadFile(names){
            for (let [index, name] of names.entries()){
                if(name.toLowerCase().includes('.pdf'.toLowerCase())){
                    $(document).ready(function () {
                        document.getElementById(name+index).src="/img/dropzone/PDF.png";
                    })
                } else if(name.toLowerCase().includes('.xlsx'.toLowerCase()) ||
                    name.toLowerCase().includes('.xls'.toLowerCase())){
                    $(document).ready(function () {
                        document.getElementById(name+index).src="/img/dropzone/EXCEL_2.png";
                    })
                } else if(name.toLowerCase().includes('.zip'.toLowerCase()) || name.toLowerCase().includes('.rar'.toLowerCase())){
                    $(document).ready(function () {
                        document.getElementById(name+index).src="/img/dropzone/ARCHIVE.png";
                    })
                } else if(name.toLowerCase().includes('.doc'.toLowerCase()) ||
                    name.toLowerCase().includes('.docx'.toLowerCase())){
                    $(document).ready(function () {
                        document.getElementById(name+index).src="/img/dropzone/WORD.png";
                    })
                } else {
                    if(!name.toLowerCase().includes('.jpg'.toLowerCase()) &&
                        !name.toLowerCase().includes('.jpeg'.toLowerCase()) &&
                        !name.toLowerCase().includes('.png'.toLowerCase())){
                        $(document).ready(function () {
                            document.getElementById(name+index).src="/img/dropzone/default.png";
                        })
                    }
                }
            }
        }


    },
    computed: {
        isFailSend(){
            return this.resp === 422 || this.resp === 500;
        },
        showElementsForAddingNewFiles() {
            return this.show;
        },

        isDisabledCheckBoxes(){
            return this.disabledCheckBoxes;
        },

        propertyBanksAndCountFiles() {
            return `${this.dropzoneCountFiles}|${this.banksForSendingNewFiles}`;
        },

        filesList() {
            return this.files_list;
        }

    },

}
</script>

<style scoped>
[class*=my-top]>input:first-child:checked+input[type=hidden]+label::after, [class*=my-top]>input:first-child:checked+label::after{
    top: 30px;
}

.contacts_logo{
    width: 50px;
    height: 50px;
}

.slide-fade-enter-active {
    transition: all .3s ease;
}

.slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */
{
    transform: translateX(10px);
    opacity: 0;
}

.file-preview {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin: 16px 16px 16px 0;
    max-height: 75px;
}
.file-preview:hover {
    z-index: 1000;
}
.file-preview:hover .file-details {
    opacity: 1;
}
.file-preview.file-file-preview .file-image {
    border-radius: 20px;
    background: #999;
}
.file-preview.file-file-preview .file-details {
    opacity: 1;
}
.file-preview.file-image-preview .file-details {
    -webkit-transition: opacity 0.2s linear;
    -moz-transition: opacity 0.2s linear;
    -ms-transition: opacity 0.2s linear;
    -o-transition: opacity 0.2s linear;
    transition: opacity 0.2s linear;
}
.file-preview .file-remove {
    font-size: 14px;
    text-align: center;
    display: block;
    cursor: pointer;
    border: none;
}

.file-preview:hover .file-details {
    opacity: 1;
}
.file-preview .file-details {
    z-index: 20;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    font-size: 18px;
    min-width: 100%;
    max-width: 100%;
    padding: 2em 1em;
    text-align: center;
    color: rgba(0, 0, 0, 0.9);
    line-height: 150%;
    max-height: 75px;
}

.file-preview:hover .file-image img {
    -webkit-transform: scale(1.05, 1.05);
    -moz-transform: scale(1.05, 1.05);
    -ms-transform: scale(1.05, 1.05);
    -o-transform: scale(1.05, 1.05);
    transform: scale(1.05, 1.05);
    /*-webkit-filter: blur(8px);*/
    /*filter: blur(8px);*/
}
.file-preview .file-image {
    border-radius: 20px;
    overflow: hidden;
    width: 75px;
    height: 75px;
    position: relative;
    display: block;
    font-size: 18px;
    z-index: 10;
}
.file-preview .file-image img {
    display: block;
}
.file-preview.file-success .file-success-mark {
    -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
}
.file-preview.file-error .file-error-mark {
    opacity: 1;
    -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
}
.file-preview .file-success-mark, .file-preview .file-error-mark {
    pointer-events: none;
    opacity: 0;
    z-index: 500;
    position: absolute;
    display: block;
    top: 50%;
    left: 50%;
    margin-left: -27px;
    margin-top: -27px;
}
.file-preview .file-success-mark svg, .file-preview .file-error-mark svg {
    display: block;
    width: 54px;
    height: 54px;
}
.file-preview.file-processing .file-progress {
    opacity: 1;
    -webkit-transition: all 0.2s linear;
    -moz-transition: all 0.2s linear;
    -ms-transition: all 0.2s linear;
    -o-transition: all 0.2s linear;
    transition: all 0.2s linear;
}
.file-preview.file-complete .file-progress {
    opacity: 0;
    -webkit-transition: opacity 0.4s ease-in;
    -moz-transition: opacity 0.4s ease-in;
    -ms-transition: opacity 0.4s ease-in;
    -o-transition: opacity 0.4s ease-in;
    transition: opacity 0.4s ease-in;
}
.file-preview:not(.file-processing) .file-progress {
    -webkit-animation: pulse 6s ease infinite;
    -moz-animation: pulse 6s ease infinite;
    -ms-animation: pulse 6s ease infinite;
    -o-animation: pulse 6s ease infinite;
    animation: pulse 6s ease infinite;
}
.file-preview .file-progress {
    opacity: 1;
    z-index: 1000;
    pointer-events: none;
    position: absolute;
    height: 16px;
    left: 50%;
    top: 50%;
    margin-top: -8px;
    width: 80px;
    margin-left: -40px;
    background: rgba(255, 255, 255, 0.9);
    -webkit-transform: scale(1);
    border-radius: 8px;
    overflow: hidden;
}
.file-preview .file-progress .file-upload {
    background: #333;
    background: linear-gradient(to bottom, #666, #444);
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 0;
    -webkit-transition: width 300ms ease-in-out;
    -moz-transition: width 300ms ease-in-out;
    -ms-transition: width 300ms ease-in-out;
    -o-transition: width 300ms ease-in-out;
    transition: width 300ms ease-in-out;
}
.file-preview.file-error .file-error-message {
    display: block;
}
.file-preview.file-error:hover .file-error-message {
    opacity: 1;
    pointer-events: auto;
}

.file-preview .file-details {
    background-color: rgba(119, 127, 134, 0);
    opacity: 1;
    color: black;
}


.file-preview .file-image {
    border-radius: 20px;
}

.file-preview.file-file-preview .file-details {
    border-radius: 20px;

}

.file-preview.file-image-preview .file-details {
    border-radius: 20px;
    min-height: 75px;
}

.file-preview.file-image-preview {
    border-radius: 20px;
}

.file-preview {
    max-width: 75px;
    max-height: 75px;
}


.file-preview .file-image img:not([src]) {
    max-width: 120px;
    max-height: 120px;
}


.file-filename {
    position: relative;
    top: -37px;
    left: 70px;
    height: 75px;
    display: flex;
    align-items: center;
    min-width: 1000px;
    text-align: left;
}


@media(max-width: 1374px){
    .file-filename {
        min-width: 900px;
    }

}

@media(max-width: 1274px){
    .file-filename {
        min-width: 633px;
    }

}

@media(max-width: 1274px){
    .file-filename {
        min-width: 633px;
    }

}

@media(max-width: 1017px){
    .file-filename {
        min-width: 550px;
        font-size: 16px;
    }

}

@media(max-width: 682px){
    .file-filename {
        min-width: 450px;
        font-size: 16px;
    }

}

@media(max-width: 575px){
    .file-filename {
        min-width: 411px;
        font-size: 14px;
    }

}

@media(max-width: 531px){
    .file-filename {
        min-width: 332px;
        font-size: 14px;
    }

}

@media(max-width: 465px){
    .file-filename {
        margin-top: 5px;
        min-width: 292px;
        font-size: 12px;
    }

}

@media(max-width: 410px){
    .file-filename {
        margin-top: 5px;
        min-width: 265px;
        font-size: 11px;
    }

}

@media(max-width: 373px){
    .file-filename {
        margin-top: 5px;
        min-width: 233px;
        font-size: 11px;
    }

}

@media(max-width: 350px){
    .file-filename {
        margin-top: 11px;
        min-width: 196px;
        font-size: 9px;
    }

}

@media(max-width: 318px){
    .file-filename {
        margin-top: 11px;
        min-width: 184px;
        font-size: 9px;
    }

}

@media(max-width: 301px){
    .file-filename {
        margin-top: 11px;
        min-width: 150px;
        font-size: 9px;
    }

}

</style>
