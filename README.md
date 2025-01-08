# GALLERY
---

## Descripción del Proyecto
Este proyecto es una página para gestionar cuadros, puedes publicar, añadir y editar cuadros,  
Está compuesto por Laravel 8 

La aplicación tiene la parte de frontend y de backend. Además, de una pequeña api para gestionar los datos.  
Los datos se almacenan en una base de datos SQL para garantizar la persistencia y la consulta eficiente de la información.

---

## Tecnologías Utilizadas
  
- **Framework**: Laravel 8  
- **Base de datos**: SQL (MySQL por defecto, pero compatible con otros motores soportados por Laravel)  
- **Validación y Controladores**: Estándar de Laravel  
- **Migraciones y Seeds**: Gestión de estructura y datos iniciales   
- **Estilos**: CSS y Bootstrap  
 

---

## Funcionalidades

### Backend  
- Registro y modificación de datos.   
- Endpoints RESTful API para consumir desde una API Externa.    

### Frontend  
- Interfaz de usuario intuitiva y responsiva gracias a SCSS y Bootstrap. 
- Visualización y modificación de datos.

---

## Requisitos Previos

### General  
- **Node.js** (v16 o superior)  
- **Composer** (para dependencias de Laravel)  
- **PHP** (v8.2 o superior)  
- **MySQL** o cualquier base de datos SQL compatible con Laravel  

### Instalaciones  
1. **Clonar el repositorio**:  
   ```bash
   git clone https://github.com/anabdr/Gallery.git
2. **Instalar dependencias de laravel**:  
   ```bash
   composer install
3. **Renombra el archivo .env.example a .env en ambos proyectos**:
    Asegúrate de configurar las claves necesarias, como la conexión a la base de datos (DB_DATABASE, DB_USERNAME, DB_PASSWORD) y cualquier otra variable requerida.
4. **Ejecutar migraciones**:
   ```bash
   php artisan migrate --seed
5. **Crear el enlace simbólico para el almacenamiento**:
    ```bash
    php artisan storage:link
6. **Iniciar el servidor**:
   ```bash
   php artisan serve
   


## Uso
1. Accede al proyecto en el navegador.
2. Accede a la ruta /index para poder ver las obras ya creadas.
3. Crea una nueva obra desde un cliente con la ruta api/gallery.

---

## Contribuciones
Las contribuciones son bienvenidas. Si deseas colaborar:

1. Haz un fork del proyecto.
2. Crea una nueva rama (`feature/nueva-funcionalidad`).
3. Envía un pull request.

---

## Licencia
Este proyecto está licenciado bajo la [MIT License](LICENSE).

---

## Contacto
Si tienes preguntas o sugerencias, no dudes en contactarme:

- **Correo**: [ana.bdr.7@gmail.com](mailto:ana.bdr.7@gmail.com)
- **GitHub**: [anabdr](https://github.com/anabdr)





