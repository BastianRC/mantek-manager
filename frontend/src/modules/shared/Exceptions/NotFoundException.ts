import { AppException } from "./AppException";

export class NotFoundException extends AppException {
  constructor(message = 'Recurso no encontrado.') {
    super(message, 404)
  }
}
