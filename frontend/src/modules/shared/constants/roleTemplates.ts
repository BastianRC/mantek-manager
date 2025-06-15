import { PERMISSIONS } from './permissions'

export const roleTemplates = [
    {
        id: "admin",
        name: "Administrador",
        description: "Acceso completo al sistema",
        permissions: Object.values(PERMISSIONS),
    },
    {
        id: "supervisor",
        name: "Supervisor",
        description: "Supervisión de órdenes y equipos",
        permissions: [
            PERMISSIONS.VIEW_USER,

            PERMISSIONS.CREATE_WORK_ORDER,
            PERMISSIONS.VIEW_ALL_WORK_ORDERS,
            PERMISSIONS.UPDATE_WORK_ORDER,

            PERMISSIONS.VIEW_ALL_MACHINES,
            PERMISSIONS.UPDATE_MACHINE,

            PERMISSIONS.VIEW_ALL_LOCATIONS,
        ],
    },
    {
        id: "technician",
        name: "Técnico",
        description: "Ejecución de órdenes de trabajo",
        permissions: [
            PERMISSIONS.VIEW_ALL_WORK_ORDERS,
            PERMISSIONS.UPDATE_WORK_ORDER,

            PERMISSIONS.VIEW_ALL_MACHINES,
            PERMISSIONS.VIEW_ALL_LOCATIONS,
        ],
    },
    {
        id: "viewer",
        name: "Visualizador",
        description: "Solo lectura",
        permissions: [
            PERMISSIONS.VIEW_USER,
            PERMISSIONS.VIEW_ALL_USERS,

            PERMISSIONS.VIEW_ALL_ROLES,

            PERMISSIONS.VIEW_ALL_LOCATIONS,
            PERMISSIONS.VIEW_ALL_MACHINES,
            PERMISSIONS.VIEW_ALL_WORK_ORDERS,
        ],
    },
] as const
