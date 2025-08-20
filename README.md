README - Sistema de Reservas
¿Qué hace el proyecto?
Un formulario web donde las personas pueden reservar citas para diferentes servicios (médico, dental, terapia, legal).
Archivos principales:

index.html - El formulario que ve el usuario
reserva.php - Procesa los datos y los guarda
reserva.css - Los estilos/colores

Cómo funciona:

Usuario llena el formulario (nombre, teléfono, servicio, fecha, hora)
Al enviar, PHP recibe los datos
Se conecta a la base de datos MySQL
Guarda la reserva
Muestra confirmación al usuario

Base de datos:

Nombre: registro_usuarios
Tabla: reservas
Campos: nombre, teléfono, servicio, fecha, hora

Lo más importante que hice:

Conexión a base de datos
Validación de datos (que no estén vacíos)
Insertar reservas de forma segura
Mostrar confirmación bonita al usuario

Servicios disponibles:

Consulta General
Limpieza Dental
Terapia Física
Asesoría Legal
