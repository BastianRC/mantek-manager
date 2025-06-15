import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"
import type { LocationTypeOptions } from "../types/LocationTypeOptions"
import type { LocationSystemOptions } from "../types/LocationSystemOptions"


export const getAllTypes = async (): Promise<LocationTypeOptions[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<LocationTypeOptions[]>>('/locations/types')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getAllSystems = async (): Promise<LocationSystemOptions[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<LocationSystemOptions[]>>('/locations/systems')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}