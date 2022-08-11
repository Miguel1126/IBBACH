<script>
import DataTable from '../../../components/DataTable.vue'
export default {
    mounted() {
        this.getSubjects();
    },
    data() {
        return {
            subjects: [],
            description: [],
            status: [],
        };
    },
    methods: {
        async getSubjects() {
            try {
                const response = await this.axios.get("/api/asignaturas/get");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.subjects = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        }
    },
    components: { DataTable }
}        
</script>
<template>
    <main>
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <DataTable title="Listado de Materias" :headers="[
                { title: 'Id' },
                { title: 'Asignaturas' },
                { title: 'Descripcion' },
                { title: 'Estado' },
            ]" :items="subjects">
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
</style>