<script>
import DataTable from '../../components/DataTable.vue'
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        this.getStudents(1, true);
        this.getLoads(1, true);
        this.getInscriptions(1, true);
    },
    data() {
        return {
            date: "",
            statuses: [
                { id: 1, status: "Inscrito" },
                { id: 2, status: "Sin inscribir" }
            ],
            statusSelected: [],
            students: [],
            studentSelected: [],
            subjects: [],
            subjectSelected: [],
            inscriptions: [],
            paginationLinks: [],
            editing: false
        };
    },
    methods: {
        async handleSubmit() {
            if (this.validateInput()) {
                try{
                const response = await this.axios.post("/api/inscripciones", {
                    registration_date: this.date,
                    status: this.statusSelected[0],
                    user_id: this.studentSelected[0].id,
                    load_id: this.subjectSelected[0].id
                });
                console.log(response);
                if (response.status === 201) {
                    this.clearInput();
                    this.getInscriptions();
                    this.$swal.fire("Listo", "La inscripcion fue exitosa", "success");
                }
            }catch(error){
                handleErrors(error)
            }
            }
        },

        async getInscriptions(pageNumber, firstInscriptions = false) {
            if(firstInscriptions) this.inscriptions[0] = 'loading'
            if(typeof (pageNumber) == 'string'){
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getInscripcion?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.inscriptions = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.inscriptions[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.inscriptions[0] = 'error'
            }
        },
        async getStudents() {
            try {
                const response = await this.axios.get("/api/students");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.students = response.data;
                    }
                    else {
                        console.log(response);
                        this.students[0] = "error";
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getLoads() {
            try {
                this.subjects[0] = "loading";
                const response = await this.axios.get("/api/getCarga");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.subjects = response.data;
                        console.log(response);
                    }
                    else {
                        console.log(response);
                        this.subjects[0] = "error";
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        clearInput() {
            this.date = null;
            this.statusSelected = [];
            this.studentSelected = [];
            this.subjectSelected = [];
            this.editing = false;
        },
        validateInput() {
            let valid = this.date && this.statusSelected && this.studentSelected && this.subjectSelected ? true : false;
            return valid;
        },
        selectStatus(event, statuses) {
            this.statusSelected = [];
            this.statusSelected.push(statuses);
        },
        selectStudent(event, students) {
            this.studentSelected = [];
            this.studentSelected.push(students);
        },
        selectSubject(event, subject) {
            this.subjectSelected = [];
            this.subjectSelected.push(subject);
        },
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <!--<h1 class="h1 fs-1 fw-bold mb-3">Inscripcion de ciclos</h1>-->
        <section class="p-3">
            <h3 class="h3 fw-semibold">Inscribir nuevo ciclo</h3>
            <form class="w-25" @submit.prevent="handleSubmit">

                <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary btn-lg ms-4">Agregar <i
                        class="material-icons m-auto ms-1">add_box</i></button>
                <button v-if="!editing" type="submit" class="d-inline-flex btn btn-warning btn-lg ms-3">Limpiar <i
                        class="material-icons m-auto ms-1">backspace</i></button>
            </form>
        </section>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo diurno" :headers="[
                { title: 'Id' },
                { title: 'Fecha de registro' },
                { title: 'Estado' },
                { title: 'Alumno' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Asignatura' },
                { title: 'Descripcion' },
                {title: 'Acciones'}
            ]" :items="inscriptions">
            <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                    <ul class="pagination">
                        <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                            v-for="page in paginationLinks" :key="page">
                            <span class="page-link" @click="getInscriptions(page.url)">{{ page.label == 'pagination.previous'
                                    ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                            }}</span>
                         </li>
                    </ul>
                </nav>
        </section>
    </main>
</template>