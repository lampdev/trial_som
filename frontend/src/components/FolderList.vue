<template>
  <b-card-group
    columns
  >
  <div v-for="(item, index) in folders" :key="index">
    <b-card>
      <b-row>
        <b-col @click="test(item.id)" cols="8">
          <i class="fas fa-folder"></i>
          {{item.title}}
        </b-col>
        <b-col cols="4">
          <b-dropdown variant="link" toggle-class="text-decoration-none" no-caret>
          <template v-slot:button-content>
            <i class="fas fa-ellipsis-h"></i>
          </template>
          <b-dropdown-item @click="$emit('edit', item, index)">Edit</b-dropdown-item>
          <b-dropdown-item @click="$emit('delete', item.id, index)">Delete</b-dropdown-item>
        </b-dropdown>
        </b-col>
      </b-row>
    </b-card>
  </div>
  </b-card-group>
</template>
<script>
export default {
  props: {
    folders: {
      required: true,
      type: Array
    }
  },

  methods: {
    test (id) {
      this.$router.push({ name: 'folder.view', params: { folder_id: id } })
    }
  }
}
</script>
