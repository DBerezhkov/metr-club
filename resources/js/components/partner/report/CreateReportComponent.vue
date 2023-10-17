<template>
    <div class="card-body">
        <transition name="fade" mode="out-in">
        <section v-if="step === 1" key="1">
        <h3 class="mb-3">Сведения о ипотечных сделках</h3>
        <p>Несмотря на то, что тут и мартышка справится, нужно вписать какой-то умный текст о том, как правильно заполнять эту наисложнейшую форму, ведь агенты - идиоты и ничего не поймут даже с десятого раза, это очевидно! Необходимо принять данный факт со слезами на глазах и родить</p>
        <ol>
            <li>пошаговое</li>
            <li>руководство</li>
            <li>для</li>
            <li>этих</li>
            <li>долбоящеров!</li>
        </ol>
        <div>
            <div>
                <div class="row">
                    <div class="col-8">
                    <div class="row">
                    <div class="form-group col-sm-5">
                        <label for="">ФИО клиента</label>
                        <div class="input-group">
                            <SearchAutocompleteComponent
                                v-model="client_name_mortgage"
                                :myid="this.input_name_mortgage"
                                :url="this.search_url"
                                :exceptions="this.exceptions"
                                :invalid="($v.client_name_mortgage.$dirty && !$v.client_name_mortgage.required)"
                                @submit="onSubmitSearchMortgage"
                                @change="onChangeSearch"
                            />
                        </div>
                    </div>
                        <div class="form-group col-sm-3">
                            <label for="exampleInputPassword1">Сумма сделки</label>
                            <div class="input-group">
                                <input type="number" v-model="cost_mortgage" class="form-control" id="cost_mortgage" name="cost_mortgage" required=""
                                       :class="{'is-invalid': ($v.cost_mortgage.$dirty && !$v.cost_mortgage.required)}">
                                <small class="invalid-feedback"
                                       v-if="($v.cost_mortgage.$dirty && !$v.cost_mortgage.required) || ($v.cost_mortgage.$dirty && !$v.cost_mortgage.minValue)"
                                >Некорректная сумма!</small>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="exampleInputPassword1">Программа кредитования</label>
                            <div class="input-group">
                                <select class="form-control" v-model="credit_program_mortgage" name="credit_program_mortgage" id="credit_program_mortgage"
                                        :class="{'is-invalid': ($v.credit_program_mortgage.$dirty && !$v.credit_program_mortgage.required)}">
                                    <option :value="null" disabled>Выберите программу</option>
                                    <option v-for="item in credit_programs" :value="item.id" :key="item.id">{{item.title}}</option>
                                </select>
                                <small class="invalid-feedback"
                                       v-if="$v.credit_program_mortgage.$dirty && !$v.credit_program_mortgage.required"
                                >Выберите продукт!</small>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="exampleInputPassword1">Город</label>
                                <div class="input-group">
                                    <input type="text" value="" v-model="city_mortgage" class="form-control" id="city_mortgage" name="city_mortgage" required=""
                                           :class="{'is-invalid': ($v.city_mortgage.$dirty && !$v.city_mortgage.required)}">
                                    <small class="invalid-feedback"
                                           v-if="$v.city_mortgage.$dirty && !$v.city_mortgage.required"
                                    >Укажите город!</small>
                                </div>
                            </div>

                        <div class="form-group col-sm-3">
                            <label>Дата КД</label>
                            <div class="input-group">
                                <date-picker v-model="date_cd_mortgage" value-type="format" format="DD.MM.YYYY"
                                     :disabled-date="notAfterLastMonth"
                                     :input-class="($v.date_cd_mortgage.$dirty && !$v.date_cd_mortgage.required) ? 'form-control is-invalid' : 'form-control'"
                                ></date-picker>
                                <small class="invalid-feedback"
                                       v-if="$v.date_cd_mortgage.$dirty && !$v.date_cd_mortgage.required"
                                >Укажите дату КД!</small>
                            </div>
                        </div>
                            <div class="form-group col-sm-4">
                                <label for="exampleInputPassword1">Банк</label>
                                <div class="input-group">
                                    <select class="form-control" v-model="bank_mortgage" name="bank_mortgage" id="bank_mortgage"
                                            :class="{'is-invalid': ($v.bank_mortgage.$dirty && !$v.bank_mortgage.required)}">
                                        <option :value="null" disabled>Выберите банк</option>
                                        <option v-for="bank in banks" v-bind:value="bank.id ">{{ bank.name }}</option>
                                    </select>
                                    <small class="invalid-feedback"
                                           v-if="$v.bank_mortgage.$dirty && !$v.bank_mortgage.required"
                                    >Выберите банк!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group col-12">
                            <label for="exampleInputPassword1">Комментарий (при необходимости)</label>
                            <div class="input-group">
                                <textarea name="comment" id="comment_mortgage" v-model="comment_mortgage" class="form-control" cols="25" rows="2"></textarea>
                            </div>
                            <input type="submit" class="btn btn-success mt-4" value="Добавить запись" @click="addMortgageRecord"
                                :class="$v.$anyDirty ? 'submit_with_errors' : ''"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="mt-3">Текуший список</h4>
        <table class="table table-striped mb-4 report-list">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>ФИО</th>
                <th>Программа кредитования</th>
                <th>Город</th>
                <th>Сумма ипотеки</th>
                <th>Банк</th>
                <th>Дата КД</th>
                <th>Комментарий</th>
                <th>Действия</th>
            </tr>
            </thead>
            <transition-group tag="tbody" name="list">
            <tr v-for="item in reportMortgage" v-bind:key="item">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ credit_programs[item.credit_program - 1].title }}</td>
                <td>{{ item.city }}</td>
                <td>{{ item.summ | toCurrency }}</td>
                <td>{{ banks[item.bank -1].name }}</td>
                <td>{{ item.date_cd }}</td>
                <td>{{ item.comment }}</td>
                <td><button type="submit" class="btn btn-success" @click="deleteMortgageRecord(item.id,item.db_id)">Удалить</button></td>
            </tr>
            </transition-group>
        </table>
        <button class="btn btn-primary" @click="next()">Далее</button>
            </section>
            <section v-if="step === 2" key="2">
        <h3 class="mb-3">Сведения о страховых сделках</h3>
        <p>Несмотря на то, что тут и мартышка справится, нужно вписать какой-то умный текст о том, как правильно заполнять эту наисложнейшую форму, ведь агенты - идиоты и ничего не поймут даже с десятого раза, это очевидно! Необходимо принять данный факт со слезами на глазах и родить</p>
        <ol>
            <li>пошаговое</li>
            <li>руководство</li>
            <li>для</li>
            <li>этих</li>
            <li>долбоящеров!</li>
        </ol>
        <div>
            <div>
                <div class="row">
                    <div class="col-8">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="exampleInputPassword1">ФИО клиента</label>
                                <div class="input-group">
                                    <SearchAutocompleteComponent
                                        v-model="client_name_insurance"
                                        :myid="this.input_name_insurance"
                                        :url="this.search_url"
                                        :exceptions="this.exceptions"
                                        :invalid="($v.client_name_insurance.$dirty && !$v.client_name_insurance.required)"
                                        @submit="onSubmitSearchInsurance"
                                        @change="onChangeSearch"
                                    />
                                    <small class="invalid-feedback"
                                           v-if="$v.client_name_insurance.$dirty || $v.client_name_insurance.required"
                                    >Укажите ФИО клиента</small>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="exampleInputPassword1">Стоимость полиса</label>
                                <div class="input-group">
                                    <input type="text" v-model="cost_insurance" class="form-control" id="cost_insurance" name="cost_insurance" required=""
                                           :class="{'is-invalid': ($v.cost_insurance.$dirty && !$v.cost_insurance.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.cost_insurance.$dirty && !$v.cost_insurance.required) || ($v.cost_insurance.$dirty && !$v.cost_insurance.minValue)"
                                    >Некорректная сумма!</small>
                                </div>
                            </div>


                            <div class="form-group col-sm-4">
                                <label for="exampleInputPassword1">Банк</label>
                                <div class="input-group">
                                    <select class="form-control" v-model="bank_insurance" name="bank_insurance" id="bank_insurance"
                                            :class="{'is-invalid': ($v.bank_insurance.$dirty && !$v.bank_insurance.required)}">
                                        <option :value="null" disabled>Выберите банк</option>
                                        <option v-for="bank in banks" v-bind:value="bank.id">{{ bank.name }}</option>
                                    </select>
                                    <small class="invalid-feedback"
                                           v-if="$v.bank_insurance.$dirty && !$v.bank_insurance.required"
                                    >Выберите банк!</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="exampleInputPassword1">Страховая компания</label>
                                <div class="input-group">
                                    <select class="form-control" v-model="insurance_insurance" name="insurance_insurance"
                                        :class="{'is-invalid': ($v.insurance_insurance.$dirty && !$v.insurance_insurance.required)}">
                                        <option :value="null" disabled>Выберите компанию</option>
                                        <option v-for="item in insurances" v-bind:value="item.id">{{item.name}}</option>
                                    </select>
                                    <small class="invalid-feedback"
                                           v-if="$v.insurance_insurance.$dirty && !$v.insurance_insurance.required"
                                    >Выберите страховую!</small>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label>Дата КД</label>
                                <div class="input-group">
                                    <date-picker v-model="date_cd_insurance" value-type="format" format="DD.MM.YYYY"
                                                 :disabled-date="notAfterLastMonth"
                                                 :input-class="($v.date_cd_insurance.$dirty && !$v.date_cd_insurance.required) ? 'form-control is-invalid' : 'form-control'"
                                    ></date-picker>
                                    <small class="invalid-feedback"
                                           v-if="$v.date_cd_insurance.$dirty && !$v.date_cd_insurance.required"
                                    >Укажите дату КД!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group col-12">
                            <label for="exampleInputPassword1">Комментарий (при необходимости)</label>
                            <div class="input-group">
                                <textarea name="comment_insurance" id="comment_insurance" v-model="comment_insurance" class="form-control" cols="25" rows="2"></textarea>
                            </div>
                            <input type="submit" class="btn btn-success mt-4" value="Добавить запись" @click="addInsuranceRecord">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="mt-3">Текуший список</h4>
        <table class="table table-striped mb-4">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>ФИО</th>
                <th>Страховая компания</th>
                <th>Стоимость полиса</th>
                <th>Банк</th>
                <th>Дата КД</th>
                <th>Комментарий</th>
                <th>Действия</th>
            </tr>
            </thead>
            <transition-group tag="tbody" name="list">
            <tr v-for="item in reportInsurance" v-bind:key="item">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.insurance }}</td>
                <td>{{ item.summ | toCurrency }}</td>
                <td>{{ item.bank }}</td>
                <td>{{ item.date_cd }}</td>
                <td>{{ item.comment }}</td>
                <td><button type="submit" class="btn btn-success" @click="deleteInsuranceRecord(item.id, item.db_id)">Удалить</button></td>
            </tr>
            </transition-group>
        </table>
        <button class="btn btn-primary" @click="prev()">Назад</button>
        <button class="btn btn-primary"  @click="next()">Далее</button>
        </section>
        <section v-if="step === 3" key="3">
                <h3 class="mb-3">Итоговый отчёт</h3>
                <p v-if="(!reportMortgage.length) && (!reportInsurance.length)">Какой смысл отправлять пустой отчёт? =)</p>
                <div v-else>
                <p class="text-danger">Внимательно проверьте корректность заполненых данных! После нажатия кнопки "Отправить отчёт" его невозможно будет отредактировать!</p>
                <h4>Ипотечные сделки</h4>
                <table class="table table-striped mb-4">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>ФИО</th>
                        <th>Продукт</th>
                        <th>Город</th>
                        <th>Сумма ипотеки</th>
                        <th>Банк</th>
                        <th>Дата КД</th>
                        <th>Комментарий</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <transition-group tag="tbody" name="list">
                    <tr v-for="item in reportMortgage" v-bind:key="item">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ credit_programs[item.credit_program] }}</td>
                        <td>{{ item.city }}</td>
                        <td>{{ item.summ | toCurrency }}</td>
                        <td>{{ banks[item.bank -1] }}</td>
                        <td>{{ item.date_cd }}</td>
                        <td>{{ item.comment }}</td>
                        <td><button type="submit" class="btn btn-success" @click="deleteMortgageRecord(item.id, item.db_id)">Удалить</button></td>
                    </tr>
                    </transition-group>
                </table>
                <h4 class="mt-3">Страховые сделки</h4>
                <table class="table table-striped mb-4">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>ФИО</th>
                        <th>Страхвая компания</th>
                        <th>Стоимость полиса</th>
                        <th>Банк</th>
                        <th>Дата КД</th>
                        <th>Комментарий</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <transition-group tag="tbody" name="list">
                    <tr v-for="item in reportInsurance" v-bind:key="item">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ insurances[item.insurance - 1].name }}</td>
                        <td>{{ item.summ | toCurrency }}</td>
                        <td>{{ banks[item.bank -1] }}</td>
                        <td>{{ item.date_cd }}</td>
                        <td>{{ item.comment }}</td>
                        <td><button type="submit" class="btn btn-success" @click="deleteInsuranceRecord(item.id, iteb.db_id)">Удалить</button></td>
                    </tr>
                    </transition-group>
                </table>
                </div>
            <button class="btn btn-primary" @click="prev()">Назад</button>
            <button v-if="(reportMortgage.length) || (reportInsurance.length)" class="btn btn-primary" @click.prevent="makeReport()">Отправить очёт</button>

            </section>
            <section v-if="step === 4" key="4">
                <h3 class="mb-3">Отчёт успешно отправлен</h3>
                <p class="text-danger">Спасибо, вам ничего не заплатят, т.к. вы плохо себя вели.</p>
                <p>Все-го ХО-РО-ШЕ-ГО!!!111</p>
                <button class="btn btn-danger" @click="prev()">Понятно</button>
            </section>
        </transition>
    </div>
