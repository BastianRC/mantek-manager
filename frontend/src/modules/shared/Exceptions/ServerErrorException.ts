import { AppException } from "./AppException";

export class ServerErrorException extends AppException {
  constructor(message = 'Error del servidor.') {
    super(message, 500)
  }
}
