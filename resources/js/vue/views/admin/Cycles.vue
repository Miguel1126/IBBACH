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
            id: '',
            cycleUp: '',
            start_dateUp: '',
            end_dateUp: '',
            groupUp: '',
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
            this.cycleUp = ''
            this.start_dateUp = ''
            this.end_dateUp = ''
            this.groupUp = ''
        },
        validateInputs() {
            return this.cycle && this.groupSelected && this.start_date && this.end_date
        },
        validateInputsUp() {
            return this.cycleUp && this.groupUp && this.start_dateUp && this.end_dateUp
        },
        async updateCycle() {
            this.loading = true

            if (this.validateInputsUp()) {
                try {
                    const response = await this.axios.put('/api/updateCycle',
                        {
                            id: this.id,
                            cycle: this.cycleUp,
                            start_date: this.start_dateUp,
                            end_date: this.end_dateUp,
                            group_id: this.groupUp
                        })

                    if (response.status === 202) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró el ciclo correctamente!',
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
                            '¡Se registró el ciclo correctamente!',
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
                            <label class="d-inline-block" for="roles">Modalidad</label>
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
                    <div class="col col-lg-3">
                        <div class="d-flex flex-wrap" v-if="!loading">
                            <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary m-2">Agregar <i
                                    class="material-icons m-auto ms-1">add_box</i></button>
                            <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning m-2"
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
        <section>
            <!-- Modal -->
            <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="ModalLabel">Modificar Ciclo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="d-flex flex-wrap">
                                    <div class="m-3">
                                        <label class="d-inline-block text-dark">Ciclo</label>
                                        <input type="text" class="form-control inputs" placeholder="01/2022"
                                            pattern="^[0-9]{2}\/[0-9]{4}$" v-model="cycleUp" />
                                    </div>
                                    <div class="m-3">
                                        <label class="d-inline-block text-dark" for="roles">Modalidad</label>
                                        <select class="form-select inputs" id="roles" v-model="groupUp" required>
                                            <option v-for="group in groups" :key="group.id" :value="group.id">{{
                                            group.group }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="m-3">
                                        <label class="d-inline-block text-dark">Fecha de inicio</label>
                                        <input type="date" class="form-control inputs" v-model="start_dateUp" />
                                    </div>
                                    <div class="m-3">
                                        <label class="d-inline-block text-dark">Fecha de finalización</label>
                                        <input type="date" class="form-control inputs" v-model="end_dateUp" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="d-flex" v-if="!loading">
                                        <button v-if="!editing" @click="updateCycle()"
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
            <DataTable title="Listado de ciclos" personalized :headers="[
                { title: 'Ciclos', value: 'cycle' },
                { title: 'Fecha de inicio', value: 'start_date' },
                { title: 'Fecha de finalización', value: 'end_date' },
                { title: 'Estado', value: 'status' },
                { title: 'Modalidad', value: 'group' },
                { title: 'Acciones' }
            ]" :items="cycles">
                <template #actions="item">
                    <button type="button"
                        @click="id = item.item.id; cycleUp = item.item.cycle; groupUp = item.item.groupId; start_dateUp = item.item.start_date; end_dateUp = item.item.end_date; "
                        class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#Modal">Modificar</button>
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