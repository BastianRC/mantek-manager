import {
    ArrowDown,
    Minus,
    ArrowUp,
    Flame
} from 'lucide-vue-next'

export const getWorkOrderPriorityMeta = (priority: string) => {
    const metaMap = {
        low: {
            label: 'Baja',
            icon: ArrowDown,
            color: 'bg-green-100 text-green-600 border-green-200',
            emoji: '🟢'
        },
        medium: {
            label: 'Media',
            icon: Minus,
            color: 'bg-yellow-100 text-yellow-600 border-yellow-200',
            emoji: '🟡'
        },
        high: {
            label: 'Alta',
            icon: ArrowUp,
            color: 'bg-orange-100 text-orange-600 border-orange-200',
            emoji: '🟠'
        },
        critical: {
            label: 'Crítica',
            icon: Flame,
            color: 'bg-red-100 text-red-600 border-red-200',
            emoji: '🔴'
        }
    }

    return metaMap[priority] ?? {
        label: priority,
        icon: null,
        color: 'bg-muted text-foreground border-border',
        emoji: ''
    }
}