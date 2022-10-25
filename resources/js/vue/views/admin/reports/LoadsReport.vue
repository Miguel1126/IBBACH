<script>
import DataTable from '../../../components/DataTable.vue'
import { handleErrors } from '../../../js/handle_error';
import LoadingDots from '../../../components/LoadingDots.vue';

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
            teachers: [],
            loading: false,
            dates:[]
        };
    },
    methods: {
        async exportPDF(e) {
            let date = this.dates;
            e.preventDefault();
            if(this.dates[0] < this.dates[1]){
            if (date.length === 0 || date.length === 1) {
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: 'Debes seleccionar dos fechas'
                })
            }
            else if (date.length === 2) {
                this.axios({
                    url: `/api/loadsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    // create file link in browser's memory
                    const href = URL.createObjectURL(response.data);

                    // create "a" HTML element with href to file & click
                    const link = document.createElement('a');
                    link.href = href;
                    link.setAttribute('target', '_blank'); //or any other extension
                    //or any other extension
                    document.body.appendChild(link);
                    link.click();

                    // clean up "a" element & remove ObjectURL
                    document.body.removeChild(link);
                    URL.revokeObjectURL(href);
                });
            }
        } else{
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: 'Ingresa una fecha valida'
                })
                this.loading = false
            }
        },
        async downloadPDF(e) {
            let date = this.dates;
            e.preventDefault();
            if(this.dates[0] < this.dates[1]){
            if (date.length === 0 || date.length === 1) {
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: 'Debes seleccionar dos fechas'
                })
            }
            else if (date.length === 2) {
                this.axios({
                    url: `/api/loadsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    // create file link in browser's memory
                    const href = URL.createObjectURL(response.data);

                    // create "a" HTML element with href to file & click
                    const link = document.createElement('a');
                    link.href = href;
                    link.setAttribute('download', 'CargasAcademicas.pdf'); //or any other extension
                    //or any other extension
                    document.body.appendChild(link);
                    link.click();

                    // clean up "a" element & remove ObjectURL
                    document.body.removeChild(link);
                    URL.revokeObjectURL(href);
                });
            }
        } else{
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: 'Ingresa una fecha valida'
                })
                this.loading = false
            }
        },
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
    components: { DataTable, LoadingDots }
}        
</script>
<template>
    <main>
        <section class=" p-3 ">
            <div>
                <h4>Selecciona un rango de fechas</h4>
                <span class="m-2">Desde:</span>
                <input type="date" class="inputs form-control" v-model="dates[0]">
                <span class="m-2">Hasta:</span>
                <input type="date" class="inputs form-control" v-model="dates[1]">
                <div class="d-flex flex-wrap"  v-if="!loading">
                    <button class="btn btn-danger m-2" @click="exportPDF">Visualizar PDF</button>
                    <button class="btn btn-danger m-2" @click="downloadPDF"><span class="material-symbols-outlined">file_download</span></button>
                </div>
            </div>
        </section>
        <section class=" p-3 ">
            <DataTable title="Listado de cargas academicas" personalized :headers="[
                { title: 'Estado', value: 'status' },
                { title: 'Ciclos', value: 'cycle' },
                { title: 'Docente', value: 'teacher' },
                { title: 'Asignatura', value: 'subject' },
                { title: 'Hora de inicio', value: 'start_time' },
                { title: 'Hora de finalizacion', value: 'end_time' },
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
.inputs {
    max-width: 400px;
    min-width: 200px;
}
</style>