import { PlayCircle, PauseCircle, Hourglass } from 'lucide-vue-next'

export const getWorkOrderStateMeta = (isStarted: boolean, isPaused: boolean) => {
  if (!isStarted) {
    return {
      label: 'No iniciada',
      icon: Hourglass,
      color: 'bg-muted text-muted-foreground border-border',
      emoji: '⏳',
    }
  }

  if (isPaused) {
    return {
      label: 'Pausada',
      icon: PauseCircle,
      color: 'bg-yellow-100 text-yellow-600 border-yellow-200',
      emoji: '⏸️',
    }
  }

  return {
    label: 'Iniciada',
    icon: PlayCircle,
    color: 'bg-blue-100 text-blue-600 border-green-200',
    emoji: '▶️',
  }
}
