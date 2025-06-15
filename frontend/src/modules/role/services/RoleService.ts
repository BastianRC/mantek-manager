import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import type { Role } from "../types/Role"
import type { CreateRolePayload } from "../types/CreateRolePayload"
import type { UpdateRolePayload } from "../types/UpdateRolePayload"
import type { RoleDetails } from "../types/RoleDetails"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"

export const getAll = async (): Promise<Role[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<Role[]>>('/roles')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getById = async (id: number): Promise<RoleDetails> => {
    try {
        const response = await useHttpQuery<BaseResponse<RoleDetails>>(`/roles/${id}`)
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const create = async (payload: CreateRolePayload): Promise<RoleDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<RoleDetails>>('/roles', {
            method: 'POST',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const update = async (id: number, payload: UpdateRolePayload): Promise<RoleDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<RoleDetails>>(`/roles/${id}`, {
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
        await useHttpRequest(`/roles/${id}`, {
            method: 'DELETE'
        })
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}