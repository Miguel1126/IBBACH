<script>
import { getgroups } from 'process';
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
export default {
    mounted() {
        this.getSubjects(1, true);
    },
    data() {
        return {
            subjects: [],
            subject: null,
            descriptions: [],
            description: null,
            statuses: [
                { id: 1, status: "disponible" },
                { id: 2, status: "ocupado" }
            ],
            paginationLinks: [],
            statusSelected: '',
            editing: false,
            headers: [
                { title: "Id" },
                { title: "Materias" },
                { title: "Descripción" },
                { title: "Estado" },
                { title: "Acciones" }
            ]
        };
    },
    methods: {
        async getSubjects(pageNumber, firstSubjects = false) {
            if (firstSubjects) this.subjects[0] = 'loading'

            if (typeof (pageNumber) == 'string') {
                pageNumber = new URL(pageNumber).searchParams.getAll('page')[0]
            }
            try {
                this.subjects[0] = 'loading'
                const response = await this.axios.get('/api/getAsignaturas/paginate?page=' + pageNumber);
                if (response.status === 200) {
                    this.subjects = response.data.data
                    this.paginationLinks = response.data.links
                }
                else {
                    this.subjects[0] = 'error'
                }
            }
            catch (error) {
                handleErrors(error)
                this.subjects[0] = 'error'
            }
        },
        clearDropdown() {
            this.subject = null;
            this.description = null;
            this.statusSelected = []
            this.editing = false;
        },
        validateDropdowns() {
            let valid = this.subject && this.description  && this.statusSelected ? true : false;
            return valid;
        },
        async savesubject() {
            const button = document.querySelector('#adder-btn')
            button.disabled = 'true'

            if (this.validateDropdowns()) {
                button.innerText = 'Cargando...'
                try {
                    const response = await this.axios.post('/api/saveAsignaturas',
                        {
                            subject: this.subject,
                            subject: this.subject,
                            description: this.description,
                            statuses: this.statusSelected,
                        })

                    if (response.status === 201) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró la materia correctamente!',
                            'success'
                        )
                        this.getSubjects()
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
        saveEdit() {
            this.editing = false;
            this.clearInput();
            this.$swal.fire("Listo", "Se editó la materia", "success");
        },
        deleteSubject(id) {
            this.subjects = this.subjects.filter(subject => subject.id != id);
            this.subjects = [...this.subjects];
        },
        deleteDescription(id) {
            this.descriptions = this.descriptions.filter(description => description.id != id);
            this.descriptions = [...this.descriptions];
        },
        confirmDelete(event, id) {
            this.$swal.fire({
                title: "¿Estas seguro de querer borrar esta materia?",
                text: "Si lo borras, no podrás recuperarlo",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Borrar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteSubject(id);
                    this.deleteDescription(id);
                    this.$swal.fire("Listo", "La materia ha sido eliminada", "success");
                }
            });
        }
    },
    setup() {
        document.title = "IBBACH | Cargas"
    },
    mounted() {
        this.getSubjects()
    },
    components: { DataTable }
}
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de Asignaturas</h1>
        <br />
        <section class=" p-3 ">
            <form @submit.prevent="savesubject">
                <h3 class="h3 fw-semibold">Crea una nueva materia</h3>
                <div>
                    <div class="input-group input-group-lg w-50 mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-lg"><i
                                class="material-icons">collections_bookmark</i></span>
                        <input type="text" class="form-control" v-model="subject" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-lg" placeholder="e.j Introducción al griego">
                    </div>
                    <div class="input-group input-group-lg w-50 mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-lg"><i
                                class="material-icons">collections_bookmark</i></span>
                        <input type="text" class="form-control" v-model="description" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-lg" placeholder="Introduce descripcion">
                    </div>
                    <div class="w-25">
                        <select class="form-select select-input" v-model="statusSelected">
                            <option selected value="">Estado</option>
                            <option v-for="status in statuses " :key="status.id" :value="status.id">{{ status.status
                            }}</option>
                        </select>
                    </div>
                    <div class="m-3">
                    <button type="submit" class="d-inline-flex btn btn-primary btn-lg" id="adder-btn"
                        >Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button type="button" class="d-inline-flex btn btn-warning btn-lg ms-3"
                        @click.prevent="clearDropdown">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                </div>
                </div>
            </form>
        </section>
        <hr class="separator" />
        <section>
            <DataTable title="Listado de asignaturas" :headers="headers" :items="subjects">
                <template #actions>
                    <button type="button" class="btn btn-primary me-2">Modificar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </template>
            </DataTable>
            <nav aria-label="Page navigation example" v-if="paginationLinks.length">
                <ul class="pagination">
                    <li class="page-item cursor-pointer" :class="page.active ? 'active' : ''"
                        v-for="page in paginationLinks" :key="page">
                        <span class="page-link" @click="getSubjects(page.url)">{{ page.label == 'pagination.previous'
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