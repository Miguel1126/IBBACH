<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getPaymentsP(1, true);
        this.getPaymentsS(1, true)

    },
    data() {
        return {
            PaymentsP: [],
            PaymentsS: [],
            paginationLinksP: [],
            paginationLinksS: []
        };
    },
    methods: {
        async getPaymentsP(pageNumber, firstPaymentsP = false) {
            if (firstPaymentsP) this.PaymentsP[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                this.PaymentsP[0] = 'loading'
                const response = await this.axios.get('/api/getPaymentspend?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.PaymentsP = response.data.data;
                        this.paginationLinksP = response.data.links
                    }
                    else {
                        this.PaymentsP[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.PaymentsP[0] = 'error'
            }
        },
        async getPaymentsS(pageNumber, firstPaymentsS = false) {
            if (firstPaymentsS) this.PaymentsS[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getPaymentssolv?page=' + pageNumber);
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
            <DataTable title="Listado de pagos pendientes" personalized :headers="[
                    {title: 'Fecha de pago', value: 'payment_date'},
                    {title: 'status', value: 'status'},
                    {title: 'Sobrecargo', value: 'sourcharge'},
                    {title: 'Cuota', value: 'price'},
                    {title: 'Alumno', value: 'student'},
                    {title: 'Total', value: 'total'},
            ]" :items="PaymentsP">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksP.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksP" :key="page">
                        <span class="page-link" @click="getPaymentsP(page.url)">{{ page.label == 'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
        <section class="p-3">
            <DataTable title="Listado de pagos Solventes" personalized :headers="[
                    {title: 'Fecha de pago', value: 'payment_date'},
                    {title: 'status', value: 'status'},
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