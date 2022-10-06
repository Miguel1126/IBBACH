<script>
import DataTable from '../../components/DataTable.vue';
import { formatTime } from '../../js/format_time';
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        this.getSchedules(1, true);
    },
    data() {
        return {
            start_time: "",
            end_time: "",
            schedules: [],
            paginationLinks: [],
            editing: false,
            headers: [
                { title: "Id" },
                { title: "Hora de inicio" },
                { title: "Hora de finalización" },
                { title: "Estado" },
                { title: "Acciones" }
            ],
        };
    },
    methods: {
        async handleSubmit() {
            if (this.validateInput()) {
                try {
                    const response = await this.axios.post("/api/horarios", {
                        start_time: this.start_time,
                        end_time: this.end_time,
                    });
                    if (response.status === 201) {
                        this.getSchedule();
                        this.clearInput();
                        this.$swal.fire("Listo", "Se registró el Horario", "success");
                    }
                }
                catch (error) {
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
                    title: "Debes rellenar el campo"
                });
            }
        },
        selectStatus(event, statuses) {
            this.statusSelected = [];
            this.statusSelected.push(statuses);
        },
        async getSchedules(pageNumber, firstSchedule = false) {
            if (firstSchedule) this.schedules[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                this.schedules[0] = 'loading'
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
                handleErrors(error)
                this.schedules[0] = 'error'
            }
        },
        formateTime(time) {
            time.forEach(schedule => {
                schedule.start_time = formatTime(schedule.start_time)
                schedule.end_time = formatTime(schedule.end_time)
            })
            return time
        },
    },
    watch: {
        'start_time'(time) {
            this.end_time = formatTime(time).split(" ")[0]
        }
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 p-3 fw-bold">Horarios</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Crear nuevo horario</h3>
            <form @submit.prevent="handleSubmit">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="d-inline-block">Hora de inicio</label>
                            <input type="time" class="form-control time-picker" v-model="start_time" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="d-inline-block">Hora de finalización</label>
                            <input type="time" class="form-control time-picker" v-model="end_time" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex">
                        <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary">Agregar <i
                            class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning ms-1"
                        @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                    </div>
                </div>
            </form>
        </section>
        <hr class="separator" />
        <section class="p-3">
            <DataTable title="Listado de horarios" :headers="headers" :items="schedules">
                <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
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