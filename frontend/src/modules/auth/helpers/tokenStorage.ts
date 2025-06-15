export function setToken(token: string): void {
    useCookie('token').value = token;
}

export function clearToken(): void {
    useCookie('token').value = null;
}

export function getToken(): string | null | undefined {
    return useCookie('token').value;
}