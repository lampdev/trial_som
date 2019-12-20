<template>
  <div>
    <b-modal
      id="newFolder"
      :title="getTitleName()"
      ref="newFolder"
      centered
      hide-footer
      @hide="$emit('hide-modal')"
    >
      <b-container fluid>
        <b-form @submit.prevent='addFolder' @keydown='form.onKeydown($event)'>
          <b-form-group>
            <label for="modal-title">Title</label>
            <b-form-input
              id="modal-title"
              name="title"
              v-model="form.title"
              :class="{'is-invalid': form.errors.has('title')}"
              required
            ></b-form-input>
            <has-error :form='form' field='title'></has-error>
          </b-form-group>
            <b-button
              variant="primary"
              @click="addFolder()"
              class='mr-2'
            >
              {{ getButtonName() }}
            </b-button>
            <b-button
              variant="primary"
              @click="close()"
            >
              Close
            </b-button>
        </b-form>
      </b-container>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: {
    form: {
      required: true,
      type: Object
    },
    isEdit: {
      type: Boolean,
      default: false
    }
  },

  methods: {
    show () {
      this.$refs.newFolder.show()
    },
    close () {
      this.$refs.newFolder.hide()
      this.$emit('close')
    },
    addFolder (index) {
      if (this.isEdit) {
        this.$emit('update')
      } else {
        this.$emit('create')
      }
    },
    getButtonName () {
      if (this.isEdit) {
        return 'Edit Folder'
      } else {
        return 'Create Folder'
      }
    },
    getTitleName () {
      if (this.isEdit) {
        return 'Edit Folder'
      } else {
        return 'Create Folder'
      }
    },
  }
}
</script>