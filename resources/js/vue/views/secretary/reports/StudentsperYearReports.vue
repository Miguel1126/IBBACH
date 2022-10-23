<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getStudents()
        document.title = 'IBBACH | Estudiantes por año'
    },
    data() {
        return {
            students: [],
            paginationLinks: [],
            count: 0
        }
    },
    methods: {
        async getStudents(pageNumber, firstStudents = false) {
            if (firstStudents) this.students[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getStudentsYear?page=' + pageNumber)
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.students = response.data.data;
                        this.paginationLinks = response.data.links
                        this.count = response.data.total
                    }
                    else {
                        this.students[0] = 'error'
                    }
                }
            }
            catch (error) {
                this.students[0] = 'error'
                handleErrors(error)
            }
        },
        
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <DataTable :title="'Estudiantes por año actual: ' + new Date().getFullYear() + ' - Total: ' + count"
            personalized :headers="[
                {title: 'Nombre', value: 'name'},
                {title: 'Apellidos', value: 'last_name'},
                {title: 'Código', value: 'code'},
                {title: 'Fecha de inscripción', value: 'created_at'}
            ]" :items="students">
        </DataTable>
        <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click.prevent="getStudents(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
    </main>
</template>