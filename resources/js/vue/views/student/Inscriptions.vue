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
                const response = await this.axios.get("/api/getInscripciones");
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
                const response = await this.axios.get("/api/getCargas");
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
        <h1 class="h1 fs-1 fw-bold mb-3">Inscripcion de ciclos</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Inscribir nuevo ciclo</h3>
            <form class="w-25" @submit.prevent="handleSubmit">
                <div class="form-group mb-3">
                    <label>Fecha de registro</label>
                    <input type="date" class="form-control" v-model="date" />
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!statusSelected.length">Estado</span>
                        <span v-else>{{ statusSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="status in statuses" :key="status.id" class="dropdown-item text-light list-click"
                            @click="selectStatus($event, status.status)">{{ status.status }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!studentSelected.length">Alumnos</span>
                        <span v-else>{{ studentSelected[0].student }} {{ studentSelected[0].last_name }} - {{
                                studentSelected[0].code
                        }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="student in students" :key="student.id" class="dropdown-item text-light list-click"
                            @click="selectStudent($event, student)">{{ student.student }} {{ student.last_name }} - {{
                                    student.code
                            }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!subjectSelected.length">Ciclo por inscribir</span>
                        <span v-else>{{ subjectSelected[0].cycle }} {{ subjectSelected[0].group }} {{
                                subjectSelected[0].subject
                        }} {{ subjectSelected[0].description }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="subject in subjects" :key="subject.id" class="dropdown-item text-light list-click"
                            @click="selectSubject($event, subject)">{{ subject.cycle }} {{ subject.group }} {{
                                    subject.subject
                            }} {{ subject.description }}</li>
                    </ul>
                </div>
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