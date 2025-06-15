import { useQuery } from "@tanstack/vue-query"
import type { MachineType } from "../../types/MachineType"
import { getAll } from "../../services/MachineTypeService"

export const useGetMachineTypesList = () => {
    return useQuery<MachineType[]>({
        queryKey: ['machines_types'],
        queryFn: getAll,
        refetchOnWindowFocus: true,
        staleTime: 1000 * 60 * 2
    })
}