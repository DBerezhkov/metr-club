<template>
    <div class="wrapper">
        <div class="card-wrapper">
            <div class="card">
                <div class="header">
                    <div class="card__header">
                        <div class="card-header__logo">
                            <a :href="main" target="_blank">
                                <img src="/img/reward/metr-club%201.svg" alt="metr-logo">
                            </a>
                        </div>
                        <div class="card-header__search" :class="{'active-search': searchFieldIsOpen}">
                            <input type="text" class="search-input" placeholder="Поиск по названию банка"
                                   :class="{'active-input': searchFieldIsOpen}" v-model="search" ref="search-input">
                            <div class="search-icon-container" @click="openSearchField()">
                                <img src="/img/reward/Search.png" alt="search-icon" class="search__icon">
                            </div>
                            <img src="/img/reward/close-btn.png" alt="close-btn" class="close-btn"
                                 :class="{'active-close-btn': searchFieldIsOpen}" @click="closeSearchField()">
                        </div>
                    </div>
                    <div class="card-body__titles">
                        <div class="titles__number"></div>
                        <div class="titles__bank">банк</div>
                        <div class="titles__cr">комиссионное вознаграждение</div>
                        <div class="titles__programs">программы</div>
                        <div class="titles__details"></div>
                    </div>
                </div>
                <div class="card__body">
                    <template>
                        <div class="card-body__bank" v-for="(bank, index) in searchHandler">
                            <div class="bank__number"><span v-if="index < 9">0</span>{{ index + 1 }}</div>
                            <div class="bank__logo">
                                <img :src="'/img/banks/' + bank.id + '/' + bank.banks_logo">
                            </div>
                            <div class="bank__cr">
                                <img v-if="bank.is_has_reward === 1" src="/img/reward/check-mark.png"
                                     alt="check-mark-logo" class="cr__logo">
                                <img v-if="bank.is_has_reward === 0" src="/img/reward/cross.png" alt="cross-logo"
                                     class="cr__logo">
                                <div v-if="bank.is_has_reward === 1" class="max-rate-reward">
                                    <div v-if="bank.max_size_reward !== null && bank.reward_is_integer !== 1" class="reward-percent">до {{ bank.max_size_reward }}%</div>
                                    <div v-if="bank.max_size_reward !== null && bank.reward_is_integer === 1" class="reward-percent"> {{ bank.max_size_reward }} ₽</div>
                                    <div v-if="bank.max_size_reward !== null" class="reward-text">Вознаграждение</div>
                                </div>
                            </div>
                            <div class="bank__programs">
                                <div class="programs__content">
                                    <div class="programs__text">
                                        <div v-html="bank.short_list_programs">
                                        </div>
                                    </div>
                                    <div class="base-rate">
                                        <img src="/img/reward/percent.svg" alt="percent-logo" style="width: 18px;"
                                             class="percent-logo">
                                        <div class="base-rate__text">{{ bank.type_percent }}</div>
                                    </div>
                                </div>
                                <img src="/img/reward/check-mark.png" alt="check-mark-logo" class="cr__check-mark">
                            </div>
                            <div class="bank__show-details-button">
                                <input id="btn-details" type="button" class="btn-details" value="подробнее"
                                       @click="showModal(bank)">
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div id="modal_wrapper" class="overlay" @click="closeModalOnWrapperSpace($event)" :class="{'modal-wrapper-hide': modalWrapperIsOpen}">
        <transition name="section">
                <div class="modal-card" v-if="isModalOpen" :class="{'visible fade-in-popup': modalIsOpen}" :key="bank.id">
                    <div class="close_mobile_modal" v-touch:swipe.bottom="closeMobileModal">
                        <input type="button" class="close-mobile-modal-btn" data-swipe-unit="px"
                               data-swipe-threshold="20"
                               data-swipe-timeout="500" data-swipe-ignore="false">
                        <img src="/img/reward/close-mobile-modal.png"
                             class="close-mobile-modal-icon">
                    </div>
                    <div class="modal-card__header">
                        <img :src="'/img/banks/' + bank.id + '/' + bank.banks_logo" class="header__logo">
                        <input id="close-modal" type="image" src="/img/reward/close-modal.png" alt="close-logo"
                               class="close-modal" @mouseover="mouseHoverCloseButton()"
                               @mouseleave="mouseLeaveCloseButton()" @click="closeModal()">
                    </div>
                    <div class="modal-card__nav">
                        <nav>
                            <button @click="openTabReward(bank.id)" id="tab_reward" class="nav__link"
                                    :class="{'active underline': tabRewardOpen && isModalOpen}">Вознаграждение
                            </button>
                            <button @click="openTabContacts(bank.id)" id="tab_contacts" class="nav__link"
                                    :class="{'active underline': tabContactsOpen}">Контакты
                            </button>
                            <button @click="openTabFiles(bank.id)" id="tab_files" class="nav__link"
                                    :class="{'active underline': tabFilesOpen}">Файлы
                            </button>
                        </nav>
                    </div>
                    <div class="modal-card__body">
                        <router-view :bank="bank" :user="user" :contacts="JSON.parse(bank.contacts)" :agree="agree" :main="main" :copyContactsData="copyContactsData" :activateSimpleBar="activateSimpleBar"
                        :adaptWidthForScrollToRewardTab="adaptWidthForScrollToRewardTab" :adaptWidthForScroll="adaptWidthForScroll"></router-view>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>

