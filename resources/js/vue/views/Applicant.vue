<script setup>
    function formatPhone() {
        let phoneNumber = document.getElementById("phone").value
        if (phoneNumber.length === 8) {
            let cleaned = ('' + phoneNumber).replace(/\D/g, '')
            let match = cleaned.match(/^(\d{4})(\d{4})$/)
            if (match) {
                document.querySelector('#phone').value = match[1] + '-' + match[2]
            }
            else {
                document.querySelector('#phone').value = ""
            }
        }
        if (phoneNumber.length > 9) {
            document.querySelector('#phone').value = phoneNumber.slice(0, -1)
        }
    }
</script>

<template>
    <div class="container-fluid d-block">
        <div class="m-auto">
            <h2 class="text-center m-4 form-title">Formulario de inscripción</h2>
            <h4 class="text-center m-3">Ingresa tus datos a continación, revisa muy bien la información antes de enviarla.</h4>
        </div>
        <div class="m-5 rounded form-container">
            <form class="d-block p-5" action="">
                <section class="w-100 text-black">
                    <h3 class="fw-bold text-center mb-5 section-title">Datos Personales</h3>
                    <div class="questions-container">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="name" placeholder="Juan José" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="lastname" placeholder="Perez López" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" placeholder="juanperez@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone" placeholder="6458-5955" @input="formatPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección donde reside</label>
                            <input type="text" class="form-control" id="address" placeholder="Barrio el centro, Chalatenango, Chalatenango, El Salvador" required>
                        </div>
                        <div class="mb-3">
                            <label for="nationality" class="form-label">Nacionalidad</label>
                            <input type="text" class="form-control" id="nationality" placeholder="Salvadoreñe" required>
                        </div>
                        <div class="mb-3">
                            <label for="birthDate" class="form-label">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="birthDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado civil</label>
                            <select class="form-select">
                                <option selected>-- --</option>
                                <option value="1">Soltere</option>
                                <option value="2">Casade</option>
                                <option value="3">Divorciade</option>
                                <option value="4">Viude</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mateName" class="form-label">Nombre del cónyuge</label>
                            <input type="text" class="form-control" id="mateName" placeholder="Juan Perez" required>
                        </div>
                        <div class="mb-3">
                            <label for="secularDegree" class="form-label">Último grado secular estudiado</label>
                            <input type="text" class="form-control" id="secularDegree" placeholder="Bachillerato stop" required>
                        </div>
                        <div class="mb-3">
                            <label for="currentOcupation" class="form-label">Ocupación actual</label>
                            <input type="text" class="form-control" id="currentOcupation" placeholder="Corralero" required>
                        </div>
                    </div>
                </section>
                <br/>
                <section class="w-100 text-black">
                     <h3 class="fw-bold text-center mb-5 section-title">Datos Eclesiásticos</h3>
                        <div class="questions-container">
                         <div class="mb-3">
                            <label class="form-label">¿Es pastor o miembro?</label>
                            <select class="form-select">
                                <option selected>-- --</option>
                                <option value="1">Pastor</option>
                                <option value="2">Miembro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="churchName" class="form-label">¿De qué iglesia?</label>
                            <input type="text" class="form-control" id="churchName" placeholder="Nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="churchAddress" class="form-label">Dirección de la iglesia</label>
                            <input type="text" class="form-control" id="churchAddress" placeholder=" municipio, departamento" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone" placeholder="6458-5955" @input="formatPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="district" class="form-label">Distrito</label>
                            <input type="text" class="form-control" id="district" placeholder="Distrito" required>
                        </div>
                        <div class="mb-3">
                            <label for="MemOrPas" class="form-label">Si es miembro escriba el nombre de su pastor</label>
                            <input type="text" class="form-control" id="MemOrPas" placeholder="Nombre" required>
                        </div>
                        <div class="d-flex">
                            <div>
                                <label for="licence" class="form-label">Licencia</label>
                                <input type="text" class="form-control" id="licence" placeholder="licencia" required>
                            </div>
                            <div>
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="phone" placeholder="6458-5955" @input="formatPhone" required>
                            </div>
                        </div>
                        <br/>
                            <div class="mb-3">
                                <label for="nationality" class="form-label">Anote el nombre y teléfono de dos pastores de Las Asambleas de Dios que puedan dar referencias suyas</label>
                            </div>
                            <div class="d-flex">
                                <div>
                                    <label for="pastor1" class="form-label">Nombre del Pastor</label>
                                    <input type="text" class="form-control" id="pastor1" placeholder="Nombre" required>
                                </div>
                                <div>
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="phone" placeholder="6458-5955" @input="formatPhone" required>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="mb-3">
                                    <label for="pastor2" class="form-label">Nombre del Pastor</label>
                                    <input type="text" class="form-control" id="pastor2" placeholder="Nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="phone" placeholder="6458-5955" @input="formatPhone" required>
                                </div>
                            </div>
                            <br/>
                            <div class="mb-3">
                                <label for="lgsus" class="form-label">¿Cuando acepto a Jesucristo?</label>
                                <input type="text" class="form-control" id="lgsus" placeholder="Aproximado" required>
                            </div>
                        <div class="mb-3">
                            <label for="christeningDate" class="form-label">¿Cuando se bautizó?</label>
                            <input type="date" class="form-control" id="christeningDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="timeBeingMember" class="form-label">¿Cuanto tiempo tiene de ser miembro de su iglesia?</label>
                            <input type="text" class="form-control" id="timeBeingMember" placeholder="Aproximado" required>
                        </div>
                        <div class="mb-3">
                            <label for="privilegesHeld" class="form-label">¿Cuales son los privilegios en que se ha desempeñado?</label>
                            <input type="text" class="form-control" id="privilegesHeld" placeholder="Aproximado" required>
                        </div>
                        <div class="mb-3">
                            <label for="denomination" class="form-label">¿A qué denominación pertenece?</label>
                            <input type="text" class="form-control" id="denomination" placeholder="Aproximado" required>
                        </div>
                        <div class="mb-3">
                            <label for="studyReason" class="form-label">¿Cuál es el interés de estudiar en el Instituto Bíblico Betel Anexo? </label>
                            <input type="text" class="form-control" id="studyReason" placeholder="Aproximado" required>
                        </div>
                      </div>
                </section>
                  <br/>
                <section class="w-100 text-black">
                      
                    <h3 class="fw-bold text-center mb-5 section-title">Datos Ministeriales</h3>
                        <div class="questions-container">
                         <div class="mb-3">
                           <label for="privilegesHeld" class="form-label">¿En qué ministerio se ha desempeñado?</label>
                            <input type="text" class="form-control" id="privilegesHeld" placeholder="ministerial" required>
                            </div>
                                <div class="mb-3">
                            <label class="form-label">Está a tiempo completo:</label>
                            <select class="form-select">
                                <option selected>-- --</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="privilegesHeld" class="form-label">¿Porque?</label>
                            <input type="text" class="form-control" id="privilegesHeld" placeholder="porque tengo tiempo" required>
                        </div>
                        <div class="mb-3">
                            <label for="denomination" class="form-label">¿A qué ministerio cree que Dios lo está llamando?</label>
                            <input type="text" class="form-control" id="denomination" placeholder="nose" required>
                        </div>
                        <div class="mb-3">
                            <label for="studyReason" class="form-label">¿En qué Institución estudio el ciclo o los ciclos anteriores? </label>
                            <input type="text" class="form-control" id="studyReason" placeholder="ya se me olvido" required>
                        </div>
                         <div class="mb-3">
                            <label for="studyReason" class="form-label">¿En qué año estudió la última vez? </label>
                            <input type="text" class="form-control" id="studyReason" placeholder="2018" required>
                        </div>
                         <div class="mb-3">
                            <label for="studyReason" class="form-label">¿Qué ministerio desempeña aparte de su iglesia? </label>
                            <input type="text" class="form-control" id="studyReason" placeholder="cristiano" required>
                        </div>
                         <div class="mb-3">
                            <label for="studyReason" class="form-label">Escriba las cualidades de un obrero cristiano: </label>
                            <input type="text" class="form-control" id="studyReason" placeholder="respetuso" required>
                        </div>
                        </div>
                </section>
                 <button type="submit" class="btn btn-primary" @click.prevent>Enviar solicitud</button>
            </form>
        </div>
    </div>
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