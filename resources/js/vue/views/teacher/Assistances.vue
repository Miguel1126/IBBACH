<script>
export default {
    mounted() {
        this.getAssistances();
        this.getNotes()
    },
    data() {
        return {
            notes: [],
            statuses: [
                { id: 1, status: 'Presente' },
                { id: 2, status: 'Ausente' },
                { id: 3, status: 'Permiso' }
            ],
            date: '',
            statusSelected: [],
            noteSelected: [],
            assistances: []
        }
    },
    methods: {
        async handleSubmit() {
            if (this.validateInput()) {
                const response = await this.axios.post('/api/asistencias', {
                    date: this.date,
                    status: this.statusSelected[0],
                    note_id: this.noteSelected[0].id
                });
                console.log(response);
                if (response.status === 201) {
                    this.clearDropdown()
                    this.$swal.fire(
                        'Listo',
                        'Se registró la asistencia',
                        'success'
                    )
                    this.getAssistances()
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
        clearDropdown() {
            this.date = null
            this.statusSelected = []
            this.noteSelected = []

        },
        async getAssistances() {
            try {
                const response = await this.axios.get('/api/getAsistencias')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.assistances = response.data
                        console.log(response)
                    }
                    else {
                        console.log(response)
                    }
                }
            }
            catch (error) {
                console.error(error)
            }
        },
        async getNotes() {
            try {
                const response = await this.axios.get('/api/getNotas')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.notes = response.data
                        console.log(response)
                    }
                    else {
                        console.log(response)
                    }
                }
            }
            catch (error) {
                console.error(error)
            }
        },
        validateInput() {
            let valid = this.date && this.statusSelected && this.noteSelected ? true : false
            return valid
        },
        selectStatus(event, status) {
            this.statusSelected = []
            this.statusSelected.push(status)
        },
        selectNote(event, note) {
            this.noteSelected = []
            this.noteSelected.push(note)
        },

    },



    setup() {
        document.title = "IBBACH | Asistencias"


    }
}

</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Registro de asistencia</h1>
        <section class="p-3">
            <form @submit.prevent="handleSubmit">
                <h3 class="h3 fw-semibold">Registrar asistencia</h3>
                <div class="d-flex">
                    <div class="m-2">
                        <label>Fecha</label>
                        <input class="form-control" type="date" name="fechainicio" placeholder="00-00-000"
                            v-model="date">
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
                            <span v-if="!noteSelected.length">Alumno</span>
                            <span v-else>Alumno: {{ noteSelected[0].name }} {{ noteSelected[0].last_name }} - {{
                                    noteSelected[0].code
                            }} Materia: {{ noteSelected[0].subject }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                            <li v-for="note in notes" :key="note.id" class="dropdown-item text-light list-click"
                                @click="selectNote($event, note)">{{ note.name }} {{ note.last_name }} - {{ note.code }}
                                Materia: {{ note.subject }}</li>
                        </ul>
                    </div>
                    <div class="m-4">
                        <button type="submit" class="d-inline-flex btn btn-primary btn-lg ms-4"
                            @click="handleSubmit">Guardar <i class="material-icons m-auto ms-1">add_box</i></button>
                        <button type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                            @click="clearDrowdop">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                    </div>
                </div>
            </form>
        </section>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado de cargas</h3>
                <table class="table table-bordered border-dark bg-light">
                    <thead class="table-success table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha de asistencia</th>
                            <th scope="col">Asignatura</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="assistance in assistances" :key="assistance.id">
                            <th scope="row">{{ assistance.id }}</th>
                            <td>{{ assistance.date }}</td>
                            <td>{{ assistance.subject }}</td>
                            <td>{{ assistance.status }}</td>
                            <td>{{ assistance.name }} {{ assistance.last_name }}</td>
                            <td>{{ assistance.code }}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2"
                                    @click="selectAssistance($event, assistance.assistance, assistance.statu, assistance.note)">Modificar</button>
                                <button type="button" class="btn btn-danger"
                                    @click="confirmDelete($event, assistance.id)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </section>
    </main>
</template>

<style scoped>
.list-click {
    cursor: pointer;
}
</style>