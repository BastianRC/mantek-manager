import { ForbiddenException } from "../Exceptions/ForbiddenException"
import { NotFoundException } from "../Exceptions/NotFoundException"
import { ServerErrorException } from "../Exceptions/ServerErrorException"
import { UnauthorizedException } from "../Exceptions/UnauthorizedException"


export class ErrorMapper {
  static fromHttp(error: any): Error {
    const status = error?.response?.status || error?.statusCode || 500

    switch (status) {
      case 401:
        return new UnauthorizedException()
      case 403:
        return new ForbiddenException()
      case 404:
        return new NotFoundException()
      case 500:
      default:
        return new ServerErrorException()
    }
  }
}
