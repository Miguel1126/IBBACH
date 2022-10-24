<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pdf.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Datos del usuario</title>
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
        <h2 class="font text-center">Datos de inicio de sesión del usuario</h2>
        <br>
        <br>
        <p class="font">Nombre: {{ $data["name"] }}</p>
        <p class="font">Código: {{ $data["code"] }}</p>
        <p class="font">Contraseña: {{ $data["password"] }}</p>
        <br>
        <br>
        <h6 class="font fs-5">*En caso de perder esta hoja y olvidarte de tus datos contacta inmediatamente a la institución.</h6>
    </div>
</body>
</html>