<script setup>
import { useUserStore } from "../../stores/user";
import { onUpdated, ref } from "vue";
import { handleErrors } from "../../js/handle_error";
import axios from "axios";
const userStore = useUserStore();

document.title = "IBBACH | Portal del Estudiante";

const siteUrl = window.location.origin;

let applicantInfo = ref({})

const getApplicantInfo = async () => {
    try {
        const response = await axios.get('/api/get-student-info/' + userStore.user.applicant_id)
        applicantInfo.value = response.data[0]
    }
    catch (error) {
        handleErrors(error)
    }
}

const tabs = [
    "personal-information",
    "ecclesiastical-information",
    "minsterial-information",
];
let tab = ref("personal-information");
let defaultClass = ref("btn text-light m-1 mb-0");
let tabStyle1 = ref("btn text-light m-1 mb-0 focused");
let tabStyle2 = ref("btn text-light m-1 mb-0");
let tabStyle3 = ref("btn text-light m-1 mb-0");

const toggleComponents = (tabSel) => {
    switch (tabSel) {
        case 1:
            tab.value = tabs.at(0);
            tabStyle1.value += " focused";
            tabStyle2.value = defaultClass.value;
            tabStyle3.value = defaultClass.value;
            break;
        case 2:
            tab.value = tabs.at(1);
            tabStyle1.value = defaultClass.value;
            tabStyle2.value += " focused";
            tabStyle3.value = defaultClass.value;
            break;
        case 3:
            tab.value = tabs.at(2);
            tabStyle1.value = defaultClass.value;
            tabStyle2.value = defaultClass.value;
            tabStyle3.value += " focused";
            break;
        default:
            break;
    }

};
getApplicantInfo()
onUpdated(() => {
    if (!applicantInfo.value.name) {
        getApplicantInfo()
    }
})
</script>

