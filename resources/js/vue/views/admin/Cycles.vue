<script>
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
import LoadingDots from '../../components/LoadingDots.vue';
import { formatDate } from '../../js/format_time';
export default {
    mounted() {
        this.getCycles(1, true);
        this.getGroups(1, true);
    },
    data() {
        return {
            cycle: '',
            groupSelected: '',
            start_date: '',
            end_date: '',
            groups: [],
            cycles: [],
            paginationLinks: [],
            editing: false,
            loading: false,
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
        async getCycles(pageNumber, firstCycle = false) {
            if (firstCycle) this.cycles[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getCiclos/paginate?page=' + pageNumber);
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.cycles = this.formateDate(response.data.data)
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
                const response = await this.axios.get("/api/getGrupos/paginate");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.groups = response.data.data;
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        clearInputs() {
            this.cycle = ''
            this.start_date = ''
            this.end_date = ''
            this.groupSelected = ''
        },
        validateInputs() {
            return this.cycle && this.groupSelected && this.start_date && this.end_date
        },
        async saveCiclo() {
            this.loading = true

            if (this.validateInputs()) {
                try {
                    const response = await this.axios.post('/api/saveCiclo',
                        {
                            cycle: this.cycle,
                            start_date: this.start_date,
                            end_date: this.end_date,
                            group_id: this.groupSelected
                        })

                    if (response.status === 201) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró la carga correctamente!',
                            'success'
                        )
                        this.getCycles()
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
                this.clearInputs()
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
        formateDate(data) {
            data.forEach(cycle => {
                cycle.start_date = formatDate(cycle.start_date)
                cycle.end_date = formatDate(cycle.end_date)
            })
            return data
        },
    },
    setup() {
        document.title = "IBBACH | Ciclos"
    },
    mounted() {
        this.getCycles()
        this.getGroups()
    },
    components: { DataTable, LoadingDots }
}
</script>
<template>
    <main>
        <section class="p-2">
            <h1 class="fw-semibold mb-2">Crea un nuevo ciclo</h1>
            <form @submit.prevent="saveCiclo">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Ciclo</label>
                            <input type="text" class="form-control inputs" placeholder="01/2022"
                                pattern="^[0-9]{2}\/[0-9]{4}$" v-model="cycle" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block" for="roles">Grupo</label>
                            <select class="form-select inputs" id="roles" v-model="groupSelected" required>
                                <option v-for="group in groups" :key="group.id" :value="group.id">{{
                                group.group }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Fecha de inicio</label>
                            <input type="date" class="form-control inputs" v-model="start_date" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Fecha de finalización</label>
                            <input type="date" class="form-control inputs" v-model="end_date" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="d-flex" v-if="!loading">
                            <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary">Agregar <i
                                    class="material-icons m-auto ms-1">add_box</i></button>
                            <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning ms-1"
                                @click="clearInputs">Limpiar <i
                                    class="material-icons m-auto ms-1">backspace</i></button>
                        </div>
                        <div v-else>
                            <LoadingDots styles="my-3 mx-5" />
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <hr class="separator" />
        <section class="p-3 table-section">
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
<style scoped>
.inputs {
    max-width: 400px;
    min-width: 200px;
}

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