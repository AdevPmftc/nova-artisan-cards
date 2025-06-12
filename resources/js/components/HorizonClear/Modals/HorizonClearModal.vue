<template>
  <Modal :show="show" size="sm">
    <form
      @submit.prevent="handleConfirm"
      class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
      style="width: 460px"
    >
      <slot>
        <ModalHeader v-text="title"/>
        <ModalContent>
          <p class="leading-normal">
            {{ message }}
          </p>

          <div class="action">
            <div
              class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
            >
              <div class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5">
                <label for="test-default-text-field" class="inline-block leading-tight space-x-1">
                  <span>Queue</span>
                </label>
              </div>
              <div class="w-full space-y-2 md:w-3/5 @md/modal:w-3/5">
                <div class="space-y-1">
                  <input type="text" placeholder="default"
                         v-model="queue"
                         class="w-full form-control form-input form-control-bordered"
                         id="test-default-text-field" maxlength="-1">
                </div>
              </div>
            </div>
          </div>
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
import {Button} from 'laravel-nova-ui'

export default {
  components: {
    Button,
  },

  emits: ['confirm', 'close'],

  props: {
    show: {type: Boolean, default: false},
    message: {type: String, default: 'Are you sure you want to do this action?'},
    title: {type: String, default: 'Confirm Action'},
    confirmButtonText: {type: String, default: 'Confirm'},
    confirmButtonState: {type: Button.ButtonState, default: 'default'},
  },

  data: () => ({
    working: false,
    queue: "default",
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
      // If the secret is blank, show an alert
      if (this.queue === '') {
        alert('Queue cannot be blank')
        return
      }
      this.$emit('confirm', this.queue)
      this.working = true
    },
  },
}
</script>
