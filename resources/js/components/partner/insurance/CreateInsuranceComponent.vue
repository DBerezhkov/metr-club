<template>
    <transition name="fade" mode="out-in">
        <section v-if="step === 1" key="1">
            <div class="row">
                <div class="form-group col-sm-2 mb-3">
                    <div class="input-group">
                        <select size="1" class="custom-select" v-model="params.bankCode">
                            <option :value="null" disabled hidden readonly>Ваш банк-кредитор</option>
                            <option v-for="item in banks" :value="item.id" :key="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-2 mb-3">
                    <div class="input-group">
                        <date-picker v-model="params.birthDate" value-type="format" format="DD.MM.YYYY"
                                     placeholder="Дата рождения"
                                     :disabled-date="notAfterToday"
                                     :input-class="($v.params.birthDate.$dirty && !$v.params.birthDate.required) ? 'form-control is-invalid' : 'form-control'"
                        ></date-picker>
                        <small class="invalid-feedback"
                               v-if="$v.params.birthDate.$dirty && !$v.params.birthDate.required"
                        >Укажите дату рождения!</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-2">
                    <div class="input-group">
                        <vue-autonumeric type="text" inputmode="decimal" class="form-control" id="creditSum"
                                         ref="creditSum" v-model="params.creditSum" placeholder="Введите сумму"
                                         :class="{'is-invalid': ($v.params.creditSum.$dirty && !$v.params.creditSum.required)
                                                                           || ($v.params.creditSum.$dirty && !$v.params.creditSum.maxEstatetSumValidator)
                                                                    || ($v.params.creditSum.$dirty && !$v.params.creditSum.estatesummValidator)}"
                                         :options="{
                                                                                      digitGroupSeparator: ' ',
                                                                                      decimalCharacter: '.',
                                                                                      allowDecimalPadding: false,
                                                                                      decimalCharacterAlternative: ',',
                                                                                      minimumValue: '0',
                                                                                      modifyValueOnWheel: false}">
                        </vue-autonumeric>
                        <small class="invalid-feedback"
                               v-if="($v.params.creditSum.$dirty && !$v.params.creditSum.required) || ($v.params.creditSum.$dirty && !$v.params.creditSum.minValue)"
                        >Некорректная сумма!</small>
                    </div>
                </div>
                <div class="form-group col-sm-2">
                    <div class="input-group">
                        <button class="btn btn-primary w-100" @click="next()">Рассчитать</button>
                    </div>
                </div>
            </div>
        </section>
        <section v-if="step === 2" key="2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Что страхуем?</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group">

                                <button class="btn mr-1 mb-1" :class="[(params.life && !params.property && !params.titleInsurance) ? 'btn-primary' : 'btn-secondary']" v-on:click="typeChange(['life'])">
                                    Жизнь
                                </button>

                                <button class="btn mr-1 mb-1" :class="[(params.life && params.property && !params.titleInsurance) ? 'btn-primary' : 'btn-secondary']" v-on:click="typeChange(['life', 'property'])">
                                    Жизнь и недвижимость
                                </button>

                                <button class="btn mr-1 mb-1" :class="[(!params.life && params.property && !params.titleInsurance) ? 'btn-primary' : 'btn-secondary']"  v-on:click="typeChange(['property'])">
                                    Недвижимость
                                </button>
                                <button class="btn mr-1 mb-1" :class="[(!params.life && params.property && params.titleInsurance) ? 'btn-primary' : 'btn-secondary']" v-on:click="typeChange(['property', 'titleInsurance'])">
                                    Титул и недвижимость
                                </button>

                                <button class="btn mb-1" :class="[(params.life && params.property && params.titleInsurance) ? 'btn-primary' : 'btn-secondary']" v-on:click="typeChange(['property', 'life', 'titleInsurance'])">
                                    Все сразу
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Параметры для расчета</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-3 col-md-6">
                                    <label>В каком банке ипотека</label>
                                    <select class="custom-select" v-model="params.bankCode">
                                        <option v-for="item in banks" :value="item.id" :key="item.id" :selected="item.id === params.bankCode">{{ item.name }}</option>
                                    </select>

                                    <label>Остаток кредита, руб.</label>
                                    <input type="text" v-model="policy.mortgageInfo.creditSum" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.mortgageInfo.creditSum.$dirty && !$v.policy.mortgageInfo.creditSum.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.mortgageInfo.creditSum.$dirty && !$v.policy.mortgageInfo.creditSum.required)"
                                    >Некорректная сумма!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label class="w-100">Дата рождения</label>
                                    <date-picker v-model="policy.mortgageInfo.birthDate" value-type="format" format="DD.MM.YYYY"
                                                 placeholder="Дата рождения"
                                                 :disabled-date="notAfterToday"
                                                 :input-class="($v.policy.mortgageInfo.birthDate.$dirty && !$v.policy.mortgageInfo.birthDate.required) ? 'form-control is-invalid' : 'form-control'"
                                    ></date-picker>
                                    <small class="invalid-feedback"
                                           v-if="$v.policy.mortgageInfo.birthDate.$dirty && !$v.policy.mortgageInfo.birthDate.required"
                                    >Укажите дату рождения!</small>

                                    <label>Пол</label>
                                    <toggle-switch
                                        :options="sexOptions"
                                        v-model="params.sex"
                                    />
                                </div>


                                <div class="form-group col-md-6 col-lg-3">
                                    <label>Объект страхования</label>
                                    <select class="custom-select" v-model="params.propertyType">
                                        <option v-for="item in propertyTypeList" :value="item.key" :key="item.id">{{ item.name }}</option>
                                    </select>

                                    <label class="w-100">Год постройки дома</label>
                                    <date-picker v-model="params.buildingYear"
                                                 type="year"
                                                 format="YYYY"
                                                 value-type="format"
                                                 placeholder="Выберите год"
                                                 :input-class="($v.params.buildingYear.$dirty && !$v.params.buildingYear.required) ? 'form-control is-invalid' : 'form-control'"
                                    ></date-picker>
                                    <small class="invalid-feedback"
                                           v-if="$v.params.buildingYear.$dirty && !$v.params.buildingYear.required"
                                    >Укажите год постройки!</small>
                                </div>


                                <div class="form-group col-md-6 col-lg-3">
                                    <label>Право собственности</label>
                                    <toggle-switch
                                        style="width: 100%"
                                        :options="ownershipRegisteredOptions"
                                        v-model="params.ownershipRegistered"
                                    />

                                    <label>В доме есть деревянные перекрытия?</label>
                                    <toggle-switch
                                        :options="woodenFloorOptions"
                                        v-model="params.woodenFloor"
                                    />
                                </div>
                                <div class="form-group col-md-6 col-lg-3">
                                    <div class="input-group">
                                        <button class="btn btn-primary w-100" v-on:click="preCalcPolicyPrice()" id="btnSubmit">Рассчитать</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card" v-if="!this.zeroOffers && Object.keys(this.offers).length !== 0 && this.offers.constructor == Object">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Предварительный расчёт с выбранными параметрами</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-if="errorLoading" class="flex-fill">
                                Ашипка: {{this.errorMessage}}
                            </div>
                            <div v-if="this.loading" class="flex-fill">
                                <div class="text-center mt-5 mb-5" id="waiting_send_demand">
                                    <div class="cssload-loader">
                                        <div class="cssload-inner cssload-one"></div>
                                        <div class="cssload-inner cssload-two"></div>
                                        <div class="cssload-inner cssload-three"></div>
                                    </div>
                                    <h3 class="modal-title text-center mt-3">Ожидайте...</h3>
                                </div>
                            </div>
                            <div v-else>
                                <div v-if="this.zeroOffers" class="p-5 text-center">
                                    <svg width="200" height="107" viewBox="0 0 200 107" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M58.1633 8.02959C56.6226 4.75552 54.5041 1.48145 52.4818 1.48145C48.5337 1.48145 44.2967 14 44.2967 14C44.2967 14 34.1855 37.1111 34.1855 54.9259C34.1855 72.7407 39.9633 71.7777 39.9633 71.7777" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M77.5186 8.12589C79.0593 4.85182 81.1778 1.48145 83.2963 1.48145C87.2445 1.48145 91.4815 14 91.4815 14C98.3186 8.31848 107.274 4.37033 116.807 4.37033C138.474 4.37033 156.578 22.3777 156.578 44.1407C156.578 54.9259 151.763 64.7481 144.637 71.874" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M80.8896 10.6303C77.423 7.4525 72.9933 5.33398 67.8896 5.33398C62.7859 5.33398 58.3563 7.4525 54.8896 10.6303" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M142.518 14.5766C140.881 18.3322 137.126 24.3026 128.652 28.6359C128.267 28.8285 127.785 28.9248 127.304 28.9248C126.244 28.9248 125.281 28.347 124.704 27.384C123.933 25.9396 124.511 24.2063 125.956 23.5322C134.43 19.1989 137.03 13.2285 137.704 11.0137" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M152.148 27.1916C150.222 29.7916 147.525 32.4879 143.77 34.799C143.288 35.0879 142.614 35.2805 142.037 35.1842C141.17 35.0879 140.303 34.7027 139.725 33.8361C138.859 32.4879 139.34 30.6583 140.688 29.8879C144.925 27.2879 147.429 24.2064 148.874 21.6064" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M130.867 7.45149C128.652 10.8219 124.993 14.8663 118.83 18.0441C118.444 18.2367 117.963 18.333 117.481 18.333C116.422 18.333 115.459 17.7552 114.881 16.7922C114.111 15.3478 114.689 13.6145 116.133 12.9404C120.37 10.7256 123.163 8.12556 124.993 5.81445" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M48.6299 71.7778C48.6299 58.4889 57.2965 52.5186 67.8891 52.5186C78.4817 52.5186 87.1484 58.4889 87.1484 71.7778" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M144.926 85.2598V104.519H39.9629V85.2598" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M144.926 71.7783L153.111 80.445H148.296" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M39.9627 71.7783L29.3701 80.445H36.5923" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M149.741 85.2598H35.1484L39.9633 71.7783H144.926L149.741 85.2598Z" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M22.1475 104.519H180.073" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M184.889 104.519H199.333" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M0 104.519H16.3704" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10"></path><path d="M67.8888 31.8145C66.8296 31.8145 65.674 32.1033 64.711 32.3922C63.5555 32.7774 63.1703 34.1256 63.8444 35.0885C64.711 36.2441 66.1555 37.5922 67.7925 37.5922C69.4296 37.5922 70.874 36.2441 71.7407 35.0885C72.4147 34.1256 72.0296 32.7774 70.874 32.3922C70.1036 32.1033 68.9481 31.8145 67.8888 31.8145Z" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M58.7407 29.4073C62.1976 29.4073 65 26.1738 65 22.1851C65 18.1964 62.1976 14.9629 58.7407 14.9629C55.2838 14.9629 52.4814 18.1964 52.4814 22.1851C52.4814 26.1738 55.2838 29.4073 58.7407 29.4073Z" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M77.0376 29.4073C80.4945 29.4073 83.2968 26.1738 83.2968 22.1851C83.2968 18.1964 80.4945 14.9629 77.0376 14.9629C73.5807 14.9629 70.7783 18.1964 70.7783 22.1851C70.7783 26.1738 73.5807 29.4073 77.0376 29.4073Z" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M58.7404 25.555C59.804 25.555 60.6663 24.6927 60.6663 23.629C60.6663 22.5654 59.804 21.7031 58.7404 21.7031C57.6767 21.7031 56.8145 22.5654 56.8145 23.629C56.8145 24.6927 57.6767 25.555 58.7404 25.555Z" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M77.0373 25.555C78.1009 25.555 78.9632 24.6927 78.9632 23.629C78.9632 22.5654 78.1009 21.7031 77.0373 21.7031C75.9736 21.7031 75.1113 22.5654 75.1113 23.629C75.1113 24.6927 75.9736 25.555 77.0373 25.555Z" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M79.4453 35.666C79.4453 35.666 82.8157 37.5919 88.112 37.5919" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M78.4814 38.0732C78.4814 38.0732 79.5407 39.8066 83.7777 41.9251" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M56.3337 35.666C56.3337 35.666 52.9633 37.5919 47.667 37.5919" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M57.2963 38.0732C57.2963 38.0732 56.237 39.8066 52 41.9251" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M67.8887 37.5918V41.9251" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M70.2962 45.7767C70.2962 47.1248 69.237 48.1841 67.8888 48.1841C66.5407 48.1841 65.4814 47.1248 65.4814 45.7767C65.4814 44.4285 66.5407 41.9248 67.8888 41.9248C69.237 41.9248 70.2962 44.4285 70.2962 45.7767Z" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M57.2969 12.5548L61.1487 11.1104" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M78.0003 12.5548L74.1484 11.1104" stroke="#FF0508" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path></svg>
                                    <h1>Извините,</h1>
                                    <h3>мы не можем рассчитать стоимость полиса по указанным параметрам.</h3>
                                    <h5>Скорректируйте свои параметры в фильтре и попробуйте снова. Если это не поможет — просто возвращайтесь к нам чуть позже.</h5>
                                </div>

                                <div v-else class="row">
                                    <template v-for="(summ, name, index) in this.offers">
                                        <div v-if="summ" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-fill">
                                            <div class="card bg-light d-flex flex-fill">
                                                <div class="card-header text-muted border-bottom-0">
                                                    {{companies[index].name}}
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <p class="mb-0">Стоимость</p>
                                                            <p class="mb-3"><b>{{ summ }} руб./год</b></p>
                                                            <!--p class="mb-0">Ваше КВ</p>
                                                            <p class="mb-3"><b>{{ offer.total }} деняк</b></p-->
                                                        </div>
                                                        <div class="col-5 text-center">
                                                            <img :src="'/img/insurances/' + name + '.svg'" class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-right">
                                                        <button class="btn btn-sm btn-primary" v-on:click="selectCompany(name)">
                                                            Оформить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section v-if="step === 3" key="3">
            <div class="row">
                <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    @click="closeModal()" style="margin-left: 92%; margin-top: 2%">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-body">
                                <img src="/img/metr.club.png"
                                     class="mx-auto d-block" style="max-height: 160px">
                                <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Стоимость страховки: {{textForModalPrice}} руб.</h3>
                                <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Ваше КВ: {{textForModalKV}} руб.</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success mx-auto pl-5 pr-5" data-dismiss="modal"
                                        @click="issuePolicy()">Погнали!
                                </button>
                                <button type="button" class="btn btn-danger mx-auto pl-5 pr-5" data-dismiss="modal"
                                        @click="closeModal()">Я передумал!
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    @click="closeModal()" style="margin-left: 92%; margin-top: 2%">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-body">
                                <img src="/img/demands/Warning-icon-isolated-on-transparent-background-PNG.png"
                                     class="mx-auto d-block" style="max-height: 160px">
                                <h3 class="modal-title text-center mt-3" id="exampleModalLabel">Ошибка!</h3>
                                <h3 class="modal-title text-center mt-3" id="exampleModalLabel"> {{textForModalError}}</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary mx-auto pl-5 pr-5" data-dismiss="modal"
                                        @click="issuePolicy()">Понял!
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group col-sm-2">
                                <div class="input-group">
                                    <button class="btn btn-primary" @click="prev()"><i class="fas fa-arrow-left mr-3">
                                    </i>Назад</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Уточнение данных для полиса</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row border-bottom">
                                <div class="form-group col-3">
                                    <img :src="'/img/insurances/' + this.selectedCompany.id + '.svg'" class="img-fluid w-50">
                                </div>
                                <div class="form-group col-3">
                                    Тип полиса
                                </div>
                                <div class="form-group col-3">
                                    <span>Остаток по кредиту</span>
                                    <span>{{this.params.creditSum}}</span>
                                </div>
                                <div class="form-group col-3">
                                    <span>Годовая стоимость</span>
                                    <span>{{this.offers[selectedCompany.id]}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <h3 class="card-title">Риски</h3>
                                </div>
                                <div class="col-12 mt-2">
                                    <span v-for="(item, index) in this.selectedCompany.propertyRisks"><span v-if="index !== 0">  •  </span>{{ item.text }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <h3>Контактная информация</h3>
                                </div>
                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Email (на него придет полис)</label>
                                    <input type="text" v-model="policy.contacts.email" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.contacts.email.$dirty && !$v.policy.contacts.email.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.contacts.email.$dirty && !$v.policy.contacts.email.required)"
                                    >Некорректный Email!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Номер телефона</label>
                                    <input type="text" v-model="policy.contacts.phone" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.contacts.phone.$dirty && !$v.policy.contacts.phone.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.contacts.phone.$dirty && !$v.policy.contacts.phone.required)"
                                    >Некорректный номер!</small>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 mt-2">
                                    <h3>Заёмщик</h3>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Фамилия</label>
                                    <input type="text" v-model="policy.insurerPersonalData.lastName" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.insurerPersonalData.lastName.$dirty && !$v.policy.insurerPersonalData.lastName.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.lastName.$dirty && !$v.policy.insurerPersonalData.lastName.required)"
                                    >Некорректные данные!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Имя</label>
                                    <input type="text" v-model="policy.insurerPersonalData.firstName" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.insurerPersonalData.firstName.$dirty && !$v.policy.insurerPersonalData.firstName.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.firstName.$dirty && !$v.policy.insurerPersonalData.firstName.required)"
                                    >Некорректные данные!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Отчество</label>
                                    <input type="text" v-model="policy.insurerPersonalData.middleName" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.insurerPersonalData.middleName.$dirty && !$v.policy.insurerPersonalData.middleName.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.middleName.$dirty && !$v.policy.insurerPersonalData.middleName.required)"
                                    >Некорректные данные!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label class="w-100">Дата рождения</label>
                                    <date-picker v-model="policy.mortgageInfo.birthDate" value-type="format" format="DD.MM.YYYY"
                                                 placeholder="Дата рождения"
                                                 :disabled-date="notAfterToday"
                                                 :input-class="($v.policy.mortgageInfo.birthDate.$dirty && !$v.policy.mortgageInfo.birthDate.required) ? 'form-control is-invalid' : 'form-control'"
                                    ></date-picker>
                                    <small class="invalid-feedback"
                                           v-if="$v.policy.mortgageInfo.birthDate.$dirty && !$v.policy.mortgageInfo.birthDate.required"
                                    >Укажите корректную дату!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Серия паспорта РФ</label>
                                    <input type="text" v-model="policy.insurerPersonalData.personDocument.series" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.insurerPersonalData.personDocument.series.$dirty && !$v.policy.insurerPersonalData.personDocument.series.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.personDocument.series.$dirty && !$v.policy.insurerPersonalData.personDocument.series.required)"
                                    >Некорректные данные!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Номер паспорта РФ</label>
                                    <input type="text" v-model="policy.insurerPersonalData.personDocument.number" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.insurerPersonalData.personDocument.number.$dirty && !$v.policy.insurerPersonalData.personDocument.number.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.personDocument.number.$dirty && !$v.policy.insurerPersonalData.personDocument.number.required)"
                                    >Некорректные данные!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Код подразделения</label>
                                    <input type="text" v-model="policy.insurerPersonalData.personDocument.divisionCode" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.insurerPersonalData.personDocument.divisionCode.$dirty && !$v.policy.insurerPersonalData.personDocument.divisionCode.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.personDocument.divisionCode.$dirty && !$v.policy.insurerPersonalData.personDocument.divisionCode.required)"
                                    >Некорректная сумма!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label class="w-100">Дата выдачи паспорта РФ</label>
                                    <date-picker v-model="policy.insurerPersonalData.personDocument.dateOfIssue" value-type="format" format="DD.MM.YYYY"
                                        placeholder="Дата выдачи паспорта РФ"
                                        :disabled-date="notAfterToday"
                                        :input-class="($v.policy.insurerPersonalData.personDocument.dateOfIssue.$dirty && !$v.policy.insurerPersonalData.personDocument.dateOfIssue.required) ? 'form-control is-invalid' : 'form-control'"
                                    ></date-picker>
                                    <small class="invalid-feedback"
                                        v-if="$v.policy.insurerPersonalData.personDocument.dateOfIssue.$dirty && !$v.policy.insurerPersonalData.personDocument.dateOfIssue.required"
                                    >Укажите дату!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Кем выдан</label>
                                    <input type="text" v-model="policy.insurerPersonalData.personDocument.issuedBy" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.insurerPersonalData.personDocument.issuedBy.$dirty && !$v.policy.insurerPersonalData.personDocument.issuedBy.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.personDocument.issuedBy.$dirty && !$v.policy.insurerPersonalData.personDocument.issuedBy.required)"
                                    >Некорректная сумма!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Адрес регистрации</label>
                                    <DaDataComponent
                                        :model.sync="params.address"
                                        :dadatas.sync="policy.insurerPersonalData.personDocument.dadataAddress"
                                        :placeholder="'Начните вводить'"
                                        class="form-control"
                                        :options="suggestionOptions"
                                    >
                                    </DaDataComponent>
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.insurerPersonalData.personDocument.dadataAddress.$dirty && !$v.policy.insurerPersonalData.personDocument.dadataAddress.required)"
                                    >Некорректный адрес!</small>
                                </div>

                                <div v-for="item in uidata.personalData" :key="item.name" class="form-group col-lg-3 col-md-6">
                                    <date-picker v-if="item.type === 'dateString'"
                                                 v-model="item.value"
                                                 value-type="format" format="DD.MM.YYYY"
                                                 :placeholder="item.title"
                                                 :disabled-date="notBeforeTomorrow"
                                                 :input-class="($v.uidata.personalData.item.value.$dirty && !$v.uidata.personalData.item.value.required) ? 'form-control is-invalid' : 'form-control'"
                                    >
                                    </date-picker>
                                    <template v-else-if="item.name === 'buildingYear'">
                                        <date-picker
                                                     v-model="item.value"
                                                     type="year"
                                                     format="YYYY"
                                                     value-type="format"
                                                     placeholder="Выберите год"
                                                     :input-class="($v.params.buildingYear.$dirty && !$v.params.buildingYear.required) ? 'form-control is-invalid' : 'form-control'"
                                        >
                                        </date-picker>
                                        <small class="invalid-feedback"
                                               v-if="($v.params.buildingYear.$dirty && !$v.params.buildingYear.required)"
                                        >Некорректный год!</small>
                                    </template>
                                    <input v-else type="text" v-model="item.value" class="form-control" id="creditSum1"
                                           :name="item.name" required=""
                                           :class="{'is-invalid': ($v.uidata.personalData.item.value.$dirty && !$v.uidata.personalData.item.value.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.uidata.personalData.item.value.$dirty && !$v.uidata.personalData.item.value.required)"
                                    >Некорректная сумма!</small>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 mt-2">
                                    <h3>Ипотека</h3>
                                </div>
                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Остаток кредита</label>
                                    <input type="text" v-model="policy.mortgageInfo.creditSum" class="form-control" id="creditSum1"
                                           name="creditSum" required=""
                                           :class="{'is-invalid': ($v.policy.mortgageInfo.creditSum.$dirty && !$v.policy.mortgageInfo.creditSum.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.policy.mortgageInfo.creditSum.$dirty && !$v.policy.mortgageInfo.creditSum.required)"
                                    >Некорректная сумма!</small>
                                </div>

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Кредитный договор</label>
                                    <toggle-switch
                                        :options="loanAgreementOptions"
                                        v-model="policy.mortgageInfo.creditAgreement"
                                    />
                                </div>
                                <template v-if="params.loanAgreement === '1'">
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Номер кредитного договора</label>
                                        <input type="text" v-model="policy.mortgageInfo.creditAgreementNumber" class="form-control" id="creditSum1"
                                               name="creditSum" required=""
                                               :class="{'is-invalid': ($v.policy.mortgageInfo.creditAgreementNumber.$dirty && !$v.policy.mortgageInfo.creditAgreementNumber.required)}">
                                        <small class="invalid-feedback"
                                               v-if="($v.policy.mortgageInfo.creditAgreementNumber.$dirty && !$v.policy.mortgageInfo.creditAgreementNumber.required)"
                                        >Некорректная сумма!</small>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Начало действия кредитного договора</label>
                                        <input type="text" v-model="params.creditSum" class="form-control" id="creditSum1"
                                               name="creditSum" required=""
                                               :class="{'is-invalid': ($v.params.creditSum.$dirty && !$v.params.creditSum.required)}">
                                        <small class="invalid-feedback"
                                               v-if="($v.params.creditSum.$dirty && !$v.params.creditSum.required) || ($v.params.creditSum.$dirty && !$v.params.creditSum.minValue)"
                                        >Некорректная сумма!</small>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Дата заключения кредитного договора</label>
                                        <input type="text" v-model="params.creditSum" class="form-control" id="creditSum1"
                                               name="creditSum" required=""
                                               :class="{'is-invalid': ($v.params.creditSum.$dirty && !$v.params.creditSum.required)}">
                                        <small class="invalid-feedback"
                                               v-if="($v.params.creditSum.$dirty && !$v.params.creditSum.required) || ($v.params.creditSum.$dirty && !$v.params.creditSum.minValue)"
                                        >Некорректная сумма!</small>
                                    </div>
                                </template>

                                <div v-for="item in uidata.mortgageInfo" :key="item.name" class="form-group col-lg-3 col-md-6">
                                    <label>{{ item.title }}</label>
                                    <date-picker v-if="item.type === 'dateString'"
                                                 v-model="item.value"
                                                 value-type="format" format="DD.MM.YYYY"
                                                 :placeholder="item.title"
                                                 :disabled-date="notBeforeTomorrow"
                                                 :input-class="($v.uidata.mortgageInfo.item.value.$dirty && !$v.uidata.mortgageInfo.item.value.required) ? 'form-control is-invalid' : 'form-control'"
                                    >
                                    </date-picker>

                                    <template v-else>
                                        <label>{{ item.title }}</label>
                                        <input type="text" v-model="item.value" class="form-control" id="creditSum1"
                                               :name="item.name" required=""
                                               :class="{'is-invalid': ($v.params.creditSum.$dirty && !$v.params.creditSum.required)}">
                                        <small class="invalid-feedback"
                                               v-if="($v.params.creditSum.$dirty && !$v.params.creditSum.required) || ($v.params.creditSum.$dirty && !$v.params.creditSum.minValue)"
                                        >Некорректная сумма!</small>
                                    </template>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12 mt-2">
                                    <h3>Объект</h3>
                                </div>
                                <div class="form-group col-lg-3 col-md-6">
                                    <label>Объект страхования</label>
                                    <select size="1" class="custom-select" v-model="policy.mortgageInfo.propertyType">
                                        <option value="flat">Квартира</option>
                                        <option value="house">Дом</option>
                                        <option value="room">Комната</option>
                                        <option value="apartments">Апартаменты</option>
                                    </select>
                                </div>

                                <div v-for="item in uidata.object" :key="item.name" class="form-group col-lg-3 col-md-6">
                                    <label>{{ item.title }}</label>

                                    <toggle-switch v-if="item.type === 'boolean'"
                                                   :options="loanAgreementOptions"
                                                   v-model="item.value"
                                    />
                                    <DaDataComponent v-else-if="item.type === 'dadata'"
                                                     :model.sync="params.mortgageAdress"
                                                     :dadatas.sync="item.value"
                                                     :placeholder="'Начните вводить'"
                                                     class="form-control"
                                                     :options="suggestionOptions"
                                    >
                                    </DaDataComponent>
                                    <date-picker v-else-if="item.type === 'dateString'"
                                                 v-model="item.value"
                                                 value-type="format" format="DD.MM.YYYY"
                                                 :placeholder="item.title"
                                                 :disabled-date="notBeforeTomorrow"
                                                 :input-class="($v.policy.requiredPolicy.beginDate.$dirty && !$v.policy.requiredPolicy.beginDate.required) ? 'form-control is-invalid' : 'form-control'"
                                    >
                                    </date-picker>
                                    <template v-else-if="item.type === 'string' && typeof item.variants !== 'undefined'">
                                        <select class="form-control" id="creditSum1"
                                                v-model="item.value"
                                                required=""
                                                :class="{'is-invalid': ($v.params.creditSum.$dirty && !$v.params.creditSum.required)}">
                                            <option v-for="variant in item.variants" v-bind:value="variant.value">{{variant.text}}</option>
                                        </select>
                                        <small class="invalid-feedback"
                                               v-if="($v.params.creditSum.$dirty && !$v.params.creditSum.required) || ($v.params.creditSum.$dirty && !$v.params.creditSum.minValue)"
                                        >Выберите что-то!</small>
                                    </template>

                                    <date-picker v-else-if="item.name === 'buildingYear'"
                                                 v-model="item.value"
                                                 type="year"
                                                 format="YYYY"
                                                 value-type="format"
                                                 placeholder="Выберите год"
                                                 :input-class="($v.params.buildingYear.$dirty && !$v.params.buildingYear.required) ? 'form-control is-invalid' : 'form-control'"
                                    >
                                    </date-picker>
                                    <input v-else type="text" v-model="item.value" class="form-control" id="creditSum1"
                                           :name="item.name" required=""
                                           :class="{'is-invalid': ($v.params.creditSum.$dirty && !$v.params.creditSum.required)}">
                                    <small class="invalid-feedback"
                                           v-if="($v.params.creditSum.$dirty && !$v.params.creditSum.required) || ($v.params.creditSum.$dirty && !$v.params.creditSum.minValue)"
                                    >Некорректная сумма!</small>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 mt-2">
                                    <h3>Полис</h3>
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="w-100">Дата начала страхования</label>
                                    <date-picker v-model="policy.requiredPolicy.beginDate" value-type="format" format="DD.MM.YYYY"
                                                 placeholder="Дата начала страхования"
                                                 :disabled-date="notBeforeTomorrow"
                                                 :input-class="($v.policy.requiredPolicy.beginDate.$dirty && !$v.policy.requiredPolicy.beginDate.required) ? 'form-control is-invalid' : 'form-control'"
                                    ></date-picker>
                                    <small class="invalid-feedback"
                                           v-if="$v.policy.requiredPolicy.beginDate.$dirty && !$v.policy.requiredPolicy.beginDate.required"
                                    >Укажите дату рождения!</small>
                                </div>
                            </div>

                            <div class="row">
                                <div v-for="item in uidata.nextcheck" class="form-group col-lg-12 col-md-12">
                                    <input type="checkbox" id="checkbox" v-model="item.value">
                                    <label for="checkbox" class="d-inline" v-html="item.title"></label>
                                    <p v-if="item.text" v-html="item.text"></p>
                                </div>
                                <button class="btn btn-primary" @click="calcPolicyPrice()">Рассчитать точную стоимость</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section v-if="step === 4" key="4">
            <div class="row">
                <div class="form-group col-sm-2 mb-3">
                    <div class="input-group">
                        <select size="1" class="custom-select" v-model="params.bankCode">
                            <option :value="null" disabled hidden readonly>Ваш банк-кредитор</option>
                            <option v-for="item in banks" :value="item.id" :key="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-2 mb-3">
                    <div class="input-group">
                        <date-picker v-model="policy.mortgageInfo.birthDate" value-type="format" format="DD.MM.YYYY"
                                     placeholder="Дата рождения"
                                     :disabled-date="notAfterToday"
                                     :input-class="($v.policy.mortgageInfo.birthDate.$dirty && !$v.policy.mortgageInfo.birthDate.required) ? 'form-control is-invalid' : 'form-control'"
                        ></date-picker>
                        <small class="invalid-feedback"
                               v-if="$v.policy.mortgageInfo.birthDate.$dirty && !$v.policy.mortgageInfo.birthDate.required"
                        >Укажите дату рождения!</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-2">
                    <div class="input-group">
                        <vue-autonumeric type="text" inputmode="decimal" class="form-control" id="creditSum"
                                         ref="creditSum" v-model="params.creditSum" placeholder="Введите сумму"
                                         :class="{'is-invalid': ($v.params.creditSum.$dirty && !$v.params.creditSum.required)
                                                                           || ($v.params.creditSum.$dirty && !$v.params.creditSum.maxEstatetSumValidator)
                                                                    || ($v.params.creditSum.$dirty && !$v.params.creditSum.estatesummValidator)}"
                                         :options="{
                                                                                      digitGroupSeparator: ' ',
                                                                                      decimalCharacter: '.',
                                                                                      allowDecimalPadding: false,
                                                                                      decimalCharacterAlternative: ',',
                                                                                      minimumValue: '0',
                                                                                      modifyValueOnWheel: false}">
                        </vue-autonumeric>
                        <small class="invalid-feedback"
                               v-if="($v.params.creditSum.$dirty && !$v.params.creditSum.required) || ($v.params.creditSum.$dirty && !$v.params.creditSum.minValue)"
                        >Некорректная сумма!</small>
                    </div>
                </div>
                <div class="form-group col-sm-2">
                    <div class="input-group">
                        <button class="btn btn-primary w-100" @click="next()">Рассчитать</button>
                    </div>
                </div>
            </div>
        </section>
    </transition>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/ru';
