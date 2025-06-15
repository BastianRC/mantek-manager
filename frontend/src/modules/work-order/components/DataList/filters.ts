import type { FilterDefinition } from "~/components/custom/DataList/types";

export const filters: FilterDefinition[] = [
    {
        key: 'status',
        label: 'Estado',
        type: 'category',
        options: [
            { value: 'pending', label: 'Pendiente' },
            { value: 'in_progress', label: 'En Progreso' },
            { value: 'completed', label: 'Completado' },
            { value: 'cancelled', label: 'Cancelado' },

        ],
    },

    {
        key: 'priority',
        label: 'Prioridad',
        type: 'category',
        options: [
            { value: 'low', label: 'Baja' },
            { value: 'medium', label: 'Media' },
            { value: 'high', label: 'Alta' },
            { value: 'critical', label: 'Critica' },
        ],
    },
]
