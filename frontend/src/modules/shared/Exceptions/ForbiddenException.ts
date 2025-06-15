import { AppException } from "./AppException";

export class ForbiddenException extends AppException {
  constructor(message = 'No tienes permisos.') {
    super(message, 403)
  }
}
