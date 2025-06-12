<template>
  <Card class="flex flex-col justify-center min-h-8">
    <div class="px-4 py-4 flex justify-between items-center">
      <div class="flex-grow pr-2">
        <h3 class="text-lg font-bold">
          Seed Database
        </h3>
        <p>This will run the provided database seeder class.</p>
      </div>
      <div class="shrink-0 ml-4">
        <Button
          @click="showModal = true"
          state="default"
        >
          Seed Database
        </Button>
      </div>
    </div>
    <DatabaseSeedModal
      :show="showModal"
      title="Seed Database"
      message="This will run the provided seeder class."
      @confirm="handleConfirm"
      confirmButtonState="danger"
      confirmButtonText="Seed Database"
      @close="handleClose"
    />
  </Card>
</template>

<script>
import {Button} from "laravel-nova-ui";
import DatabaseSeedModal from './Modals/DatabaseSeedModal.vue'

export default {
  components: {
    DatabaseSeedModal,
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
      loading: false,
      showModal: false,
    };
  },
  methods: {
    async handleConfirm(seederClass) {
      this.loading = true;
      try {
        const response = await Nova.request()
          .post('/nova-vendor/nova-artisan-cards/artisan/database-seed', {
            'seederClass': seederClass,
          });
        // Redirect user back to /
        alert(response.data.output);
      } catch (error) {
        console.error('Error seeding database:', error);
        // Handle error here
        alert('Database Seeder experienced an error');
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
