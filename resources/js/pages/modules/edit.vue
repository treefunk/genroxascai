<template>
    <div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter Module Name" v-model="module.name">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <button type="button" @click="updateModule" class="btn btn-primary">Submit</button>
            <router-link to="/modules">
                -- back to modules
            </router-link>
    </div>
</template>

<script>
    import { api_able } from '../../mixins/api_able'
    import axios from 'axios'

    export default {
        mixins: [ api_able ],
        data(){
            return {
                module: {}
            }
        },
        methods: {
            updateModule(){
                axios.patch(`/api/modules/${this.module.id}`, this.module)
                .then(res => {console.log(res)})
            }
        },
        beforeRouteEnter(to,from,next){
            axios.get(`/api/modules/${to.params.id}`).then(
                res => { next(vm => { vm.setData('module',res.data.module) })}
            )
        },
        beforeRouteUpdate(to,from,next){
            this.module = null
            axios.get(`/api/modules/${to.params.id}/edit`).then(
                res => { next(vm => { vm.setData('module',res.data.module) })}
            )
        }
    }
</script>

<style scoped>

</style>