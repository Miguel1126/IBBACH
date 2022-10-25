<script>
import DataTable from '../../../components/DataTable.vue'
import LoadingDots from '../../../components/LoadingDots.vue';
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
            paginationLinks: [],
            loading: false,
            dates: []
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
                    url: `/api/subjectsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
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
                    url: `/api/subjectsPDF/pdf?date1=${date[0]}&date2=${date[1]}`, //your url
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    // create file link in browser's memory
                    const href = URL.createObjectURL(response.data);

                    // create "a" HTML element with href to file & click
                    const link = document.createElement('a');
                    link.href = href;
                    link.setAttribute('download', 'Asignaturas.pdf'); //or any other extension
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
            <DataTable title="Listado de Materias" personalized :headers="[
                { title: 'Asignaturas', value: 'subject' },
                { title: 'Descripcion', value: 'description' },
                { title: 'Estado', value: 'status'},
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
.inputs {
    max-width: 400px;
    min-width: 200px;
}
</style>
