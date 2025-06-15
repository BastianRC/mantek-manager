import type { ColumnDef } from '@tanstack/vue-table'
import { h } from 'vue'
import GenericTableFilter from './GenericTableFilter.vue'
import Button from '@/components/ui/button/Button.vue'
import { ChevronsUpDown, type LucideIcon } from 'lucide-vue-next'

type WithGenericFilterOptions<T> = {
    getValue?: (value: any, row: T) => string
}

export function withGenericFilter<T>(
    accessorKey: keyof T,
    label: string,
    icon: LucideIcon,
    options?: WithGenericFilterOptions<T>
): ColumnDef<T> {
    return {
        accessorKey: accessorKey as string,
        filterFn: (row, columnId, filterValue) => {
            if (!Array.isArray(filterValue)) return true

            const raw = row.getValue(columnId)
            const value = options?.getValue ? options.getValue(raw, row.original) : String(raw ?? '-')

            return filterValue.includes(value)
        },
        header: ({ column, table }) => {
            const values = table.getPreFilteredRowModel().rows.map(row =>
                row.getValue(accessorKey as string)
            )

            const displayValues = values
                .map((v, i) => {
                    const row = table.getPreFilteredRowModel().rows[i].original
                    return options?.getValue ? options.getValue(v, row) : String(v ?? '-')
                })
                .filter(Boolean)

            const unique = [...new Set(displayValues)]
            const elementOptions = unique.map(v => ({
                label: v,
                value: v
            }))

            return h(GenericTableFilter, {
                modelValue: (column.getFilterValue() ?? []) as string[],
                'onUpdate:modelValue': (value: string[] | undefined) =>
                    column.setFilterValue(value),
                elements: elementOptions,
                sortState: column.getIsSorted(),
                onToggleSort: () => column.toggleSorting(),
                onUpdateSortState: () => column.clearSorting()
            }, {
                default: () =>
                    h(Button, { variant: 'ghost', class: 'gap-2' }, () => [
                        h(icon, { class: 'size-4' }),
                        label,
                    ])
            })
        },
        cell: ({ row }) => {
            const raw = row.getValue(accessorKey as string)
            const value = options?.getValue
                ? options.getValue(raw, row.original)
                : String(raw ?? '-')


            return h('div', {}, value)
        }
    }
}
