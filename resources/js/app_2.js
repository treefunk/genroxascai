/**
 * 
 * seperate instance for the teacher/admin 
 * 
 */

import Vue from 'vue'


// components
import CreateTestForm from './_components/CreateTestForm';


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

