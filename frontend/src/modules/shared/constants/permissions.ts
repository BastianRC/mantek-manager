export const PERMISSIONS = {
  CREATE_USER: 'Create user',
  UPDATE_USER: 'Update user',
  DELETE_USER: 'Delete user',
  VIEW_USER: 'View user',
  VIEW_ALL_USERS: 'View all users',
  ASSIGN_ROLE: 'Assign role',

  CREATE_ROLE: 'Create role',
  UPDATE_ROLE: 'Update role',
  DELETE_ROLE: 'Delete role',
  VIEW_ROLE: 'View role',
  VIEW_ALL_ROLES: 'View all roles',

  CREATE_LOCATION: 'Create location',
  UPDATE_LOCATION: 'Update location',
  DELETE_LOCATION: 'Delete location',
  VIEW_LOCATION: 'View location',
  VIEW_ALL_LOCATIONS: 'View all locations',

  CREATE_MACHINE: 'Create machine',
  UPDATE_MACHINE: 'Update machine',
  DELETE_MACHINE: 'Delete machine',
  VIEW_MACHINE: 'View machine',
  VIEW_ALL_MACHINES: 'View all machines',

  CREATE_WORK_ORDER: 'Create work order',
  UPDATE_WORK_ORDER: 'Update work order',
  DELETE_WORK_ORDER: 'Delete work order',
  VIEW_WORK_ORDER: 'View work order',
  VIEW_ALL_WORK_ORDERS: 'View all work orders',

  VIEW_CHRONOLOGY: 'View chronology',
  VIEW_ALL_CHRONOLOGIES: 'View all chronologies',

  VIEW_ALL_PERMISSIONS: 'View all permissions',
} as const

export const PERMISSION_CATEGORIES = {
  users: {
    name: 'Gestión de Usuarios',
    permissions: [
      { id: PERMISSIONS.CREATE_USER, name: PERMISSIONS.CREATE_USER, description: 'Permite crear nuevos usuarios' },
      { id: PERMISSIONS.VIEW_USER, name: PERMISSIONS.VIEW_USER, description: 'Permite ver usuarios' },
      { id: PERMISSIONS.UPDATE_USER, name: PERMISSIONS.UPDATE_USER, description: 'Permite editar usuarios' },
      { id: PERMISSIONS.DELETE_USER, name: PERMISSIONS.DELETE_USER, description: 'Permite eliminar usuarios' },
      { id: PERMISSIONS.VIEW_ALL_USERS, name: PERMISSIONS.VIEW_ALL_USERS, description: 'Permite ver todos los usuarios' },
      { id: PERMISSIONS.ASSIGN_ROLE, name: PERMISSIONS.ASSIGN_ROLE, description: 'Permite asignar roles a los usuarios' },
    ],
  },
  roles: {
    name: 'Gestión de Roles',
    permissions: [
      { id: PERMISSIONS.CREATE_ROLE, name: PERMISSIONS.CREATE_ROLE, description: 'Permite crear roles' },
      { id: PERMISSIONS.VIEW_ROLE, name: PERMISSIONS.VIEW_ROLE, description: 'Permite ver roles' },
      { id: PERMISSIONS.UPDATE_ROLE, name: PERMISSIONS.UPDATE_ROLE, description: 'Permite editar roles' },
      { id: PERMISSIONS.DELETE_ROLE, name: PERMISSIONS.DELETE_ROLE, description: 'Permite eliminar roles' },
      { id: PERMISSIONS.VIEW_ALL_ROLES, name: PERMISSIONS.VIEW_ALL_ROLES, description: 'Permite ver todos los roles' },
    ],
  },
  locations: {
    name: 'Ubicaciones',
    permissions: [
      { id: PERMISSIONS.CREATE_LOCATION, name: PERMISSIONS.CREATE_LOCATION, description: 'Permite crear ubicaciones' },
      { id: PERMISSIONS.VIEW_LOCATION, name: PERMISSIONS.VIEW_LOCATION, description: 'Permite ver ubicaciones' },
      { id: PERMISSIONS.UPDATE_LOCATION, name: PERMISSIONS.UPDATE_LOCATION, description: 'Permite editar ubicaciones' },
      { id: PERMISSIONS.DELETE_LOCATION, name: PERMISSIONS.DELETE_LOCATION, description: 'Permite eliminar ubicaciones' },
      { id: PERMISSIONS.VIEW_ALL_LOCATIONS, name: PERMISSIONS.VIEW_ALL_LOCATIONS, description: 'Permite ver todas las ubicaciones' },
    ],
  },
  machines: {
    name: 'Máquinas y Equipos',
    permissions: [
      { id: PERMISSIONS.CREATE_MACHINE, name: PERMISSIONS.CREATE_MACHINE, description: 'Permite crear máquinas' },
      { id: PERMISSIONS.VIEW_MACHINE, name: PERMISSIONS.VIEW_MACHINE, description: 'Permite ver máquinas' },
      { id: PERMISSIONS.UPDATE_MACHINE, name: PERMISSIONS.UPDATE_MACHINE, description: 'Permite editar máquinas' },
      { id: PERMISSIONS.DELETE_MACHINE, name: PERMISSIONS.DELETE_MACHINE, description: 'Permite eliminar máquinas' },
      { id: PERMISSIONS.VIEW_ALL_MACHINES, name: PERMISSIONS.VIEW_ALL_MACHINES, description: 'Permite ver todas las máquinas' },
    ],
  },
  workorders: {
    name: 'Órdenes de Trabajo',
    permissions: [
      { id: PERMISSIONS.CREATE_WORK_ORDER, name: PERMISSIONS.CREATE_WORK_ORDER, description: 'Permite crear órdenes de trabajo' },
      { id: PERMISSIONS.VIEW_WORK_ORDER, name: PERMISSIONS.VIEW_WORK_ORDER, description: 'Permite ver órdenes de trabajo' },
      { id: PERMISSIONS.UPDATE_WORK_ORDER, name: PERMISSIONS.UPDATE_WORK_ORDER, description: 'Permite editar órdenes de trabajo' },
      { id: PERMISSIONS.DELETE_WORK_ORDER, name: PERMISSIONS.DELETE_WORK_ORDER, description: 'Permite eliminar órdenes de trabajo' },
      { id: PERMISSIONS.VIEW_ALL_WORK_ORDERS, name: PERMISSIONS.VIEW_ALL_WORK_ORDERS, description: 'Permite ver todas las órdenes de trabajo' },
    ],
  },
  chronologies: {
    name: 'Cronologia',
    permissions: [
      { id: PERMISSIONS.VIEW_CHRONOLOGY, name: PERMISSIONS.VIEW_CHRONOLOGY, description: 'Permite ver la cronología' },
      { id: PERMISSIONS.VIEW_ALL_CHRONOLOGIES, name: PERMISSIONS.VIEW_ALL_CHRONOLOGIES, description: 'Permite ver todas las cronologías' },
    ],
  },
} as const

export type PermissionKey = keyof typeof PERMISSIONS

export type PermissionValue = (typeof PERMISSIONS)[PermissionKey]

export const ALL_PERMISSION_VALUES: PermissionValue[] = Object.values(PERMISSIONS)
