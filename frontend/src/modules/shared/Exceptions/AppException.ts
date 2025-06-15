// shared/exceptions/AppException.ts
export class AppException extends Error {
    constructor(
        public override readonly message: string,
        public readonly code: number = 500
    ) {
        super(message)
        this.name = new.target.name
    }
}
