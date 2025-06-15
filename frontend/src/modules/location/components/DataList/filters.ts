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
        key: 'type',
        label: 'Estado',
        type: 'category',
        options: [
            { value: 'building', label: 'Edificio' },
            { value: 'room', label: 'Sala' },
            { value: 'floor', label: 'Planta' },
            { value: 'warehouse', label: 'Almacén' },
            { value: 'datacenter', label: 'Centro de Datos' },
            { value: 'outdoor', label: 'Exterior' },
            { value: 'parking', label: 'Parking' },
            { value: 'rooftop', label: 'Azotea' },
        ],
    },
]
