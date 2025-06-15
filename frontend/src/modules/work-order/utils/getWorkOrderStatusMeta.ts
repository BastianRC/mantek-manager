import {
    Clock,
    UserCheck,
    Hammer,
    CheckCircle2,
    XCircle,
    type LucideIcon
} from 'lucide-vue-next'

export const getWorkOrderStatusMeta = (status: string): {
    label: string
    icon: LucideIcon
    color: string
} => {
    const metaMap: Record<string, { label: string; icon: LucideIcon; color: string }> = {
        pending: {
            label: 'Pendiente',
            icon: Clock,
            color: 'bg-yellow-100 text-yellow-600 border-yellow-200'
        },
        in_progress: {
            label: 'En progreso',
            icon: Hammer,
            color: 'bg-blue-100 text-blue-600 border-blue-200'
        },
        completed: {
            label: 'Completada',
            icon: CheckCircle2,
            color: 'bg-green-100 text-green-600 border-green-200'
        },
        cancelled: {
            label: 'Cancelada',
            icon: XCircle,
            color: 'bg-red-100 text-red-600 border-red-200'
        }
    }

    return metaMap[status] ?? {
        label: status,
        icon: Clock,
        color: 'bg-gray-100 text-gray-600 border-gray-200'
    }
}