<template>
    <main>
        <div class="d-flex justify-content-center w-100">
            <section class="user-data-card shadow">
                <div class="user-data-container">
                    <div class="profile-picture">
                        <img v-if="userStore.user.img" class="img-fluid shadow"
                            :src="`${siteUrl}/images/users/${userStore.user.img}`" />
                        <img v-else class="img-fluid shadow" :src="`${siteUrl}/images/users/no-image.svg`" />
                    </div>
                    <div class="user-data">
                        <p>
                            <b>Estudiante: </b>{{ userStore.user.name }}
                            {{ userStore.user.last_name }}
                        </p>
                        <p><b>Código: </b>{{ userStore.user.code }}</p>
                        <p><b>Modalidad: </b>{{ userStore.user.group }}</p>
                    </div>
                </div>
            </section>
        </div>
        <div class="m-3 p-3 mb-0 pb-0">
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <router-link class="link-to" to="/alumno/notas">
                        <div class="widget">
                            <div class="icon">
                                <i class="material-icons">list_alt</i>
                            </div>
                            <div class="content">
                                <h4>Consulta de Notas</h4>
                            </div>
                        </div>
                    </router-link>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <router-link class="link-to" to="/alumno/inscripciones">
                        <div class="widget bg-pink hover-zoom-effect">
                            <div class="icon">
                                <i class="material-icons">bookmark_add</i>
                            </div>
                            <div class="content">
                                <h4>Inscripción de Ciclo</h4>
                            </div>
                        </div>
                    </router-link>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <router-link class="link-to" to="/alumno/horarios">
                        <div class="widget">
                            <div class="icon">
                                <i class="material-icons">today</i>
                            </div>
                            <div class="content">
                                <h4>Consulta de Horarios</h4>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="">
            <div class="d-block">
                <div class="d-flex tabs">
                    <div :class="tabStyle1" @click="toggleComponents(1)">
                        Información Personal
                    </div>
                    <div :class="tabStyle2" @click="toggleComponents(2)">
                        Información Eclesiástica
                    </div>
                    <div :class="tabStyle3" @click="toggleComponents(3)">
                        Información Ministerial
                    </div>
                </div>
                <div class="w-100 h-100 rounded component-container p-4">
                    <div v-if="tab === tabs.at(0)">
                        <div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Nombre: </b>{{ applicantInfo.name }} {{ applicantInfo.last_name }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Telefono: </b>{{ applicantInfo.phone }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Correo Electrónico: </b>{{ applicantInfo.email }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Dirección: </b>{{ applicantInfo.address }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Fecha de nacimiento: </b>{{ applicantInfo.birth_date }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Nacionalidad: </b>{{ applicantInfo.nationality }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Estado civíl: </b>{{ applicantInfo.marital_status }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row" v-if="applicantInfo.mate_name">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Nombre del conyuge: </b>{{ applicantInfo.mate_name }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Grado secular: </b>{{ applicantInfo.secular_degree }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Ocupación actual: </b>{{ applicantInfo.current_ocupation }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="tab === tabs.at(1)">
                        <div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Es pastor: </b>{{ applicantInfo.is_pastor ? 'Si' : 'No' }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Es miembro: </b>{{ applicantInfo.is_member ? 'Si' : 'No' }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row" v-if="applicantInfo.is_member">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Nombre del pastor: </b>{{ applicantInfo.pastor_name }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row" v-if="applicantInfo.is_member">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Teléfono del pastor: </b>{{ applicantInfo.pastor_phone }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row" v-if="applicantInfo.is_member">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Licencia del pastor: </b>{{ applicantInfo.licence }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Iglesia a la que pertenece: </b>{{ applicantInfo.church_name }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Dirección de la iglesia: </b>{{ applicantInfo.church_address }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Teléfono de la iglesia: </b>{{ applicantInfo.church_phone }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Distrito: </b>{{ applicantInfo.district }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Pastor de referencia 1: </b>{{ applicantInfo.reference_name_one }}</label>
                                    <label class="ms-2"><b>Teléfono: </b>{{ applicantInfo.reference_phone_one }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Pastor de referencia 2: </b>{{ applicantInfo.reference_name_two }}</label>
                                    <label class="ms-2"><b>Teléfono: </b>{{ applicantInfo.reference_phone_two }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Cuando aceptó a cristo: </b>{{ applicantInfo.christ_accepted }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Fecha de bautismo: </b>{{ applicantInfo.christening_date }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Es miembro desde: </b>{{ applicantInfo.time_being_member }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Privilegios desempeñados: </b>{{ applicantInfo.privileges_held }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Denominación: </b>{{ applicantInfo.denomination }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Razón de estudio: </b>{{ applicantInfo.study_reason }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="tab === tabs.at(2)">
                        <div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Ministerio desempeñado: </b>{{ applicantInfo.ministry_performed }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Ministerio actual: </b>{{ applicantInfo.current_ministry }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Está a tiempo completo: </b>{{ applicantInfo.full_time ? 'Si' : 'No'
                                    }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Calificación del ministerio: </b>{{ applicantInfo.ministry_qualification
                                    }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Ministerio al que aspira: </b>{{ applicantInfo.aspirated_ministry }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Razón para aspirar: </b>{{ applicantInfo.reason_aspiring_ministry }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Ciclo que va a tomar: </b>{{ applicantInfo.cicle_to_be_taken }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Institución en la que estudió: </b>{{ applicantInfo.previous_institution
                                    }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Ultimo año en que estudió: </b>{{ applicantInfo.last_year_studied }}</label>
                                </div>
                            </div>
                            <div class="formgrid grid row">
                                <div class="field col-6 w-100 mb-2">
                                    <label><b>Cualidades de un obrero cristiano: </b>{{
                                    applicantInfo.qualities_religious_worker
                                    }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<style scoped>
.user-data-card {
    max-width: 40rem;
    padding: 2rem;
    background: var(--dark);
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border: 4px solid var(--grey);
}

.user-data-container {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 2rem;
}

.profile-picture img {
    border-radius: 50%;
    width: 200px;
    height: 200px;
}

.user-data {
    font-size: 1.2em;
}

.link-to {
    text-decoration: none;
    color: #fff;
}

.widget {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    height: 80px;
    display: flex;
    cursor: pointer;
    background: var(--dark);
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
    border-radius: 5px;
    border: 2px solid var(--grey);
}

.widget .icon {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.12);
    width: 80px;
    border-right: 2px solid var(--grey);
}

.material-icons {
    font-size: 30px;
}

.widget .content {
    display: inline-flex;
    align-items: center;
    padding: 7px 10px;
}

.tabs div {
    background-color: var(--dark);
}

.focused {
    background-color: var(--dark-alt) !important;
}

.component-container {
    background-color: var(--dark-alt);
}

@media (max-width: 1025px) {
    .component-container {
        padding: 3px !important;
    }
}
</style>
