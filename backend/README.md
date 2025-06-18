# 🛠️ Mantek Manager - Backend

Backend API del sistema de gestión de mantenimiento industrial **Mantek Manager**, desarrollado en **Laravel 12**, siguiendo los principios de **Arquitectura Limpia**, **DDD**, **Hexagonal** y **SOLID**.

---

## 🛆 Requisitos

* PHP >= 8.2
* Composer
* MySQL >= 8
* Laravel 12
* Extensiones PHP: `pdo`, `mbstring`, `openssl`, `bcmath`, `curl`, `fileinfo`, `tokenizer`, `xml`, `ctype`, `json`

---

## 🚀 Instalación

```bash
git clone https://github.com/tuusuario/mantek-manager-backend.git
cd mantek-manager-backend
composer install
cp .env.example .env
php artisan key:generate
```

Configura tu `.env` con la base de datos y otras variables necesarias:

```dotenv
APP_NAME=MantekManager
APP_ENV=local
APP_KEY=base64:...
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mantek
DB_USERNAME=root
DB_PASSWORD=
```

### 🧱 Migraciones y Seeders

```bash
php artisan migrate --seed
```

Esto incluye un usuario super admin preconfigurado y los roles/permisos necesarios.

---

## 🧠 Arquitectura

El backend sigue una **estructura modular**, con separación de responsabilidades:

```
src/
├── Auth/
├── User/
├── Role/
├── Location/
├── Machine/
├── WorkOrder/
├── Chronology/
├── Shared/
└── 
```

Cada módulo tiene las siguientes capas:

* `Domain`: Entidades, contratos, excepciones, value objects
* `Application`: Casos de uso, DTOs, mapeadores
* `Infrastructure`: Modelos Eloquent, controladores, repositorios, requests, rutas
* `Routes`: Rutas propias del módulo

---

## 🔐 Autenticación

Autenticación basada en **Laravel Sanctum**.
Los endpoints protegidos requieren el token en la cabecera:

```
Authorization: Bearer {token}
```

---

## 👤 Roles y permisos

Sistema de roles gestionado con `spatie/laravel-permission`, desacoplado mediante contratos de dominio.

Roles por defecto:

* `super-admin`

---

## ✨ Funcionalidades destacadas

* Gestión de usuarios, roles y permisos
* Maquinaria y ubicaciones jerárquicas
* Partes de trabajo y tareas programadas
* Histórico de acciones (cronología)
* Notificaciones push en tiempo real
* Arquitectura escalable y desacoplada
* DTOs estandarizados y pruebas unitarias

---

## 📦 Versionado

Este repositorio sigue **SemVer**
Versión actual: `v1.0.0-beta.2`

---

## 📄 Licencia

Este proyecto está licenciado bajo los términos de la licencia CC BY-NC 4.0.

Esto significa que puedes usar, modificar y distribuir este software, siempre que:

Se dé crédito al autor original.

No se utilice con fines comerciales.