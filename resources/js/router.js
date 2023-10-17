import Vue from "vue";
import VueRouter from "vue-router";
import TabRewardComponent from "./components/reward/TabRewardComponent";
import TabContactsComponent from "./components/reward/TabContactsComponent";
import TabFilesComponent from "./components/reward/TabFilesComponent";
import RewardComponent from "./components/reward/RewardComponent";

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/reward/:banks_id',
            name: 'bank',
            components: {
               default: TabRewardComponent,
            }
        },
        {
            path: '/reward/:banks_id/contacts',
            name: 'bank_contacts',
            components: {
                default: TabContactsComponent,
            }
        },
        {
            path: '/reward/:banks_id/files',
            name: 'bank_files',
            components: {
                default: TabFilesComponent,
            }
        },
    ],
});
