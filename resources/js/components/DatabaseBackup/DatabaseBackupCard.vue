<template>
  <Card class="flex flex-col justify-center min-h-8">
    <div class="px-4 py-4 flex justify-between items-center">
      <div class="flex-grow pr-2">
        <h3 class="text-lg font-bold">Database Backup</h3>
        <p>
          This will create a database backup in the following disks:
          <span class="font-bold">{{ card.backup_disks }}</span>
        </p>
        <br/>
        <p class="text-xs" v-if="card.last_database_backup_at">Last database backup was generated at <span
          class="font-bold">{{ lastDatabaseBackupAt }}</span></p>
      </div>
      <div class="shrink-0 ml-4">
        <Button
          @click="showModal = true"
          ref="confirmButton"
          state="default"
        >
          Backup Database
        </Button>
      </div>
    </div>
    <ConfirmActionModal
      :show="showModal"
      title="Create Database Backup"
      :message="'Are you sure you want to create a backup of the database? These will saved in the following disks: '+card.backup_disks"
      @confirm="handleConfirm"
      confirmButtonState="default"
      confirmButtonText="Backup Database"
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
        await Nova.request()
          .post('/nova-vendor/nova-artisan-cards/artisan/database-backup', {
            // Add any data you need to send with the request here
          });
      } catch (error) {
        console.error('Error creating a database backup:', error);
        alert('Error creating a database backup. Please try again later.')
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
    lastDatabaseBackupAt() {
      // if this.card.maintenance_mode_since doesn't have a value, return
      if (!this.card.last_database_backup_at) {
        return null;
      }
      return this.convertDateTime(this.card.last_database_backup_at)
    },
  },
};
</script>
