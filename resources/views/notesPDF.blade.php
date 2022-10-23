<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pdf.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Reporte de notas</title>
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
        <span class="font">Reporte de Notas</span>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Ciclo</th>
                        <th class="text-center" scope="col">Asignatura</th>
                        <th class="text-center" scope="col">Nombre</th>
                        <th class="text-center" scope="col">Ev1</th>
                        <th class="text-center" scope="col">Ev2</th>
                        <th class="text-center" scope="col">Ev3</th>
                        <th class="text-center" scope="col">Ev4</th>
                        <th class="text-center" scope="col">Ev5</th>
                        <th class="text-center" scope="col">Resultado Final</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        <td class="text-center"><?= $note->cycle ?></td>
                        <td class="text-center"><?= $note->subject ?></td>
                        <td class="text-center"><?= $note->name .' '. $note->last_name ?></td>
                        <td class="text-center"><?= $note->ev1 ?></td>
                        <td class="text-center"><?= $note->ev2 ?></td>
                        <td class="text-center"><?= $note->ev3 ?></td>
                        <td class="text-center"><?= $note->ev4 ?></td>
                        <td class="text-center"><?= $note->ev5 ?></td>
                        <td class="text-center"><?= $note->finalAverage?></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>