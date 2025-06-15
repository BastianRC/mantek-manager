export function getNestedValue(obj: any, key: string): string {
  return key
    .split('.')
    .reduce((acc, part) => acc?.[part] ?? '', obj)
}