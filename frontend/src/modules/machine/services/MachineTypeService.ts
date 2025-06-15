import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"
import type { MachineType } from "../types/MachineType"
import type { CreateMachineTypePayload } from "../types/CreateMachineTypePayload"
import type { UpdateMachineTypePayload } from "../types/UpdateMachineTypePayload"

export const getAll = async (): Promise<MachineType[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<MachineType[]>>('/machines/types')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const create = async (payload: CreateMachineTypePayload): Promise<MachineType> => {
    try {
        const response = await useHttpRequest<BaseResponse<MachineType>>('/machines/types', {
            method: 'POST',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const update = async (id: number, payload: UpdateMachineTypePayload): Promise<MachineType> => {
    try {
        const response = await useHttpRequest<BaseResponse<MachineType>>(`/machines/types/${id}`, {
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
        await useHttpRequest(`/machines/types/${id}`, {
            method: 'DELETE'
        })
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}