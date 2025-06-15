import type { FilterDefinition } from "~/components/custom/DataList/types";

export const filters: FilterDefinition[] = [
    {
        key: 'status',
        label: 'Estado',
        type: 'category',
        options: [
            { value: 'operational', label: 'Operativo' },
            { value: 'maintenance', label: 'Mantenimiento' },
            { value: 'warning', label: 'Advertencia' },
            { value: 'critical', label: 'Critico' },
            { value: 'retired', label: 'Retirado' },
        ],
    },

    {
        key: 'category.name',
        label: 'Categoria',
        type: 'category',
        dynamic: true 
    },
]
