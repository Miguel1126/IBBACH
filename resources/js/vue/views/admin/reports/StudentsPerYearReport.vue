<script>
import DataTable from '../../../components/DataTable.vue';
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getStudents()
        document.title = 'IBBACH | Estudiantes por año'
    },
    data() {
        return {
            students: []
        }
    },
    methods: {
        async getStudents() {
            this.students[0] = 'loading'
            try {
                const response = await this.axios.get('/api/getStudentsByYear')
                if (response.status === 200) {
                    this.students = response.data
                }
                else {
                    this.students[0] = 'error'
                }
            }
            catch (error) {
                this.students[0] = 'error'
                handleErrors(error)
            }
        }
    },
    components: { DataTable }
}
</script>
<template>
    <main>
        <DataTable :title="'Estudiantes por año actual: ' + new Date().getFullYear() + ' - Total: ' + students.length"
            personalized :headers="[
                {title: 'Nombre', value: 'name'},
                {title: 'Apellidos', value: 'last_name'},
                {title: 'Código', value: 'code'},
                {title: 'Fecha de inscripción', value: 'created_at'}
            ]" :items="students"></DataTable>
    </main>
</template>