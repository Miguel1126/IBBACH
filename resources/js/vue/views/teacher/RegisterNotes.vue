<script>
import { handleErrors } from '../../js/handle_error'

export default {
    data() {
        return {
            notes: [],
            load: {},
            loading: true,
            published: false
        }
    },
    methods: {
        async getNotes() {
            if (this.$route.params.loadId) {
                try {
                    const response = await this.axios.get('/api/students-notes/' + this.$route.params.loadId)
                    if (response.status === 200) {
                        this.notes = response.data.notes
                        this.load = response.data.load
                        this.loading = false
                        this.checkIfPublished()
                    }
                    else {
                        this.$router.push({ name: 'Notes' })
                    }
                } catch (error) {
                    this.loading = false
                    handleErrors(error)
                }
            }
        },
        async updateNotes() {
            try {
                const response = await this.axios.put('/api/update-notes', { notes: this.notes })
                if (response.status === 200) {
                    this.$swal.fire("¡Listo!", "Se han guardado los cambios de las notas!!", "success")
                }
            } catch (error) {
                this.$swal.fire("Error", "No se pudieron guardar los cambios de las notas", "error")
                handleErrors(error)
            }
        },
        ask() {
            this.$swal.fire({
                title: '¿Quieres publicar las notas para todos los alumnos?',
                showCancelButton: true,
                confirmButtonText: 'Publicar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.publishNotes()
                }
            })
        },
        async publishNotes() {
            
            try {
                const response = await this.axios.put('/api/publish-notes', { notes: this.notes })
                if (response.status === 200) {
                    this.published = true
                    this.$swal.fire("¡Listo!", "Se han publicado las notas!!", "success")
                }
            } catch (error) {
                this.$swal.fire("Error", "No se pudieron publicar las notas", "error")
                handleErrors(error)
            }
        },
        checkIfPublished() {
            let notesCount = this.notes.length
            let publishedCount = 0

            this.notes.forEach(n => {
                if (n.status === "A") {
                    publishedCount++
                }
            })

            if (notesCount === publishedCount) {
                this.published = true
            }
        }
    },
    mounted() {
        document.title = "IBBACH | Registrar Notas"
        this.getNotes()
    }
}
</script>
<template>
    <div v-if="loading"></div>
    <main v-else>
        <div class="m-2">
            <h3 class="fs-4">Asignatura: {{load.subject }}</h3>
            <h3 class="fs-4">Ciclo: {{ load.cycle }}</h3>
            <h3 class="fs-4">Modalidad: {{ load.group }}</h3>
        </div>
        <div class="m-2 mt-3">
            <p class="fs-4 m-0 p-0 text-center border-bottom">Edita las notas de los alumnos en la tabla</p>
            <div class="table-container">
                <table class="styled-table shadow">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Estudiante</th>
                            <th class="text-center" scope="col">EV1</th>
                            <th class="text-center" scope="col">%</th>
                            <th class="text-center" scope="col">EV2</th>
                            <th class="text-center" scope="col">%</th>
                            <th class="text-center" scope="col">EV3</th>
                            <th class="text-center" scope="col">%</th>
                            <th class="text-center" scope="col">EV4</th>
                            <th class="text-center" scope="col">%</th>
                            <th class="text-center" scope="col">EV5</th>
                            <th class="text-center" scope="col">%</th>
                            <th class="text-center" scope="col">Nota Final</th>
                            <th class="text-center" scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="note in notes" :key="note.id">
                            <td class="text-center">{{ note.student }}</td>
                            <td class="text-center"><input type="number" v-model="note.ev1"></td>
                            <td class="text-center"><input type="number" v-model="note.percentege1"></td>
                            <td class="text-center"><input type="number" v-model="note.ev2"></td>
                            <td class="text-center"><input type="number" v-model="note.percentege2"></td>
                            <td class="text-center"><input type="number" v-model="note.ev3"></td>
                            <td class="text-center"><input type="number" v-model="note.percentege3"></td>
                            <td class="text-center"><input type="number" v-model="note.ev4"></td>
                            <td class="text-center"><input type="number" v-model="note.percentege4"></td>
                            <td class="text-center"><input type="number" v-model="note.ev5"></td>
                            <td class="text-center"><input type="number" v-model="note.percentege5"></td>
                            <td class="text-center"><input type="number" v-model="note.finalAverage"></td>
                            <td class="text-center">
                                <select v-model="note.result_status">
                                    <option value="R">Reprobado</option>
                                    <option value="A">Aprobado</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" @click="updateNotes()">Guardar</button>
                    <button class="btn btn-success" @click="ask()" v-if="!published">Publicar</button>
                </div>
            </div>
        </div>
    </main>
</template>
<style scoped>
.table-container {
    scrollbar-color: #eee #eee;
    scrollbar-width: thin;
}

.styled-table {
    color: #000;
    border-collapse: collapse;
    margin: 14px 0;
    border-radius: 20px !important;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    width: 100%;
}

.styled-table tbody {
    background-color: #fff;
}

.styled-table thead tr {
    background-color: #373737;
    color: #ffffff;
    text-align: left;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #373737;
}

.styled-table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
}

.table-color {
    background-color: #eee;
}

.table-container {
    overflow-x: scroll;
}

input,
select {
    width: 70px;
    text-align: center;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    appearance: textfield;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
    appearance: texfield;
}
</style>