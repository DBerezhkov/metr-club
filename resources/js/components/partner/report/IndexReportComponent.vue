<template>
    <div>
        <a href="/partner/reports/create" class="btn btn-success mb-3">Создать отчёт</a>
        <a href="/partner/reports/create" class="btn btn-info mb-3">Создать отчёт</a>
        <a href="/partner/reports/create" class="btn btn-primary mb-3">Создать отчёт</a>
        <a href="/partner/reports/create" class="btn btn-dark mb-3">Создать отчёт</a>
        <a href="/partner/reports/create" class="btn btn-warning mb-3">Создать отчёт</a>
        <h4 class="mt-3">Мои отчёты</h4>
        <table class="table table-striped mb-4">
            <thead>
            <tr>
                <th>#</th>
                <th>Отчетный период</th>
                <th>Сумма сделок</th>
                <th>Вознаграждение</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in reports" :key="item.id">
                <td>{{ index + 1}}</td>
                <td>{{ item.period }}</td>
                <td>{{ item.summ | toCurrency }}</td>
                <td v-if="item.amount > 0">{{ item.amount | toCurrency }}</td>
                <td v-else>Идёт расчёт</td>
                <td>{{ item.status }}</td>
                <td><button type="submit" class="btn btn-success">Открыть</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "ReportComponent",

    data() {
        return {
            reports: [],
        }
    },

    mounted() {
        this.getReports()
    },

    methods: {
        getReports() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('/api/reports/getreports')
                    .then(data => {
                        this.reports = data.data
                        console.log(this.reports);
                    })
            });
        },
    },

}
</script>

<style scoped>

</style>
