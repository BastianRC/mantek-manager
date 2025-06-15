<script setup lang="ts">
import { cn } from '@/lib/utils'
import {
  ProgressIndicator,
  ProgressRoot,
  type ProgressRootProps,
} from 'reka-ui'
import { computed, type HTMLAttributes } from 'vue'

const props = withDefaults(
  defineProps<
    ProgressRootProps & {
      class?: HTMLAttributes['class']
      indeterminate?: boolean
    }
  >(),
  {
    modelValue: 0,
    indeterminate: false,
  },
)

const delegatedProps = computed(() => {
  const { class: _, indeterminate: __, ...delegated } = props
  return delegated
})
</script>

<template>
  <ProgressRoot
    data-slot="progress"
    v-bind="delegatedProps"
    :class="
      cn(
        'bg-primary/20 relative h-2 w-full overflow-hidden rounded-full',
        props.class,
      )
    "
  >
    <ProgressIndicator
      v-if="!props.indeterminate"
      data-slot="progress-indicator"
      class="bg-primary h-full w-full flex-1 transition-all"
      :style="`transform: translateX(-${100 - (props.modelValue ?? 0)}%);`"
    />
    <div
      v-else
      data-slot="progress-indicator"
      class="absolute top-0 left-0 h-full w-1/3 bg-primary animate-indeterminate-progress"
    />
  </ProgressRoot>
</template>

<style scoped>
@keyframes indeterminate-progress {
  0% {
    left: -50%;
  }
  100% {
    left: 100%;
  }
}

.animate-indeterminate-progress {
  animation: indeterminate-progress 1.5s infinite ease-out;
  position: absolute;
}
</style>
