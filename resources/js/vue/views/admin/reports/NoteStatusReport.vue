<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getStudentA(1, true);
        this.getStudentR(1, true);
    },
    data() {
        return {
            notesA: [],
            notesR: [],
            paginationLinks: [],
            paginationLinksR: [],
            editing: false
        };
    },
    methods: {
        async getStudentA(pageNumber, fisrtStudentA = false) {
            if(fisrtStudentA) this.notesA[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                    pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
                }
            try {
                const response = await this.axios.get('/api/getEstadoA?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.notesA = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.notesA[0] = 'error'
                    }
                }
            }
            catch (error) {
                console.error(error);
                this.notesA[0] = 'error'
            }
        },
        async getStudentR(pageNumber, fisrtStudentR = false) {
            if(fisrtStudentR) this.notesR[0] = 'loanding'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getEstadoR?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.notesR = response.data.data;
                        this.paginationLinksR = response.data.links
                    }
                    else {
                        this.notesR[0] = 'error'
                    }
                }
            }
            catch (error) {
                console.error(error);
                this.notesR[0] = 'error'
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
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinks" :key="page">
                            <span class="page-link" @click="getStudentA(page.url)">{{ page.label == 'pagination.previous'
                                    ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                            }}</span>
                        </li>
                    </ul>
                </nav>
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
            <nav aria-label="Page navigation example" v-if="paginationLinksR.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinksR" :key="page">
                            <span class="page-link" @click="getStudentR(page.url)">{{ page.label == 'pagination.previous'
                                    ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                            }}</span>
                        </li>
                    </ul>
                </nav>
        </section>
    </main>
</template>
