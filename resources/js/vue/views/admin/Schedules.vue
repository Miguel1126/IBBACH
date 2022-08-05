<script>
import DataTable from '../../components/DataTable.vue';
    export default {
    mounted() {
        this.getSchedule();
    },
    data() {
        return {
            start_time: "",
            end_time: "",
            statuses: [
                { id: 1, status: "activo" },
                { id: 2, status: "inactivo" }
            ],
            statusSelected: [],
            schedules: [],
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
                const response = await this.axios.post("/api/horarios", {
                    start_time: this.start_time,
                    end_time: this.end_time,
                    status: this.statusSelected[0]
                });
                console.log(response);
                if (response.status === 201) {
                    this.getSchedule();
                    this.clearInput();
                    this.$swal.fire("Listo", "Se registró el Horario", "success");
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
        getSchedule() {
            this.axios.get("/api/getHorarios")
                .then(response => {
                this.schedules = response.data;
            })
                .catch(error => {
                console.error(error);
            });
        },
        clearInput() {
            this.start_time = null;
            this.end_time = null;
            this.statusSelected = [];
            this.editing = false;
        },
        validateInput() {
            let valid = this.start_time && this.end_time && this.statusSelected ? true : false;
            return valid;
        },
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold mb-3">Horarios</h1>
        <section class=" p-3 ">
            <h3 class="h3 fw-semibold">Crear nuevo horario</h3>
            <form class="w-25" @submit.prevent="handleSubmit">
                <div class="form-group mb-3">
                    <label>Hora de inicio</label>
                    <input type="time" class="form-control" v-model="start_time" placeholder="Nuevo ciclo" />
                </div>
                <div class="form-group mb-3">
                    <label>Hora de finalización</label>
                    <input type="time" class="form-control" v-model="end_time" />
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
                <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary btn-lg ms-4">Agregar <i
                        class="material-icons m-auto ms-1">add_box</i></button>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                    @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
            </form>
        </section>
        <hr class="separator" />
        <section class="p-3">
            <DataTable
            title="Listado de horarios"
            :headers="headers"
            :items="schedules"
            >
                <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
.list-click {
    cursor: pointer;
}
</style>