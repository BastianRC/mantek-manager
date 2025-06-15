import type { BaseResponse } from "~/modules/shared/types/BaseResponse"
import type { Permission } from "../types/Permission"
import { ErrorMapper } from "~/modules/shared/mappers/ErrorMapper"

export const getAll = async (): Promise<Permission[]> => {
    try {
        const response = await useHttpQuery<BaseResponse<Permission[]>>('/roles/permissions')
        return response.data ?? []
        
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}