<script>
import DataTable from '../../components/DataTable.vue'
export default {
    mounted() {
        this.getStudents();
        this.getLoads();
        this.getInscriptions();
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
            editing: false
        };
    },
    methods: {
        async handleSubmit() {
            if (this.validateInput()) {
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
            }
        },

        async getInscriptions() {
            try {
                const response = await this.axios.get("/api/getInscripcion");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.inscriptions = response.data;
                        console.log(response);
                    }
                    else {
                        console.log(response);
                        this.inscriptions[0] = "error";
                    }
                }
            }
            catch (error) {
                console.error(error);
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
                console.error(error);
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
                console.error(error);
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
                { title: 'Descripcion' }
            ]" :items="inscriptions">
            </DataTable>
        </section>
    </main>
</template>