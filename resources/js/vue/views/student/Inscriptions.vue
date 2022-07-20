<script>
    export default {
        mounted(){
            this.getStudents(),
            this.getLoads(),
            this.getInscriptions()
        },
        data(){
            return {
               date: '',
               statuses: [
                {id: 1, status: 'activo'},
                {id: 2, status: 'inactivo'}
               ],
               statusSelected:[],
               students: [],
               studentSelected: [],
               loads: [],
               loadSelected: [],
               inscriptions: [],
               editing: false

            }
        },
        methods:{
            async handleSubmit(){
                if (this.validateInput()) {
                    const response = await this.axios.post('/api/inscripciones', {
                    register_date: this.date,
                    status: this.statusSelected[0],
                    user_id: this.studentSelected[0],
                    load_id: this.loadSelected[0]
                    });
                    console.log(response);
                if (response.status === 201) {
                    this.clearInput() 
                    this.$swal.fire(
                        'Listo',
                        'La inscripcion fue exitosa',
                        'success'
                    )
                }
                }
                else {
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
                        title: 'Debes rellenar el campo'
                    })
                }
            },
            async getInscriptions() {
                try {
                    const response = await this.axios.get('/api/inscripciones/get')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.inscriptions = response.data
                        }
                        else {
                            this.inscriptions[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            async getStudents() {
                try {
                    const response = await this.axios.get('/api/students')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.students = response.data
                        }
                        else {
                            console.log(response)
                            this.students[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            async getLoads() {
                try {
                    const response = await this.axios.get('/api/cargas/all')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.loads = response.data
                        }
                        else {
                            this.loads[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            clearInput() {
                this.date = null
                this.statusSelected = []
                this.studentSelected = []
                this.loadSelected = []
                this.editing = false
            },
            validateInput() {
                let valid = this.date && this.statusSelected && this.studentSelected && this.loadSelected ? true : false
                return valid
            },
            selectStatus(event, statuses) {
                this.statusSelected = [];
                this.statusSelected.push(statuses);
            },
            selectStudent(event, students) {
                this.studentSelected = [];
                this.studentSelected.push(students);
            },
            selectLoad(event, loads) {
                this.loadSelected = [];
                this.loadSelected.push(loads);
            },
        }
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
                        <input type="date" class="form-control" v-model="date"/>
                    </div>
                    <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!statusSelected.length">Estado</span>
                        <span v-else>{{ statusSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="status in statuses" :key="status.id" class="dropdown-item text-light list-click" @click="selectStatus($event, status.status)">{{ status.status }}</li>
                    </ul>
                    </div>
                    <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!studentSelected.length">Alumnos</span>
                        <span v-else>{{ studentSelected[0].student }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="student in students" :key="student.id" class="dropdown-item text-light list-click" @click="selectStudent($event, student)">{{ student.student }}</li>
                    </ul>
                    </div>
                    <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!loadSelected.length">Cargas</span>
                        <span v-else>{{ loadSelected[0].load_id }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="load in loads" :key="load.id" class="dropdown-item text-light list-click" @click="selectLoad($event, load_id)">{{ load.load }}</li>
                    </ul>
                    </div>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg ms-4" @click="handleSubmit">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                </form>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado </h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha de Registro</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Alumnos</th>
                            <th scope="col">Cargas</th>
                            <th scope="col" class="w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="inscription in inscriptions" :key="inscription.id">
                            <th scope="row">{{ inscription.id }}</th>
                            <td>{{ inscription.date }}</td>
                            <td>{{ inscription.status }}</td>
                            <td>{{ inscription.student }}</td>
                            <td>{{ inscription.load_id}}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2" @click="selectGroup($event, inscription.inscription )">Modificar</button>
                                <button type="button" class="btn btn-danger" @click="confirmDelete($event, inscription.id)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>