<template>
  <div>
    <transition name="bounce">
      <h2 v-if="modules">Mga Yunit</h2>
    </transition>
    <transition-group name="zoom" class="row colored-cards">
      <div v-for="module in modules" :key="module.id" class="col-xl-3 col-sm-6 mb-4">
        <div class="card card-lock h-100" :class="{'item-locked': isLocked(module)}">
          <div class="card-body">
            <h5 class="card-title">{{ module.name }}</h5>
            <img style="max-width: 100%;" :src="getImagePath(module)"/>
            <p class="card-text">{{ module.description }}</p>
          </div>
          <div class="card-footer">
            <router-link :to="getLessonsRoute(module)" class="btn btn-primary">View
            </router-link>
          </div>
        </div>
      </div>
    </transition-group>
    <transition name="slideRight">
      <p v-if="isDataEmpty()">
        Wala pang bukas na yunit
      </p>
    </transition>

    <hr>

    <transition name="bounce">
      <h2 v-if="ebooks">Mga Libro</h2>
    </transition>

    <transition-group name="zoom" class="row colored-cards">
      <div v-for="ebook in ebooks" :key="ebook.id" class="col-xl-3 col-sm-6 mb-4">
        <div class="card card-lock h-100">
          <div class="card-body">
            <h5 class="card-title">{{ ebook.name }}</h5>
            <img style="max-width: 100%;" src="/images/cliparts/pdf.svg">
            <p class="card-text">{{ ebook.description }}</p>
          </div>
          <div class="card-footer">
            <router-link :to="getEBookRoute(ebook)" class="btn btn-primary">View
            </router-link>
          </div>
        </div>
      </div>
    </transition-group>

    <transition name="slideRight">
      <p v-if="isEBookEmpty()">
        Wala pang bukas na libro
      </p>
    </transition>
  </div>
</template>
<script>

  import { mapGetters } from 'vuex'
  import { getLessonsRoute, getEBookRoute, isLocked, playSound } from '~/helpers'

  export default {
    metaInfo() {
      return { title: 'Yunit' };
    },
    watch: {
    },
    components: {
    },
    computed: mapGetters({
      modules: 'module/all',
      ebooks: 'ebook/all',
    }),
    data() {
      return {
      };
    },
    methods: {
      isLocked(module) {
        return isLocked(module)
      },
      getImagePath(module) {
        if (_.get(module, 'file_name')) {
          return '/storage/images/modules/' + _.get(module, 'file_name')
        }
         return '/images/default-image-module.png'
      },
      isDataEmpty() {
        return _.get(this.modules, 'length') === 0
      },
      isEBookEmpty() {
        return _.get(this.ebooks, 'length') === 0
      },
      getLessonsRoute (module) {
        return getLessonsRoute(module)
      },
      getEBookRoute (ebook) {
        return getEBookRoute(ebook)
      },
    },
    async mounted () {
      await this.$store.dispatch('module/clear')
      await this.$store.dispatch('module/fetch', {
        is_open: 1
      });

      await this.$store.dispatch('ebook/fetch', {
        is_open: 1
      });

      const sound = _.get(localStorage, 'play_sound')
      console.log('localStorage:', localStorage)
      if (sound) {
        playSound(sound)
        _.set(localStorage, 'play_sound', '')
      }

    }
  };
</script>
