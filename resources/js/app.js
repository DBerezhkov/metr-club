import Vue from 'vue'
import {Vuelidate} from "vuelidate";
import VueMask from 'v-mask';
import CreateDemandComponent from "./components/partner/demand/CreateDemandComponent";
import IndexReportComponent from "./components/partner/report/IndexReportComponent";
import CreateReportComponent from "./components/partner/report/CreateReportComponent";
import CreateCreditComponent from "./components/partner/credit/CreateCreditComponent";
import CreateInsuranceComponent from "./components/partner/insurance/CreateInsuranceComponent";
import createNumberMask from 'text-mask-addons/dist/createNumberMask'
import IndexBankComponent from "./components/admin/bank/IndexBankComponent";
import ShowDemandComponent from "./components/partner/demand/ShowDemandComponent";
import VueTippy, { TippyComponent } from "vue-tippy";
import RewardComponent from "./components/reward/RewardComponent";
import SopdComponent from "./components/SopdComponent";
import DropZoneComponent from "./components/DropZoneComponent";
import router from "./router";
import ToggleSwitch from 'vuejs-toggle-switch';

require('./bootstrap');

Vue.use(Vuelidate);
Vue.use(VueTippy);
Vue.use(VueMask);
Vue.use(createNumberMask);
Vue.component("tippy", TippyComponent);
Vue.use(ToggleSwitch);

Vue.filter('toCurrency', function (value) {
    if (typeof value !== "number") {
        console.log('не число!');
        return value;
    }
    var formatter = new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB'
    });
    return formatter.format(value);
})

const app = new Vue({
    el: '#app',
    components: {
        IndexReportComponent,
        CreateDemandComponent,
        IndexBankComponent,
        CreateReportComponent,
        CreateCreditComponent,
        CreateInsuranceComponent,
        ShowDemandComponent,
        RewardComponent,
        DropZoneComponent,
        SopdComponent
    },
    router
})