</template>

<script>
import {requiredIf} from 'vuelidate/lib/validators'
import SearchAutocompleteComponent from "../../SearchAutocompleteComponent";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/ru';
export default {
    components: {
        SearchAutocompleteComponent,
        DatePicker,
    },

    name: "CreateReportComponent",

    data() {
        return {
            input_name_mortgage: 'client_name_mortgage',
            input_name_insurance: 'client_name_insurance',
            search_url: '/api/reports/search/',
            steps: {},
            step: 1,
            demands: null,
            credit_programs: [],
            report: [],
            exceptions: [0],
            exception: null,
            invalid_date: false,
            reportMortgage: [],
            reportInsurance: [],
            client_name_mortgage: null,
            client_name_insurance: null,
            credit_program_mortgage: null,
            insurance_insurance: null,
            city_mortgage: null,
            cost_mortgage: null,
            cost_insurance: null,
            bank_mortgage: null,
            bank_insurance: null,
            comment_mortgage: null,
            comment_insurance: null,
            date_cd_mortgage: null,
            date_cd_insurance: null,
            banks: {},
            insurances: {},
        }
    },

    mounted() {
        this.getCreditPrograms()
        this.getBanks()
        this.getInsurances()
        this.setDefaultDay()
    },

    methods: {
        prev() {
            this.$v.$reset()
            this.step--;
        },

        next() {
            this.$v.$reset()
            this.step++;
        },

        notAfterToday(date) {
            return date > new Date(new Date().setHours(0, 0, 0, 0));
        },

        setDefaultDay() {
            var d = new Date()
            d.setDate(1)
            d.setHours(-1)
            this.date_cd_mortgage = d.toLocaleDateString()
            this.date_cd_insurance = d.toLocaleDateString()
        },

        notAfterLastMonth(date) {
            var d = new Date()
            d.setDate(1)
            d.setHours(-1)
            return date > d
        },

        onSubmitSearchMortgage(result) {
            const selectedItem = result
            this.exception = selectedItem.id
            this.client_name_mortgage = selectedItem.name
            document.getElementById('cost_mortgage').value = selectedItem.credit_summ
            this.cost_mortgage = selectedItem.credit_summ
            document.getElementById('credit_program_mortgage').value = selectedItem.creditprogram
            this.credit_program_mortgage = selectedItem.creditprogram
            this.cost_mortgage = selectedItem.credit_summ
            if (selectedItem.banks_list.length === 1) {
                document.getElementById('bank_mortgage').value = parseInt(selectedItem.banks_list[0])
                this.bank_mortgage = parseInt(selectedItem.banks_list[0])
            }
        },

        onSubmitSearchInsurance(result) {
            const selectedItem = result
            this.exception = selectedItem.id
            this.client_name_insurance = selectedItem.name

            // здесь заменить на стоимость полиса
            // document.getElementById('cost_insurance').value = selectedItem.credit_summ
            // this.cost_insurance = selectedItem.credit_summ

            // здесь заменить на наименование страховой компании
            //document.getElementById('insurance_insurance').value = selectedItem.insurance
            //this.insurance_insurance = selectedItem.insurance
            if (selectedItem.banks_list.length === 1) {
                document.getElementById('bank_insurance').value = parseInt(selectedItem.banks_list[0])
                this.bank_insurance = parseInt(selectedItem.banks_list[0])
            }
        },



        onChangeSearch(searchText) {
            this.client_name_mortgage = searchText
            this.exception = null
        },

        makeReport() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/reports/makereport', {'mortgage_report': this.reportMortgage,'insurance_report': this.reportInsurance})
                    .then(data => {
                        this.step++;
                    }).catch(error => {
                })
            })
        },

        getCreditPrograms() {
            axios.get('/api/reports/getcreditprograms')
                .then(data => {
                    this.credit_programs = data.data
                })
        },

        getBanks() {
            axios.get('/api/reports/getbanks')
                .then(data => {
                    this.banks = data.data
                })
        },
        getInsurances() {
            axios.get('/api/reports/getinsurances')
                .then(data => {
                    this.insurances = data.data
                })
        },

        addMortgageRecord() {
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
            }
            else {
                this.$v.$reset()
                this.reportMortgage.push({
                    id: '',
                    name: this.client_name_mortgage,
                    credit_program: this.credit_program_mortgage,
                    city: this.city_mortgage,
                    summ: parseFloat(this.cost_mortgage),
                    bank: this.bank_mortgage,
                    comment: this.comment_mortgage,
                    date_cd: this.date_cd_mortgage,
                    db_id: this.exception
                })
                this.reportMortgage.map((item, index) => {
                    item.id = index + 1
                })

                let mortgages = ['city_mortgage', 'client_name_mortgage', 'cost_mortgage', 'credit_program_mortgage', 'comment_mortgage', 'date_cd_mortgage', 'bank_mortgage']
                const self = this
                mortgages.forEach((el) => {
                    document.getElementById(el).value = null
                    self[el] = null
                })

                if (Number.isInteger(this.exception)) {
                    this.exceptions.push(this.exception)
                    this.exception = null
                }
            }
        },

        addInsuranceRecord() {
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
            }
            else {
                this.reportInsurance.push({
                    id: '',
                    name: this.client_name_insurance,
                    insurance: this.insurance_insurance,
                    summ: parseFloat(this.cost_insurance),
                    bank: this.bank_insurance,
                    comment: this.comment_insurance,
                    date_cd: this.date_cd_insurance,
                    db_id: this.exception,
                })
                this.reportInsurance.map((item, index) => {
                    item.id = index + 1
                })

                if (Number.isInteger(this.exception)) {
                    this.exceptions.push(this.exception)
                    this.exception = null
                }

                let mortgages = ['client_name_insurance', 'cost_insurance', 'insurance_insurance', 'comment_insurance', 'date_cd_insurance', 'bank_insurance']
                const self = this
                mortgages.forEach((el) => {
                    document.getElementById(el).value = null
                    self[el] = null
                })


            }
        },

        deleteIdFromExceptions(id) {
            for( let i = 0; i < this.exceptions.length; i++){
                if ( this.exceptions[i] === id) {
                    this.exceptions.splice(i, 1);
                    i--;
                }
            }
        },

        deleteMortgageRecord(id, db_id) {
            this.reportMortgage = this.reportMortgage.filter( el => el.id !== id );
            this.reportMortgage.map((item, index) => {
                item.id = index + 1
            })
            this.deleteIdFromExceptions(db_id)
        },

        deleteInsuranceRecord(id, db_id) {
            this.reportInsurance = this.reportInsurance.filter( el => el.id !== id );
            this.reportInsurance.map((item, index) => {
                item.id = index + 1
            })
            this.deleteIdFromExceptions(db_id)
        },
    },

    validations:{
        client_name_mortgage: {required: requiredIf(function (){
                return this.step === 1
            })
        },
        client_name_insurance: {required: requiredIf(function (){
                return this.step === 2
            })
        },
        credit_program_mortgage: {required: requiredIf(function (){
                return this.step === 1
            })
        },
        insurance_insurance: {required: requiredIf(function (){
                return this.step === 2
            })
        },
        city_mortgage: {required: requiredIf(function (){
                return this.step === 1
            })
        },
        cost_mortgage: {required: requiredIf(function (){
                return this.step === 1
            })
        },
        cost_insurance: {required: requiredIf(function (){
                return this.step === 2
            })
        },
        bank_mortgage: {required: requiredIf(function (){
                return this.step === 1
            })
        },
        bank_insurance: {required: requiredIf(function (){
                return this.step === 2
            })
        },
        date_cd_mortgage: {required: requiredIf(function (){
                return this.step === 1
            })
        },
        date_cd_insurance: {required: requiredIf(function (){
                return this.step === 2
            })
        },
    },
}
</script>
<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity .3s ease
}

.fade-enter-from, .fade-leave-to {
    opacity: 0
}

.list-item {
    display: inline-block;
}
.list-enter-active, .list-leave-active {
    transition: all 1s;
}
.list-enter {
    opacity: 0;
    transform: translateY(30px);
}
.list-leave-to {
    opacity: 0;
}

th, td {
    vertical-align: baseline !important;
}
.mx-date-row td {
    vertical-align: middle !important;
}
.mx-table th {
    vertical-align: middle !important;
}

.mx-calendar-header button {
    height: 34px !important;
    line-height: 20px;
}

.mx-btn {
    font-weight: 500;
    padding: 7px 5px;
    margin: 0;
    cursor: pointer;

    white-space: nowrap;
}

.content-wrapper {
    height: auto !important;
}

.submit_with_errors {
    margin-top: 45px !important;
}
</style>
