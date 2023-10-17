<template>
    <div class="body__reward tabs" id="reward" style="height: 100%">
        <div class="reward__standart-terms">
            <div class="standart-terms__title">
                Размеры комиссионного вознаграждения по программам:
            </div>
            <div class="standart-terms__content">
                <div v-html="bank.full_list_programs"></div>
            </div>
        </div>
        <div class="reward_additional-terms">
            <div class="additional-terms__title">
                Дополнительная информация:
            </div>
            <div class="additional-terms__content">
                <div v-html="bank.extra_conditions"></div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['bank', 'activateSimpleBar', 'adaptWidthForScrollToRewardTab'],

    mounted() {
                const simpleBar = this.activateSimpleBar('.body__reward');
                this.adaptWidthForScrollToRewardTab(simpleBar, '.reward__standart-terms', '.reward_additional-terms');

    }
}
</script>

<style>

</style>
