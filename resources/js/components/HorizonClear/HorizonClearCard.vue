<template>
  <Card class="flex flex-col justify-center min-h-8">
    <div class="px-4 py-4 flex justify-between items-center">
      <div class="flex-grow pr-2">
        <h3 class="text-lg font-bold">
          Horizon Clear
        </h3>
        <p>This will delete all jobs from a specified queue.</p>
      </div>
      <div class="shrink-0 ml-4">
        <Button
          @click="showModal = true"
          state="default"
        >
          Clear Queue
        </Button>
      </div>
    </div>
    <HorizonClearModal
      :show="showModal"
      title="Horizon Clear"
      message="This will clear all jobs from Horizon queue."
      @confirm="handleConfirm"
      confirmButtonState="danger"
      confirmButtonText="Clear Queue"
      @close="handleClose"
    />
  </Card>
</template>

<script>

import HorizonClearModal from "./Modals/HorizonClearModal.vue";
import {Button} from "laravel-nova-ui";

export default {
  components: {
    Button,
    HorizonClearModal,
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
      showModal: false,
    };
  },
  methods: {
    async handleConfirm(queue) {
      this.loading = true;
      try {
        const response = await Nova.request()
          .post('/nova-vendor/nova-artisan-cards/artisan/horizon-clear', {
            'queue': queue,
          });
        // Redirect user back to /
        alert(response.data.output);
      } catch (error) {
        console.error('Error clearing horizon queue:', error);
        // Handle error here
        alert('Horizon clear experienced an error');
      } finally {
        this.showModal = false;
        this.loading = false;
      }
    },
    handleClose() {
      this.showModal = false;
    },
  },
};
</script>
