<script>
export default {
    data() {
        return {
            personalInformation: {
                name: '',
                last_name: '',
                email: '',
                phone: null,
                address: '',
                nationality: '',
                birth_date: '',
                marital_status: '',
                mate_name: '',
                secular_degree: '',
                current_ocupation: ''
            }
        }
    },
    methods: {
        passData() {
            this.personalInformation.phone = document.querySelector('#phone1').value.replace('-', '')
            this.$emit('personalInfo', this.personalInformation)
        },
        formatPhone(id) {
            let phoneNumber = document.getElementById(id).value
            if (phoneNumber.length === 8) {
                let cleaned = ('' + phoneNumber).replace(/\D/g, '')
                let match = cleaned.match(/^(\d{4})(\d{4})$/)
                if (match) {
                    document.querySelector(`#${id}`).value = match[1] + '-' + match[2]
                }
                else {
                    document.querySelector(`#${id}`).value = ""
                }
            }
            if (phoneNumber.length > 9) {
                document.querySelector(`#${id}`).value = phoneNumber.slice(0, -1)
            }
        }
    },
    expose: ['passData']
}
</script>

<template>
    <section class="w-100 text-black">
        <h3 class="fw-bold text-center mb-5 section-title">Datos Personales</h3>
        <div class="questions-container">
            <div class="mb-3">
                <label for="name" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="name" placeholder="Juan José" v-model="personalInformation.name" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="lastname" placeholder="Perez López" v-model="personalInformation.last_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="juanperez@gmail.com" v-model="personalInformation.email" required>
            </div>
            <div class="mb-3">
                <label for="phone1" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone1" placeholder="6458-5955" @input="formatPhone('phone1')" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Dirección donde reside</label>
                <input type="text" class="form-control" id="address"
                    placeholder="Barrio el centro, Chalatenango, Chalatenango, El Salvador" v-model="personalInformation.address" required>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nacionalidad</label>
                <input type="text" class="form-control" id="nationality" placeholder="Salvadoreñe" v-model="personalInformation.nationality" required>
            </div>
            <div class="mb-3">
                <label for="birthDate" class="form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="birthDate" v-model="personalInformation.birth_date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Estado civil</label>
                <select class="form-select" v-model="personalInformation.marital_status">
                    <option selected>-- --</option>
                    <option value="Soltero/a">Soltere</option>
                    <option value="Casado/a">Casade</option>
                    <option value="Divorsiado/a">Divorciade</option>
                    <option value="Viudo/a">Viude</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="mateName" class="form-label">Nombre del cónyuge</label>
                <input type="text" class="form-control" id="mateName" placeholder="Juan Perez" v-model="personalInformation.mate_name" required>
            </div>
            <div class="mb-3">
                <label for="secularDegree" class="form-label">Último grado secular estudiado</label>
                <input type="text" class="form-control" id="secularDegree" placeholder="Bachillerato stop" v-model="personalInformation.secular_degree" required>
            </div>
            <div class="mb-3">
                <label for="currentOcupation" class="form-label">Ocupación actual</label>
                <input type="text" class="form-control" id="currentOcupation" placeholder="Corralero" v-model="personalInformation.current_ocupation" required>
            </div>
        </div>
    </section>
</template>
<style scoped>
.form-title {
    text-shadow: 2px 2px 3px rgb(0, 0, 0);
}

.form-container {
    background: var(--bs-gray-400);
    border: 6px solid #ccc;
}

.section-title {
    text-decoration: underline;
}

.questions-container {
    display: grid;
    justify-content: left;
}
</style>