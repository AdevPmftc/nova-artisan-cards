<template>
  <div v-if="isDownforMaintenance"
       class="px-4 py-4 rounded-lg flex justify-between items-center w-full min-h-6 bg-red-100 text-red-600 dark:text-red-900">
    <div class="flex-grow pr-2">
      <h3>
        <MaintenanceModeBadge :is-down-for-maintenance="isDownforMaintenance"/>
        <span class="ml-1">
          The application is currently in <span class="font-bold">Maintenance Mode</span>
        </span>
      </h3>
    </div>
  </div>
</template>

<script>

import {Button} from "laravel-nova-ui";
import MaintenanceModeBadge from "./Badges/MaintenanceModeBadge.vue";

export default {
  components: {
    MaintenanceModeBadge,
    Button,
  },
  props: [
    'card',
    // The following props are only available on resource detail cards...
    // 'resource',
    // 'resourceId',
    // 'resourceName',
  ],
  data() {
    return {
      isDownforMaintenance: this.card.is_down_for_maintenance,
    };
  },
};
</script>
