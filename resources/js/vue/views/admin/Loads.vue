<script setup>
import { handleErrors } from '../../js/handle_error'
import DataTable from '../../components/DataTable.vue'
</script>
<script>
export default {
    mounted() {
        this.getCycles(1, true);
        this.getSubjects(1, true);
        this.getTeacher(1, true);
        this.getSchedules(1, true);
        this.getLoads(1, true)
    },
    data() {
        return {
            cycles: [],
            subjects: [],
            teachers: [],
            schedules: [],
            loads: [],
            paginationLinks: [],
            cySelected: [],
            subSelected: [],
            teaSelected: [],
            schSelected: [],
            editing: false,
            tableHeaders: [
                {title: 'Id'},
                {title: 'Estado'},
                {title: 'Ciclo'},
                {title: 'Asignatura'},
                {title: 'Docente'},
                {title: 'Apellidos'},
                {title: 'Hora de inicio'},
                {title: 'Hora de fin'},
                {title: 'Acciones'}
            ],
        }
    },
    methods: {
        async getLoads(pageNumber, firtsLoad = false) {
            if(firtsLoad) this.loads[0] = 'loading'

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
                    if (typeof (response.data) === 'object') {
                        this.cycles = response.data
                    }
                    else {
                        console.log(response)
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
                    if (typeof (response.data) === 'object') {
                        this.subjects = response.data
                    }
                    else {
                        console.log(response)
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getTeachers() {
            try {
                const response = await this.axios.get('/api/getDocentes')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.teachers = response.data
                    }
                    else {
                        console.log(response)
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
                    if (typeof (response.data) === 'object') {
                        this.schedules = response.data
                    }
                    else {
                        console.log(response)
                    }
                }
            }
            catch (error) {
                handleErrors(error)
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
            this.cySelected = []
            this.subSelected = []
            this.teaSelected = []
            this.schSelected = []
            this.editing = false
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
                try {
                    const response = await this.axios.post('/api/saveCarga',
                        {
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
                } catch (error) {
                    handleErrors(error)
                }
                this.clearDropdown()
                button.innerHTML = `Agregar <i class="material-icons m-auto ms-1">add_box</i>`
                button.disabled = ''
            }
            else {
                button.disabled = ''
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
           /*  this.clearDropdown()
            this.editing = true
            this.cySelected.push(load)
            this.subSelected.push(load)
            this.teaSelected.push(load)
            this.schSelected.push(load)
            console.log(this.subSelected)
            console.log(this.teaSelected) */
            console.log(load)
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
        deleteLoad(id) {
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
    },
    components: {DataTable}
}
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de carga académica</h1>
        <br />
        <section class="p-3">
            <h3 class="h3 fw-semibold">Asignar una nueva carga</h3>
            <div class="d-flex flex-wrap">
                <div class="form-control">
                    <select class="form-select" id="roles" v-model="roleSelected" required>
                        <!--<option v-for="cycle in cycles" :key="cycle.id" :value="cycle.cycle">{{ cycle.cycle }}
                        </option>-->
                    </select>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!subSelected.length">Asignaturas</span>
                        <span v-else>{{ subSelected[0].subject }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                       <!-- <li v-for="subject in subjects" :key="subject.id" class="dropdown-item text-light list-click"
                            @click="selectSub($event, subject)">{{ subject.subject }}</li>-->
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!teaSelected.length">Docente</span>
                        <span v-else>{{ teaSelected[0].teacher }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                       <!-- <li v-for="teacher in teachers" :key="teacher.id" class="dropdown-item text-light list-click"
                            @click="selectTea($event, teacher)">{{ teacher.teacher }}</li>-->
                    </ul>
                </div>
                <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!schSelected.length">Horario</span>
                        <span v-else>{{ schSelected[0].start_time || loads.schedule }} - {{ schSelected[0].end_time ||
                                loads.schedule
                        }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <!--<li v-for="schedule in schedules" :key="schedule.id" class="dropdown-item text-light list-click"
                            @click="selectSch($event, schedule)">{{ schedule.start_time }} - {{ schedule.end_time }}
                        </li>-->
                    </ul>
                </div>
                <div class="m-4">
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg" id="adder-btn"
                        @click="saveLoad">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-success btn-lg" @click="saveEdit">Guardar
                        <i class="material-icons m-auto ms-1">edit</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                        @click="clearDropdown">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                    <button v-else type="button" class="d-inline-flex btn btn-danger btn-lg ms-3"
                        @click="clearDropdown">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
                </div>
            </div>
        </section>
        <hr class="separator" />
        <section class="p-3">
            <DataTable
            title="Listado de cargas"
            :headers="tableHeaders"
            :items="loads"
            >
                <template #actions="{ item }">
                    <button type="button" class="btn btn-primary me-2" @click="selectLoad($event, item)">Modificar</button>
                    <button type="button" class="btn btn-danger" @click="confirmDelete($event, load.id)">Eliminar</button>
                </template>
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
.list-click {
    cursor: pointer;
}
</style>