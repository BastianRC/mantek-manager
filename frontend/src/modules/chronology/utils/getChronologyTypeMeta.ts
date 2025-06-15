import {
    PlusCircle,
    Edit,
    Trash2,
    UserCheck,
    Play,
    Pause,
    XCircle,
    CheckCircle2,
    MessageCircle,
    ShieldCheck,
    ShieldOff,
    type LucideIcon
} from 'lucide-vue-next'

type ChronologyEventType =
    | 'created'
    | 'updated'
    | 'deleted'
    | 'assigned'
    | 'started'
    | 'paused'
    | 'canceled'
    | 'completed'
    | 'commented'
    | 'activated'
    | 'deactivated'

export const getChronologyEventMeta = (type: ChronologyEventType | string): {
    label: string
    icon: LucideIcon
    color: string
} => {
    const metaMap: Record<ChronologyEventType, { label: string; icon: LucideIcon; color: string }> = {
        created: {
            label: 'Creado',
            icon: PlusCircle,
            color: 'bg-green-100 text-green-600 border-green-200'
        },
        updated: {
            label: 'Actualizado',
            icon: Edit,
            color: 'bg-blue-100 text-blue-600 border-blue-200'
        },
        deleted: {
            label: 'Eliminado',
            icon: Trash2,
            color: 'bg-red-100 text-red-600 border-red-200'
        },
        assigned: {
            label: 'Asignado',
            icon: UserCheck,
            color: 'bg-indigo-100 text-indigo-600 border-indigo-200'
        },
        started: {
            label: 'Iniciado',
            icon: Play,
            color: 'bg-yellow-100 text-yellow-600 border-yellow-200'
        },
        paused: {
            label: 'Pausado',
            icon: Pause,
            color: 'bg-orange-100 text-orange-600 border-orange-200'
        },
        canceled: {
            label: 'Cancelado',
            icon: XCircle,
            color: 'bg-gray-100 text-gray-600 border-gray-200'
        },
        completed: {
            label: 'Completado',
            icon: CheckCircle2,
            color: 'bg-emerald-100 text-emerald-600 border-emerald-200'
        },
        commented: {
            label: 'Comentado',
            icon: MessageCircle,
            color: 'bg-cyan-100 text-cyan-600 border-cyan-200'
        },
        activated: {
            label: 'Activado',
            icon: ShieldCheck,
            color: 'bg-lime-100 text-lime-600 border-lime-200'
        },
        deactivated: {
            label: 'Desactivado',
            icon: ShieldOff,
            color: 'bg-zinc-100 text-zinc-600 border-zinc-200'
        }
    }

    return metaMap[type as ChronologyEventType] ?? {
        label: type,
        icon: MessageCircle,
        color: 'bg-muted text-foreground border-border'
    }
}
