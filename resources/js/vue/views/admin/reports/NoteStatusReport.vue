<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getStudentA();
        this.getStudentR();
    },
    data() {
        return {
            notesA: [],
            notesR: [],
            editing: false
        };
    },
    methods: {
        async getStudentA() {
            try {
                const response = await this.axios.get("/api/getEstadoA");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.notesA = response.data;
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
        async getStudentR() {
            try {
                const response = await this.axios.get("/api/getEstadoR");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.notesR = response.data;
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
            <DataTable title="Listado de Aprobados" :headers="[
                {title:'Id'},
                {title:'Nombre'},
                {title:'Apellido'},
                {title:'Codigo'},
                {title:'Asignatura'},
                {title:'Resultado Final'},
                {title:'Estado'},
            ]" :items="notesA">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Listado de Reprobados" :headers="[
                {title:'Id'},
                {title:'Nombre'},
                {title:'Apellido'},
                {title:'Codigo'},
                {title:'Asignatura'},
                {title:'Resultado Final'},
                {title:'Estado'},
            ]" :items="notesR">
            </DataTable>
        </section>
    </main>
</template>
