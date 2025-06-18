# 🎨 Mantek Manager - Frontend

Frontend del sistema de gestión de mantenimiento industrial **Mantek Manager**, desarrollado con **Nuxt 3**, **TypeScript** y **Tailwind CSS**, utilizando una **arquitectura modular tipo Screaming Architecture** siguiendo los principios de **DDD** y **SOLID**.

---

## 📦 Requisitos

* Node.js >= 18
* pnpm (recomendado) o npm/yarn

---

## 🚀 Instalación

```bash
git clone https://github.com/tuusuario/mantek-manager-frontend.git
cd mantek-manager-frontend
pnpm install
cp .env.example .env
```

Configura el archivo `.env` con la URL de la API:

```env
NUXT_PUBLIC_API_BASE_URL=http://localhost/api
```

### ▶️ Ejecutar en desarrollo

```bash
pnpm dev
```

Abre en el navegador: `http://localhost:3000`

---

## 🧠 Arquitectura

El frontend está estructurado con **arquitectura modular**. Cada módulo incluye:

```
modules/
├── auth/
│   ├── components/
│   ├── composables/
│   ├── services/
│   ├── types/
│   └── views/
├── user/
├── role/
├── location/
├── machine/
└── work-order/
```

Además:

* `shared/`: componentes, tipos y lógica común reutilizable

Usamos:

* **Pinia** para gestión de estado
* **TanStack Query** para manejo de datos
* **ShadCN Vue** + **Tailwind CSS** para la interfaz
* **VeeValidate + Zod** para validación de formularios

---

## 🔐 Autenticación

Autenticación con **Laravel Sanctum**. El token se guarda y gestiona con **Pinia** y cookies.

---

## ✨ Funcionalidades destacadas

* Login/logout con validación y persistencia
* Gestión de usuarios y roles
* Gestión ubicaciones
* Maquinaria y ordenes de trabajo
* Vistas reactivas y componentes dinámicos

---

## 🧪 Testing

(En desarrollo) Se utilizará:

* Vitest o Jest para unitarios
* Cypress para end-to-end (futuro)

---

## 📦 Versionado

Este repositorio sigue **SemVer**
Versión actual: `v1.0.0-beta.2`

---

## 📄 Licencia

Este proyecto está licenciado bajo los términos de la licencia [CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/).

Esto significa que puedes usar, modificar y distribuir este software, siempre que:

* Se dé crédito al autor original.
* No se utilice con fines comerciales.
