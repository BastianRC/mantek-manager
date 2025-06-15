import {
    ShieldCheck,
    Repeat,
    Activity,
    Search,
    Wand2,
    Scale,
    PanelTopClose,
    Sparkles,
    type LucideIcon
} from 'lucide-vue-next'

export const getWorkOrderTypeMeta = (type: string): {
    label: string
    icon: LucideIcon
    color: string
} => {
    const metaMap: Record<string, { label: string; icon: LucideIcon; color: string }> = {
        corrective: {
            label: 'Correctiva',
            icon: ShieldCheck,
            color: 'bg-red-100 text-red-800 border-red-200'
        },
        preventive: {
            label: 'Preventiva',
            icon: Repeat,
            color: 'bg-green-100 text-green-800 border-green-200'
        },
        predictive: {
            label: 'Predictiva',
            icon: Activity,
            color: 'bg-yellow-100 text-yellow-800 border-yellow-200'
        },
        inspection: {
            label: 'Inspección',
            icon: Search,
            color: 'bg-blue-100 text-blue-800 border-blue-200'
        },
        improvement: {
            label: 'Mejora',
            icon: Wand2,
            color: 'bg-indigo-100 text-indigo-800 border-indigo-200'
        },
        legal: {
            label: 'Legal / Normativa',
            icon: Scale,
            color: 'bg-gray-100 text-gray-800 border-gray-200'
        },
        installation: {
            label: 'Instalación',
            icon: PanelTopClose,
            color: 'bg-orange-100 text-orange-800 border-orange-200'
        },
        cleaning: {
            label: 'Limpieza técnica',
            icon: Sparkles,
            color: 'bg-teal-100 text-teal-800 border-teal-200'
        }
    }

    return metaMap[type] ?? {
        label: type,
        icon: Search, // fallback
        color: 'bg-muted text-foreground border-border'
    }
}
