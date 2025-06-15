import { useQuery } from "@tanstack/vue-query"
import { getById } from "../services/LocationService"
import type { LocationDetails } from "../types/LocationDetails"

export const useGetLocationById = (id: Ref<number | null>) => {
    return useQuery<LocationDetails>({
        queryKey: ['location', id],
        queryFn: async () => getById(id.value!),
        enabled: computed(() => id.value !== null),
        refetchOnWindowFocus: true
    })
}