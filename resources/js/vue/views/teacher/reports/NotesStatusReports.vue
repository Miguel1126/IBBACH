<script>
import DataTable from '../../../components/DataTable.vue';
import LoadingDots from '../../../components/LoadingDots.vue';
import { handleErrors } from '../../../js/handle_error';
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
            editing: false,
            dates: [],
            datesS: []
        };
    },
    methods: {
        async exportPDF(e) {
            this.loading = true
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
                    url: `/api/studentsApPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
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
            this.loading = true
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
                    url: `/api/studentsApPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    // create file link in browser's memory
                    const href = URL.createObjectURL(response.data);

                    // create "a" HTML element with href to file & click
                    const link = document.createElement('a');
                    link.href = href;
                    link.setAttribute('download', 'AlumnosAprobados.pdf'); //or any other extension
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
        async exportPDFs(e) {
            this.loading = true
            let date = this.datesS;
            e.preventDefault();
            if(this.datesS[0] < this.datesS[1]){
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
                    url: `/api/studentsRePDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
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
        async downloadPDFs(e) {
            this.loading = true
            let date = this.datesS;
            e.preventDefault();
            if(this.datesS[0] < this.datesS[1]){
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
                    url: `/api/studentsRePDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    // create file link in browser's memory
                    const href = URL.createObjectURL(response.data);

                    // create "a" HTML element with href to file & click
                    const link = document.createElement('a');
                    link.href = href;
                    link.setAttribute('download', 'AlumnosReprobados.pdf'); //or any other extension
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
        async getStudentA(pageNumber, fisrtStudentA = false) {
            if (fisrtStudentA) this.notesA[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getEstadoApr?page=' + pageNumber);
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
                handleErrors(error)
                this.notesA[0] = 'error'
            }
        },
        async getStudentR(pageNumber, fisrtStudentR = false) {
            if (fisrtStudentR) this.notesR[0] = 'loanding'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getEstadoRep?page=' + pageNumber);
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
                handleErrors(error)
                this.notesR[0] = 'error'
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
                <div class="d-flex flex-wrap" v-if="!loading">
                    <button class="btn btn-danger m-2" @click="exportPDF">Visualizar PDF</button>
                    <button class="btn btn-danger m-2" @click="downloadPDF"><span class="material-symbols-outlined">file_download</span></button>
                </div>
            </div>
        </section>
        <section class="p-3">
            <DataTable title="Listado de Aprobados" personalized :headers="[
                {title:'Nombre', value: 'student'},
                {title:'Apellido', value: 'last_name'},
                {title:'Codigo', value: 'code'},
                {title:'Asignatura', value: 'subject'},
                {title:'Resultado Final', value: 'finalAverage'},
                {title:'Estado', value: 'result_status'},
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
        <section class=" p-3 ">
            <div>
                <h4>Selecciona un rango de fechas</h4>
                <span class="m-2">Desde:</span>
                <input type="date" class="inputs form-control" v-model="datesS[0]">
                <span class="m-2">Hasta:</span>
                <input type="date" class="inputs form-control" v-model="datesS[1]">
                <div class="d-flex flex-wrap" v-if="!loading">
                    <button class="btn btn-danger m-2" @click="exportPDFs">Visualizar PDF</button>
                    <button class="btn btn-danger m-2" @click="downloadPDFs"><span class="material-symbols-outlined">file_download</span></button>
                </div>
            </div>
        </section>
        <section class="p-3">
            <DataTable title="Listado de Reprobados" personalized :headers="[
                {title:'Nombre', value: 'student'},
                {title:'Apellido', value: 'last_name'},
                {title:'Codigo', value: 'code'},
                {title:'Asignatura', value: 'subject'},
                {title:'Resultado Final', value: 'finalAverage'},
                {title:'Estado', value: 'result_status'},
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
<style scoped>
.inputs {
    max-width: 400px;
    min-width: 200px;
}
</style>