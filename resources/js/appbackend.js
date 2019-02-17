/**
 *
 * seperate instance for the teacher/admin
 *
 */

import Vue from 'vue'


// components
import CreateTestForm from './backend/components/CreateTestForm.vue';


let app2 = new Vue({
    el: "#wrapper",
    components: {
        'create-test-form': CreateTestForm
    }
})





import $ from 'jquery'
import 'bootstrap'
window.jQuery = $;
window.$ = $;

