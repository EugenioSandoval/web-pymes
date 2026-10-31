# Web Pymes Chillán

Página de venta para ofrecer páginas web y sistemas de gestión a pymes de Chillán. Hecha con Laravel 13, Tailwind CSS 4 y MySQL (o SQLite en local).

## Qué tiene

- Página de venta (`resources/views/landing.blade.php`): portada, servicios, rubros, planes con precios, proceso, preguntas frecuentes y formulario de contacto.
- Formulario de contacto que guarda cada interesado en la tabla `leads`.
- Botón flotante de WhatsApp.
- Ruta `/demo`, que por ahora muestra "El demo viene pronto" (el demo del centro de salud es el siguiente paso).

## Cambiar textos y precios

Casi todo lo que cambia seguido está en `config/negocio.php`: nombre, WhatsApp, correo, ciudad, planes con sus precios y rubros. El nombre, WhatsApp, correo y ciudad también se pueden cambiar en el archivo `.env`:

```
NEGOCIO_NOMBRE="Web Pymes Chillán"
NEGOCIO_WHATSAPP=56912345678
NEGOCIO_EMAIL=contacto@tudominio.cl
NEGOCIO_CIUDAD="Chillán, Ñuble"
```

Los colores de la marca están en `resources/css/app.css` (variables `--color-marca-*`).

## Trabajar en tu computador

Necesitas PHP 8.3 o superior, Composer y Node.js 20 o superior.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run dev        # en una terminal
php artisan serve  # en otra terminal, abre http://localhost:8000
```

## Publicar en Benzahosting (cPanel)

1. En cPanel, crea una base de datos MySQL y un usuario con todos los permisos.
2. En tu computador ejecuta `npm run build` y `composer install --no-dev --optimize-autoloader`.
3. Sube todo el proyecto a una carpeta fuera de `public_html`, por ejemplo `/home/tuusuario/web-pymes`.
4. Haz que el dominio apunte a la carpeta `web-pymes/public`. En cPanel: Dominios, editar el dominio y cambiar la raíz del documento. Si el plan no lo permite, copia el contenido de `public` a `public_html` y en `public_html/index.php` cambia las rutas `__DIR__.'/../` por `__DIR__.'/../web-pymes/`.
5. Crea el archivo `.env` en el servidor con `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://tudominio.cl` y los datos de MySQL (`DB_CONNECTION=mysql`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
6. Desde la Terminal de cPanel (o SSH), dentro de la carpeta del proyecto: `php artisan key:generate`, `php artisan migrate --force` y `php artisan config:cache`.
7. Verifica que la versión de PHP del dominio sea 8.3 o superior (cPanel, "Select PHP Version").

## Ver los contactos recibidos

Por ahora se ven en la tabla `leads` (phpMyAdmin en cPanel). En el siguiente paso se agregará un panel de administración con Filament.
