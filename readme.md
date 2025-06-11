[![php](https://img.shields.io/badge/php-8.x-blue)]()

# Congrexia Events

Proyecto final del Grado Superior en Desarrollo de Aplicaciones Web.

## 📋 Descripción  
Breve resumen de la aplicación:  
- Plataforma de gestión y venta de entradas para eventos  
- Monolito MVC en PHP con patron Front Controller y ORM tipo Active Record 
- Registro de ponentes, compra de entradas, generación de QR y PDFs, APIs interna, dashboard de administración…

## 🚀 Características principales  
- Autenticación y autorización (login, registro, bloqueo tras X intentos durante X tiempo)  
- Gestión de eventos, ponentes y regalos  
- Generación de tickets en PDF (DomPDF)  
- Optimización de assets (Gulp, WebP/AVIF, SASS)  
- API REST interna para consumo AJAX 

## Estructura del proyecto

- `src/`: Código fuente de frontend (JS, CSS, etc.).
- `controllers/`, `models/`, `views/`: Lógica de backend en PHP (MVC).
- `public/`: Archivos públicos para el navegador.
- `node_modules/`: Dependencias de Node.js.
- `vendor/`: Dependencias de PHP instaladas con Composer.
- `controllers/` → Lógica de enrutado y acciones
- `models/` → Modelos Active Record
- `views/` → Plantillas PHP
- `includes/` → Configuración (.env)
- `src/` → JS, SASS y IMG
- `vendor/` → Dependencias PHP
- `node_modules/` → Dependencias JS
- `gulpfile.js, package.json, composer.json`
- `.htaccess, .env.example, README.md`

## Primeros pasos

```bash
# Instala las dependencias de Node.js
npm install

# Instala las dependencias de PHP
composer install

# Compila los assets de frontend en modo desarrollo
npm run dev
```

## Requisitos

- Node.js >= 16.x
- PHP >= 8.0
- Composer
- XAMPP o similar (MySQL, Apache)

## Desarrollo

- El código fuente JS está en `src/js/`.
- Los estilos están en `src/scss/`.
- El backend sigue el patrón MVC en PHP.
- Los endpoints de la API están en `controllers/`.

## Consejos

- Usa `npm run dev` durante el desarrollo para recargar los cambios automáticamente.
- Si tienes problemas con dependencias, elimina `node_modules` y ejecuta `npm install` de nuevo.

