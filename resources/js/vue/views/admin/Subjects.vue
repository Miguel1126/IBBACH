<script>
import { getgroups } from 'process';
import DataTable from '../../components/DataTable.vue';
import { handleErrors } from '../../js/handle_error';
import LoadingDots from '../../components/LoadingDots.vue';
export default {
    mounted() {
        this.getSubjects(1, true);
    },
    data() {
        return {
            subjects: [],
            subject: '',
            description: '',
            paginationLinks: [],
            editing: false,
            loading: false,
            headers: [
                { title: "Id" },
                { title: "Materia" },
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
        clearInputs() {
            this.subject = ''
            this.description = ''
        },
        validateInputs() {
            return this.subject && this.description
        },
        async savesubject() {
            this.loading = true

            if (this.validateInputs()) {
                try {
                    const response = await this.axios.post('/api/saveAsignaturas',
                        {
                            subject: this.subject,
                            description: this.description
                        })

                    if (response.status === 201) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se registró la asignatura correctamente!',
                            'success'
                        )
                        this.getSubjects()
                    }
                } catch (error) {
                    this.loading = false
                    this.$swal.fire(
                        'Error',
                        'Parece que algo salió mal, intentalo de nuevo',
                        'error'
                    )
                    handleErrors(error)
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
        document.title = "IBBACH | Asignaturas"
    },
    mounted() {
        this.getSubjects()
    },
    components: { DataTable, LoadingDots }
}
</script>

<template>
    <main>
        <section class="p-2">
            <form @submit.prevent="savesubject">
                <h1 class="fw-semibold">Crea una nueva asignatura</h1>
                <div class="row mb-2">
                    <div class="col col-lg-3">
                        <label class="form-label mt-1">Asignatura</label>
                        <input type="text" class="form-control inputs" v-model="subject" placeholder="Nueva asignatura"
                            pattern="^[a-zA-Z\u00C0-\u017F\s]+$" title="Solo debes escribir letras" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-lg-3">
                        <label class="form-label mt-1">Descripción</label>
                        <textarea class="form-control inputs" v-model="description"
                            placeholder="Breve descripción de la asignatura" pattern="^[a-zA-Z\u00C0-\u017F\s]+$"
                            title="Solo debes escribir letras" maxlength="72" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-lg-3">
                        <div class="d-flex" v-if="!loading">
                            <button v-if="!editing" type="submit" class="d-inline-flex btn btn-primary">Agregar <i
                                    class="material-icons m-auto ms-1">add_box</i></button>
                            <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning ms-2"
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
.inputs {
    width: 450px;
}

@media (max-width: 525px) {
    .inputs {
        width: 300px;
    }
}
@media (max-width: 330px) {
    .inputs {
        width: 200px;
    }
}
</style>