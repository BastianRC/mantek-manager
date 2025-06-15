import { h } from 'vue'
import { CheckCircle, Wrench, AlertTriangle, Clock, Minus } from 'lucide-vue-next'

export const getStatusMeta = (status: string): {
    label: string
    icon: ReturnType<typeof h>
    color: string
} => {
    const metaMap: Record<string, { label: string; icon: ReturnType<typeof h>; color: string }> = {
        operational: {
            label: 'Operativo',
            icon: h(CheckCircle, { class: 'size-4' }),
            color: 'bg-green-100 text-green-800 border-green-200'
        },
        maintenance: {
            label: 'Mantenimiento',
            icon: h(Wrench, { class: 'size-4' }),
            color: 'bg-blue-100 text-blue-800 border-blue-200'
        },
        warning: {
            label: 'Advertencia',
            icon: h(AlertTriangle, { class: 'size-4' }),
            color: 'bg-yellow-100 text-yellow-800 border-yellow-200'
        },
        critical: {
            label: 'Crítico',
            icon: h(AlertTriangle, { class: 'size-4' }),
            color: 'bg-red-100 text-red-800 border-red-200'
        },
        retired: {
            label: 'Retirado',
            icon: h(Minus, { class: 'size-4' }),
            color: 'bg-gray-100 text-gray-800 border-gray-200'
        }
    }

    return metaMap[status] ?? {
        label: status,
        icon: h(Clock, { class: 'size-4' }),
        color: 'bg-gray-100 text-gray-800 border-gray-200'
    }
}
