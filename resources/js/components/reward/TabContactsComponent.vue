<template>
    <div class="body__contacts tabs" id="contacts" style="height: 100%">
        <div class="contact__cards">
            <template v-if="user !== 0 && user.agreement === 1">
                <div class="contacts__card"
                     :class="contact.is_contact_has_color === true ? 'contact-has-color' : ''"
                     v-for="(contact, index) in contacts">
                    <div :id="'contact' + index" class="contact">
                        <div class="contacts__city">{{ contact.contacts_city }}</div>
                        <div class="contacts__name">{{ contact.contacts_name }}</div>
                        <div class="contacts__phone">{{ contact.contacts_phone }}</div>
                        <div class="contacts__email">{{ contact.contacts_email }}</div>
                    </div>
                    <input type="image" src="/img/reward/copy-logo.png" alt="copy-logo"
                           class="copy-contact"
                           :id="'copyButton' + index" @click="copyContactsData(index)">
                </div>
            </template>
            <div v-else-if="user.agreement === 0">Для просмотра, примите условия <a :href="agree"
                                                                                    target="_blank">оферты.</a>
            </div>
            <div v-else>Для просмотра, <a :href="main" target="_blank">авторизуйтесь.</a></div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";

export default {
    props: ['bank', 'user', 'contacts', 'agree', 'main', 'copyContactsData', 'activateSimpleBar', 'adaptWidthForScroll'],
    mounted() {
            const simpleBar = this.activateSimpleBar('.tabs');
            this.adaptWidthForScroll(simpleBar, '.contact__cards');
    }
}
</script>

<style>



</style>
