import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import type { Chronology } from "../types/Chronology"
import { ErrorMapper } from "~/modules/shared/Mappers/ErrorMapper"

export const getAll = async (): Promise<Chronology[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<Chronology[]>>('/chronologies')
        return response.data ?? []
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getByTarget = async (id: number, target: string): Promise<Chronology[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<Chronology[]>>(`/chronologies/target/${target}/${id}`)
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const getByUserId = async (id: number): Promise<Chronology[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<Chronology[]>>(`/chronologies/user/${id}`)
        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}