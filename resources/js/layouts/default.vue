<template>
  <div class="main-layout h-100">
    <navbar/>

    <div class="container mt-4 h-100">
      <child/>
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  name: 'MainLayout',

  components: {
    Navbar
  }
}
</script>
