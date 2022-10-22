<script>
import DataTable from '../components/DataTable.vue';

export default {
    mounted() {
        this.levelbasic1();
        this.levelbasic2();
        this.levelbasic3();
        this.levelbasic4();
    },
    data() {
        return {
            subjects: [],
            subjects2: [],
            subjects3: [],
            subjects4: [],
            siteUrl: window.location.origin,
        };
    },
    methods: {
        async levelbasic1() {
            try {
                const response = await this.axios.get('/api/level');
                if (response.status === 200) {
                    this.subjects = response.data;
                }
                else {
                    this.subjects[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.subjects[0] = "error";
            }
        },
        async levelbasic2() {
            try {
                const response = await this.axios.get('/api/level2');
                if (response.status === 200) {
                    this.subjects2 = response.data;
                }
                else {
                    this.subjects2[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.subjects2[0] = "error";
            }
        },
        async levelbasic3() {
            try {
                const response = await this.axios.get('/api/level3');
                if (response.status === 200) {
                    this.subjects3 = response.data;
                }
                else {
                    this.subjects3[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.subjects3[0] = "error";
            }
        },
        async levelbasic4() {
            try {
                const response = await this.axios.get('/api/level4');
                if (response.status === 200) {
                    this.subjects4 = response.data;
                }
                else {
                    this.subjects4[0] = "error";
                }
            }
            catch (error) {
                handleErrors(error);
                this.subjects4[0] = "error";
            }
        },
    },
    components: { DataTable }
}
</script>
<template>
  
        <DataTable title="Nivel Basico 1" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="subjects">
        </DataTable>
        <br>
        <DataTable title="Nivel Basico 2" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="subjects2">
        </DataTable>
        <br>
        <DataTable title="Nivel Basico 3" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="subjects3">
        </DataTable>
        <br>
        <DataTable title="Nivel Basico 4" personalized :headers="[
            { title: 'Asignatura', value: 'subject' },
            { title: 'UV', value: 'uv'},
        ]" :items="subjects4">
        </DataTable>
        <footer class="section footer-classic context-dark bg-image" style=" background: #272525;">
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

