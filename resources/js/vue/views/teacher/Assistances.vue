<script>
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        this.getAssistances(1, true);
        this.getNotes(1, true)
    },
    data() {
        return {
            notes: [],
            date: '',
            noteSelected: '',
            assistances: [],
            paginationLinks: [],
        }
    },
    methods: {
        async getAssistances(pageNumber, firstAssistances = false) {
            if (firstAssistances) this.assistances[0] = 'loading'
            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                const response = await this.axios.get('/api/getAsistencia?page=' + pageNumber)
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.assistances = response.data.data;
                        this.paginationLinks = response.data.links
                    }
                    else {
                        this.assistances[0] = 'error'
                    }
                }
            }
            catch (error) {
                handleErrors(error)
                this.assistances[0] = 'error'
            }
        },
        async getNotes() {
            try {
                const response = await this.axios.get('/api/getNota')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.notes = response.data

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
            this.date = ''
            this.noteSelected = ''

        },
        validateDropdowns() {
            const valid = this.date && this.noteSelected ? true : false
            return valid

        },
        async saveAssistances() {
            const button = document.querySelector('#adder-btn')
            button.disabled = 'true'

            if (this.validateDropdowns()) {
                button.innerText = 'Cargando...'
                try {
                    const response = await this.axios.post('/api/saveAssistances',
                        {
                            date: this.date,
                            note_id: this.noteSelected
                        })

                    if (response.status === 201) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró la asistencia correctamente!',
                            'success'
                        )
                        this.getAssistances()
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
        mounted() {
            document.title = "IBBACH | Asistencias"
            this.getAssistances()
            this.getNotes()
        },
    },
    components: { DataTable }

}

</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Registro de asistencia</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">Registrar asistencia</h3>
            <form @submit.prevent="saveAssistances">
                <div class="d-flex flex-wrap row m-3">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="d-inline-block">Fecha</label>
                            <input class="form-control inputs" type="date" name="fechainicio" placeholder="00-00-000"
                                v-model="date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="select-input">
                            <label class="d-inline-block">Seleccione un alumno</label>
                            <select class="form-select inputs" v-model="noteSelected">
                                <option v-for="note in notes" :key="note.id" :value="note.id">{{ note.name }}
                                    {{ note.last_name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row m-3">
                    <div class="col col-lg-3">
                        <div class="d-flex flex-wrap">
                            <button type="submit" class="d-inline-flex btn btn-primary m-2" id="adder-btn">Agregar <i
                                    class="material-icons m-auto ms-1">add_box</i></button>
                            <button type="button" class="d-inline-flex btn btn-warning m-2"
                                @click.prevent="clearDropdown">Limpiar <i
                                    class="material-icons m-auto ms-1">backspace</i></button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <hr class="separator" />
        <section class="p-3 table-section">
        </section>
        <section class="p-3">
            <DataTable title="Listado de asistencia" personalized :headers="[
                {title:'Fecha de asistencia', value: 'date'},
                {title:'Asignatura', value: 'subject'},
                {title:'Estado', value: 'status'},
                {title:'Alumno', value: 'name'},
                {title:'Apellido', value: 'last_name'},
                {title:'Codigo', value: 'code'},
                {title: 'Acciones'}

            ]" :items="assistances">
                <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getAssistances(page.url)">{{ page.label == 'pagination.previous'
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

.list-click {
    cursor: pointer;
}
</style>