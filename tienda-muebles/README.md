# 🛋️ Tienda Muebles

Bienvenido a **Tienda Muebles**, una plataforma de comercio electrónico robusta y moderna diseñada para la gestión y venta de mobiliario. Este proyecto está construido sobre el potente framework **Laravel 12**, aprovechando las últimas tecnologías web para ofrecer una experiencia de usuario fluida y un backend sólido.

## 🚀 Características Principales

El sistema cuenta con una arquitectura modular que incluye:

*   **🔐 Autenticación y Seguridad:**
    *   Sistema completo de Registro e Inicio de Sesión.
    *   Gestión de **Roles y Permisos** para administradores y clientes.
*   **📦 Gestión de Catálogo:**
    *   Administración de **Productos** con detalles completos.
    *   Organización por **Categorías** para una fácil navegación.
    *   Relación dinámica entre productos y categorías.
*   **🖼️ Galería Multimedia:**
    *   Sistema de **Galerías e Imágenes** para visualizar los productos en alta calidad.
*   **🛒 Experiencia de Compra:**
    *   **Carrito de Compras** funcional.
    *   Gestión de ítems en el carrito (añadir, eliminar, actualizar).

## 🛠️ Stack Tecnológico

Este proyecto utiliza tecnologías de vanguardia para garantizar rendimiento y escalabilidad:

*   **Backend:** [Laravel 12](https://laravel.com) (PHP ^8.2)
*   **Frontend:** [Blade Templates](https://laravel.com/docs/blade), [TailwindCSS v4](https://tailwindcss.com), [Vite](https://vitejs.dev)
*   **Base de Datos:** MySQL / MariaDB
*   **Gestión de Dependencias:** Composer (PHP), NPM (JavaScript)

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente en tu entorno de desarrollo:

*   [PHP](https://www.php.net/) >= 8.2
*   [Composer](https://getcomposer.org/)
*   [Node.js](https://nodejs.org/) & NPM
*   Un servidor de base de datos (MySQL, MariaDB, etc.)

## 🔧 Instalación y Configuración

Sigue estos pasos para desplegar el proyecto en tu máquina local:

1.  **Clonar el repositorio**
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd tienda-muebles
    ```

2.  **Instalar dependencias de Backend**
    ```bash
    composer install
    ```

3.  **Instalar dependencias de Frontend**
    ```bash
    npm install
    ```

4.  **Configurar el entorno**
    Copia el archivo de configuración de ejemplo:
    ```bash
    cp .env.example .env
    ```
    Abre el archivo `.env` y configura tus credenciales de base de datos (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5.  **Generar clave de aplicación**
    ```bash
    php artisan key:generate
    ```

6.  **Ejecutar migraciones**
    Crea la estructura de la base de datos (tablas de usuarios, productos, carritos, etc.):
    ```bash
    php artisan migrate
    ```

7.  **Iniciar el servidor de desarrollo**
    Para trabajar en el proyecto, necesitarás ejecutar tanto el servidor de Laravel como el de Vite.

    *Terminal 1 (Servidor Laravel):*
    ```bash
    php artisan serve
    ```

8.  **Acceder a la aplicación**
    Abre tu navegador y visita: `http://localhost:8000`

## 🤝 Contribución

¡Las contribuciones son bienvenidas! Ayúdanos a hacer de **Tienda Muebles** la mejor plataforma.

1.  Haz un Fork del proyecto.
2.  Crea una rama para tu nueva funcionalidad (`git checkout -b feature/nueva-funcionalidad`).
3.  Haz Commit de tus cambios (`git commit -m 'Añadir nueva funcionalidad'`).
4.  Haz Push a la rama (`git push origin feature/nueva-funcionalidad`).
5.  Abre un Pull Request.

## 📄 Licencia

Este proyecto es de código abierto y está bajo la licencia [MIT](https://opensource.org/licenses/MIT).
