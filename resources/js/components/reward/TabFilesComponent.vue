<template>
    <div class="body__files tabs" id="files" style="height: 100%">
        <div class="files__cards">
            <template v-if="user !== 0 && user.agreement === 1">
                <template v-for="file in JSON.parse(bank.files)">
                    <a :href="'/files/banks/' + bank.id + '/' + file" target="_blank"
                       style="overflow: hidden;">
                        <div class="file">
                            <img src="/img/reward/file-icon.png" alt="file-icon">
                            <div class="file__name">{{ file }}</div>
                        </div>
                    </a>
                </template>
            </template>
            <div v-else-if="user.agreement === 0">Для просмотра, примите условия <a :href="agree"
                                                                                    target="_blank">оферты.</a>
            </div>
            <div v-else>Для просмотра, <a :href="main" target="_blank">авторизуйтесь.</a></div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['bank', 'user', 'agree', 'main',  'activateSimpleBar', 'adaptWidthForScroll'],
    mounted() {
            const simpleBar = this.activateSimpleBar('.body__files');
            this.adaptWidthForScroll(simpleBar, '.files__cards');
    }
}
</script>

<style>



</style>
