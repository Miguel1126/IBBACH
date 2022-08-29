<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
       this.getrates();
        
    },
    data() {
        return {
            Rates: []
        };
    },
    methods: {
         async getrates() {
            try {
                const response = await this.axios.get('/api/getRate')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.Rates = response.data
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
            <DataTable title="Listado de cuotas" :headers="[
                { title: 'id'},
                { title: 'Precio' },
                { title: 'Matricula' }
            ]" :items="Rates">
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
</style>