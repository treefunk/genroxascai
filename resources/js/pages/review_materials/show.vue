<template>
	<div class="h-100">
    <app-breadcrumbs></app-breadcrumbs>
    <transition name="bounce">
      <h2 v-if="review_material">{{ review_material.name }}</h2>
    </transition>
    <object v-if="isVideoSWF()" autoplay="false" width="100%" height="100%" :data="getSrc()"></object>
    <video v-if="isVideoMP4()" width="100%" height="auto" controls @ended="videoEnd()">
      <source :src="getSrc()" :type="getType()">
      Your browser does not support the video tag.
    </video>
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
      review_material: 'review_material/review_material',
    }),
    methods: {
      async videoEnd () {
        console.log('Video ended')
        await this.$store.dispatch('review_material/finish', {
          review_material_id: _.get(this.review_material, 'id')
        });
      },
      getType() {
        return this.review_material.mime_type
      },
      getSrc() {
        return '/storage/review-materials/' + this.review_material.file_name
      },
      isVideoSWF() {
        return _.get(this.review_material, 'mime_type') === 'application/x-shockwave-flash'
      },
      isVideoMP4() {
        return _.get(this.review_material, 'mime_type') === 'video/mp4'
      }
    },
    async mounted () {
      await this.$store.dispatch('review_material/clear')
      await this.$store.dispatch('review_material/get', {
        id: _.get(this.$route.params, 'review_material_id')
      });
      await this.$store.dispatch('module/get', {
        id: _.get(this.$route.params, 'module_id')
      });
      await this.$store.dispatch('lesson/get', {
        id: _.get(this.$route.params, 'lesson_id')
      });
    }

  }
</script>
