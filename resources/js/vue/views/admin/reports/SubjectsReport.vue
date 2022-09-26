<script>
import DataTable from '../../../components/DataTable.vue'
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getSubjectsReport(1, true);
    },
    data() {
        return {
            subjects: [],
            description: [],
            status: [],
            paginationLinks: []
        };
    },
    methods: {
        async getSubjectsReport(pageNumber, firstSubjects = false) {
            if (firstSubjects) this.subjects[0] = 'loading'
    
                if (typeof (pageNumber) == 'string') {
                    pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
                }
            try {
                this.subjects[0] = 'loading'
                const response = await this.axios.get('/api/getSubjectsReport?page=' + pageNumber);
                if (response.status === 200) {
                    this.subjects = response.data.data;
                    this.paginationLinks = response.data.links
                }
                else {
                    this.subjects[0] = 'error'
                }
            } 
            catch (error) {
                handleErrors(error)
                this.subjects[0] = 'error'
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
            <DataTable title="Listado de Materias" :headers="[
                { title: 'Id' },
                { title: 'Asignaturas' },
                { title: 'Descripcion' },
                { title: 'Estado' },
            ]" :items="subjects">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinks" :key="page">
                            <span class="page-link" @click="getSubjectsReport(page.url)">{{ page.label == 'pagination.previous'
                                    ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                            }}</span>
                        </li>
                    </ul>
                </nav>
        </section>
    </main>
</template>

<style scoped>
</style>