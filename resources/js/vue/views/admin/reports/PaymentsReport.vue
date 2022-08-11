<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
       this.getPaymentsP();
       this.getPaymentsS()

    },
    data() {
        return {
            PaymentsP: [],
            PaymentsS: [],
        };
    },
    methods: {
         async getPaymentsP() {
            try {
                const response = await this.axios.get('/api/getPaymentsp')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.PaymentsP = response.data
                        console.log(response)
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
         async getPaymentsS() {
            try {
                const response = await this.axios.get('/api/getPaymentsS')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.PaymentsS = response.data
                        console.log(response)
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
 <main>
    <section class="p-3">
            <DataTable title="Listado de pagos pendientes" :headers="[
                { title: 'Id' },
                { title: 'Fecha de pago' },
                { title: 'Ultima fecha de pago' },
                { title: 'Estado'},
                { title: 'Sobrecargo' },
                { title: 'Alumno'},
                { title: 'Apellido'},
                { title: 'Codigo'},
                { title: 'Cuota'}
            ]" :items="PaymentsP">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Listado de pagos solventes" :headers="[
                { title: 'Id' },
                { title: 'Fecha de pago' },
                { title: 'Ultima fecha de pago' },
                { title: 'Estado'},
                { title: 'Sobrecargo' },
                { title: 'Alumno'},
                { title: 'Apellido'},
                { title: 'Codigo'},
                { title: 'Cuota'}
            ]" :items="PaymentsS">
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
</style>