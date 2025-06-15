import { useMutation, useQueryClient } from "@tanstack/vue-query"
import type { CreateLocationPayload } from "../types/CreateLocationPayload"
import { create } from "../services/LocationService"
import { toast } from "vue-sonner"
import type { Location } from "../types/Location"
import type { LocationDetails } from "../types/LocationDetails"


export const useCreateLocation = () => {
    const queryClient = useQueryClient()

    return useMutation({
        mutationFn: (payload: CreateLocationPayload) => create(payload),
        onSuccess: (response: LocationDetails) => {
            toast.success(`Has añadido la ubicación ${response.name}`, {
                description: 'Se ha añadido la ubicación correctamente.'
            })

            queryClient.setQueryData(['locations'], (old: Location[] | undefined) => {
                if (!old) return [response]
                return [...old, response]
            })

            queryClient.setQueryData(['location', response.id], response)
        },
        onError: (error) => {
            toast.error('Ha ocurrido un error al intentar crear la ubicación.', {
                description: error.message
            })
        }
    })
}