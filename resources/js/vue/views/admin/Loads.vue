<script setup>
import { handleErrors } from '../../js/handle_error'
import { formatTime } from '../../js/format_time'
import DataTable from '../../components/DataTable.vue'
import LoadingDots from '../../components/LoadingDots.vue';
</script>
<script>
export default {
    mounted() {
        this.getCycles(1, true)
        this.getSubjects(1, true)
        this.getTeacher(1, true)
        this.getSchedules(1, true)
        this.getLoads(1, true)
    },
    data() {
        return {
            id: '',
            user_id: '',
            cycle_id: '',
            subject_id: '',
            schedule_id: '',
            cycles: [],
            subjects: [],
            teachers: [],
            schedules: [],
            loads: [],
            paginationLinks: [],
            cySelected: '',
            subSelected: '',
            teaSelected: '',
            schSelected: '',
            editing: false,
            loading: false,
            tableHeaders: [
                { title: 'Id' },
                { title: 'Estado' },
                { title: 'Ciclo' },
                { title: 'Docente' },
                { title: 'Asignatura' },
                { title: 'Hora de inicio' },
                { title: 'Hora de fin' },
                { title: 'Acciones' }
            ],
        }
    },
    methods: {
        async getLoads(pageNumber, firtsLoad = false) {
            if (firtsLoad) this.loads[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getCargas?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.loads = this.formateTime(response.data.data)
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
        clearDropdown() {
            this.cySelected = ''
            this.subSelected = ''
            this.teaSelected = ''
            this.schSelected = ''
            this.user_id = ''
            this.cycle_id = ''
            this.subject_id = ''
            this.schedule_id = ''
            this.editing = false
        },
        validateDropdowns() {
            const valid = this.cySelected && this.subSelected && this.teaSelected && this.schSelected
            return valid
        },
        validateSelects() {
            const valid = this.user_id && this.cycle_id && this.subject_id && this.schedule_id
            return valid
        },
        async updateLoads() {
            this.loading = true

            if (this.validateSelects()) {
                try {
                    const response = await this.axios.put('/api/updateLoad',
                        {
                            id: this.id,
                            user_id: this.user_id,
                            cycle_id: this.cycle_id,
                            subject_id: this.subject_id,
                            schedule_id: this.schedule_id
                        })

                    if (response.status === 202) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró la carga correctamente!',
                            'success'
                        )
                        this.getLoads()
                    }
                } catch (error) {
                    this.$swal.fire(
                        'Error',
                        'Parece que algo salió mal, intentalo de nuevo',
                        'error'
                    )
                    handleErrors(error)
                    this.loading = false
                }
                this.clearDropdown()
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
            this.loading = false
        },
        async saveLoad() {
            const button = document.querySelector('#adder-btn')
            button.disabled = 'true'

            if (this.validateDropdowns()) {
                button.innerText = 'Cargando...'
                try {
                    const response = await this.axios.post('/api/saveCarga',
                        {
                            user_id: this.teaSelected,
                            cycle_id: this.cySelected,
                            subject_id: this.subSelected,
                            schedule_id: this.schSelected
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
        },
        formateTime(data) {
            data.forEach(schedule => {
                schedule.start_time = formatTime(schedule.start_time)
                schedule.end_time = formatTime(schedule.end_time)
            })
            return data
        },
    },
    mounted() {
        document.title = "IBBACH | Cargas"
        this.getCycles()
        this.getSubjects()
        this.getTeachers()
        this.getSchedules()
        this.getLoads(1, true)
    },
    components: { DataTable }
}
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de carga académica</h1>
        <br />
        <section class="p-3">
            <h3 class="h3 fw-semibold">Asignar una nueva carga</h3>
            <form @submit.prevent="saveLoad">
                <div class="d-flex flex-wrap">
                    <div class="select-input">
                        <select class="form-select select-input" v-model="cySelected">
                            <option selected value="">Selecciona un ciclo</option>
                            <option v-for="cycle in cycles" :key="cycle.id" :value="cycle.id">{{ cycle.cycle }}</option>
                        </select>
                    </div>
                    <div class="select-input">
                        <select class="form-select select-input" v-model="subSelected">
                            <option selected value="">Selecciona una materia</option>
                            <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{ subject.subject
                            }}</option>
                        </select>
                    </div>
                    <div class="select-input">
                        <select class="form-select select-input" v-model="teaSelected">
                            <option selected value="">Selecciona un docente</option>
                            <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">{{ teacher.teacher
                            }}
                                {{ teacher.last_name }}</option>
                        </select>
                    </div>
                    <div class="select-input">
                        <select class="form-select select-input" v-model="schSelected">
                            <option selected value="">Selecciona un horario</option>
                            <option v-for="schedule in schedules" :key="schedule.id" :value="schedule.id">{{
                            formatTime(schedule.start_time) }} - {{ formatTime(schedule.end_time) }}</option>
                        </select>
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="d-inline-flex btn btn-primary m-2" id="adder-btn"
                        >Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button type="button" class="d-inline-flex btn btn-warning m-2"
                        @click.prevent="clearDropdown">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                </div>
            </form>
        </section>
        <section>
            <!-- Modal -->
            <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="ModalLabel">Modificar Asignatura</h5>
                            <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="d-flex flex-wrap">
                                    <div class="select-input">
                                        <select class="form-select select-input" v-model="cycle_id">
                                            <option selected value="">Selecciona un ciclo</option>
                                            <option v-for="cycle in cycles" :key="cycle.id" :value="cycle.id">{{
                                            cycle.cycle }}</option>
                                        </select>
                                    </div>
                                    <div class="select-input">
                                        <select class="form-select select-input" v-model="subject_id">
                                            <option selected value="">Selecciona una materia</option>
                                            <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{
                                            subject.subject
                                            }}</option>
                                        </select>
                                    </div>
                                    <div class="select-input">
                                        <select class="form-select select-input" v-model="user_id">
                                            <option selected value="">Selecciona un docente</option>
                                            <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">{{
                                            teacher.teacher
                                            }}
                                                {{ teacher.last_name }}</option>
                                        </select>
                                    </div>
                                    <div class="select-input">
                                        <select class="form-select select-input" v-model="schedule_id">
                                            <option selected value="">Selecciona un horario</option>
                                            <option v-for="schedule in schedules" :key="schedule.id"
                                                :value="schedule.id">{{
                                                formatTime(schedule.start_time) }} - {{ formatTime(schedule.end_time) }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col col-lg-3">
                                    <div class="d-flex" v-if="!loading">
                                        <button v-if="!editing" @click="updateLoads()"
                                            class="d-inline-flex btn btn-primary m-2">Actualizar<span
                                                class="material-symbols-outlined">
                                                update
                                            </span></button>
                                    </div>
                                    <div v-else>
                                        <LoadingDots styles="my-3 mx-5" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <hr class="separator" />
        <section class="p-3 table-section">
            <DataTable title="Listado de cargas" personalized :headers="[
                { title: 'Estado', value: 'status' },
                { title: 'Ciclos', value: 'cycle' },
                { title: 'Docente', value: 'teacher' },
                { title: 'Asignatura', value: 'subject' },
                { title: 'Hora de inicio', value: 'start_time' },
                { title: 'Hora de finalizacion', value: 'end_time' },
                { title: 'Acciones' }
            ]" :items="loads">
                <template #actions="item">
                    <button type="button"
                        @click="id = item.item.id; cycle_id = item.item.cycleId; subject_id = item.item.subjectId; user_id = item.item.userId; schedule_id = item.item.scheduleId ;"
                        class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#Modal">Modificar</button>
                    <button type="button" class="btn btn-danger"
                        @click="confirmDelete($event, load.id)">Eliminar</button>
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
.select-input {
    min-width: 300px;
    margin: 2px;
}

.list-click {
    cursor: pointer;
}

@media (max-width: 377px) {
    .select-input {
        min-width: 200px;
    }
}
</style>