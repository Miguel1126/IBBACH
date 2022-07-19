<script>
export default{
    data() {
        return{
            note: {
                ev1: '',
                ev2: '',
                ev3: '',
                ev4: '',
                ev5: '',
            },
            percentege: {
                percentege1: '',
                percentege2: '',
                percentege3: '',
                percentege4: '',
                percentege5: '',
            },
            finalAverage: '',
            statuses: [
                {id: 1, status: 'aprovado'},
                {id: 2, status: 'reprovado'}
               ],
            statusSelected:[],
            load_id: '',
            inscription_id: '',
            notes: []
        }
    },
    methods: {
        selectStatus(event, statuses) {
                this.statusSelected = [];
                this.statusSelected.push(statuses);
            },
    }
}
</script>
<template>
    <main>
        <h1 class="h1 fs-1 fw-bold mb-3">Registro de notas</h1>
        <section class="p-3">
            <h3 class="h3 fw-semibold">registrar una nueva nota</h3>
                <form>
                    <div class="d-flex mb-3 w-25">
                        <div class="form-group mb-3">
                            <label>Evalucion #1</label>
                            <input type="number" class="form-control"/>
                        </div>
                        <div class="form-group mb-3">
                            <label>Porcentaje #1</label>
                            <input type="number" class="form-control"/>
                        </div>
                    </div>
                    <div class="d-flex mb-3 w-25">
                        <div class="form-group mb-3">
                            <label>Evalucion #2</label>
                            <input type="number" class="form-control"/>
                        </div>
                        <div class="form-group mb-3">
                            <label>Porcentaje #2</label>
                            <input type="number" class="form-control"/>
                        </div>
                    </div>
                    <div class="d-flex mb-3 w-25">
                        <div class="form-group mb-3">
                            <label>Evalucion #3</label>
                            <input type="number" class="form-control"/>
                        </div>
                         <div class="form-group mb-3">
                            <label>Porcentaje #3</label>
                            <input type="number" class="form-control"/>
                        </div>
                    </div>
                    <div class="d-flex mb-3 w-25">
                        <div class="form-group mb-3">
                            <label>Evalucion #4</label>
                            <input type="number" class="form-control"/>
                        </div>
                        <div class="form-group mb-3">
                            <label>Porcentaje #4</label>
                            <input type="number" class="form-control"/>
                        </div>
                    </div>
                    <div class="d-flex mb-3 w-25">
                        <div class="form-group mb-3">
                            <label>Evalucion #5</label>
                            <input type="number" class="form-control"/>
                        </div>
                        <div class="form-group mb-3">
                            <label>Porcentaje #5</label>
                            <input type="number" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group mb-3 w-25">
                        <label>Resultado final</label>
                        <input type="number" class="form-control"/>
                    </div>
                    <div class="dropdown m-4">
                    <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="!statusSelected.length">Estado</span>
                        <span v-else>{{ statusSelected[0] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li v-for="status in statuses" :key="status.id" class="dropdown-item text-light list-click" @click="selectStatus($event, status.status)">{{ status.status }}</li>
                    </ul>
                    </div>


                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-primary btn-lg ms-4" @click="handleSubmit">Agregar <i class="material-icons m-auto ms-1">add_box</i></button>
                    <button v-if="!editing" type="button" class="d-inline-flex btn btn-warning btn-lg ms-3" @click="clearInput">Limpiar <i class="material-icons m-auto ms-1">backspace</i></button>
                </form>
        </section>
        <hr class="separator"/>
        <section class="p-3">
            <div class="table-container p-3 mb-5 bg-body rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Listado </h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                                <th scope="col" class="w-10">#</th>
                                <th scope="col" class="w-10">Evalucion #1</th>
                                <th scope="col" class="w-10">Porcentaje</th>
                                <th scope="col" class="w-10">Evalucion #2</th>
                                <th scope="col" class="w-10">Porcentaje</th>
                                <th scope="col" class="w-10">Evalucion #3</th>
                                <th scope="col" class="w-10">Porcentaje</th>
                                <th scope="col" class="w-10">Evalucion #4</th>
                                <th scope="col" class="w-10">Porcentaje</th>
                                <th scope="col" class="w-10">Evalucion #5</th>
                                <th scope="col" class="w-10">Porcentaje</th>
                                <th scope="col" class="w-10">Resultado Final</th>
                                <th scope="col" class="w-10">Estado</th>
                                <th scope="col" class="w-10">Alumno</th>
                                <th scope="col" class="w-10">Asignatura</th>
                                <th scope="col" class="w-10">Ciclo</th>
                                <th scope="col" class="w-15">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="note in notes" :key="note.id">
                            <th scope="row">{{ note.id }}</th>
                            <td>{{ note.ev1 }}</td>
                            <td>{{ note.percentage1 }}</td>
                            <td>{{ note.ev2 }}</td>
                            <td>{{ note.percentage2 }}</td>
                            <td>{{ note.ev3 }}</td>
                            <td>{{ note.percentage3 }}</td>
                            <td>{{ note.ev4 }}</td>
                            <td>{{ note.percentage4 }}</td>
                            <td>{{ note.ev5 }}</td>
                            <td>{{ note.percentage5 }}</td>
                            <td>{{ note.finalAverage }}</td>
                            <td>{{ note.status }}</td>
                            <td>{{ note.subject_id }}</td>
                            <td>{{ note.inscription_id }}</td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary me-2" @click="selectGroup($event, note.note )">Modificar</button>
                                <button type="button" class="btn btn-danger" @click="confirmDelete($event, note.id)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>