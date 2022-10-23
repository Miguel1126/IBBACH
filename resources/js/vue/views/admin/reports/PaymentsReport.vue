<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getPaymentsS(1, true)

    },
    data() {
        return {
            PaymentsS: [],
            paginationLinksS: []
        };
    },
    methods: {
        async getPaymentsS(pageNumber, firstPaymentsS = false) {
            if (firstPaymentsS) this.PaymentsS[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getPaymentsS?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.PaymentsS = response.data.data;
                        this.paginationLinksS = response.data.links
                    }
                    else {
                        this.PaymentsS[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.PaymentsS[0] = 'error'
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
    <main>
        <section class="p-3">
            <DataTable title="Listado de pagos solventes" personalized :headers="[
                    {title: 'Fecha de pago', value: 'payment_date'},
                    {title: 'Estado', value: 'status'},
                    {title: 'Sobrecargo', value: 'sourcharge'},
                    {title: 'Cuota', value: 'price'},
                    {title: 'Alumno', value: 'student'},
                    {title: 'Total', value: 'total'},
            ]" :items="PaymentsS">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksS.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksS" :key="page">
                        <span class="page-link" @click="getPaymentsS(page.url)">{{ page.label == 'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
    </main>
</template>

<style scoped>

</style>