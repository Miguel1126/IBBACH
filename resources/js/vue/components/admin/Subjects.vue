<script>
    export default {
        data() {
            return {
                subjects: [
                    { id: 1, subject: 'Introducción al griego' },
                    { id: 2, subject: 'Amar al progimo' },
                    { id: 3, subject: 'Como rezar' },
                    { id: 4, subject: 'Habilidades eclesiasticas' }
                ],
                subject: null,
                editing: false
            }
        },
        methods: {
            clearInput() {
                this.subject = null
                this.editing = false
            },
            validateInput() {
                let valid = this.subject ? true : false
                return valid
            },
            updateTable() {
                const app = this
                if (app.validateInput()) {
                    app.subjects.push({ id: app.subjects.length + 1, subject: app.subject })
                    app.clearInput()
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
                        title: 'Debes rellenar el campo'
                    })
                }
            },
            selectGroup(event, subject) {
                const app = this
                app.editing = true
                app.subject = subject
            },
            saveEdit() {
                this.editing = false
                this.clearInput()
                this.$swal.fire(
                        'Listo',
                        'Se editó la materia',
                        'success'
                    )
            },
            deleteSubject(id){
                this.subjects = this.subjects.filter(subject => subject.id != id)
                this.subjects = [... this.subjects]
            },
            confirmDelete(event, id) {
                this.$swal.fire({
                    title: '¿Estas seguro de querer borrar esta materia?',
                    text: "Si lo borras, no podrás recuperarlo",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteSubject(id)
                    this.$swal.fire(
                        'Listo',
                        'La materia ha sido eliminada',
                        'success'
                    )
                }
                })
            }
        }
    }
</script>

<template>
    <main>
        <h1 class="h1 fs-1 fw-bold">Administrador de Materias</h1>
        <br />
        <section class="load border border-success p-3 border-3 rounded">
            <h3 class="h3 fw-semibold">Crea una nueva materia</h3>
            <div class="d-flex">
                <div class="input-group input-group-lg w-50">
                    <span class="input-group-text" id="inputGroup-sizing-lg"><i class="material-icons">collections_bookmark</i></span>
                    <input type="text" class="form-control" v-model="subject" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="e.j Introducción al griego">
                </div>
                <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg ms-4" @click="updateTable">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                <button v-else type="button" class="d-inline-flex btn btn-success btn-lg ms-4" @click="saveEdit">Guardar <i class="material-icons m-auto ms-1">edit</i></button>
                <button v-if="editing" type="button" class="d-inline-flex btn btn-danger btn-lg ms-3" @click="clearInput">Cancelar <i class="material-icons m-auto ms-1">cancel</i></button>
            </div>
        </section>
        <section class="load border mt-4 border-primary p-3 border-3 rounded">
            <h3 class="h3 fw-semibold mb-3">Listado de materias</h3>
            <table class="table table-bordered border-dark">
                <thead class="table-info table-bordered border-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Materias</th>
                        <th scope="col" class="w-25">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr v-for="subject in subjects" :key="subject.id">
                        <th scope="row">{{ subject.id }}</th>
                        <td>{{ subject.subject }}</td>
                        <td class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary me-2" @click="selectGroup($event, subject.subject)">Modificar</button>
                            <button type="button" class="btn btn-danger" @click="confirmDelete($event, subject.id)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>    
</template>

<style scoped>
    .load {
        border-radius: 15px !important;
    }
</style>