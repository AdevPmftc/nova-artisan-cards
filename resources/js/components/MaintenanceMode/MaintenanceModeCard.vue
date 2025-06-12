<template>
  <Card class="flex flex-col justify-center min-h-8">
    <div class="px-4 py-4 flex justify-between items-center">
      <div class="flex-grow pr-2">
        <h3 class="text-lg font-bold">
          Maintenance Mode
          <span>
            <MaintenanceModeBadge :isDownForMaintenance="card.is_down_for_maintenance"/>
          </span>
        </h3>
        <div v-if="!isDownforMaintenance">
          <p>This will put the application into maintenance mode.</p>
          <br/>
          <p class="text-xs" v-if="card.last_up_at && card.maintenance_mode_since">
            Last maintenance was from <span class="font-bold">{{ maintenanceModeSince }}</span> to <span class="font-bold">{{ lastUpAt }}</span>
          </p>
        </div>
        <div v-else>
          <p>The site is currently in maintenance mode.</p>
          <p>
            Bypass using this link:
            <a class="link-default" target="_blank"
               href="{{ card.maintenance_mode_bypass_url }}">{{ card.maintenance_mode_bypass_url }}
            </a>
          </p>
          <br/>
          <p class="text-xs" v-if="card.maintenance_mode_since">In maintenance mode since: <span class="font-bold">{{ maintenanceModeSince }}</span></p>
        </div>
      </div>
      <div class="shrink-0 ml-4">
        <Button
          v-if="!isDownforMaintenance"
          @click="showDownModal = true"
          state="danger"
        >
          Enable Maintenance Mode
        </Button>
        <Button
          v-if="isDownforMaintenance"
          @click="showUpModal = true"
          state="default"
        >
          Disable Maintenance Mode
        </Button>

      </div>
    </div>
    <EnableMaintenanceModeModal
      :show="showDownModal"
      title="Maintenance Mode"
      message="Are you sure you want to put the application into maintenance mode? This will make the application unavailable to users."
      @confirm="handleDownConfirm"
      confirmButtonState="danger"
      confirmButtonText="Maintenance Mode"
      @close="handleClose"
    />
    <ConfirmActionModal
      :show="showUpModal"
      title="Disable Maintenance Mode"
      message="Are you sure you want to disable maintenance mode? This will make the application available to users."
      @confirm="handleUpConfirm"
      confirmButtonState="default"
      confirmButtonText="Disable Maintenance Mode"
      @close="handleClose"
    />
  </Card>
</template>

<script>

import ConfirmActionModal from "../Modals/ConfirmActionModal.vue";
import EnableMaintenanceModeModal from "./Modals/EnableMaintenanceModeModal.vue";
import {Button} from "laravel-nova-ui";
import MaintenanceModeBadge from "./Badges/MaintenanceModeBadge.vue";
import { DateTime } from 'luxon'

export default {
  components: {
    MaintenanceModeBadge,
    Button,
    ConfirmActionModal,
    EnableMaintenanceModeModal,
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
      loading: false,
      showDownModal: false,
      showUpModal: false,
      isDownforMaintenance: this.card.is_down_for_maintenance,
    };
  },
  methods: {
    async handleDownConfirm(secret) {
      this.loading = true;
      try {
        const response = await Nova.request()
          .post('/nova-vendor/nova-artisan-cards/artisan/down', {
            'secret': secret,
          });
        // Redirect user back to /
        window.location.href = '/' + secret;
      } catch (error) {
        console.error('Error putting app in maintenance mode:', error);
        // Handle error here
      } finally {
        this.showModal = false;
        this.loading = false;
      }
    },
    async handleUpConfirm(secret) {
      this.loading = true;
      try {
        const response = await Nova.request()
          .post('/nova-vendor/nova-artisan-cards/artisan/up');
        // Redirect user back to /
        window.location.href = '/';
      } catch (error) {
        console.error('Error disabling maintenance mode:', error);
        // Handle error here
      } finally {
        this.showUpModal = false;
        this.loading = false;
      }
    },
    handleClose() {
      this.showDownModal = false;
      this.showUpModal = false;
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
    maintenanceModeSince() {
      // if this.card.maintenance_mode_since doesn't have a value, return
      if (!this.card.maintenance_mode_since) {
        return null;
      }
      return this.convertDateTime(this.card.maintenance_mode_since)
    },
    lastUpAt() {
      // if this.card.last_up_at doesn't have a value, return
      if (!this.card.last_up_at) {
        return null;
      }
      return this.convertDateTime(this.card.last_up_at)
    },
  },
};
</script>
