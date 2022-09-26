<script>
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        this.getCycles(1, true);
        this.getGroups(1, true);
    },
    data() {
        return {
            cycle: "",
            start_date: "",
            end_date: "",
            statuses: [
                { id: 1, status: "activo" },
                { id: 2, status: "inactivo" }
            ],
            statusSelected: [],
            groups: [],
            groupSelected: [],
            cycles: [],
            paginationLinks: [],
            editing: false,
            headers: [
                { title: 'Id' },
                { title: 'Ciclo' },
                { title: 'Fecha de inicio' },
                { title: 'Fecha de finalización' },
                { title: 'Estado' },
                { title: 'Grupo' },
                { title: 'Acciones' },
            ]
        };
    },
    methods: {
        async handleSubmit() {
            if (this.validateInput()) {

                try {
                    const response = await this.axios.post("/api/ciclos", {
                        cycle: this.cycle,
                        start_date: this.start_date,
                        end_date: this.end_date,
                        status: this.statusSelected[0],
                        group_id: this.groupSelected[0].id
                    });
                    console.log(response);
                    if (response.data.status === 302) {
                        this.$swal.fire("Error", `${response.data.message}`, "error");
                    }
                    else if (response.status === 201) {
                        this.clearInput();
                        this.getCycles();
                        this.$swal.fire("Listo", "¡Se ha registrado el ciclo correctamente!", "success");
                    }
                } catch (error) {
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
        async getCycles(pageNumber, firstCycle = false) {
            if (firstCycle) this.cycles[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                this.cycles[0] = 'loading'
                const response = await this.axios.get('/api/getCiclos?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.cycles = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.cycles[0] = "error";
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.cycles[0] = "error";

            }
        },
        async getGroups() {
            try {
                const response = await this.axios.get("/api/getGrupos");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.groups = response.data;
                    }
                    else {
                        this.groups[0] = "error";
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        clearInput() {
            this.cycle = null;
            this.start_date = null;
            this.end_date = null;
            this.statusSelected = [];
            this.groupSelected = [];
            this.editing = false;
        },
        validateInput() {
            let valid = this.cycle && this.start_date && this.end_date && this.statusSelected && this.groupSelected ? true : false;
            return valid;
        },
        selectStatus(event, statuses) {
            this.statusSelected = [];
            this.statusSelected.push(statuses);
        },
        selectGroup(event, groups) {
            this.groupSelected = [];
            this.groupSelected.push(groups);
        },
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold mb-3">Registro de ciclos</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Crear nuevo ciclo</h3>
            <form class="w-25" @submit.prevent="handleSubmit">
                <div class="form-group mb-3">
                    <label>Ciclo</label>
                    <input type="text" class="form-control" v-model="cycle" placeholder="Nuevo ciclo" />
                </div>
                <div class="form-group mb-3">
                    <label>Fecha de inicio</label>
                    <input type="date" class="form-control" v-model="start_date" />
                </div>
                <div class="form-group mb-3">
                    <label>fecha de finalización</label>
                    <input type="date" class="form-control" v-model="end_date" />
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
                        <span v-if="!groupSelected.length">Grupos</span>
                        <span v-else>{{ groupSelected[0].group }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <!--<li v-for="group in groups" :key="group.id" class="dropdown-item text-light list-click"
                            @click="selectGroup($event, group)">{{ group.group }}</li>-->
                    </ul>
                </div>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg ms-4"
                    @click="handleSubmit">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                    @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
            </form>
        </section>
        <hr class="separator" />
        <section class="p-3">
            <DataTable title="Listado de ciclos" :headers="headers" :items="cycles">
                <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getCycles(page.url)">{{ page.label == 'pagination.previous'
                        ? '&laquo;' : page.label == 'pagination.next' ? '&raquo;' : page.label
                        }}</span>
                    </li>
                </ul>
            </nav>
        </section>
    </main>
</template>