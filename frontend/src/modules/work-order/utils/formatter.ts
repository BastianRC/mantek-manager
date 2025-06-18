export function formatWorkedHours(hours: number | null | undefined): string {
  if (hours === null || hours === undefined) return '---';

  const totalMinutes = Math.round(hours * 60);
  const wholeHours = Math.floor(totalMinutes / 60);
  const minutes = totalMinutes % 60;

  const parts: string[] = [];
  if (wholeHours > 0) parts.push(`${wholeHours}h`);
  if (minutes > 0 || wholeHours === 0) parts.push(`${minutes}min`);

  return parts.join(' ');
}