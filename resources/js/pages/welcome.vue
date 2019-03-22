<template>
  <div class="container">
    <div class="top-right links" style="z-index:99">
      <template v-if="authenticated">
        <a href="/dashboard">Dashboard</a>
      </template>
      <template v-if="!authenticated">
        <a href="#" @click.prevent="showLogin()">
          {{ $t('login') }}
        </a>
      </template>
    </div>


    <div class="row">
      <div class="col-12 text-center">
          <div class="mb-4 mt-4">
            <img style="max-width: 100px;" src="/images/logo.png" class="mb-4">
            <h3>General Roxas Elementary School</h3>
          </div>
          <div>
            <h6>Computer Aided Instruction for ESP3</h6>
          </div>

          <div>
            <transition name="modal">
              <div v-if="show_login" class="modal" style="display: block; overflow-y: auto;">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <app-login @close="show_login = false"></app-login>
                  </div>
                </div>
              </div>
            </transition>
          </div>
      </div> 
    </div>

    <div class="row">
      <div class="col-12 text-center">

        <carousel v-if="images.length" :autoplay="true" :per-page="1" :center-mode="true">
          <slide class="p-1" v-for="(image, index) in images" :key="index">

          <div class="text-center">
            <img width="600" height="500" :src="image" >
            <br>
          </div>
             <!--  -->
          </slide>
        </carousel>

      </div> 
    </div>
    <hr>
      
    <div class="row">
      <div class="col-12 text-center">
        <h4>History</h4>
        <p>
          General Roxas Elementary School stands on a 11,000 meter rolling parcel of land right on the heart of Barangay Roxas two blocks away east of the Amoranto Stadium, adjoining the Barangay Health Center,Barangay Hall and the Holy Family Church.
        </p>

        <p>
          It is surrounded by a concrete perimeter fence two meter in height. It enclosed by Madre Silva St. on the North, Lilac St. on the South and on the East by Jasmin St. where the main gate is located.
        </p>
        <p>
          General Roxas was established last 1949, offering primary level. On 1954-1955 the first batch of Grade VI graduated on this school, from then on it became a full pledge public elementary school of Quezon City.
        </p>
        <p>
          In 1977, a special class for the mentally gifted/ fast learners was organized by Mrs. Teresa P. Mantala, the General Roxas Elementary School SPED Coordinator. In 1983 Mrs. Marilyn O. Lingayo organized a special class for the Mentally Retarded. The special class for the Visually-impaired was organized in 1994 by Mrs. Leonar B. Belisario. On the following year, Hearing –Impaired class was organized by Mr. Praxedes C. Adeva. Another teacher with a big heart for children with special needs came and she is Mrs. Antonieta R. Casamorin, she organized a class for Intellectual Disabilities catering different ages. At present the schools caters children with special needs and continue to address the different exceptionalities so they will become a fully functional person in the community.
        </p>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12 text-center">
        <h4>Mission</h4>
        <br>
        <p>
          To protect and promote the right of every Filipino to quality, equitable, culture-based and complete basic education where:
        </p>
        <p>
          Students learn in a child-friendly, gender-sensitive, safe and motivating environment
        </p>
        <p>
          Teachers facilitate learning and constantly nurture every learner
        </p>
        <p>
          Administrator and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen
        </p>
        <p>
          Family, community and other stakeholders are actively engaged and share responsibility for developing lifelong learners.
        </p>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12 text-center">
        <h4>Vision</h4>
        <br>
        <p>We dream of Filipinos</p>
        <p>Who passionately love their country and whose competencies and values</p>
        <p>enable them to realize their full potential</p>
        <p>and contribute meaningfully to building the nation.</p>
        <br>
        <p>We are a learner-centered public institution,</p>
        <p>the Department of Education</p>
        <p>continuously improves itself</p>
        <p>to better serve its stakeholders.</p>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12 text-center">
        <h4>Core Values</h4>
        <br>
        <p>Maka-Diyos</p>
        <p>Maka-Tao</p>
        <p>Makakakalikasan</p>
        <p>Makabansa</p>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12 text-center">
        <p class="small">General Roxas Elementary School &copy; 2019</p>
        <p class="small">Contact Us - 412-23-49</p>
      </div>
    </div>

  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
import { mapGetters } from 'vuex'
import LoginComponent from '~/components/auth/login.vue'
import { playSound } from '~/helpers'


export default {
  layout: 'basic',
  metaInfo () {
    return { title: this.$t('home') }
  },

  components: {
    Carousel,
    Slide,
    'app-login': LoginComponent
  },

  data: () => ({
    title: window.config.appName,
    images: window.images,
    show_login: false
  }),

  computed: mapGetters({
    authenticated: 'auth/check',
    user: 'auth/user'
  }),

  mounted () {
    const sound = _.get(localStorage, 'play_sound')
    if (sound) {
      playSound(sound)
      _.set(localStorage, 'play_sound', '')
    }
  },
  
  methods: {
    showLogin (show = true) {
      this.show_login = show
    }
  },
}

</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
