<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getTeachers(1, true);
    },
    data() {
        return {
            teachers: [],
            teaSelected: [],
            paginationLinks: []
        };
    },
    methods: {
        async getTeachers(pageNumber, firstTeacher = false) {
            if(firstTeacher) this.teachers[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getDocentes?page=' + pageNumber);
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
                console.error(error);
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
    <section class=" p-5 ">
        </section>
        <section class="p-5">
            <DataTable :title="'Listado de Docentes - Total: ' + teachers.length" :headers="[
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
                        <span class="page-link" @click.prevent="getTeachers(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
                </nav>
        </section>
</template>