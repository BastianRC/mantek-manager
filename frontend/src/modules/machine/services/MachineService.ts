import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import type { Machine } from "../types/Machine"
import type { CreateMachinePayload } from "../types/CreateMachinePayload"
import type { UpdateMachinePayload } from "../types/UpdateMachinePayload"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"
import type { MachineDetails } from "../types/MachineDetails"


export const getAll = async (): Promise<Machine[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<Machine[]>>('/machines')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getById = async (id: number): Promise<MachineDetails> => {
    try {
        const response = await useHttpQuery<BaseResponse<MachineDetails>>(`/machines/${id}`)
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const create = async (payload: CreateMachinePayload): Promise<MachineDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<MachineDetails>>('/machines', {
            method: 'POST',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const update = async (id: number, payload: UpdateMachinePayload): Promise<MachineDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<MachineDetails>>(`/machines/${id}`, {
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
        await useHttpRequest(`/machines/${id}`, {
            method: 'DELETE'
        })
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}