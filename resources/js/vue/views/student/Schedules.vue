<script setup>
import { formatDate, formatTime } from '../../js/format_time';
</script>
<script>
import { handleErrors } from '../../js/handle_error';

export default {
    mounted() {
        document.title = 'IBBACH | Horarios'
        this.getCycles()
    },
    data() {
        return {
            cySelected: '',
            cycles: [],
            schedules: []
        }
    },
    methods: {
        async getCycles() {
            try {
                const response = await this.axios.get('/api/inscription-cycles')
                this.cycles = response.data
                if (this.cycles[0]) {
                    this.cySelected = this.cycles[0].id
                    this.getSchedules()
                }
            } 
            catch (error) {
                handleErrors(error)    
            }
        },

        async getSchedules() {
            try {
                const response = await this.axios.get('/api/get-schedules/' + this.cySelected)
                this.schedules = response.data
            } 
            catch (error) {
                handleErrors(error)    
            }
        }
    },
    watch: {
        cySelected(id) {
            if (this.cySelected) this.getSchedules()
        }
    }
}
</script>
<template>
    <main>
        <h1>Horarios</h1>
        <div>
            <label class="d-inline-block">Selecciona el Ciclo:</label>
            <select class="form-select select-input" v-model="cySelected">
                <option v-for="cycle in cycles" :key="cycle.id" :value="cycle.id">{{ cycle.cycle }}</option>
            </select>
        </div>
        <div class="m-3" v-if="schedules.length">
            <div class="d-flex flex-wrap gap-2">
                <div class="schedule-card" v-for="schedule in schedules">
                    <p><b>Ciclo:</b> {{ schedule.cycle }}</p>
                    <p><b>Docente:</b> {{ schedule.teacher }}</p>
                    <hr>
                    <p><b>Asignatura:</b> {{ schedule.subject }}</p>
                    <p><b>Descripción:</b> {{ schedule.description }}</p>
                    <hr>
                    <p><b>Fecha de inicio:</b> {{ formatDate(schedule.start_date) }}  <br><b>Fecha de finalización:</b> {{ formatDate(schedule.start_date) }}</p>
                    <p><b>De:</b> {{ formatTime(schedule.start_time) }}  <b>A:</b> {{ formatTime(schedule.end_time) }}</p>
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
}
p {
    padding: 0;
    margin: 0;
    margin-bottom: .5rem;
}
</style>