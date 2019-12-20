<template>
  <div>
    <b-alert
      :show="dismissCountDown"
      dismissible
      variant="success"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
    >
      {{getAlerText()}} <b-button v-if="!isCreate && !isRestore" @click="UndoDeletedFolder">Undo</b-button>
    </b-alert>

  </div>
</template>

<script>
export default {
  props: {
    isCreate: {
      type: Boolean,
      default: true
    },
    folderName: {
      type: String,
      required: true 
    },
    isRestore: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      dismissSecs: 5,
      dismissCountDown: 0
    }
  },

  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs
    },
    getAlerText () {
      if (this.isCreate) {
        return 'Your folder ' + this.folderName + ' has been created'
      } else if (this.isRestore) {
        return 'Your trash items have been restored'
      } else {
        return 'Your folder has been deleted'
      }
    },
    UndoDeletedFolder () {
      this.$emit('undo-delete-folder')
    },
    restore () {
      this.dismissCountDown = 0
      this.showAlert()
    }
  }
}
</script>