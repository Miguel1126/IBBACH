<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getNotes();
    },
    data() {
        return {
            notes: [],
            noteSelected: [],
        };
    },
    methods: {
        async getNotes() {
            try {
                const response = await this.axios.get("/api/getNotas");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.notes = response.data;
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
        selectNote(event, note) {
            this.noteSelected = [];
            this.noteSelected.push(note);
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
            <DataTable title="Listado de notas" :headers="[
                {title:'Id'},
                {title:'Ciclo'},
                {title:'Asignatura'},
                {title:'Nombre'},
                {title:'Apellido'},
                {title:'Codigo'},
                {title:'Grupo'},
                {title:'Evalucion #1'},
                {title:'Porcentaje'},
                {title:'Evalucion #2'},
                {title:'Porcentaje'},
                {title:'Evalucion #3'},
                {title:'Porcentaje'},
                {title:'Evalucion #4'},
                {title:'Porcentaje'},
                {title:'Evalucion #5'},
                {title:'Porcentaje'},
                {title:'Resultado Final'},
                {title:'Estado'},
            ]" :items="notes">
            </DataTable>
        </section>
    </main>
</template>