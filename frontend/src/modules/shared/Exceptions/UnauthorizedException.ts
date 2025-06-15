import { AppException } from "./AppException";

export class UnauthorizedException extends AppException {
  constructor(message = 'No autorizado.') {
    super(message, 401)
  }
}
