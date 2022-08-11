<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getTeachers();
    },
    data() {
        return {
            teachers: [],
            teaSelected: [],
        };
    },
    methods: {
        async getTeachers() {
            try {
                const response = await this.axios.get("/api/getDocentes");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.teachers = response.data;
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
        selectTea(event, teacher) {
            this.teaSelected = [];
            this.teaSelected.push(teacher);
        }
    },
    components: { DataTable }
}
</script>
<template>
    <section class=" p-3 ">
        </section>
        <section class="p-3">
            <DataTable title="Listado de Docentes" :headers="[
                {title:'Id'},
                {title:'Nombre'},
                {title:'Apellido'},
                {title:'Codigo'},
                {title:'Estado'},
            ]" :items="teachers">
            </DataTable>
        </section>
</template>