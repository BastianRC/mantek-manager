import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import type { Location } from "../types/Location"
import type { CreateLocationPayload } from "../types/CreateLocationPayload"
import type { UpdateLocationPayload } from "../types/UpdateLocationPayload"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"
import type { LocationDetails } from "../types/LocationDetails"

export const getAll = async (): Promise<Location[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<Location[]>>('/locations')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getById = async (id: number): Promise<LocationDetails> => {
    try {
        const response = await useHttpQuery<BaseResponse<LocationDetails>>(`/locations/${id}`)
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const create = async (payload: CreateLocationPayload): Promise<LocationDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<LocationDetails>>('/locations', {
            method: 'POST',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const update = async (id: number, payload: UpdateLocationPayload): Promise<LocationDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<LocationDetails>>(`/locations/${id}`, {
            method: 'PATCH',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const destroy = async (id: number): Promise<void> => {
    try {
        await useHttpRequest(`/locations/${id}`, {
            method: 'DELETE'
        })
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}