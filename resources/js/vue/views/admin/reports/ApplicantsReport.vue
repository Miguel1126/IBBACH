<script>
export default {
    mounted() {
        this.getApplicant();
    },
    data() {
        return {
            applicants: [],
            applicantSelected: []
        }
    },
    methods: {
        async getApplicant() {
            try {
                const response = await this.axios.get('/api/getAplicantes')
                if (response.status === 200) {
                    if (typeof (response.data) === 'object') {
                        this.applicants = response.data
                        console.log(response)
                    }
                    else {
                        this.applicants[0] = 'error'
                        console.log(response)
                    }
                }
            }
            catch {
                (error) => console.error(error)
            }
        },
        selectApplicant(event, applicants) {
            this.applicantSelected = [];
            this.applicantSelected.push(applicants);
        }
    }
}
</script>

<template>
    <main>
        <hr class="separator" />
        <section class="p-3 mb-4">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Informacion personal </h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Nacionalidad</th>
                            <th scope="col">Fecha de nacimiento</th>
                            <th scope="col">Estado civil</th>
                            <th scope="col">Nombre del conyuge</th>
                            <th scope="col">Grado secular</th>
                            <th scope="col">Ocupacion actual</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="applicant in applicants" :key="applicant.id">
                            <th scope="row">{{ applicant.id }}</th>
                            <td>{{ applicant.name }}</td>
                            <td>{{ applicant.last_name }}</td>
                            <td>{{ applicant.email }}</td>
                            <td>{{ applicant.phone }}</td>
                            <td>{{ applicant.address }}</td>
                            <td>{{ applicant.nationality }}</td>
                            <td>{{ applicant.birth_date }}</td>
                            <td>{{ applicant.marital_status }}</td>
                            <td>{{ applicant.mate_name }}</td>
                            <td>{{ applicant.secular_degree }}</td>
                            <td>{{ applicant.current_ocupation }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="p-3 mb-4">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Informacion eclesiastica </h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Aplicante</th>
                            <th scope="col">Es pastor</th>
                            <th scope="col">Es miembro</th>
                            <th scope="col">Telefono </th>
                            <th scope="col">Nombre de la iglesia</th>
                            <th scope="col">Direccion de la iglesia</th>
                            <th scope="col">Telefono de la iglesia</th>
                            <th scope="col">Distrito</th>
                            <th scope="col">Pastor de la iglesia</th>
                            <th scope="col">Licencia </th>
                            <th scope="col">Pator de referencia</th>
                            <th scope="col">Telefono </th>
                            <th scope="col">Pator de referencia</th>
                            <th scope="col">Telefono </th>
                            <th scope="col">Cuando acepto a cristo</th>
                            <th scope="col">Fecha de bautizo</th>
                            <th scope="col">Tiempo siendo miembro</th>
                            <th scope="col">Privilegios donde se desempeño</th>
                            <th scope="col">Denominacion a la que pertenece</th>
                            <th scope="col">Interes de estudio</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="applicant in applicants" :key="applicant.id">
                            <th scope="row">{{ applicant.id }}</th>
                            <td>{{ applicant.name }} {{ applicant.last_name }}</td>
                            <td>{{ applicant.is_pastor }}</td>
                            <td>{{ applicant.is_member }}</td>
                            <td>{{ applicant.pastor_phone }}</td>
                            <td>{{ applicant.church_name }}</td>
                            <td>{{ applicant.church_address }}</td>
                            <td>{{ applicant.church_phone }}</td>
                            <td>{{ applicant.district }}</td>
                            <td>{{ applicant.pastor_name }}</td>
                            <td>{{ applicant.licence }}</td>
                            <td>{{ applicant.reference_name_one }}</td>
                            <td>{{ applicant.reference_phone_one }}</td>
                            <td>{{ applicant.reference_name_two }}</td>
                            <td>{{ applicant.reference_phone_two }}</td>
                            <td>{{ applicant.christ_accepted }}</td>
                            <td>{{ applicant.christening_date }}</td>
                            <td>{{ applicant.time_being_member }}</td>
                            <td>{{ applicant.privileges_held }}</td>
                            <td>{{ applicant.denomination }}</td>
                            <td>{{ applicant.study_reason }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="p-3 mb-4">
            <div class="table-container p-3 mb-5 table-color rounded">
                <h3 class="h3 fw-semibold mb-3 text-black">Informacion ministerial </h3>
                <table class="table table-bordered border-dark">
                    <thead class="table-info table-bordered border-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Aplicante</th>
                            <th scope="col">Ministerios desmpeñados</th>
                            <th scope="col">Ministerio actual</th>
                            <th scope="col">Tiempo completo</th>
                            <th scope="col">Calificacion del ministerio actual</th>
                            <th scope="col">Ministerio deseado</th>
                            <th scope="col">Porque cree asi</th>
                            <th scope="col">Ciclo correspondiente</th>
                            <th scope="col">Institucion donde estudio</th>
                            <th scope="col">Ultimo año estudiado </th>
                            <th scope="col">Cualidades</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr v-for="applicant in applicants" :key="applicant.id">
                            <th scope="row">{{ applicant.id }}</th>
                            <td>{{ applicant.name }} {{ applicant.last_name }}</td>
                            <td>{{ applicant.ministry_performed }}</td>
                            <td>{{ applicant.current_ministry }}</td>
                            <td>{{ applicant.full_time }}</td>
                            <td>{{ applicant.ministry_qualification }}</td>
                            <td>{{ applicant.aspirated_ministry }}</td>
                            <td>{{ applicant.reason_aspiring_ministry }}</td>
                            <td>{{ applicant.cicle_to_be_taken }}</td>
                            <td>{{ applicant.previous_institution }}</td>
                            <td>{{ applicant.last_year_studied }}</td>
                            <td>{{ applicant.qualities_religious_worker }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</template>