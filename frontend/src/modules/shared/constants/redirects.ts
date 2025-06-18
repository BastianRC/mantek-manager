import { PERMISSIONS } from "./permissions";

export const DASHBOARD_REDIRECTS = [
  {
    path: "/dashboard/users",
    permission: PERMISSIONS.VIEW_ALL_USERS,
  },
  {
    path: "/dashboard/roles",
    permission: PERMISSIONS.VIEW_ALL_ROLES,
  },
  {
    path: "/dashboard/locations",
    permission: PERMISSIONS.VIEW_ALL_LOCATIONS,
  },
  {
    path: "/dashboard/machines",
    permission: PERMISSIONS.VIEW_ALL_MACHINES,
  },
  {
    path: "/dashboard/work-orders",
    permission: PERMISSIONS.VIEW_ALL_WORK_ORDERS,
  },
  {
    path: "/dashboard/chronologies",
    permission: PERMISSIONS.VIEW_ALL_CHRONOLOGIES,
  },
];
