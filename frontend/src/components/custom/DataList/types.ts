export interface FilterOption {
    value: string
    label: string
}

export type FilterType = 'boolean' | 'category' | 'custom'

export interface FilterDefinition {
    key: string
    label: string
    type: FilterType
    options?: FilterOption[]
    dynamic?: boolean
}

export interface FilterCardProps {
    items: any[]
    searchKeys: string[]
    filters?: FilterDefinition[]
    itemsPerPageOptions?: number[]
    title?: string
    gridClass?: string
}