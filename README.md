# Mantek Manager – Beta Pública

**Mantek Manager** es una plataforma completa para la **gestión de mantenimiento de maquinaria industrial**, desarrollada con tecnologías modernas y principios de arquitectura limpia.

> 🔒 Este repositorio contiene el frontend y backend preparados para su primer lanzamiento público: `v1.0.0-beta.2`.

---

## 🗞 Versión actual

**`v1.0.0-beta.2`**
🗓️ Junio 2025
🔖 Tag oficial: [v1.0.0-beta.2](https://github.com/BastianRC/mantek-manager/releases/tag/v1.0.0-beta.2)

---

## 🗑 Estructura del proyecto

```
mantek-manager-public/
├── frontend/       → Aplicación cliente (Nuxt 3 + Tailwind + Vite)
├── backend/        → API REST (Laravel 12 + Hexagonal + DDD)
├── docker-compose.yml
└── README.md
```

---

## 🚀 Tecnologías principales

### Frontend

* [Nuxt 3](https://nuxt.com/)
* [Tailwind CSS](https://tailwindcss.com/)
* [Pinia](https://pinia.vuejs.org/)
* [TanStack Query](https://tanstack.com/query/latest/docs/framework/vue/overview)
* [Vite](https://vitejs.dev/)
* [Shadcn Vue](https://www.shadcn-vue.com/)

### Backend

* [Laravel 12](https://laravel.com/)
* PHP 8.2+
* MySQL 8
* Arquitectura Hexagonal + DDD + SOLID
* Repositorios + Casos de uso desacoplados
* Integración vía API REST + Laravel Sanctum

---

## ⚙️ Instalación local

### 🔧 Requisitos previos

* Node.js 18+
* PHP 8.2+
* Composer
* MySQL
* [pnpm](https://pnpm.io/) recomendado

---

### 🧑‍💻 Frontend

```bash
cd frontend
pnpm install
pnpm dev
```

---

### 🧑‍💻 Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## 🧪 Estado actual de la beta

| Módulo                 | Estado          |
| ---------------------- | --------------- |
| Autenticación          | ✅ Completo      |
| Gestión de usuarios    | ✅ Completo      |
| Roles y permisos       | ✅ Completo      |
| Maquinaria             | ✅ Completo      |
| Órdenes de trabajo     | ✅ Beta estable  |
| Cronología             | ✅ Básico        |
| Programación de tareas | 🚧 Próximamente  |
| Tickets/Soporte        | 🚧 Planeado      |

---

## 📆 Docker (opcional)

Si prefieres probarlo vía contenedor:

```bash
docker-compose up --build
```

> Asegúrate de revisar `docker-compose.yml` y configurar los puertos correctamente.

---

## 📄 Licencia

Este proyecto está licenciado bajo los términos de la licencia [CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/).

Esto significa que puedes usar, modificar y distribuir este software, siempre que:

* Se dé crédito al autor original.
* No se utilice con fines comerciales.

---

## 🤝 Contacto

* Autor: [Bastian](https://github.com/BastianRC)
