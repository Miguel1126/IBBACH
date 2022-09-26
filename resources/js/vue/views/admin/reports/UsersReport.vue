<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getTeachers(1, true);
        this.getStudents(1, true);
        this.getAdmin(1, true);
        this.getSecre(1, true);

    },
    data() {
        return {
            Teachers:[],
            Students:[],
            Admin:[],
            paginationLinksT: [],
            paginationLinksA: [],
            paginationLinksSe: [],
            paginationLinksS: [],
            Secre:[]
        };
    },
    methods: {
        async getTeachers(pageNumber, firstTeachers = false) {
            if(firstTeachers) this.Teachers[0] = 'loading'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getteachers?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Teachers = response.data.data;
                        this.paginationLinksT = response.data.links
                    }
                    else {
                        this.Teachers[0]='error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.Teachers[0]='error'
            }
        },
         async getStudents(pageNumber, firstStudents = false) {
            if(firstStudents) this.Students[0] = 'loading'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getStudents?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Students = response.data.data;
                        this.paginationLinksS = response.data.links
                    }
                    else {
                        this.Students[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.Students[0] = 'error'
            }
        },
        async getAdmin(pageNumber, firstAdmin = false) {
            if(firstAdmin) this.Admin[0] = 'loading'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getAdmin?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Admin = response.data.data;
                        this.paginationLinksA = response.data.links
                    }
                    else {
                        this.Admin[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.Admin[0] = 'error'
            }
        },
        async getSecre(pageNumber, firstSecre = false) {
            if(firstSecre) this.Secre[0] = 'loading'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getSecre?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Secre = response.data.data;
                        this.paginationLinksSe = response.data.links
                    }
                    else {
                        this.Secre[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.Secre[0] = 'error'
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
    <main>
                <section class="p-3">
            <DataTable title="Listado de usuarios secretaria" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Secre">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksSe.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksSe" :key="page">
                        <span class="page-link" @click.prevent="getSecre(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
                </nav>
        </section>
        <section class="p-3">
            <DataTable title="Listado de usuarios docentes" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Teachers">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksT.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksT" :key="page">
                        <span class="page-link" @click.prevent="getTeachers(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
                </nav>
        </section>
         <section class="p-3">
            <DataTable title="Listado de usuarios alumnos" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Students">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksS.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksS" :key="page">
                        <span class="page-link" @click.prevent="getStudents(page.url)">{{ page.label == 'pagination.previous'
                                ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
                </nav>
        </section>
        <section class="p-3">
            <DataTable title="Listado de usuarios administrador" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Admin">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksA.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksA" :key="page">
                        <span class="page-link" @click.prevent="getAdmin(page.url)">{{ page.label == 'pagination.previous'
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