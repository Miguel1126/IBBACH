<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pdf.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Reporte de inscripciones</title>
</head>

<body>
    <header class="header">
        <div>
            <div><img class="img2" src="images/logo.jpg" style="width: 120px; height: 130px" ></div>
            <h3 class="title font text-center">INSTITUTO BIBLICO BETEL DE LAS ASAMBLEAS DE DIOS ANEXO CHALATENANGO</h3>
            <div><img class="img1" src="images/asambleas-dios.jpg" style="width: 130px; height: 130px" ></div>
        </div>
    </header>
    <div class="marginbody">
        <span class="font">Reporte de Inscripciones</span>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Fecha</th>
                        <th class="text-center" scope="col">Estado</th>
                        <th class="text-center" scope="col">Ciclo</th>
                        <th class="text-center" scope="col">Modalidad</th>
                        <th class="text-center" scope="col">Alumno</th>
                        <th class="text-center" scope="col">Apellido</th>
                        <th class="text-center" scope="col">Codigo</th>
                        <th class="text-center" scope="col">Asignatura</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscriptions as $inscription)
                    <tr>
                        <td class="text-center"><?= $inscription->created_at ?></td>
                        <td class="text-center"><?= $inscription->status ?></td>
                        <td class="text-center"><?= $inscription->cycle ?></td>
                        <td class="text-center"><?= $inscription->group ?></td>
                        <td class="text-center"><?= $inscription->name ?></td>
                        <td class="text-center"><?= $inscription->last_name ?></td>
                        <td class="text-center"><?= $inscription->code ?></td>
                        <td class="text-center"><?= $inscription->subject ?></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>