# API REST Laravel 12

# 1. Instrucciones para configurar localmente.

## Requisitos previos

- Docker y Docker Compose instalados en tu máquina.
- No necesitas instalar PHP, Composer ni MySQL localmente.

## Pasos para levantar el entorno

1.1. **Clona el repositorio:**

   ```sh
   git clone https://github.com/jucs7/php-technical-test-25014.git
   cd php-technical-test-25014
   ```

1.2. **Copia el archivo de entorno:**

   ```sh
   cp .env.example .env
   ```

1.3. **Instala las dependencias de Composer usando Sail:**

   ```sh
   ./vendor/bin/sail up -d
   ./vendor/bin/sail composer install
   ```

   Si es la primera vez, ejecuta:

   ```sh
   docker run --rm \
     -u "$(id -u):$(id -g)" \
     -v $(pwd):/var/www/html \
     -w /var/www/html \
     laravelsail/php82-composer:latest composer install
   ```

1.4. **Levanta los servicios:**

   ```sh
   ./vendor/bin/sail up -d
   ```

1.5. **Genera la clave de la aplicación:**

   ```sh
   ./vendor/bin/sail artisan key:generate
   ```

1.6. **Ejecuta las migraciones:**

   ```sh
   ./vendor/bin/sail artisan migrate
   ```

1.7. **Ejecuta el seeder:**

   ```sh
   ./vendor/bin/sail artisan db:seed DatabaseSeeder
   ```
   Este Seeder insertará un usuario con rol 'admin' para realizar operaciones de dicho rol.
   - email: admin@test.com
   - password: adminpass


1.8. **Accede a la aplicación:**

   Utiliza la URL [http://0.0.0.0:80](http://0.0.0.0:80) o [http://localhost](http://localhost) en tu Postman client según tu configuración.

## Comandos útiles

- Parar los servicios:

  ```sh
  ./vendor/bin/sail down
  ```

- Ver logs:

  ```sh
  ./vendor/bin/sail logs -f
  ```

## Notas

- Puedes modificar la configuración de la base de datos en el archivo `.env` si es necesario.
- Para más información sobre Sail, consulta la [documentación oficial](https://laravel.com/docs/12.x/sail).

# 2. Uso de la colección Postman

2.1. **Importa la colección:**

   - Abre Postman.
   - Haz clic en "Import" (Importar) en la parte superior izquierda.
   - Selecciona el archivo de la colección Postman incluido en este repositorio (`php-technical-test-25014-jucs7.postman_collection.json`) o arrástralo a la ventana de importación.

2.2. **Configura el entorno:**

   En caso de usar la API en entorno local asegúrate de que la variable `url` apunte a `http://0.0.0.0:80` o `http://localhost` según tu configuración.

2.3. **Usa la colección:**

   - Selecciona la colección importada en la barra lateral de Postman.
   - Ejecuta las peticiones según lo necesites.
   - Si alguna petición requiere autenticación, loguéate como administrador y apunta la variable `token-bearer` al token generado.

# 3. Decisiones de diseño

## Elección de enum vs tabla de roles

Se optó por utilizar un **enum** para los roles de usuario en lugar de una tabla de roles en base de datos porque la cantidad de roles es limitada, bien definida y poco cambiante (por ejemplo: `admin`, `user`). Usar un enum simplifica el código, mejora la legibilidad y evita consultas adicionales a la base de datos. Si en el futuro se requiere una gestión dinámica de roles o permisos, se podría migrar fácilmente a una tabla de roles.

## Middleware o paquete de autorización

Para la autenticación mediante tokens se eligió implementar **Laravel Sanctum**. Para los permisos se optó por un middleware personalizado **admin** en lugar de un paquete externo como Spatie Laravel Permission. Esto se debe a que los requerimientos de autorización son simples y directos (por ejemplo, restringir ciertas rutas solo a usuarios con rol `admin`). El middleware es ligero, fácil de mantener y suficiente para este caso. Si el sistema crece y requiere una gestión más granular de permisos, se podría considerar integrar un paquete especializado.

## Arquitectura en capas

La aplicación está estructurada siguiendo una arquitectura por capas, lo que permite una clara separación de responsabilidades y facilita el mantenimiento y escalabilidad del sistema:

- **Presentación (Controllers, Form Requests):** Esta capa se encarga de recibir y validar las solicitudes HTTP. Los controladores orquestan el flujo de la aplicación y delegan la lógica de negocio a los servicios, mientras que los Form Requests centralizan la validación de datos.
- **Aplicación (Services):** Contiene la lógica de negocio principal. Los servicios coordinan operaciones complejas, aplican reglas de negocio y utilizan los repositorios para acceder a los datos.
- **Infraestructura (Repositories, Providers, Migrations):** Aquí se gestiona el acceso a recursos externos y la configuración técnica. Los Repositories abstraen el acceso a la base de datos, los Providers configuran servicios y dependencias, y las Migrations definen la estructura de la base de datos.
- **Dominio (Entities / Models):** Define los conceptos centrales del negocio, como usuarios y roles, y puede incluir reglas de negocio propias de cada entidad.

## Patrón Service-Repository

Se implementó el patrón Service-Repository para desacoplar la lógica de acceso a datos (repositories) de la lógica de negocio (services). Esto permite:
- Facilitar el testeo y la reutilización de código.
- Mantener los controladores delgados y enfocados solo en la interacción con el usuario.
- Cambiar la fuente de datos o la lógica de negocio con mínimo impacto en el resto del sistema.
