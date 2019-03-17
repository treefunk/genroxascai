<template>
	<div class="h-100">
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="ebook">{{ ebook.name }}</h2>
    </transition>
     <embed :src="getSrc()" width="100%" height="800" type="application/pdf">
  </div>
</template>
<script>
  import * as _ from 'lodash'
  import { mapGetters } from 'vuex'
  import Breadcrumbs from '~/components/breadcrumbs/index'
  export default {
    components: {
      'app-breadcrumbs': Breadcrumbs
    },
    computed: mapGetters({
      ebook: 'ebook/ebook',
    }),
    methods: {
      getType() {
        return this.ebook.mime_type
      },
      getSrc() {
        return '/storage/ebooks/' + this.ebook.file_name
      },
    },
    async mounted () {
      await this.$store.dispatch('ebook/clear')
      await this.$store.dispatch('ebook/get', {
        id: _.get(this.$route.params, 'ebook_id')
      });
    }

  }
</script>
