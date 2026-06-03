<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DWES9 - API Remota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #2c7a4b;
            color: white;
            padding: 20px 30px;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        header p {
            margin: 5px 0 0;
            font-size: 14px;
            opacity: 0.85;
        }
        .menu {
            background-color: #1f5c38;
            padding: 10px 30px;
            display: flex;
            gap: 15px;
        }
        .menu a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            background-color: rgba(255,255,255,0.15);
        }
        .menu a:hover {
            background-color: rgba(255,255,255,0.3);
        }
        .menu a.activo {
            background-color: white;
            color: #2c7a4b;
            font-weight: bold;
        }
        .contenido {
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
        }
        .tarjeta {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .tarjeta h2 {
            color: #2c7a4b;
            margin-top: 0;
            border-bottom: 2px solid #e0f0e8;
            padding-bottom: 10px;
        }
        .enlace-btn {
            display: inline-block;
            background-color: #2c7a4b;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 15px;
            margin-top: 10px;
        }
        .enlace-btn:hover {
            background-color: #1f5c38;
        }
        .info-alumno {
            font-size: 13px;
            color: #666;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        ul.lista-tareas {
            list-style: none;
            padding: 0;
        }
        ul.lista-tareas li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }
        ul.lista-tareas li:last-child {
            border-bottom: none;
        }
        ul.lista-tareas a {
            color: #2c7a4b;
            text-decoration: none;
            font-weight: bold;
        }
        ul.lista-tareas a:hover {
            text-decoration: underline;
        }
        .badge {
            display: inline-block;
            background-color: #e0f0e8;
            color: #1f5c38;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 8px;
            font-weight: normal;
        }
    </style>
</head>
<body>

<header>
    <h1>DWES9 - API Remota</h1>
</header>

<nav class="menu">
    <a href="index.php" class="activo">Inicio</a>
    <a href="clima.php">Servicio del Clima</a>
</nav>

<div class="contenido">

    <div class="tarjeta">
        <h2>Bienvenido a la Aplicacion</h2>
        <p>
            Esta aplicacion es el resultado de la tarea DWES9. Consume servicios web externos
            mediante <code>file_get_contents()</code> y muestra los datos de forma visual.
        </p>
        <p>
            Utiliza el menu superior para navegar entre las diferentes secciones.
        </p>
    </div>

    <div class="tarjeta">
        <h2>Paginas de la Aplicacion</h2>
        <ul class="lista-tareas">
            <li>
                <a href="clima.php">Servicio del Clima</a>
                <span class="badge">RA9_f</span>
                <br>
                <small>Muestra el clima actual de una ciudad usando la API Open-Meteo (gratuita, sin clave).</small>
            </li>
        </ul>
    </div>

    <div class="tarjeta">
        <h2>Repositorio del Codigo</h2>
        <p>
            El codigo fuente de esta tarea esta publicado en GitHub:
        </p>
        <p>
            <strong>URL del repositorio:</strong><br>
            <a href="https://github.com/robrojas" target="_blank">
                https://github.com/cursoroberto
            </a>
        </p>
        <p style="font-size:13px; color:#666;">
            El repositorio contiene todo el codigo fuente del curso, incluyendo esta tarea en la carpeta <code>dwes/dwes9/</code>.
        </p>
    </div>

    <div class="tarjeta">
        <h2>Pruebas y Documentacion</h2>
        <ul style="line-height: 2;">
            <li>Las funciones estan documentadas con <strong>PHPDoc</strong> (<code>/** */</code>, <code>@param</code>, <code>@return</code>).</li>
            <li>Se ha realizado una prueba de carga con <strong>Apache JMeter</strong> usando Concurrency Thread Group.</li>
            <li>La documentacion generada con <strong>phpDocumentor</strong> se encuentra en el directorio <code>doc/</code>.</li>
        </ul>
    </div>

    <div class="info-alumno">
        DWES Unidad 9
    </div>

</div>

</body>
</html>
