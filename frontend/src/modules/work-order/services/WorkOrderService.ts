import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import type { WorkOrder } from "../types/WorkOrder"
import type { CreateWorkOrderPayload } from "../types/CreateWorkOrderPayload"
import type { UpdateWorkOrderPayload } from "../types/UpdateWorkOrderPayload"
import type { WorkOrderDetails } from "../types/WorkOrderDetails"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"

export const getAll = async (): Promise<WorkOrder[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<WorkOrder[]>>('/work-orders')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getById = async (id: number): Promise<WorkOrderDetails> => {
    try {
        const response = await useHttpQuery<BaseResponse<WorkOrderDetails>>(`/work-orders/${id}`)
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const create = async (payload: CreateWorkOrderPayload): Promise<WorkOrder> => {
    try {
        const response = await useHttpRequest<BaseResponse<WorkOrder>>('/work-orders', {
            method: 'POST',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const update = async (id: number, payload: UpdateWorkOrderPayload): Promise<WorkOrder> => {
    try {
        const response = await useHttpRequest<BaseResponse<WorkOrder>>(`/work-orders/${id}`, {
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
        await useHttpRequest(`/work-orders/${id}`, {
            method: 'DELETE'
        })
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}