<script>
import DataTable from '../../../components/DataTable.vue'
export default {
    mounted() {
        this.getCycles();
    },
    data() {
        return {
            cycles: [],
            start_date: [],
            end_date: [],
            status: [],
            groups: [],
        };
    },
    methods: {
        async getCycles() {
            try {
                const response = await this.axios.get("/api/ciclos/get");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.cycles = response.data;
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
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <DataTable title="Listado de Ciclos" :headers="[
                { title: 'Id' },
                { title: 'Ciclos' },
                { title: 'Fecha de inicio' },
                { title: 'Fecha de finalización' },
                { title: 'Estado' },
                { title: 'Grupo' },
            ]" :items="cycles">
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
</style>