<template>
  <div>
    <Alert
      :folderName="folderNameForAlert"
      :isCreate="isCreate"
      :isRestore="isRestore"
      @undo-delete-folder="undoDeleteFolder"
      ref="alert"
    />
    <b-card title="Folders">
      <FolderList
        :folders="folders"
        @edit="editFolder"
        @delete="deleteFolder"
      />
      <b-button @click="openModal()">New Folder</b-button>
    </b-card>
    <NewFolder
			ref="folder"
			:form="newFolder"
      :isEdit="isEdit"
			@close="closeModal"
			@create="addFolder"
      @hide-modal="resetForm"
      @update="updateFolder"
		/>
  </div>
</template>
<script>
import Form from 'vform'
import axios from 'axios'
import NewFolder from '@/components/NewFolder'
import FolderList from '@/components/FolderList'
import Alert from '@/components/Alert'
import Vue from 'vue'

export default {
  data () {
		return {
      folders: [],
      isEdit: false,
      idEditFolder: null,
      indexEditFolder: null,
      folderNameForAlert: '',
      isCreate: true,
      lastDeleteIdFolder: null,
      isRestore: false,
      newFolder: new Form({
        id: 0,
				title: '',
				parent_id: 0
			}),
		}
	},

	components: {
    NewFolder,
    FolderList,
    Alert
  },

  async mounted () {
    this.getFolders()
    let parent_id = this.$route.params.folder_id
    this.newFolder = new Form({
      id: 0,
      title: '',
      parent_id: parent_id
    })
  },

  methods: {
		openModal () {
      this.isEdit = false
      this.$refs.folder.show()
		},
		closeModal () {
			this.newFolder.reset()
		},
		async addFolder () {
      const {data} = await this.newFolder.post(process.env.VUE_APP_BACKEND_URL + '/api/folders')
      this.folderNameForAlert = data.data.title
      this.isCreate = true
      this.isRestore = false
      this.$refs.alert.showAlert()
      this.resetForm()
      this.$refs.folder.close()
      this.folders.push(data.data)
    },
    editFolder (item, index) {
      this.isEdit = true
      this.indexEditFolder = index
      this.idEditFolder = item.id
      this.newFolder.id = item.id
      this.newFolder.title = item.title
      this.$refs.folder.show()
    },
    resetForm () {
      this.newFolder.reset()
      this.idEditFolder = null
    },
    async updateFolder () {
      const { data } = await this.newFolder.patch(process.env.VUE_APP_BACKEND_URL + '/api/folders/' + this.idEditFolder)
      Vue.set(this.folders, this.indexEditFolder, data.data)
      this.resetForm()
      this.$refs.folder.close()
      this.indexEditFolder = null
    },
    async deleteFolder (id, index) {
      const { data } = await axios.delete(process.env.VUE_APP_BACKEND_URL + '/api/folders/' + id)
      this.isCreate = false
      this.folderNameForAlert = data.data.title
      this.lastDeleteIdFolder = data.data.id
      this.folders.splice(index, 1)
      this.isRestore = false
      this.$refs.alert.showAlert()
    },
    async undoDeleteFolder () {
      const { data } = await axios.post(process.env.VUE_APP_BACKEND_URL + '/api/folders/' + this.lastDeleteIdFolder + '/restore')
      this.folders.push(data.data)
      this.isRestore = true
      this.$refs.alert.restore()
    },
    async getFolders () {
      const { data } = await axios.get(process.env.VUE_APP_BACKEND_URL + '/api/folders/' + this.$route.params.folder_id)
      this.folders = data.data
    }

  },

  watch: {
    $route () {
      this.getFolders();
      let parent_id = this.$route.params.folder_id
      this.newFolder = new Form({
        id: 0,
        title: '',
				parent_id: parent_id
      })
    }
  }
}
</script>