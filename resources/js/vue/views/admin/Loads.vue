<script>
    export default {
        data() {
            return {
                cycles: [], 
                subjects: [],
                teachers: [],
                schedules: [],
                loads: [],
                cySelected: [],
                subSelected: [],
                teaSelected: [],
                schSelected: [],
                editing: false
            }
        },
        methods: {
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
            async getCycles() {
                try {
                    const response = await this.axios.get('/api/ciclos/get')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.cycles = response.data
                        }
                        else {
                            this.cycles[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            async getSubjects() {
                try {
                    const response = await this.axios.get('/api/asignaturas/get')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.subjects = response.data
                        }
                        else {
                            this.subjects[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            async getTeachers() {
                try {
                    const response = await this.axios.get('/api/docentes')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.teachers = response.data
                        }
                        else {
                            this.teachers[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            async getSchedules() {
                try {
                    const response = await this.axios.get('/api/horarios/get')
                    if (response.status === 200) {
                        if (typeof(response.data) === 'object') {
                            this.schedules = response.data
                        }
                        else {
                            this.schedules[0] = 'error'
                        }
                    }
                }
                catch {
                    (error) => console.error(error) 
                }
            },
            selectCy(event, cycle) {
                this.cySelected = []
                this.cySelected.push(cycle)
            },
            selectSub(event, subject) {
                this.subSelected = []
                this.subSelected.push(subject)
            },
            selectTea(event, teacher) {
                this.teaSelected = []
                this.teaSelected.push(teacher)
            },
            selectSch(event, schedule) {
                this.schSelected = []
                this.schSelected.push(schedule)
            },
            clearDropdown() {
                const app = this
                app.cySelected = []
                app.subSelected = []
                app.teaSelected = []
                app.schSelected = []
                app.editing = false
            },
            validateDropdowns() {
                const app = this;
                const valid = app.cySelected.length && app.subSelected.length && app.teaSelected.length && app.schSelected.length ? true : false
                return valid
            },
            async saveLoad() {
                const button = document.querySelector('#adder-btn')
                button.disabled = 'true'

                if (this.validateDropdowns()) {
                    button.innerText = 'Cargando...'
                    const response = await this.axios.post('/api/cargas/save', 
                    { 
                        status: 'D',
                        user_id: this.teaSelected[0].id,
                        cycle_id: this.cySelected[0].id,
                        subject_id: this.subSelected[0].id,
                        schedule_id: this.schSelected[0].id
                    })
                    if (response.status === 201) {
                        this.$swal.fire(
                        'Listo',
                        '¡Se registró la carga correctamente!',
                        'success'
                        )
                        this.getLoads()  
                    }
                    else {
                        this.$swal.fire(
                        'Error',
                        'Parece que algo salió mal, intentalo de nuevo',
                        'error'
                        )
                        console.log(response)
                    }
                    this.clearDropdown()
                    button.innerHTML = `Agregar <i class="material-icons m-auto ms-1">add_box</i>`
                    button.disabled = ''
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
                        title: 'Debes rellenar todos los campos'
                    })
                }
            },
            selectLoad(event, load) {
                this.clearDropdown()
                this.editing = true
                this.cySelected.push(load)
                this.subSelected.push(load)
                this.teaSelected.push(load)
                this.schSelected.push(load)
                console.log(this.subSelected)
                console.log(this.teaSelected)
            },
            saveEdit() {
                this.editing = false
                this.clearDropdown()
                this.$swal.fire(
                        'Listo',
                        'Se editó la carga',
                        'success'
                    )
            },
            deleteLoad(id){
                this.loads = this.loads.filter(load => load.id != id);
                this.loads = [... this.loads];
            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar esta carga?',
                    text: "Si la borras, no podrás recuperarla",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteLoad(id)
                    this.$swal.fire(
                        'Listo',
                        'La carga ha sido eliminada',
                        'success'
                    )
                }
                })
            }
        },
        setup() {
            document.title = "IBBACH | Cargas"
        },
        mounted() {
            this.getCycles()
            this.getSubjects()
            this.getTeachers()
            this.getSchedules()
            this.getLoads()
        }
    }
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de carga académica</h1>
        <br />
        <section class="p-3">
            <h3 class="h3 fw-semibold">Asignar una nueva carga</h3>
            <div class="d-flex">
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!cySelected.length">Ciclo</span>
                        <span v-else>{{ cySelected[0].cycle }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="cycle in cycles" :key="cycle.id" class="dropdown-item text-light list-click" @click="selectCy($event, cycle)">{{ cycle.cycle }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!subSelected.length">Materia</span>
                        <span v-else>{{ subSelected[0].subject }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="subject in subjects" :key="subject.id" class="dropdown-item text-light list-click" @click="selectSub($event, subject)">{{ subject.subject }}</li>
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!teaSelected.length">Docente</span>
                        <span v-else>{{ teaSelected[0].teacher }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="teacher in teachers" :key="teacher.id" class="dropdown-item text-light list-click" @click="selectTea($event, teacher)">{{ teacher.teacher }}</li>    
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!schSelected.length">Horario</span>
                        <span v-else>{{ schSelected[0].start_time || loads.schedule }} - {{ schSelected[0].end_time || loads.schedule }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="schedule in schedules" :key="schedule.id" class="dropdown-item text-light list-click" @click="selectSch($event, schedule)">{{ schedule.start_time }} - {{ schedule.end_time }}</li>    
                    </ul>
                </div> 
                <div class="m-4">
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg" id="adder-btn" @click="saveLoad">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-success btn-lg" @click="saveEdit">Guardar <i class="material-icons m-auto ms-1">edit</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearDropdown">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-danger btn-lg ms-3" @click="clearDropdown">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
                </div>
            </div>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de cargas</h3>
                <div v-if="!loads.length" class="d-flex justify-content-center">
                    <div class="waveform">
                        <div class="waveform__bar"></div>
                        <div class="waveform__bar"></div>
                        <div class="waveform__bar"></div>
                        <div class="waveform__bar"></div>
                    </div>
                </div>
                <div v-else-if="loads[0] === 'error'" class="d-flex justify-content-center">
                    <h4 class="text-black">Ups... Ocurrió un error, inténtalo de nuevo más tarde.</h4>
                </div>
                <div class="table-responsive" v-else>
                    <table class="table table-bordered border-dark bg-light">
                        <thead class="table-success table-bordered border-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ciclo</th>
                                <th scope="col">Materia</th>
                                <th scope="col">Docente</th>
                                <th scope="col">Horario</th>
                                <th scope="col" class="w-25">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr v-for="load in loads" :key="load.id">
                                <th scope="row">{{ load.id }}</th>
                                <td>{{ load.cycle }}</td>
                                <td>{{ load.subject }}</td>
                                <td>{{ load.teacher }}</td>
                                <td>{{ load.schedule }}</td>
                                <td class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary me-2" @click="selectLoad($event, load)">Modificar</button>
                                    <button type="button" class="btn btn-danger" @click="confirmDelete($event, load.id)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>    
</template>

<style scoped>
    .list-click {
        cursor: pointer;
    }
    .table-container {
        background: black;
    }
    /**loader styles */
    .waveform {
    --uib-size: 40px;
    --uib-speed: 1s;
    --uib-color: black;
    --uib-line-weight: 3.5px;

    display: flex;
    flex-flow: row nowrap;
    align-items: center;
    justify-content: space-between;
    width: var(--uib-size);
    height: calc(var(--uib-size) * 0.9);
    }

    .waveform__bar {
    width: var(--uib-line-weight);
    height: 100%;
    background-color: var(--uib-color);
    }

    .waveform__bar:nth-child(1) {
    animation: grow var(--uib-speed) ease-in-out
        calc(var(--uib-speed) * -0.45) infinite;
    }

    .waveform__bar:nth-child(2) {
    animation: grow var(--uib-speed) ease-in-out
        calc(var(--uib-speed) * -0.3) infinite;
    }

    .waveform__bar:nth-child(3) {
    animation: grow var(--uib-speed) ease-in-out
        calc(var(--uib-speed) * -0.15) infinite;
    }

    .waveform__bar:nth-child(4) {
    animation: grow var(--uib-speed) ease-in-out infinite;
    }

    @keyframes grow {
    0%,
    100% {
        transform: scaleY(0.3);
    }

    50% {
        transform: scaleY(1);
    }
    }
</style>