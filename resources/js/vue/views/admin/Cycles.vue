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
            cycle: [],
            start_date: [],
            end_date: [],
            statuses: [
                { id: 1, status: "activo" },
                { id: 2, status: "inactivo" }
            ],
            statusSelected: '',
            groups: [],
            groupSelected: '',
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
        async getCycles(pageNumber, firstCycle = false) {
            if (firstCycle) this.cycles[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                this.cycles[0] = 'loading'
                const response = await this.axios.get('/api/getCiclos/paginate?page=' + pageNumber);
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
                const response = await this.axios.get("/api/getGrupos/paginate");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.groups = response.data.data;
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
        clearDropdown() {
            this.cycle = null;
            this.start_date = null;
            this.end_date = null;
            this.statusSelected = [];
            this.groupSelected = [];
            this.editing = false;
        },
        validateDropdowns() {
            let valid = this.cycle && this.start_date && this.end_date && this.statusSelected && this.groupSelected ? true : false;
            return valid;
        },
        async saveCiclo() {
            const button = document.querySelector('#adder-btn')
            button.disabled = 'true'

            if (this.validateDropdowns()) {
                button.innerText = 'Cargando...'
                try {
                    const response = await this.axios.post('/api/saveCiclo',
                        {
                            cycle: this.cycle,
                            start_date: this.start_date,
                            end_date: this.end_date,
                            status: this.statusSelected,
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
        
    },
    setup() {
        document.title = "IBBACH | Cargas"
    },
    mounted() {
        this.getCycles()
        this.getGroups()
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold mb-3">Registro de ciclos</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Crear nuevo ciclo</h3>
            <form class="w-25" @submit.prevent="saveCiclo">
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
                <div class="select-input">
                        <select class="form-select select-input" v-model="statusSelected">
                            <option selected value="">Selecciona un estado</option>
                            <option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.status }}</option>
                        </select>
                    </div>
                    <div class="select-input">
                        <select class="form-select select-input" v-model="groupSelected">
                            <option selected value="">Selecciona un grupo</option>
                            <option v-for="group in groups" :key="group.id" :value="group.id">{{group.group}}</option>
                        </select>
                    </div>
                <div class="m-3">
                    <button type="submit" class="d-inline-flex btn btn-primary btn-lg" id="adder-btn"
                        >Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                        @click.prevent="clearDropdown">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                </div>
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