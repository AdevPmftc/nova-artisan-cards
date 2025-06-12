<template>
  <Card class="flex flex-col justify-center min-h-8">
    <div class="px-4 py-4 flex justify-between items-center">
      <div class="flex-grow pr-2">
        <h3 class="text-lg font-bold">Refresh Database</h3>
        <p>This will wipe the database and do a database migration, effectively putting the app into a clean slate.</p>
        <p><span class="font-bold">Warning:</span> Make sure you're not wiping production data.</p>
        <br/>
        <p class="text-xs" v-if="card.last_migrate_fresh_at">Last refresh was at <span class="font-bold">{{ lastMigrateFreshAt }}</span></p>
      </div>
      <div class="shrink-0 ml-4">
        <Button
          @click="showModal = true"
          ref="confirmButton"
          state="danger"
        >
          Refresh Database
        </Button>
      </div>
    </div>
    <ConfirmActionModal
      :show="showModal"
      title="Refresh Database"
      message="Are you sure you want to refresh the database? This will wipe the database and do a database migration, effectively putting the app into a clean slate."
      @confirm="handleConfirm"
      confirmButtonState="danger"
      confirmButtonText="Refresh Database"
      @close="handleClose"
    />
  </Card>
</template>

<script>

import ConfirmActionModal from "../Modals/ConfirmActionModal.vue";
import {Button} from "laravel-nova-ui";
import {DateTime} from "luxon";

export default {
  components: {Button, ConfirmActionModal},
  props: [
    'card',
    // The following props are only available on resource detail cards...
    // 'resource',
    // 'resourceId',
    // 'resourceName',
  ],
  data() {
    return {
      loading: false,
      showModal: false,
    };
  },
  methods: {
    async handleConfirm() {
      this.loading = true;
      try {
        const response = await Nova.request()
          .post('/nova-vendor/nova-artisan-cards/artisan/migrate-fresh', {
            // Add any data you need to send with the request here
          });
        console.log('Database refreshed successfully:', response);
        // Redirect user back to /
        window.location.href = '/';
      } catch (error) {
        console.error('Error refreshing database:', error);
        // Handle error here
      } finally {
        this.showModal = false;
        this.loading = false;
      }
    },
    handleClose() {
      this.showModal = false;
      this.loading = false;
    },
    convertDateTime(dateTime) {
      return DateTime.fromISO(dateTime)
        .setZone(this.timezone)
        .toLocaleString({
          year: 'numeric',
          month: '2-digit',
          day: '2-digit',
          hour: '2-digit',
          minute: '2-digit',
          timeZoneName: 'short',
        })
    },
  },
  computed: {
    lastMigrateFreshAt() {
      // if this.card.maintenance_mode_since doesn't have a value, return
      if (!this.card.last_migrate_fresh_at) {
        return null;
      }
      return this.convertDateTime(this.card.last_migrate_fresh_at)
    },
  },
};
</script>
