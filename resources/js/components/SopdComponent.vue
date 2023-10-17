<template>
    <div class="wrapper">
        <div class="card-wrapper">
            <div class="card">
                <div class="card__body">
                    <span v-html="text"></span>
                </div>
            </div>
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

    props: ['text', 'agree', 'main'],

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

<style scoped>

.wrapper {
    padding: 0px 100px 68px 100px;
    background-color: #E5E9F5;
    min-height: 100%;
    /* overflow: hidden; */
    display: flex;
    justify-content: center; }

.card-wrapper {
    padding-top: 50px;
    width: 100%;
    height: 100%; }

.card {
    display: flex;
    background-color: #FFFFFF;
    flex-direction: column;
    flex-wrap: nowrap;
    border-radius: 30px;
    /* overflow: hidden; */
    height: max-content;
    flex: 1 1 auto;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
}
.card__body {
    background-color: #FFFFFF;
    border-radius: 30px;
    padding: 30px;
}

@media(max-width: 780px) {
    .wrapper {
        padding: 0px;
    }
    .card-wrapper {
        padding-top: 0px;
    }
    .card__body {
        background-color: #FFFFFF;
        border-radius: 30px;
        padding: 10px;
    }
}

</style>
