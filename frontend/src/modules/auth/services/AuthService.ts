import type { BaseResponse } from "~/modules/shared/types/BaseResponse";
import type { Auth } from "../types/Auth";
import type { LoginPayload } from "../types/LoginPayload";
import { ErrorMapper } from "@/modules/shared/Mappers/ErrorMapper";
import type { AuthResponse } from "../types/AuthResponse";

export const login = async (payload: LoginPayload): Promise<AuthResponse> => {
    try {
        const response = await useHttpRequest<BaseResponse<AuthResponse>>('/auth/login', {
            method: 'POST',
            body: payload
        })

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const logout = async (): Promise<void> => {
    try {
        await useHttpRequest('/auth/logout', {
            method: 'POST',
        })

    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}

export const validate = async (): Promise<Auth> => {
    try {
        const response = await useHttpQuery<BaseResponse<Auth>>('/auth/validate')

        return response.data
    } catch (error) {
        throw ErrorMapper.fromHttp(error)
    }
}