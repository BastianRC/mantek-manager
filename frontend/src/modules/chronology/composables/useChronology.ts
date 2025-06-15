// composables/useChronology.ts
import { useGetChronologyByTarget } from './useGetChronologyByTarget'
import { useGetChronologyByUserId } from './useGetChronologyByUserId'
import { useGetChronologiesList } from './useGetChronologiesList'
import { computed, type Ref } from 'vue'

export const useChronology = (
    id: Ref<number | null>,
    target: Ref<string | null>
) => {
    const enabled = computed(() => true)

    if (id.value && target.value) {
        return useGetChronologyByTarget(id, target)
    }

    if (id.value) {
        return useGetChronologyByUserId(id)
    }

    return useGetChronologiesList()
}
