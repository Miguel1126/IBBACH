<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getNotesReport(1, true);
    },
    data() {
        return {
            notes: [],
            noteSelected: [],
            paginationLinks: []
        };
    },
    methods: {
        async getNotesReport(pageNumber, firstNota = false) {
            if (firstNota) this.notes[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getNotesReport?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.notes = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.notes[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.notes[0] = 'error'
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
            <DataTable title="Listado de notas" personalized :headers="[
                {title:'Ciclo', value: 'cycle'},
                {title:'Asignatura', value: 'subject'},
                {title:'Nombre', value: 'name'},
                {title:'Apellido', value: 'last_name'},
                {title:'Codigo', value: 'code'},
                {title:'Modaidad', value: 'group'},
                {title:'Evalucion #1', value: 'ev1'},
                {title:'Porcentaje', value: 'percentege1'},
                {title:'Evalucion #2', value: 'ev2'},
                {title:'Porcentaje', value: 'percentege2'},
                {title:'Evalucion #3', value: 'ev3'},
                {title:'Porcentaje', value: 'percentege3'},
                {title:'Evalucion #4', value: 'ev4'},
                {title:'Porcentaje', value: 'percentege4'},
                {title:'Evalucion #5', value: 'ev5'},
                {title:'Porcentaje', value: 'percentege5'},
                {title:'Resultado Final', value: 'finalAverage'},
                {title:'Estado', value: 'status'},
            ]" :items="notes">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click.prevent="getNotesReport(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
    </main>
</template>