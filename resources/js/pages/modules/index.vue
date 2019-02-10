<template>
<div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter Module Name" v-model="new_module.name">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <button type="button" @click="addModule" class="btn btn-primary">Submit</button>
                    <div v-for="(single_module,index) in modules" :key="index" class="card border-secondary mb-3">
                        <div class="card-header">{{ single_module.name }}</div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title">{{ single_module.order }}</h5>
                            <p class="card-text">
                                <button class="btn btn-default" @click="moduleEdit(single_module.id)">
                                Edit
                                </button>
                                <button class="btn btn-default" @click="moduleDelete(index,single_module.id)">
                                Delete
                                </button>
                            </p>
                        </div>
                    </div>
                    <router-link :to="{name: 'teacher_dashboard'}">
                     Back
                    </router-link>
</div>
</template>

<script>
    import { api_able } from '../../mixins/api_able'
    import axios from 'axios'

    export default {
        mixins: [ api_able ],
        methods:{
            moduleEdit(id){
                this.$router.push(`/modules/edit/${id}`)
            },
            moduleDelete(index,id){
                axios.delete(`/api/modules/${id}`)
                .then(res => {
                    if(res.data.status == true){
                        let module = this.modules.splice(index,1)[0]
                        let new_modules = this.modules.map(m => {
                            if(m.order > module.order){
                                m.order = m.order - 1;
                            }
                            return m
                        })
                        this.modules = new_modules
                    }
                })
            },
            addModule(){
                let m = this.new_module;
                axios.post(`/api/modules`,this.new_module)
                .then(res => {
                    this.modules.push(res.data.module)
                })
            }
        },
        data(){
        return {
                modules: [],
                new_module: {
                    name: ''
                }
            }
        },
        beforeRouteEnter(from,to,next){
            axios.get('/api/modules').then(res => next(vm => { vm.setData('modules',res.data.modules)}))
        }
    }
</script>

<style scoped>

</style>