import {required, requiredIf, requiredUnless, integer} from "vuelidate/lib/validators";
import _ from "lodash";
import VueAutonumeric from "vue-autonumeric/dist/vue-autonumeric";
import DaDataComponent from "../../DaDataComponent.vue";

const estatesummValidator = (value) => parseFloat(value) > 0;
const maxEstatetSumValidator = (value) => parseFloat(value) < 999999999;

export default {
    components: {
        DatePicker,
        VueAutonumeric,
        DaDataComponent,
    },

    name: "CreateInsuranceComponent",

    data() {
        return {
            banks: {},
            propertyTypeList: {
                0: {
                    name: "Квартира",
                    key: 'flat',
                },
                1: {
                    name: "Дом",
                    key: 'house',
                },
                2: {
                    name: "Комната",
                    key: 'room',
                },
                3: {
                    name: "Апартаменты",
                    key: 'apartments',
                },
            },
            companies: null,
            textForModalPrice: '',
            textForModalKV: '',
            textForModalError: '',
            uidata: null,
            offers: {},
            zeroOffers: true,
            loading: false,
            errorLoading: false,
            errorMessage: '',
            selectedCompany: null,
            params: {
                address: '',
                mortgageAdress: '',
                bankCode: 'sberbank',
                birthDate: '01.01.1970',
                creditSum: 100000,
                sex: 'male',
                propertyType: 'flat',
                life: false,
                property: true,
                titleInsurance: false,
                buildingYear: 2023,
                ownershipRegistered: null,
                woodenFloor: null,
                loanAgreement: null,
            },
            policy: {
                requiredPolicy: {
                    beginDate: "",
                    life: false,
                    property: true,
                    titleInsurance: false
                },
                mortgageInfo: {
                    sex: "male",
                    birthDate: "1987-06-02",
                    bankCode: "sberbank",
                    creditSum: 200000,
                    propertyType: "flat",
                    creditAgreement: true,
                    creditAgreementNumber: "4242432",
                    creditAgreementDate: ""
                },
                insurerPersonalData: {
                    firstName: '',
                    lastName: '',
                    middleName: '',
                    personDocument: {
                        dateOfIssue: null,
                        number: null,
                        series: null,
                        divisionCode: null,
                        issuedBy: null,
                        dadataAddress: null,
                    }
                },
                contacts: {
                    email: '',
                    phone: ''
                },
                additionalData: {
                },
                calcSource: "api",
            },
            typeOptions: {
                layout: {
                    fontWeight: 'normal',
                    fontWeightSelected: 'normal',
                    noBorder: true,
                },
                size: {
                    fontSize: 0.9,
                    height: 2.2,
                    width: 60
                },
                config: {
                    delay: .3,
                    preSelected: 'property',
                    disabled: false,
                    items: [
                        { name: 'Недвижимость', value: 'property', color: 'white', backgroundColor: '#dc3545' },
                        { name: 'Жизнь', value: 'life', color: 'white', backgroundColor: '#dc3545' },
                        { name: 'Жизнь и недвижимость', value: 'life_property', color: 'white', backgroundColor: '#dc3545' },
                        { name: 'Титул и недвижимость', value: 'titleInsurance_property', color: 'white', backgroundColor: '#dc3545' },
                        { name: 'Все сразу', value: 'titleInsurance_property_life', color: 'white', backgroundColor: '#dc3545' },
                    ]
                }
            },
            sexOptions: {
                layout: {
                    fontWeight: 'normal',
                    fontWeightSelected: 'normal',
                    noBorder: true,
                },
                size: {
                    fontSize: 0.9,
                    height: 2.2,
                    width: 16.5,
                },
                config: {
                    delay: .3,
                    preSelected: 'male',
                    disabled: false,
                    items: [
                        { name: 'Мужчина', value: 'male', color: 'white', backgroundColor: '#007bff' },
                        { name: 'Женщина', value: 'female', color: 'white', backgroundColor: '#007bff' }
                    ]
                }
            },

            ownershipRegisteredOptions: {
                layout: {
                    fontWeight: 'normal',
                    fontWeightSelected: 'normal',
                    noBorder: true
                },
                size: {
                    fontSize: 0.9,
                    height: 2.2,
                    width: 16.5
                },
                config: {
                    delay: .3,
                    preSelected: '1',
                    disabled: false,
                    items: [
                        { name: 'Уже есть', value: '1', color: 'white', backgroundColor: '#007bff' },
                        { name: 'Пока что нет', value: '0', color: 'white', backgroundColor: '#007bff' }
                    ]
                }
            },

            woodenFloorOptions: {
                layout: {
                    fontWeight: 'normal',
                    fontWeightSelected: 'normal',
                    noBorder: true
                },
                size: {
                    fontSize: 0.9,
                    height: 2.2,
                    width: 16.5
                },
                config: {
                    delay: .3,
                    preSelected: '0',
                    disabled: false,
                    items: [
                        { name: 'Нет', value: '0', color: 'white', backgroundColor: '#007bff' },
                        { name: 'Да', value: '1', color: 'white', backgroundColor: '#007bff' }
                    ]
                }
            },

            loanAgreementOptions: {
                layout: {
                    fontWeight: 'normal',
                    fontWeightSelected: 'normal',
                    noBorder: true
                },
                size: {
                    fontSize: 0.9,
                    height: 2.2,
                    width: 16.5
                },
                config: {
                    delay: .3,
                    preSelected: '0',
                    disabled: false,
                    items: [
                        { name: 'Нет', value: '0', color: 'white', backgroundColor: '#007bff' },
                        { name: 'Да', value: '1', color: 'white', backgroundColor: '#007bff' }
                    ]
                }
            },
            step: 2,

            suggestionOptions: {
                token: '50e09e9a559d764a0dd75936e507e2469d53b34d',
                type: "ADDRESS",
                geoLocation: false,
                scrollOnFocus: true,
                triggerSelectOnBlur: false,
                triggerSelectOnEnter: false,
                addon: 'none',
                onSelect (suggestion) {

                }
            },
        }
    },

    mounted() {
        this.bankList()
        this.companyList()
        this.partnerLogin()
    },
    methods: {
        setAllFalse() {
            this.params.titleInsurance = false
            this.params.property = false
            this.params.life = false
        },
        typeChange(data) {
            this.setAllFalse()
            const self = this.params
            data.forEach((param) => {
                self[param] = true
            })
        },
        next() {
            this.$v.$reset()
            this.step++;
        },

        prev() {
            this.$v.$reset()
            this.step--;
        },

        companyUIData() {
            let sec = [
                this.params.life ? "life" : null,
                this.params.property ? "property" : null,
                this.params.titleInsurance ? "title" : null,
            ]
            sec = sec.filter((item) => item !== null)
            axios.post('/api/insurances/companyUIData/' + this.selectedCompany.id, {
                "bank": this.params.bankCode,
                "sections": sec,
            }).then(response => {
                //console.log(response.data)
                this.uidata = response.data
                this.step++
                window.scrollTo({ top: 0, behavior: 'smooth' })
            })
        },

        closeModal() {
            $('#modal').modal('hide')
        },

        downloadFile() {

        },

        selectCompany(companyId) {
            this.$v.$reset()
            this.selectedCompany = this.companies.find(obj => {
                return obj.id === companyId
            })
            this.companyUIData();
            //this.step++;
        },
        notAfterToday(date) {
            return date > new Date(new Date().setHours(0, 0, 0, 0));
        },
        notBeforeTomorrow(date) {
            return date < new Date(new Date().setHours(0, 0, 0, 0) + 1);
        },
        bankList() {
            axios.get('/api/insurances/bankList').then(response => {
                this.banks = response.data
            })
        },
        companyList() {
            axios.get('/api/insurances/companyList').then(response => {
                console.log(response.data)
                this.companies = response.data
            })
        },

        //  preCalcPolicyPrice() {
        //     this.loading = true
        //      console.log('start')
        //     for (const company of this.companies) {
        //             axios.post('/api/insurances/preCalcPolicyPrice/' + company.id, {"params": this.params}).then(response => {
        //                 let myId = company.id
        //                 this.offers[myId] = response.data
        //                 //console.log(myId + ' = ' + this.offers[myId])
        //             })
        //     }
        //     this.loading = false
        //      console.log('finish')
        // },

        async preCalcPolicyPrice() {
            this.loading = true
            this.zeroOffers = true
            $("#btnSubmit").attr("disabled", true).html('Подождите...');
            for (const company of this.companies) {
                await
                    axios.post('/api/insurances/preCalcPolicyPrice/' + company.id, {"params": this.params}).then(response => {
                        let myId = company.id
                        this.offers[myId] = response.data
                        if(typeof response.data == 'number') {
                            this.zeroOffers = false
                        }
                    })
            }
            this.loading = false
            $("#btnSubmit").attr("disabled", false).html('Рассчитать');
        },

        calcPolicyPrice() {
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
                this.policy.additionalData[this.selectedCompany.id] = this.uidata
                axios.post('/api/insurances/calcPolicyPrice/' + this.selectedCompany.id, {"data": this.policy}).then(response => {
                    console.log(response.data)
                    if (typeof response.data.errorMessages !== 'undefined') {
                        this.textForModalError = response.data.errorMessages;
                        $('#modalError').modal('show');
                        return;
                    } else {
                        this.textForModalPrice = response.data.total;
                        this.textForModalKV = response.data.partnerKv;
                        $('#modal').modal('show');
                    }
                })
            }
        },

        issuePolicy() {
            this.closeModal();
            this.step++;
            axios.post('/api/insurances/issuePolicy/' + this.selectedCompany.id, {"data": this.policy}).then(response => {
                console.log(response.data);
            })
        },
        partnerLogin() {
            //это не нужно
            axios.get('/api/insurances/partnerLogin/').then(response => {
            })
        },
    },
    // watch: {
    //     'params' : {
    //         handler: function (val, oldVal) {
    //             if (this.step === 2) {
    //                 this.debouncedPreCalcPolicyPrice()
    //             }
    //         },
    //         deep: true
    //     }
    // },
    created: function () {
        this.debouncedPreCalcPolicyPrice = _.debounce(this.preCalcPolicyPrice, 500)
    },

    validations: {
        params: {
            creditSum: {required, maxEstatetSumValidator, estatesummValidator},
            propertyType: {required},
            birthDate: {required},
            buildingYear: {required},
        },
        policy: {
            requiredPolicy: {
                beginDate: {required, minValue: value => value > new Date().toISOString()},
                life: {
                    requiredIf: requiredUnless(function() {
                        return (
                            this.policy.requiredPolicy.property || this.policy.requiredPolicy.titleInsurance
                        )
                    })
                },
                property: {
                    requiredIf: requiredUnless(function() {
                        return (
                            this.policy.requiredPolicy.life || this.policy.requiredPolicy.titleInsurance
                        )
                    })
                },
                titleInsurance: {
                    requiredIf: requiredUnless(function() {
                        return (
                            this.policy.requiredPolicy.life || this.policy.requiredPolicy.property
                        )
                    })
                }
            },
            mortgageInfo: {
                sex: {required},
                birthDate: {required},
                bankCode: {required},
                creditSum: {required},
                propertyType: {required},
                creditAgreement: {required},
                creditAgreementNumber: {required, integer},
                creditAgreementDate: {required}
            },
            insurerPersonalData: {
                firstName: {required},
                lastName: {required},
                middleName: {required},
                personDocument: {
                    dateOfIssue: {required},
                    number: {required},
                    series: {required},
                    divisionCode: {required},
                    issuedBy: {required},
                    dadataAddress: {required},
                }
            },
            contacts: {
                email: {required},
                phone: {required}
            },
            additionalData: {required},
            calcSource: {required},
        }
    },
}
</script>

<style scoped>
@import '/css/registration/dadata.css';

.suggestions-input {
    padding-left: 0.75rem !important;
}

.mx-datepicker {
    width: 100% !important;
}

.toggle-switch  {
    width: 100% !important;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
}

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
