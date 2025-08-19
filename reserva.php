<?php

// --- 1. CONEXIÓN A LA BASE DE DATOS ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registro_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// --- 2. VERIFICAR QUE LOS DATOS LLEGUEN POR POST ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 3. RECIBIR Y LIMPIAR DATOS DEL FORMULARIO ---
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $service = isset($_POST['service']) ? $_POST['service'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';

    // --- 4. VALIDACIONES BÁSICAS ---
    if (empty($name) || empty($phone) || empty($service) || empty($date) || empty($time)) {
        echo "Error: Todos los campos son obligatorios.";
        echo "<br><a href='index.html'>Volver al formulario</a>";
        exit();
    }

    // --- 5. CONVERTIR CÓDIGOS DE SERVICIOS A NOMBRES LEGIBLES ---
    $servicios = [
        'consulta-general' => 'Consulta General',
        'limpieza-dental' => 'Limpieza Dental',
        'terapia-fisica' => 'Terapia Física',
        'asesoria-legal' => 'Asesoría Legal'
    ];

    $servicio_nombre = isset($servicios[$service]) ? $servicios[$service] : $service;

    // --- 6. FORMATEAR FECHA Y HORA PARA MOSTRAR ---
    $fecha_formateada = date('d/m/Y', strtotime($date));
    $hora_formateada = date('H:i', strtotime($time));

    // --- 7. INSERTAR DATOS EN LA BASE DE DATOS ---
    $sql = "INSERT INTO reserva (nombre, telefono, servicio, fecha, hora) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $phone, $servicio_nombre, $date, $time);

    // --- 8. EJECUTAR LA CONSULTA Y MOSTRAR RESULTADO ---
    if ($stmt->execute()) {
        echo "<h2>✅ ¡Reserva Confirmada!</h2>";
        echo "<p><strong>Nombre:</strong> " . $name . "</p>";
        echo "<p><strong>Teléfono:</strong> " . $phone . "</p>";
        echo "<p><strong>Servicio:</strong> " . $servicio_nombre . "</p>";
        echo "<p><strong>Fecha:</strong> " . $fecha_formateada . "</p>";
        echo "<p><strong>Hora:</strong> " . $hora_formateada . "</p>";
        echo "<br><p>Nos pondremos en contacto contigo para confirmar tu cita.</p>";
        echo "<br><a href='index.html'>← Hacer otra reserva</a>";
    } else {
        echo "Error al procesar la reserva: " . $conn->error;
        echo "<br><a href='index.html'>Volver al formulario</a>";
    }

    $stmt->close();
} else {
    // --- 9. ACCESO DIRECTO SIN FORMULARIO ---
    echo "<h2>Acceso no válido</h2>";
    echo "<p>Por favor, completa el formulario de reserva.</p>";
    echo "<a href='index.html'>Ir al formulario</a>";
}

// --- 10. CERRAR CONEXIÓN ---
$conn->close();
?>