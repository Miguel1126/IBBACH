<script>
import DataTable from '../../../components/DataTable.vue';
export default {
    mounted() {
        this.getApplicant();
        this.getPersonalInfo();
        this.getEcclesiasticalInfo();
        this.getMinisterialInfo();
    },
    data() {
        return {
            Applicant:[],
            PersonalInfo:[],
            EcclesiasticalInfo:[],
            MinisterialInfo:[]
        };
    },
    methods: {
        async getApplicant() {
            try {
                const response = await this.axios.get("/api/getApplicant");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.applicants = response.data;
                        console.log(response);
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
        async getPersonalInfo() {
            try {
                const response = await this.axios.get("/api/getPersonalInfo");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.PersonalInfo = response.data;
                        console.log(response);
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
        async getEcclesiasticalInfo() {
            try {
                const response = await this.axios.get("/api/getEcclesiasticalInfo");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.EcclesiasticalInfo = response.data;
                        console.log(response);
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
        async getMinisterialInfo() {
            try {
                const response = await this.axios.get("/api/getMinisterialInfo");
                if (response.status === 200) {
                    if (typeof (response.data) === "object") {
                        this.MinisterialInfo = response.data;
                        console.log(response);
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
        <section class=" p-3 ">
        </section>
        <section class="p-3">
            <DataTable title="Informacion Personal" :headers="[
                 { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Correo' },
                { title: 'Telefono' },
                { title: 'Direccion' },
                { title: 'Nacionalidad' },
                { title: 'Fecha de nacimiento' },
                { title: 'Estado civil' },
                { title: 'Nombre del conyuge' },
                { title: 'Grado secular' },
                { title: 'Ocupacion actual' },
            ]" :items="PersonalInfo">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Informacion Eclesiastica" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Es pastor' },
                { title: 'Es miembro' },
                { title: 'Telefono' },
                { title: 'Nombre de la iglesia' },
                { title: 'Direccion de la iglesia' },
                { title: 'Telefono de la iglesia' },
                { title: 'Distrito' },
                { title: 'Pastor de la iglesia' },
                { title: 'Licencia' },
                { title: 'Pastor' },
                { title: 'Telefono' },
                { title: 'Pastor' },
                { title: 'Telefono' },
                { title: 'Cuando acepto a cristo' },
                { title: 'Fecha de bautizo' },
                { title: 'Tiempo siendo miembro' },
                { title: 'Privilegios donde se desempeño' },
                { title: 'Demominacion a la pertenece' },
                { title: 'Interes de estudio' },
            ]" :items="EcclesiasticalInfo">
            </DataTable>
        </section>
        <section class="p-3">
            <DataTable title="Informacion Ministerial" :headers="[
                { title: 'Id' },
                { title: 'Nombre' },
                { title: 'Apellido' },
                { title: 'Miniserios desempeñados' },
                { title: 'Ministerio actual' },
                { title: 'Tiempo completo' },
                { title: 'Calificasion del ministerio actual' },
                { title: 'Ministerio deseado' },
                { title: 'Porque cree asi' },
                { title: 'Ciclo correspondiente' },
                { title: 'Institucion donde estudio' },
                { title: 'Ultimo año estudiado'},
                { title: 'Cualidades' },
            ]" :items="MinisterialInfo">
            </DataTable>
        </section>
    </main>
</template>