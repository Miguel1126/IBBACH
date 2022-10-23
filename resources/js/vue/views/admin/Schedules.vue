<script>
import DataTable from '../../components/DataTable.vue';
import { formatDate, formatTime } from '../../js/format_time';
import { handleErrors } from '../../js/handle_error';
import LoadingDots from '../../components/LoadingDots.vue';
export default {
    mounted() {
        document.title = "IBBACH | Horarios"
        this.getSchedules(1, true);
    },
    data() {
        return {
            id: '',
            start_dateUp: '',
            end_dateUp: '',
            start_timeUp: '',
            end_timeUp: '',
            start_time: "",
            end_time: "",
            start_date: "",
            end_date: "",
            startTimeFormatted: "00:00 AM",
            endTimeFormatted: "00:00 AM",
            schedules: [],
            paginationLinks: [],
            editing: false,
            loading: false,
            headers: [
                { title: "Fecha de inicio", value: 'start_date' },
                { title: "Fecha de finalización", value: 'end_date' },
                { title: "Hora de inicio", value: 'start_time' },
                { title: "Hora de finalización", value: 'end_time' },
                { title: "Acciones" }
            ],
        };
    },
    methods: {
        async updateSchedule() {
            this.loading = true
            if (this.validateInputsUp()) {
                try {
                    const response = await this.axios.put("/api/updateSchedule", {
                        id: this.id,
                        start_time: this.start_timeUp,
                        end_time: this.end_timeUp,
                        start_date: this.start_dateUp,
                        end_date: this.end_dateUp,
                    });
                    if (response.status === 202) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró la asignatura correctamente!',
                            'success'
                        )
                        this.getSchedules();
                        this.clearInputs();
                    }
                }
                catch (error) {
                    this.loading = false
                    console.log(error)
                    this.$swal.fire("Error", "Hubo un error", "error");
                    handleErrors(error)
                }

            }
            else {
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", this.$swal.stopTimer);
                        toast.addEventListener("mouseleave", this.$swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: "Debes rellenar todos los campos"
                });
            }
            this.loading = false
        },
        async handleSubmit() {
            this.loading = true
            if (this.validateInputs()) {
                try {
                    const response = await this.axios.post("/api/horarios", {
                        start_time: this.start_time,
                        end_time: this.end_time,
                        start_date: this.start_date,
                        end_date: this.end_date,
                    });
                    if (response.status === 201) {
                        this.getSchedules();
                        this.clearInputs();
                        this.$swal.fire("Listo", "Se registró el Horario", "success");
                    }
                }
                catch (error) {
                    this.loading = false
                    console.log(error)
                    this.$swal.fire("Error", "Hubo un error", "error");
                    handleErrors(error)
                }

            }
            else {
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", this.$swal.stopTimer);
                        toast.addEventListener("mouseleave", this.$swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: "Debes rellenar todos los campos"
                });
            }
            this.loading = false
        },
        async getSchedules(pageNumber, firstSchedule = false) {
            if (firstSchedule) this.schedules[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getHorarios/paginate?page=' + pageNumber);
                if (response.status === 200) {
                    this.schedules = this.formateTime(response.data.data);
                    this.paginationLinks = response.data.links
                }
                else {
                    this.schedules[0] = 'error'
                }
            }
            catch (error) {
                console.log(error)
                handleErrors(error)
                this.schedules[0] = 'error'
            }
        },
        validateInputs() {
            return this.start_date && this.end_date && this.start_time && this.end_time
        },
        validateInputsUp() {
            return this.start_dateUp && this.end_dateUp && this.start_timeUp && this.end_timeUp
        },
        clearInputs() {
            this.start_time = ""
            this.end_time = ""
            this.start_date = ""
            this.end_date = ""
            this.start_timeUp = ""
            this.end_timeUp = ""
            this.start_dateUp = ""
            this.end_dateUp = ""
        },
        formateTime(time) {
            time.forEach(schedule => {
                schedule.start_time = formatTime(schedule.start_time)
                schedule.end_time = formatTime(schedule.end_time)
                schedule.start_date = formatDate(schedule.start_date)
                schedule.end_date = formatDate(schedule.end_date)
            })
            return time
        },
    },
    watch: {
        'start_time'(time) {
            this.startTimeFormatted = time ? formatTime(time) : '00:00 AM'
        },
        'end_time'(time) {
            this.endTimeFormatted = time ? formatTime(time) : '00:00 AM'
        }
    },
    components: { DataTable, LoadingDots }
}
</script>
<template>
    <main>
        <h1 class="ms-3 fs-1 fw-bold">Horarios</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Crear nuevo horario</h3>
            <form @submit.prevent="handleSubmit">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Fecha de inicio</label>
                            <input type="date" class="form-control time-picker" v-model="start_date" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Fecha de finalización</label>
                            <input type="date" class="form-control time-picker" v-model="end_date" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Hora de inicio</label>
                            <input type="time" class="form-control time-picker" v-model="start_time" />
                            <span class="fs-6 text-light"><span class="fs-4">&#10551;</span> {{ startTimeFormatted
                            }}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Hora de finalización</label>
                            <input type="time" class="form-control time-picker" v-model="end_time" />
                            <span class="fs-6 text-light"><span class="fs-4">&#10551;</span> {{ endTimeFormatted
                            }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-lg-3">
                        <div class="d-flex flex-wrap" v-if="!loading">
                            <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary m-2">Agregar <i
                                    class="material-icons m-auto ms-1">add_box</i></button>
                            <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning m-2"
                                @click="clearInputs">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                        </div>
                        <div v-else>
                            <LoadingDots styles="my-3 mx-auto" />
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <section>
            <!-- Modal -->
            <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="ModalLabel">Modificar Ciclo</h5>
                            <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="d-flex flex-wrap">
                                    <div class="m-3 text-dark">
                                        <label class="d-inline-block">Fecha de inicio</label>
                                        <input type="date" class="form-control time-picker" v-model="start_dateUp" />
                                    </div>
                                    <div class="m-3 text-dark">
                                        <label class="d-inline-block">Fecha de finalización</label>
                                        <input type="date" class="form-control time-picker" v-model="end_dateUp" />
                                    </div>
                                    <div class="m-3 text-dark">
                                        <label class="d-inline-block">Hora de inicio</label>
                                        <input type="time" class="form-control time-picker" v-model="start_timeUp" />
                                    </div>
                                    <div class="m-3 text-dark">
                                        <label class="d-inline-block">Hora de finalización</label>
                                        <input type="time" class="form-control time-picker" v-model="end_timeUp" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="d-flex" v-if="!loading">
                                        <button v-if="!editing" @click="updateSchedule()"
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
            <DataTable personalized title="Listado de horarios" :headers="[
                {title: 'Fecha de inicio', value: 'start_date' },
                {title: 'Fecha de finalización', value: 'end_date' },
                {title: 'Hora de inicio', value: 'start_time' },
                {title: 'Hora de finalización', value: 'end_time' },
                {title: 'Acciones'}
            ]" :items="schedules">
                <template #actions="item">
                    <button type="button" @click="id = item.item.id;" class="btn btn-primary me-2"
                        data-bs-toggle="modal" data-bs-target="#Modal">Modificar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item list-click" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getSchedules(page.url)">{{ page.label == 'pagination.previous'
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

.time-picker {
    width: 200px;
    min-width: 200px;
}
</style>