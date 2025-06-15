import type { BaseResponse } from "~/modules/shared/types/BaseResponse";
import type { User } from "../types/User";
import type { UserDetails } from '../types/UserDetails'
import type { CreateUserPayload } from "../types/CreateUserPayload";
import type { UpdateUserPayload } from "../types/UpdateUserPayload";
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper";

export const getAll = async (): Promise<User[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<User[]>>('/users')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getById = async (id: number): Promise<UserDetails> => {
    try {
        const response = await useHttpQuery<BaseResponse<UserDetails>>(`/users/${id}`)
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const create = async (payload: CreateUserPayload): Promise<UserDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<UserDetails>>('/users', {
            method: 'POST',
            body: payload,
        })
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const update = async (id: number, payload: UpdateUserPayload): Promise<UserDetails> => {
    try {
        const response = await useHttpRequest<BaseResponse<UserDetails>>(`/users/${id}`, {
            method: 'PATCH',
            body: payload,
        })
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const destroy = async (id: number): Promise<void> => {
    try {
        await useHttpRequest(`/users/${id}`, {
            method: 'DELETE',
        })
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}