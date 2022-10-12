<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getInscriptionsD(1, true);
        this.getInscriptionsS(1, true)

    },
    data() {
        return {
            inscriptionsD: [],
            inscriptionsS: [],
            paginationLinksD: [],
            paginationLinksS: []
        };
    },
    methods: {
        async getInscriptionsD(pageNumber, firstInscriptionsD = false) {
            if (firstInscriptionsD) this.inscriptionsD[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getInscrip?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.inscriptionsD = response.data.data;
                        this.paginationLinksD = response.data.links
                    }
                    else {
                        this.inscriptionsD[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.inscriptionsD[0] = 'error'
            }
        },
        async getInscriptionsS(pageNumber, firstInscriptionsS = false) {
            if (firstInscriptionsS) this.inscriptionsS[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getInscript?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.inscriptionsS = response.data.data;
                        this.paginationLinksS = response.data.links
                    }
                    else {
                        this.inscriptionsS[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.inscriptionsS[0] = 'error'
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
    <main>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo diurno" :headers="[
                { title: 'Id' },
                { title: 'Fecha de registro' },
                { title: 'Estado' },
                { title: 'Ciclo' },
                { title: 'Modalidad' },
                { title: 'Alumno' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Asignatura' },
                { title: 'Descripcion' }
            ]" :items="inscriptionsD">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksD.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksD" :key="page">
                        <span class="page-link" @click.prevent="getInscriptionsD(page.url)">{{ page.label ==
                        'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo sabatino" :headers="[
                { title: 'Id' },
                { title: 'Fecha de registro' },
                { title: 'Estado' },
                { title: 'Ciclo' },
                { title: 'Grupo' },
                { title: 'Alumno' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Asignatura' },
                { title: 'Descripcion' }
            ]" :items="inscriptionsS">
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinksS.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinksS" :key="page">
                        <span class="page-link" @click.prevent="getInscriptionsS(page.url)">{{ page.label ==
                        'pagination.previous'
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