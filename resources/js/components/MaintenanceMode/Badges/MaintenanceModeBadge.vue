<template>
  <div class="inline-block">
    <Badge
      class="whitespace-nowrap inline-flex items-center min-h-6 px-2 rounded-full uppercase text-xs font-bold whitespace-nowrap inline-flex items-center"
      :class="{
        'bg-red-100 text-red-600 dark:bg-red-400 dark:text-red-900': isDownForMaintenance,
        'bg-green-100 text-green-600 dark:bg-green-400 dark:text-green-900': !isDownForMaintenance,
      }"
    >
        <span class="mr-1 -ml-1">
          <Icon
            v-if="isDownForMaintenance"
            :solid="true"
            type="exclamation-circle"
          />
          <Icon
            v-if="!isDownForMaintenance"
            :solid="true"
            type="check-circle"
          />
        </span>
      {{ (isDownForMaintenance) ? 'Down' : 'Up' }}
    </Badge>
  </div>
</template>

<script>
export default {
  props: {
    isDownForMaintenance: Boolean,
  }
}
</script>
