import type { FilterDefinition } from "~/components/custom/DataList/types";

export const filters: FilterDefinition[] = [
  {
    key: 'is_active',
    label: 'Estado',
    type: 'boolean',
    options: [
      { value: 'true', label: 'Activos' },
      { value: 'false', label: 'Inactivos' },
    ],
  },
  {
    key: 'department',
    label: 'Departamento',
    type: 'category',
    dynamic: true,
  },
]
