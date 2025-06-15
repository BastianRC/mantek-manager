export const getMaintenanceStatusMeta = (nextDate: string | Date | null): {
    color: string
    label: string
} => {
    if (!nextDate) {
        return {
            label: 'Sin fecha',
            color: 'bg-gray-100 text-gray-800 border-gray-200'
        }
    }

    const today = new Date()
    const next = new Date(nextDate)
    const diffInDays = Math.floor((next.getTime() - today.getTime()) / (1000 * 60 * 60 * 24))

    if (diffInDays <= 0) {
        return {
            label: `${nextDate} (Vencido)`,
            color: 'text-red-600 border-red-200'
        }
    }

    if (diffInDays <= 30) {
        return {
            label: `${nextDate} (${diffInDays} días)`,
            color: 'text-yellow-600 border-yellow-200'
        }
    }

    return {
        label: `${nextDate} (${diffInDays} días)`,
        color: 'text-green-600 border-green-200'
    }
}
