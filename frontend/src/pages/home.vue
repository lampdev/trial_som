<template>
  <card :title="$t('home')">
    {{ $t('you_are_logged_in') }}
    <b-button
      variant="primary"
      @click="$route.push({name: 'folder'}) "
    >
      Folders
    </b-button>
  </card>
</template>

<script>
export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  },
}
</script>
