<template>
    <button v-if="verb" class="btn btn-warning" @click.prevent="update()">{{ verb }}</button>
</template>

<script>
    export default {
        data() {
            return {
                // if verb is null in the template, the user is probably not logged in..
                verb: null
            }
        },
        props: {
            topicSlug: null
        },
        methods: {
            update() {
var that = this;
                 axios.post('/forum/topics/' + this.topicSlug + '/subscription', {
            }).then(function(response){
              console.log(response);
               that.getStatus();
            }).catch(function(error){
                console.log(error)
            })
            },
            getStatus() {
var that = this;
                 axios.get('/forum/topics/' + this.topicSlug + '/subscription/status', {
            }).then(function(response){
                console.log('response', response)
                        if (response.data == null) {
                            // subscribed
                            that.verb = 'Unsubscribe';
                        } else {
                            // not subscribed
                            that.verb = 'Subscribe';
                        }
            }).catch(function(error){

            })


            }
        },
        mounted() {
            this.getStatus();
            console.log('sample')
        }
    }
</script>
