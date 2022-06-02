<script>
    export default {
        data() {
            return {
               name: [
                    { id: 1, name: 'Fredy' },
                    { id: 2, name: 'Fredy' },
                    { id: 3, name: '' }
                ],
                lastname:[
                     { id: 1, lastname: 'Alvarez' },
                    { id: 2, lastname: 'Alvarez' },
                    { id: 3, lastname: '' }
                ],
                email:[
                    {id: 1, email: 'alvarez@gmail.com'},
                    {id: 2, email: 'alvarez@gmail.com'},
                    {id: 3, email: ''}
                ],
                telephone: [
                    {id: 3, telephone: '33434890'},
                    {id: 3, telephone: '12567890'},
                    {id: 3, telephone: ''}
                ],
                teachers:[
                    { id: 1,name: 'Fredy', lastname: 'Alvarez', email: 'alvarez@gmail.com', telephone: '33434890'},
                    { id: 2,name: 'Fredy', lastname: 'Alvarez', email: 'alvarez@gmail.com', telephone: '12567890'},
                    { id: 3, }
                
                ],
                names: null,
                lastnames:null,
                emails: null,
                telephones: null,
                namSelected: [],
                lastSelected:[],
                emaSelected: [],
                telSelected: [],
                
            }
        },
        methods: {
            selectnam(event, teacher) {
                this.teaSelected = []
                this.teaSelected.push(teacher)
            },
            selectlast(event, teacher) {
                this.lastSelected = []
                this.lastSelected.push(teacher)
            },
            selectema(event, teacher){
                this.emaSelected = []
                this.emaSelected.push(teacher)
            },
            selecttel(event, teacher){
                this.telSelected = []
                this.telSlected.push(teacher)
            },
            clearDropdown() {
                const app = this
                app.namSelected = []
                app.lastSelected =[]
                app.emaSelected = []
                app.telSelected = []
            },
            updateTable() {
                const app = this
                this.teachers.push({ id: app.teachers.length + 1,  name: app.names, lastname: app.lastnames, email: app.emails, telephone: app.telephones})
                app.clearDropdown()
            }
        }
       
    }

</script>
<template>
<main>
    <h1 class="h1 fs-1 fw-bold">Registro De Docentes</h1>
    <section class="teacher border border-info p-3 border-5">
    <h3 class="h1 fw-semibold">Editar Registro De Docentes</h3>
    <div class="d-flex">
    <div class="m-4">
        <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
  </div>
  <input v-model="names" placeholder="Escribir nombre" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Apellido</span>
  </div>
  <input v-model="lastnames" placeholder="Escribir apellido" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Correo</span>
  </div>
  <input v-model="emails" placeholder="Escribir correo electronico" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Telefono</span>
  </div>
  <input v-model="telephones" placeholder="Escribir telefono" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
                    <br>
                <button type="button" class="d-inline-flex btn btn-outline-primary" @click="updateTable">Agregar<i class="material-icons m-auto">add_box</i></button>
                <button type="button" class="d-inline-flex btn btn-outline-info ms-4"  @click="updateTable">Editar<i class="material-icons m-auto">drive_file_rename_outline</i></button>
                <button type="button"  class=" d-inline-flex btn btn-outline-danger ms-4" @click="updateTable">Eliminar<i class="material-icons m-auto">delete</i></button>
                <button type="button" class=" d-inline-flex btn btn-outline-success ms-4" @click="updateTable">Guardar<i class="material-icons m-auto">save_as</i></button>

            </div>
            </div>
         </section> 
        <br />
         <section class="teacher border mt-4 border-info p-3 border-5 rounded">
            <h3 class="h3 fw-semibold mb-3">Listado De Docentes</h3>
            <table class="table table-bordered border-body">
                <thead class="table-success table-bordered border-info">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Correo electronico</th>
                        <th scope="col">Telefono</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr v-for="teacher in teachers" :key="teacher.id">
                        <th scope="row">{{ teacher.id }}</th>
                        <td>{{ teacher.name }}</td>
                        <td>{{teacher.lastname}}</td>
                        <td>{{teacher.email}}</td>
                        <td>{{teacher.telephone}}</td>
                    </tr>
                </tbody>
            </table>
        </section>  
        <br> 
         <br>
</main>
</template>
<style scoped>
    .teacher {
        border-radius: 20px !important;
    }
</style>
