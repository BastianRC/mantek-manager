import { useQuery } from "@tanstack/vue-query"
import { getAll } from "../services/ChronologyService"
import type { Chronology } from "../types/Chronology"

export const useGetChronologiesList = () => {
    return useQuery<Chronology[]>({
        queryKey: ['chronologies'],
        queryFn: getAll
    })
}