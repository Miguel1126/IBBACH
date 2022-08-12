<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getTeachers();
        this.getStudents();
        this.getAdmin();
        this.getSecre();

    },
    data() {
        return {
            Teachers:[],
            Students:[],
            Admin:[],
            Secre:[]
        };
    },
    methods: {
        async getTeachers() {
            try {
                const response = await this.axios.get("/api/getteachers");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Teachers = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
         async getStudents() {
            try {
                const response = await this.axios.get("/api/getStudents");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Students = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
        async getAdmin() {
            try {
                const response = await this.axios.get("/api/getAdmin");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Admin = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
        async getSecre() {
            try {
                const response = await this.axios.get("/api/getSecre");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.Secre = response.data;
                    }
                    else {
                        console.log(response);
                    }
                }
            }
            catch (error) {
                console.error(error);
            }
        },
    },
    components: { DataTable }
}        
</script>
<template>
    <main>
                <section class="p-3">
            <DataTable title="Listado de usuarios secretaria" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Secre">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Listado de usuarios docentes" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Teachers">
            </DataTable>
        </section>
         <section class="p-3">
            <DataTable title="Listado de usuarios alumnos" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Students">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Listado de usuarios administrador" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Codigo' },
                { title: 'Estado'},
                { title: 'Rol'}
            ]" :items="Admin">
            </DataTable>
        </section>
    </main>
</template>

<style scoped>
</style>