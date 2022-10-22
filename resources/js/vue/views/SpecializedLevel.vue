<script>
import DataTable from '../components/DataTable.vue';

export default {
    mounted() {
        this.MinisterioPas();
        this.Misiones();
        this.EducacionCris();
        this.MinisterioJ();
        this.PlantacionIg();
        this.MinisterioU();
        this.MinisterioI();

    },
    data() {
        return {
            ministerioPas: [],
            misiones: [],
            educacion: [],
            ministerio: [],
            plantacion: [],
            ministeriou: [],
            ministerioi: [],
            siteUrl: window.location.origin,
        }
    },
    methods: {
        async MinisterioPas() {
            try {
                const response = await this.axios.get('/api/MinisterioPas');
                if (response.status === 200) {
                    this.ministerioPas = response.data;
                }
                else {
                    this.ministerioPas[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.ministerioPas[0] = "error";
            }
        },
        async Misiones() {
            try {
                const response = await this.axios.get('/api/Misiones');
                if (response.status === 200) {
                    this.misiones = response.data;
                }
                else {
                    this.misiones[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.misiones[0] = "error";
            }
        },
        async EducacionCris() {
            try {
                const response = await this.axios.get('/api/EducacionCris');
                if (response.status === 200) {
                    this.educacion = response.data;
                }
                else {
                    this.educacion[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.educacion[0] = "error";
            }
        },
        async MinisterioJ() {
            try {
                const response = await this.axios.get('/api/MinisterioJ');
                if (response.status === 200) {
                    this.ministerio = response.data;
                }
                else {
                    this.ministerio[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.ministerio[0] = "error";
            }
        },
        async PlantacionIg() {
            try {
                const response = await this.axios.get('/api/PlantacionIg');
                if (response.status === 200) {
                    this.plantacion = response.data;
                }
                else {
                    this.plantacion[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.plantacion[0] = "error";
            }
        },
        async MinisterioU() {
            try {
                const response = await this.axios.get('/api/MinisterioU');
                if (response.status === 200) {
                    this.ministeriou = response.data;
                }
                else {
                    this.ministeriou[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.ministeriou[0] = "error";
            }
        },
        async MinisterioI() {
            try {
                const response = await this.axios.get('/api/MinisterioI');
                if (response.status === 200) {
                    this.ministerioi = response.data;
                }
                else {
                    this.ministerioi[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.ministerioi[0] = "error";
            }
        },
    },
    components: { DataTable }
}

</script>
<template>
 
        <DataTable title="Ministerio pastoral" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="ministerioPas">
        </DataTable>
        <br>
        <DataTable title="Misiones" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="misiones">
        </DataTable>
        <br>
        <DataTable title="Educacion cristiana" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="educacion">
        </DataTable>
        <br>
        <DataTable title="Ministerio juvenil" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="ministerio">
        </DataTable>
        <br>
        <DataTable title="Plantacion de iglesias" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="plantacion">
        </DataTable>
        <br>
        <DataTable title="Ministerio universitario" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="ministeriou">
        </DataTable>
        <br>
        <DataTable title="Ministerio infantil" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="ministerioi">
        </DataTable>

    <footer class=" section footer-classic context-dark bg-image" style=" background: #272525;">
		<div class="container-fluid">
			<div class="row row-30">
				<div class="col-md-4 col-xl-5">
					<div class="pr-xl-4"><a class="brand" href="http://127.0.0.1:8000/"><img
								class=" d-block img-fluid rounded mt-3" style="width: 20%; height: 20%"
								:src="`${siteUrl}/images/logo.jpg`" /></a>
						<br>
						<h6> El Instituto Bíblico Betel Anexo Chalatenango, inició operaciones en 1996 y se dedica a la
							formación de ministros para las diferentes áreas que el ministerio cristiano exige,
							pastores, evangelistas y misioneros. Una institución para formar a hombres y mujeres para la
							obra del ministerio</h6>
					</div>
				</div>
				<div class="col-md-4">
					<dl class="contact-list d-block">
						<div class="d-inline-flex gap-1 align-items-center">
							<h5>Contactos</h5>
						</div>
					</dl>
					<dl class="contact-list d-block">
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<h6>Direccion: </h6>
								<p>
									<a target="_blank" href="https://goo.gl/maps/UhWRrTBXpxHZsVha7">Potrero Grande a
										Iglesia Filipos de las
										Asambleas de Dios por Carr. longitudinal del Nte./CA-3</a>
								</p>
							</div>
						</div>
						<br>
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<h6>Correo Electronico: </h6>
								<p>ibbachal@yahoo.com</p>
							</div>
						</div>
						<br>
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<h6>Telefono: </h6>
								<p>2309 2234</p>
							</div>
						</div>
					</dl>
				</div>
				<div class="col-md-4 col-xl-3">
					<h5>Redes sociales</h5>
					<ul class="navbar-nav">
						<div class="d-inline-flex gap-1 align-items-center">
							<div>
								<p>
									<a target="_blank" href="https://www.facebook.com/ibbachad">
										<i class="text-primary fa-brands fa-square-facebook"
											style="font-size: 50px"></i></a>
								</p>
							</div>
						</div>
						<p>
							<a target="_blank" href="https://wa.me/+50369840681">
								<i class="text-success fa-brands fa-square-whatsapp" style="font-size: 50px"></i></a>
						<h6>6984-0681</h6>
						<a target="_blank" href="https://wa.me/+50370527126">
							<i class="text-success fa-brands fa-square-whatsapp" style="font-size: 50px"></i></a>
						<h6>7052-7126</h6>
						</p>
					</ul>
				</div>
			</div>
			<p class="rights text-center"><span>©  </span><span
					class="copyright-year">2022</span><span> </span><span>IBBACH</span><span>. </span><span></span>
			</p>
		</div>
	</footer>
</template>
