<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
import LoadingDots from '../../../components/LoadingDots.vue';
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
            paginationLinksS: [],
            dates: [],
            loading: false,
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
                    url: `/api/inscriptionsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
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
                    url: `/api/inscriptionsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    // create file link in browser's memory
                    const href = URL.createObjectURL(response.data);

                    // create "a" HTML element with href to file & click
                    const link = document.createElement('a');
                    link.href = href;
                    link.setAttribute('download', 'InscripcionesDiurno.pdf'); //or any other extension
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
                    url: `/api/inscriptionsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
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
                    url: `/api/inscriptionsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    // create file link in browser's memory
                    const href = URL.createObjectURL(response.data);

                    // create "a" HTML element with href to file & click
                    const link = document.createElement('a');
                    link.href = href;
                    link.setAttribute('download', 'InscripcionesSabatino.pdf'); //or any other extension
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
            <DataTable title="Listado de alumnos inscritos en la modalidad diurna" personalized="" :headers="[
                { title: 'Fecha de registro', value: 'created_at'},
                { title: 'Estado', value: 'status' },
                { title: 'Ciclo', value: 'cycle' },
                { title: 'Modalidad', value: 'group' },
                { title: 'Alumno', value: 'name' },
                { title: 'Apellido', value: 'last_name' },
                { title: 'Codigo', value: 'code'},
                { title: 'Asignatura', value: 'subject'},
                { title: 'Descripcion', value: 'description'}
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
            <DataTable title="Listado de alumnos inscritos en la modalidad sabatina" personalized="" :headers="[
                { title: 'Fecha de registro', value: 'created_at'},
                { title: 'Estado', value: 'status' },
                { title: 'Ciclo', value: 'cycle' },
                { title: 'Modalidad', value: 'group' },
                { title: 'Alumno', value: 'name' },
                { title: 'Apellido', value: 'last_name' },
                { title: 'Codigo', value: 'code'},
                { title: 'Asignatura', value: 'subject'},
                { title: 'Descripcion', value: 'description'}
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
.inputs {
    max-width: 400px;
    min-width: 200px;
}
</style>