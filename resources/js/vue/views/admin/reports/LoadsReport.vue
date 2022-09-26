<script>
import DataTable from '../../../components/DataTable.vue'
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getCycles(1, true);
        this.getSubjects(1, true);
        this.getTeacher(1, true);
        this.getSchedules(1, true);
        this.getLoads(1, true);
    },
    data() {
        return {
            loads: [],
            paginationLinks: [],
            teachers: []
        };
    },
    methods: {
        async getLoads(pageNumber, firtsLoad = false) {
            if (firtsLoad) this.loads[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                this.loads[0] = 'loading'
                const response = await this.axios.get('/api/getCargas?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.loads = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.loads[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.loads[0] = 'error'
            }
        },
        async getCycles() {
            try {
                const response = await this.axios.get('/api/getCiclos')

                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.cycles = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getSubjects() {
            try {

                const response = await this.axios.get('/api/getAsignaturas')

                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.subjects = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getTeacher() {
            try {
                const response = await this.axios.get("/api/getTeacher1");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.teachers = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getSchedules() {
            try {
                const response = await this.axios.get('/api/getHorarios')

                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.schedules = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
    <main>
        <section class=" p-3 ">
            <DataTable title="Listado de Carga Academica" :headers="[
                { title: 'id'},
                { title: 'Estado'},
                { title: 'Ciclo' },
                { title: 'Asignaturas' },
                { title: 'Docente' },
                { title: 'Apellido' },
                { title: 'Hora de inicio' },
                { title: 'Hora de finalizacion' },
            ]" :items="loads">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getLoads(page.url)">{{ page.label == 'pagination.previous'
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