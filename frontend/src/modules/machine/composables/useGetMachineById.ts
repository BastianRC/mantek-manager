import { useQuery } from "@tanstack/vue-query"
import { getById } from "../services/MachineService"
import type { MachineDetails } from "../types/MachineDetails"


export const useGetMachineById = (id: Ref<number | null>) => {
    return useQuery<MachineDetails>({
        queryKey: ['machine', id],
        queryFn: async () => getById(id.value!),
        enabled: computed(() => id.value !== null),
        refetchOnWindowFocus: true
    })
}