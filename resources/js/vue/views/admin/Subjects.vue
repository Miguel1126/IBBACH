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
            id: '',
            subjectUp: '',
            descriptionUp: '',
            subjects: [],
            subject: '',
            description: '',
            uv: '',
            level: '',
            uvUp: '',
            levelUp: '',
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
            this.subjectUp = '' 
            this.descriptionUp = ''
            this.uv = ''
            this.level = ''
            this.uvUp = ''
            this.levelUp = ''
        },
        validateInputs() {
            return this.subject && this.description && this.uv && this.level
        },
        validateInputsUp() {
            return this.subjectUp && this.descriptionUp && this.uvUp && this.levelUp
        },
        async updateSubject() {
            this.loading = true
            if (this.validateInputsUp()) {
                try {
                    const response = await this.axios.put('/api/updateSubject', {
                        id: this.id,
                        subject: this.subjectUp,
                        description: this.descriptionUp,
                        uv: this.uvUp,
                        level: this.levelUp
                    })

                    if (response.status === 202) {
                        this.$swal.fire(
                            'Listo',
                            '¡Se actualizo la asignatura correctamente!',
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
                this. clearInputs()
            } else {
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
        async savesubject() {
            this.loading = true

            if (this.validateInputs()) {
                try {
                    const response = await this.axios.post('/api/saveAsignaturas',
                        {
                            subject: this.subject,
                            description: this.description,
                            uv: this.uv,
                            level: this.level,

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
                <div class="row mb-3">
                    <div class="col col-lg-3">
                        <label class="form-label mt-1">Unidad valorativa</label>
                        <input v-model="uv" type="number" class="inputs form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-lg-3">
                        <label class="form-label mt-1">Nivel</label>
                        <select class=" inputs form-select" v-model="level">
                        <option value="Basico 1">Basico 1</option>
                        <option value="Basico 2">Basico 2</option>
                        <option value="Basico 3">Basico 3</option>
                        <option value="Basico 4">Basico 4</option>
                        <option value="Ministerial 1">Ministerial 1</option>
                        <option value="Ministerial 2">Ministerial 2</option>
                        <option value="Ministerio pastoral">Ministerio pastoral</option>
                        <option value="Misiones">Misiones</option>
                        <option value="Educacion cristiana">Educacion cristiana</option>
                        <option value="Ministerio juvenil">Ministerio juvenil</option>
                        <option value="Plantacion de iglesias">Plantacion de iglesias</option>
                        <option value="Ministerio universitario">Ministerio universitario</option>
                        <option value="Ministerio infantil">Ministerio infantil</option>
                    </select>
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
                            <h5 class="modal-title text-dark" id="ModalLabel">Modificar Asignatura</h5>
                            <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row mb-2">
                                    <div class="col col-lg-3">
                                        <label class="form-label text-dark mt-1">Asignatura</label>
                                        <input type="text" class="form-control inputs" v-model="subjectUp"
                                            placeholder="Actualizar asignatura" pattern="^[a-zA-Z\u00C0-\u017F\s]+$"
                                            title="Solo debes escribir letras" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-lg-3">
                                        <label class="form-label text-dark mt-1">Descripción</label>
                                        <textarea class="form-control inputs" v-model="descriptionUp"
                                            placeholder="Actualizar descripción de la asignatura"
                                            pattern="^[a-zA-Z\u00C0-\u017F\s]+$" title="Solo debes escribir letras"
                                            maxlength="72" required></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                    <div class="col col-lg-3">
                        <label class="form-label mt-1 text-black">Unidad valorativa</label>
                        <input v-model="uvUp" type="number" class="inputs form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-lg-3">
                        <label class="form-label mt-1 text-black">Nivel</label>
                        <select class=" inputs form-select" v-model="levelUp">
                        <option value="Basico 1">Basico 1</option>
                        <option value="Basico 2">Basico 2</option>
                        <option value="Basico 3">Basico 3</option>
                        <option value="Basico 4">Basico 4</option>
                        <option value="Ministerial 1">Ministerial 1</option>
                        <option value="Ministerial 2">Ministerial 2</option>
                        <option value="Ministerio pastoral">Ministerio pastoral</option>
                        <option value="Misiones">Misiones</option>
                        <option value="Educacion cristiana">Educacion cristiana</option>
                        <option value="Ministerio juvenil">Ministerio juvenil</option>
                        <option value="Plantacion de iglesias">Plantacion de iglesias</option>
                        <option value="Ministerio universitario">Ministerio universitario</option>
                        <option value="Ministerio infantil">Ministerio infantil</option>
                    </select>
                    </div>
                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col col-lg-3">
                                    <div class="d-flex" v-if="!loading">
                                        <button v-if="!editing" @click="updateSubject()"
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
            <DataTable title="Listado de asignaturas" personalized :headers="[
                { title: 'Asignatura', value: 'subject' },
                { title: 'Descripción', value: 'description' },
                { title: 'UV', value: 'uv'},
                { title: 'Nivel', value: 'level'},
                { title: 'Estado', value: 'status'},
                { title: 'Acciones'}
            ]" :items="subjects">
                <template #actions="item">
                    <button type="button"
                        @click="id = item.item.id; subjectUp = item.item.subject; descriptionUp = item.item.description; uvUp = item.item.uv; levelUp = item.item.level;"
                        class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#Modal">Modificar</button>
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