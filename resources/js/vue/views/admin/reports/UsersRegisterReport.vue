<script>
import { handleErrors } from '../../../js/handle_error';
export default {
    mounted() {
        this.getTeachers();
    },
    data() {
        return {
            teachers: [],
            students: [],
            admins: [],
            secretaries: []
        }
    },
    methods: {
        async getTeachers() {
            try {
                const response = await this.axios.get('/api/getDocentes')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.teachers = response.data
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
        async getStudents() {
            try {
                const response = await this.axios.get("/api/students");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.students = response.data;
                    }
                    else {
                        console.log(response);
                        this.students[0] = "error";
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getAdmins() {
            try {
                const response = await this.axios.get("/api/getAdmins");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.students = response.data;
                    }
                    else {
                        console.log(response);
                        this.students[0] = "error";
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },
        async getSecretaries() {
            try {
                const response = await this.axios.get("/api/getSecre");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.students = response.data;
                    }
                    else {
                        console.log(response);
                        this.students[0] = "error";
                    }
                }
            }
            catch (error) {
                handleErrors(error)
            }
        },

    }
}
</script>
<template>
    <main>
        <section class="p-3">
            <DataTable title="Listado de alumnos inscritos en el grupo diurno" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Grupo' }
            ]" :items="usersD">
            </DataTable>
        </section>
    </main>
</template>