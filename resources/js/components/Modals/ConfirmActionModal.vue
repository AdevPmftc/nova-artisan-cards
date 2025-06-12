<template>
  <Modal :show="show" size="sm">
    <form
      @submit.prevent="handleConfirm"
      class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
      style="width: 460px"
    >
      <slot>
        <ModalHeader v-text="title" />
        <ModalContent>
          <p class="leading-normal">
            {{ message }}
          </p>
        </ModalContent>
      </slot>

      <ModalFooter>
        <div class="ml-auto">
          <LinkButton
            type="button"
            dusk="cancel-restore-button"
            @click.prevent="handleClose"
            class="mr-3"
          >
            {{ __('Cancel') }}
          </LinkButton>

          <Button
            type="submit"
            ref="confirmButton"
            :loading="working"
            :state="confirmButtonState"
          >
            {{ confirmButtonText }}
          </Button>
        </div>
      </ModalFooter>
    </form>
  </Modal>
</template>

<script>
import { Button } from 'laravel-nova-ui'

export default {
  components: {
    Button,
  },

  emits: ['confirm', 'close'],

  props: {
    show: { type: Boolean, default: false },
    message: { type: String, default: 'Are you sure you want to do this action?' },
    title: { type: String, default: 'Confirm Action' },
    confirmButtonText: { type: String, default: 'Confirm' },
    confirmButtonState: { type: Button.ButtonState, default: 'default' },
  },

  data: () => ({
    working: false,
  }),

  watch: {
    show(showing) {
      if (showing === false) {
        this.working = false
      }
    },
  },

  methods: {
    handleClose() {
      this.$emit('close')
      this.working = false
    },

    handleConfirm() {
      this.$emit('confirm')
      this.working = true
    },
  },
}
</script>
