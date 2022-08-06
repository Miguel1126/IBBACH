<script>
import DataTable from '../../../components/DataTable.vue'
export default {
    mounted() {
        this.getAssistances();
        this.getNotes();
    },
    data() {
        return {
            notes: [],
            assistances: []
        };
    },
    methods: {
        async getAssistances() {
            try {
                const response = await this.axios.get("/api/getAsistencias");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.assistances = response.data;
                        console.log(response);
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
        async getNotes() {
            try {
                const response = await this.axios.get("/api/getNotas");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.notes = response.data;
                        console.log(response);
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
            <DataTable title="Listado de asistencia" :headers="[
                {title:'Id'},
                {title:'Fecha de asistencia'},
                {title:'Asignatura'},
                {title:'Estado'},
                {title:'Alumno'},
                {title:'Apellido'},
                {title:'Codigo'},

            ]" :items="assistances">>
            </DataTable>
        </section>
    </main>
</template>