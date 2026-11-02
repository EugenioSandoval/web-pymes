# Mostrador Digital

Página de venta de Mostrador Digital: páginas web y sistemas de gestión para pymes de Chillán y Ñuble. Hecha con Laravel 13, Tailwind CSS 4 y MySQL (o SQLite en local).

## Qué tiene

- Página de venta (`resources/views/landing.blade.php`): portada, servicios, rubros, planes con precios, proceso, preguntas frecuentes y formulario de contacto.
- Formulario de contacto que guarda cada interesado en la tabla `leads`.
- Botón flotante de WhatsApp.
- Panel `/admin` para ver y marcar los contactos recibidos.
- **Demo "Centro Kine Ñuble"**, un centro de salud ficticio para mostrar a clientes:
  - Web pública en `/demo` con servicios, equipo y **reserva de horas en línea**.
  - Panel de gestión en `/demo/panel` (Filament) con agenda semanal, citas, pacientes, cotizaciones imprimibles en PDF, profesionales y servicios. El login ya viene con los datos de prueba (`demo@centrokine.cl` / `demo1234`).
  - Los datos del demo se reinician cada noche a las 04:00 con `php artisan demo:reset`.

## Cambiar textos y precios

Casi todo lo que cambia seguido está en `config/negocio.php`: nombre, WhatsApp, correo, ciudad, planes con sus precios y rubros. El nombre, WhatsApp, correo y ciudad también se pueden cambiar en el archivo `.env`:

```
NEGOCIO_NOMBRE="Mostrador Digital"
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
php artisan migrate --seed
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
6. Agrega también al `.env` tu usuario administrador: `ADMIN_EMAIL=tu@correo.cl` y `ADMIN_PASSWORD=una-clave-segura`.
7. Desde la Terminal de cPanel (o SSH), dentro de la carpeta del proyecto: `php artisan key:generate`, `php artisan migrate --seed --force`, `php artisan config:cache` y `php artisan filament:optimize`.
8. Para que el demo se reinicie solo cada noche, en cPanel ve a "Cron Jobs" y agrega uno cada minuto con: `cd /home/tuusuario/web-pymes && php artisan schedule:run >> /dev/null 2>&1`
9. Verifica que la versión de PHP del dominio sea 8.3 o superior (cPanel, "Select PHP Version").

## Ver los contactos recibidos

Entra a `/admin` con el usuario de `ADMIN_EMAIL`. Desde ahí puedes escribirle por WhatsApp a cada contacto y marcarlo como contactado.

## Dónde está cada parte del demo

| Qué | Archivo |
| --- | --- |
| Tablas | `database/migrations/2026_10_31_200000_create_clinica_tables.php` |
| Datos de ejemplo | `database/seeders/DemoClinicaSeeder.php` |
| Web pública y reservas | `app/Http/Controllers/DemoClinicaController.php`, `resources/views/demo/` |
| Panel (pantallas) | `app/Filament/Clinica/` |
| Agenda semanal | `app/Filament/Clinica/Pages/Agenda.php`, `resources/views/filament/clinica/agenda.blade.php` |
| Cotización imprimible | `resources/views/demo/cotizacion.blade.php` |

## Pruebas

`php artisan test` revisa la página de venta, el formulario, las reservas (incluido que no se pueda tomar dos veces la misma hora), los permisos de cada panel y que todas las pantallas del panel carguen.
