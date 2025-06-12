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
                  <span>Secret</span>
                </label>
              </div>
              <div class="w-full space-y-2 md:w-3/5 @md/modal:w-3/5">
                <div class="space-y-1">
                  <input type="text" placeholder="Secret"
                         v-model="secret"
                         class="w-full form-control form-input form-control-bordered"
                         id="test-default-text-field" maxlength="-1">
                </div>
              </div>
              <!-- Create a copy button here -->
              <div class="w-full md:w-1/5 @md/modal:w-1/5">
                <button
                  type="button"
                  class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 relative disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&amp;:not(:disabled)]:bg-primary-400 hover:[&amp;:not(:disabled)]:border-primary-400 text-white dark:text-gray-900"
                  @click="generateSecret"
                >
                  Generate
                </button>
              </div>
            </div>
          </div>
          <p>
            Make sure to copy the secret so you can give to users who need to bypass maintenance mode
            using this link:
          </p>
          <div class="action">
            <div
              class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
            >
              <div class="w-full space-y-2 md:w-4/5 @md/modal:w-4/5">
                <div class="space-y-1">
                  <input type="text" placeholder="Secret"
                         readonly
                         v-model="baseUrlWithSecret"
                         class="w-full form-control form-input form-control-bordered"
                         id="test-default-text-field" maxlength="-1">
                </div>
              </div>
              <!-- Create a copy button here -->
              <div class="w-full md:w-1/5 @md/modal:w-1/5">
                <button
                  type="button"
                  class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 relative disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&amp;:not(:disabled)]:bg-primary-400 hover:[&amp;:not(:disabled)]:border-primary-400 text-white dark:text-gray-900"
                  @click="copyToClipboard(baseUrlWithSecret, 'Maintenance mode bypass link copied to clipboard')"
                >
                  Copy
                </button>
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
    // generate an alpha numeric secret 20 length randomly
    secret: Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15),
  }),

  watch: {
    show(showing) {
      if (showing === false) {
        this.working = false
      }
    },
  },

  computed: {
    baseUrlWithSecret() {
      return window.location.origin + '/' + this.secret;
    },

  },

  methods: {
    handleClose() {
      this.$emit('close')
      this.working = false
    },

    handleConfirm() {
      // If the secret is blank, show an alert
      if (this.secret === '') {
        alert('Secret cannot be blank')
        return
      }
      this.$emit('confirm', this.secret)
      this.working = true
    },

    copyToClipboard(text, successMessage) {
      navigator.clipboard.writeText(text).then(() => {
        Nova.success(successMessage || 'Copied to clipboard')
      })
    },

    generateSecret() {
      this.secret = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
    },
  },
}
</script>
