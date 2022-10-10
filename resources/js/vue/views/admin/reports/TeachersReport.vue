<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getTeacher(1, true);
    },
    data() {
        return {
            teachers: [],
            teaSelected: [],
            paginationLinks: []
        };
    },
    methods: {
        async getTeacher(pageNumber, firstTeacher = false) {
            if(firstTeacher) this.teachers[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getDocentes/paginate?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.teachers = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.teachers[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.teachers[0] = 'error'
            }
        },
        selectTea(event, teacher) {
            this.teaSelected = [];
            this.teaSelected.push(teacher);
        }
    },
    components: { DataTable }
}
</script>
<template>
    <main>
    <section class=" p-">
        </section>
        <section class="p-3">
            <DataTable :title="'Listado de Docentes - Total: '" :headers="[
                {title:'Id'},
                {title:'Nombre'},
                {title:'Apellido'},
                {title:'Codigo'},
                {title:'Estado'},
            ]" :items="teachers">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click.prevent="getTeacher(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
                </nav>
        </section>
    </main>
</template>