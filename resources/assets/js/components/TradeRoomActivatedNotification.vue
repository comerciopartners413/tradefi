<template>
    <div v-if="activated" class="text-center">Trade room has been activated. <a href="/trade-room">Reload Page</a></div v-if="activated">
</template>

<script>
    export default {
        data() {
            return {
               activated: false
            }
        },
        props: ['user'],
        created(){
                 
        },
        mounted() {
          Echo.private(`traderoom.${this.user}`)
                .listen('TradeRoomActivated', (e) => {
                    this.activated =  true;
            });
        }
    }
</script>
