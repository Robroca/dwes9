<?php

/**
 * Obtiene las coordenadas geograficas de una ciudad usando la API de geocodificacion de Open-Meteo.
 *
 * @param string $ciudad Nombre de la ciudad a buscar.
 * @return array|null Array con 'lat', 'lon' y 'nombre', o null si no se encuentra.
 */
function obtenerCoordenadas($ciudad) {
    $url = "https://geocoding-api.open-meteo.com/v1/search?name=" . urlencode($ciudad) . "&count=1&language=es&format=json";
    $respuesta = file_get_contents($url);

    if ($respuesta === false) {
        return null;
    }

    $datos = json_decode($respuesta, true);

    if (empty($datos['results'])) {
        return null;
    }

    $resultado = array();
    $resultado['lat'] = $datos['results'][0]['latitude'];
    $resultado['lon'] = $datos['results'][0]['longitude'];
    $resultado['nombre'] = $datos['results'][0]['name'];
    $resultado['pais'] = $datos['results'][0]['country'];

    return $resultado;
}

/**
 * Obtiene los datos del clima actual para unas coordenadas dadas usando la API Open-Meteo.
 *
 * @param float $lat Latitud de la ubicacion.
 * @param float $lon Longitud de la ubicacion.
 * @return array|null Array con datos del clima, o null si hay error.
 */
function obtenerClima($lat, $lon) {
    $url = "https://api.open-meteo.com/v1/forecast?latitude=" . $lat . "&longitude=" . $lon;
    $url .= "&current=temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code,apparent_temperature";
    $url .= "&timezone=auto&language=es";

    $respuesta = file_get_contents($url);

    if ($respuesta === false) {
        return null;
    }

    $datos = json_decode($respuesta, true);

    if (empty($datos['current'])) {
        return null;
    }

    return $datos['current'];
}

/**
 * Convierte el codigo WMO del clima en una descripcion en texto.
 *
 * @param int $codigo Codigo WMO del estado del tiempo.
 * @return string Descripcion del estado del tiempo.
 */
function describirClima($codigo) {
    $descripciones = array(
        0  => "Despejado",
        1  => "Mayormente despejado",
        2  => "Parcialmente nublado",
        3  => "Nublado",
        45 => "Niebla",
        48 => "Niebla con escarcha",
        51 => "Llovizna ligera",
        53 => "Llovizna moderada",
        55 => "Llovizna intensa",
        61 => "Lluvia ligera",
        63 => "Lluvia moderada",
        65 => "Lluvia intensa",
        71 => "Nevada ligera",
        73 => "Nevada moderada",
        75 => "Nevada intensa",
        80 => "Chubascos ligeros",
        81 => "Chubascos moderados",
        82 => "Chubascos intensos",
        95 => "Tormenta",
        96 => "Tormenta con granizo",
        99 => "Tormenta con granizo intenso"
    );

    if (isset($descripciones[$codigo])) {
        return $descripciones[$codigo];
    }

    return "Desconocido";
}

$ciudad = "";
$error = "";
$coordenadas = null;
$clima = null;

if (isset($_GET['ciudad']) && trim($_GET['ciudad']) !== '') {
    $ciudad = trim($_GET['ciudad']);
    $coordenadas = obtenerCoordenadas($ciudad);

    if ($coordenadas === null) {
        $error = "No se ha encontrado la ciudad: " . htmlspecialchars($ciudad);
    } else {
        $clima = obtenerClima($coordenadas['lat'], $coordenadas['lon']);
        if ($clima === null) {
            $error = "No se han podido obtener los datos del clima.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clima - DWES9</title>
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
            max-width: 700px;
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
        .formulario input[type="text"] {
            width: 65%;
            padding: 10px;
            border: 2px solid #2c7a4b;
            border-radius: 4px;
            font-size: 15px;
        }
        .formulario button {
            padding: 10px 20px;
            background-color: #2c7a4b;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            cursor: pointer;
            margin-left: 8px;
        }
        .formulario button:hover {
            background-color: #1f5c38;
        }
        .error {
            background-color: #ffe0e0;
            color: #cc0000;
            padding: 12px 16px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .clima-resultado {
            margin-top: 20px;
        }
        .clima-ciudad {
            font-size: 22px;
            font-weight: bold;
            color: #1f5c38;
        }
        .clima-temp {
            font-size: 56px;
            font-weight: bold;
            color: #2c7a4b;
            line-height: 1.1;
        }
        .clima-desc {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .clima-detalles {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .clima-dato {
            background-color: #e8f5ee;
            padding: 12px 18px;
            border-radius: 6px;
            text-align: center;
            min-width: 120px;
        }
        .clima-dato .etiqueta {
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
        }
        .clima-dato .valor {
            font-size: 20px;
            font-weight: bold;
            color: #1f5c38;
            margin-top: 4px;
        }
        .info-alumno {
            font-size: 13px;
            color: #666;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .fuente {
            font-size: 12px;
            color: #999;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<header>
    <h1>Servicio del Clima</h1>
</header>

<nav class="menu">
    <a href="index.php">Inicio</a>
    <a href="clima.php" class="activo">Servicio del Clima</a>
</nav>

<div class="contenido">

    <div class="tarjeta">
        <h2>Consultar el Clima</h2>
        <p>Introduce el nombre de una ciudad para ver su clima actual.</p>
        <div class="formulario">
            <form action="clima.php" method="get">
                <input
                    type="text"
                    name="ciudad"
                    placeholder="Ej: Madrid, Barcelona, Paris..."
                    value="<?php echo htmlspecialchars($ciudad); ?>"
                    required
                >
                <button type="submit">Buscar</button>
            </form>
        </div>

        <?php if ($error !== ''): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($clima !== null && $coordenadas !== null): ?>
            <div class="clima-resultado">
                <div class="clima-ciudad">
                    <?php echo htmlspecialchars($coordenadas['nombre']); ?>,
                    <?php echo htmlspecialchars($coordenadas['pais']); ?>
                </div>
                <div class="clima-temp">
                    <?php echo $clima['temperature_2m']; ?> ºC
                </div>
                <div class="clima-desc">
                    <?php echo describirClima($clima['weather_code']); ?>
                </div>
                <div class="clima-detalles">
                    <div class="clima-dato">
                        <div class="etiqueta">Sensacion termica</div>
                        <div class="valor"><?php echo $clima['apparent_temperature']; ?> ºC</div>
                    </div>
                    <div class="clima-dato">
                        <div class="etiqueta">Humedad</div>
                        <div class="valor"><?php echo $clima['relative_humidity_2m']; ?>%</div>
                    </div>
                    <div class="clima-dato">
                        <div class="etiqueta">Viento</div>
                        <div class="valor"><?php echo $clima['wind_speed_10m']; ?> km/h</div>
                    </div>
                </div>
                <div class="fuente">Datos proporcionados por Open-Meteo API (open-meteo.com) - Gratuita y sin clave de acceso.</div>
            </div>
        <?php endif; ?>

        <?php if ($ciudad === '' && $error === ''): ?>
            <p style="color:#888; margin-top:15px;">Introduce una ciudad para ver los resultados.</p>
        <?php endif; ?>
    </div>

    <div class="info-alumno">
        DWES Unidad 9
    </div>

</div>

</body>
</html>
