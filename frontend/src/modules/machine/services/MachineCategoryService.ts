import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"
import type { MachineCategory } from "../types/MachineCategory"
import type { CreateMachineCategoryPayload } from "../types/CreateMachineCategoryPayload"
import type { UpdateMachineCategoryPayload } from "../types/UpdateMachineCategoryPayload"

export const getAll = async (): Promise<MachineCategory[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<MachineCategory[]>>('/machines/categories')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const create = async (payload: CreateMachineCategoryPayload): Promise<MachineCategory> => {
    try {
        const response = await useHttpRequest<BaseResponse<MachineCategory>>('/machines/categories', {
            method: 'POST',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const update = async (id: number, payload: UpdateMachineCategoryPayload): Promise<MachineCategory> => {
    try {
        const response = await useHttpRequest<BaseResponse<MachineCategory>>(`/machines/categories/${id}`, {
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
        await useHttpRequest(`/machines/categories/${id}`, {
            method: 'DELETE'
        })
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}