<template>
    <div class="col-md-12">
        <div class="card card-primary">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1% !important;">
                            #
                        </th>
                        <th>
                            Название
                        </th>
                        <th>
                            E-mail
                        </th>
                        <th>
                            Копия E-mail
                        </th>
                        <th>
                            Контактный телефон
                        </th>
                        <th>
                            Подсказка
                        </th>
                        <th>
                            Вкл
                        </th>
                        <th>
                            id
                        </th>
                        <th>
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <draggable :list="banksNew" tag="tbody" animation="500"  @change="update">
                        <tr v-for="(bank) in banksNew" :key="bank.id">
                            <td>
                                {{ bank.order }}
                            </td>
                            <td>
                                <a class="btn btn-light btn-sm" :href="url + '/' + bank.id + '/edit'">
                                    {{ bank.name }}
                                </a>
                            </td>
                            <td>
                                {{ bank.email }}
                            </td>
                            <td>
                                {{ bank.email_copy }}
                            </td>
                            <td>
                                {{ bank.contact_phone }}
                            </td>
                            <td>
                                <span v-tippy="{arrow : true, arrowType : 'round', animation : 'fade', allowHTML: true}" :content="bank.alt_contact">{{ bank.alt_contact | truncate(10)}}</span>
                            </td>
                            <td>
                                <span v-if="bank.enabled" class="text-green">Да</span>
                                <span v-else class="text-red">Нет</span>
                            </td>
                            <td>
                                {{ bank.id }}
                            </td>
                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm" :href="'/admin_panel/bank/' + bank.id + '/edit'">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    </draggable>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable"

export default {
    props: ['banks', 'url'],
    filters: {
        truncate: function (data, num) {
            let dots = ''
            if (data.length > num) {
                dots = '...'
            }
            return data.split("").slice(0, num).join("") + dots
        },
    },
    components: {
        draggable
    },
    data() {
        return {
            banksNew: this.banks,
        };
    },
    methods: {
        update() {
            this.banksNew.map((bank, index) => {
                bank.order = index + 1
            })
            axios.post('/api/banks', {
                banks: this.banksNew
            })
        }
    },
    mounted() {

    },
}
</script>

<style>
</style>
