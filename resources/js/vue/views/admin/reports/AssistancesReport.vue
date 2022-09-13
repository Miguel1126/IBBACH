<script>
import DataTable from '../../../components/DataTable.vue'
export default {
    mounted() {
        this.getAssistances(1, true);
        this.getNotes(1, true);
    },
    data() {
        return {
            notes: [],
            paginationLinks: [],
            assistances: []
        };
    },
    methods: {
        async getAssistances(pageNumber, firstAssistances = false) {
            if(firstAssistances) this.assistances[0] = 'loading'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getAssistancesReport?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.assistances = response.data.data;
                        this.paginationLinks = response.data.links 
                        console.log(response);
                    }
                    else {
                        this.assistances[0] = 'error'
                    }
                }
            }
            catch (error) {
                console.error(error);
                this.assistances[0] = 'error'
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

            ]" :items="assistances">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click.prevent="getAssistances(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
                </nav>
        </section>
    </main>
</template>