import Vue from "vue";
import Vue2TouchEvents from 'vue2-touch-events'
import 'simplebar';
import 'simplebar/dist/simplebar.css';
import ResizeObserver from 'resize-observer-polyfill';
import SimpleBar from "simplebar";
window.ResizeObserver = ResizeObserver;

Vue.use(Vue2TouchEvents);

export default {
    components: {},

    props: ['user', 'agree', 'main'],

    data() {
        return {
            banks: null,
            bank: null,
            modalIsOpen: false,
            hideModalWrapper: true,
            tabRewardOpen: false,
            tabContactsOpen: false,
            tabFilesOpen: false,
            searchFieldIsOpen: false,
            search: '',
            isCheckRoutes: true,
            banksIsLoading: false,


        }
    },

    watch: {
        checkRoutes: {
            handler: function (banks_id) {
                        if(this.banksIsLoading && banks_id && this.isCheckRoutes){
                            if(this.$route.name === 'bank'){
                                    let bank =  this.banks.find(bank => {
                                        return bank.id === parseInt(banks_id[1]);
                                    });
                                    if(bank){
                                        this.showModal(bank);
                                    }
                                    this.isCheckRoutes = false;
                            }
                            if(this.$route.name === 'bank_contacts'){
                                    let bank =  this.banks.find(bank => {
                                        return bank.id === parseInt(banks_id[1]);
                                    });
                                if(bank){
                                    this.showModal(bank);
                                    this.openTabContacts(bank.id);
                                }
                                    this.isCheckRoutes = false;
                            }
                            if(this.$route.name === 'bank_files'){
                                    let bank =  this.banks.find(bank => {
                                        return bank.id === parseInt(banks_id[1]);
                                    });
                                    if (bank){
                                        this.showModal(bank);
                                        this.openTabFiles(bank.id);
                                    }
                                    this.isCheckRoutes = false;
                            }
                        }
            },
                deep: true,
                immediate: true
        }
    },

    mounted() {
        this.getDataFromServer();

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal();
            }
        });


    },
    methods: {
        getDataFromServer() {
            axios.get('/api/reward/').then(response => {
                this.banks = response.data.banks;
                this.banksIsLoading = true;
            }).catch(error => {
                console.log(error);
            });
        },

        activateSimpleBar(className){
            return new SimpleBar( document.querySelector(className), {
                autoHide: false,
            });
        },

        adaptWidthForScrollToRewardTab(simpleBar, classStandartTerms, classAdditionalTerms){
            let screen = window.matchMedia("(max-width: 780px)");
            if(simpleBar.getContentElement().offsetHeight !== simpleBar.getScrollElement().offsetHeight){
                if(screen.matches){
                    document.querySelector(classStandartTerms).style.cssText = 'width: 95%;'
                    document.querySelector(classAdditionalTerms).style.cssText = 'width: 95%;'
                } else {
                    document.querySelector(classStandartTerms).style.cssText = 'width: 98%;'
                }
            }
        },

        adaptWidthForScroll(simpleBar, className){
            let screen = window.matchMedia("(max-width: 780px)");
            if(simpleBar.getContentElement().offsetHeight !== simpleBar.getScrollElement().offsetHeight){
                if(screen.matches){
                    document.querySelector(className).style.cssText = 'width: 95%;'
                }
            }
        },

        showModal(bank) {
            this.bank = bank;
            this.modalIsOpen = true;
            this.hideModalWrapper = false;
            this.tabRewardOpen = true;
            this.tabContactsOpen = false;
            this.tabFilesOpen = false;
            document.querySelector("body").style.overflow = 'hidden';
            this.$router.push('/reward/'+bank.id.toString()).catch(()=>{});

        },

        openTabReward(id) {
            this.tabRewardOpen = true;
            this.tabContactsOpen = false;
            this.tabFilesOpen = false;
            this.$router.push('/reward/'+ id.toString());
        },
        openTabContacts(id) {
            this.tabRewardOpen = false;
            this.tabContactsOpen = true;
            this.tabFilesOpen = false;
            this.$router.push('/reward/' + id.toString() + '/contacts');
        },

        openTabFiles(id) {
            this.tabRewardOpen = false;
            this.tabContactsOpen = false;
            this.tabFilesOpen = true;
            this.$router.push('/reward/' + id.toString() + '/files');
        },

        mouseHoverCloseButton() {
            document.getElementById("close-modal").src = "/img/reward/cross-hover.png";
        },

        mouseLeaveCloseButton() {
            document.getElementById("close-modal").src = "/img/reward/close-modal.png";
        },

        closeModal() {
            this.modalIsOpen = false;
            this.hideModalWrapper = true;
            document.querySelector("body").style.overflow = 'visible';
            this.$router.push('/reward').catch((error) =>{});

        },
        closeMobileModal() {
            this.modalIsOpen = false;
            setTimeout( () => {
                    this.hideModalWrapper = true;
            }, 250);
            document.querySelector("body").style.overflow = 'visible';
            this.$router.push('/reward');
        },

        closeModalOnWrapperSpace(e) {
            if (!e.target.closest('.modal-card')) {
                e.target.closest('.overlay');
                this.modalIsOpen = false;
                this.hideModalWrapper = true;
                document.querySelector("body").style.overflow = 'visible';
                this.$router.push('/reward');
            }

        },

        openSearchField() {
            this.searchFieldIsOpen = true;
            this.$refs['search-input'].focus();
        },

        closeSearchField() {
            this.searchFieldIsOpen = false;
            this.search = '';
        },

        copyElementToClipboard(element) {
            window.getSelection().removeAllRanges();
            let range = document.createRange();
            range.selectNode(typeof element === 'string' ? document.getElementById(element) : element);
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        },

        copyContactsData(index) {
            this.copyElementToClipboard('contact' + index);
            document.getElementById("copyButton" + index).src = "/img/reward/copy-logo-blue.png";
        }
    },
    computed: {
        checkRoutes(){
            return [this.banksIsLoading, this.$route.params.banks_id];
        },
        isModalOpen() {
            return this.modalIsOpen;
        },
        modalWrapperIsOpen() {
            return this.hideModalWrapper;
        },

        searchHandler() {
            if (this.banks) {
                let replacer = {
                    "q": "й", "w": "ц", "e": "у", "r": "к", "t": "е", "y": "н", "u": "г",
                    "i": "ш", "o": "щ", "p": "з", "[": "х", "]": "ъ", "a": "ф", "s": "ы",
                    "d": "в", "f": "а", "g": "п", "h": "р", "j": "о", "k": "л", "l": "д",
                    ";": "ж", "'": "э", "z": "я", "x": "ч", "c": "с", "v": "м", "b": "и",
                    "n": "т", "m": "ь", ",": "б", ".": "ю", "/": "."
                };
                return this.banks.filter(elem => {
                    return elem.name.toLowerCase().includes(this.search.toLowerCase().replace(/[A-z/,.;\'\]\[]/g, function (x) {
                        return x == x.toLowerCase() ? replacer[x] : replacer[x.toLowerCase()].toUpperCase();
                    }));
                });
            } else {
                return this.banks;
            }

        },
    },

}
</script>

<style>

@media(min-width: 781px) {
    .fade-in-popup {
        animation: fadeIn 0.3s;
        -webkit-animation: fadeIn 0.3s;
        -moz-animation: fadeIn 0.3s;
        -o-animation: fadeIn 0.3s;
        -ms-animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    @-moz-keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    @-webkit-keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    @-o-keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    @-ms-keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
}
@media(max-width: 780px) {
    .section-leave-active,
    .section-enter-active {
        transition: .5s;
    }

    .section-enter {
        top: 100%;
    }

    .section-leave-to {
        top: 100%;
    }
}


.simplebar-scrollbar::before {
    background-color: #006FFF;
    width: 5px;
}

.tabs:target {
    height: 100%;
}


</style>
