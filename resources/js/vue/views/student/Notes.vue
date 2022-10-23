<script>
export default {
    mounted() {
        document.title = 'IBBACH | Notas'
        this.getCycles()
    },
    data() {
        return {
            cySelected: '',
            cycles: [],
            notes: []
        }
    },
    methods: {
        async getCycles() {
            try {
                const response = await this.axios.get('/api/inscription-cycles')
                this.cycles = response.data
                if (this.cycles[0]) {
                    this.cySelected = this.cycles[0].id
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },

        async getNotes() {
            try {
                const response = await this.axios.get('/api/get-notes/' + this.cySelected)
                this.notes = response.data
            }
            catch (error) {
                handleErrors(error)
            }
        },

        getCurrentCycle(cycles) {
            let cycleObject = {...cycles[0]}
            return cycleObject['cycle']
        }
    },
    watch: {
        cySelected(id) {
            if (this.cySelected) this.getNotes()
        }
    }
}
</script>
<template>
    <main>
        <div class="m-2">
            <h1>Notas</h1>
            <label class="d-inline-block">Selecciona el Ciclo:</label>
            <select class="form-select select-input" v-model="cySelected">
                <option v-for="cycle in cycles" :key="cycle.id" :value="cycle.id">{{ cycle.cycle }}</option>
            </select>
        </div>
        <div class="m-2">
            <div class="table-container">
                <div v-for="note in notes" :key="note.id">
                    <div class="mt-3 p-3 subject">
                        <h5>Asignatura: {{ note.subject }}</h5>
                    </div>
                    <table class="styled-table shadow">
                        <thead>
                            <tr>
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
                            <tr>
                                <td class="text-center">{{ note.ev1 }}</td>
                                <td class="text-center">{{ note.percentege1 }}</td>
                                <td class="text-center">{{ note.ev2 }}</td>
                                <td class="text-center">{{ note.percentege2 }}</td>
                                <td class="text-center">{{ note.ev3 }}</td>
                                <td class="text-center">{{ note.percentege3 }}</td>
                                <td class="text-center">{{ note.ev4 }}</td>
                                <td class="text-center">{{ note.percentege4 }}</td>
                                <td class="text-center">{{ note.ev5 }}</td>
                                <td class="text-center">{{ note.percentege5 }}</td>
                                <td class="text-center fw-bold" :class="note.result_status == 'A' ? '' : 'text-danger'">{{ note.finalAverage }}</td>
                                <td class="text-center" :class="note.result_status == 'A' ? 'text-success' : 'text-danger'">{{ note.result_status == 'A' ? 'Aprobado' : 'Reprobado' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</template>
<style scoped>
select {
    max-width: 400px;
    min-width: 200px;
}

.schedule-card {
    background-color: var(--dark);
    max-width: 300px;
    padding: 1rem;
    font-size: 1.2em;
    border-radius: 5px;
}

p {
    padding: 0;
    margin: 0;
}
.subject {
    background-color: #373737;
    border-bottom: 1px solid #545454;
}
.table-container {
    scrollbar-color: #eee #eee;
    scrollbar-width: thin;
}

.styled-table {
    color: #000;
    border-collapse: collapse;
    margin: 0px 0px 14px 0px;
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
</style>