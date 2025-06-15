import { useQuery } from "@tanstack/vue-query"
import type { Chronology } from "../types/Chronology"
import { getByTarget } from "../services/ChronologyService"

export const useGetChronologyByTarget = (id: Ref<number | null>, target: Ref<string | null>) => {
    return useQuery<Chronology[]>({
        queryKey: ['chronology', target, id],
        queryFn: async () => getByTarget(id.value!, target.value!),
        enabled: computed(() => id.value !== null),
        refetchOnWindowFocus: true
    })
}