import { useQuery } from "@tanstack/vue-query"
import type { Chronology } from "../types/Chronology"
import { getByUserId } from "../services/ChronologyService"


export const useGetChronologyByUserId = (id: Ref<number | null>) => {
    return useQuery<Chronology[]>({
        queryKey: ['chronology', 'user', id],
        queryFn: async () => getByUserId(id.value!),
        enabled: computed(() => id.value !== null),
        refetchOnWindowFocus: true
    })
}