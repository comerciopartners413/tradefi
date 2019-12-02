<template>
   <li class="dropdown dropdown-notifications">
                            <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i :data-count="unreadNotifications.length" :class="[ unreadNotifications.length <= 0 ? 'no-noti': '']" class="glyphicon glyphicon-bell notification-icon"></i>
                            </a>


                            <div class="dropdown-container dropdown-position-bottomright">

                                <div class="dropdown-toolbar">
                                    <div class="dropdown-toolbar-actions" v-if="unreadNotifications.length > 0">
                                        <a @click.prevent="markAsRead()">Mark all as read</a>
                                    </div>
                                    <h3 class="dropdown-toolbar-title">Notifications (2)</h3>
                                </div>
                                <div class="clearfix"></div>
                                <!-- /dropdown-toolbar -->

                                <ul class="dropdown-menu">
                                  

                                     <notification-item v-for="unread in unreadNotifications" :key="unread.id"  :unread="unread"></notification-item>
                                     <div v-if="unreadNotifications.length <= 0" class="text-center" style="padding: 20px">
                                       No new Notifications
                                     </div>

                                </ul>

                                <div class="dropdown-footer text-center">
                                    <!-- <a href="{{ route('profile.index') }}">View All</a> -->
                                </div>
                                <!-- /dropdown-footer -->

                            </div>
                            <!-- /dropdown-container -->
    </li>
</template>

<script>
import NotificationItem from './NotificationItem.vue';
    export default {
        data(){
            return {
                unreadNotifications:this.unreads
            }
        },
        props: ['unreads', 'userId'],
        components: {
            NotificationItem
        },
        created() {
            // console.log('Component is mounted.');
            let that = this;
            Echo.private('App.User.' + this.userId)
                .notification((notification) => {
                    console.log(notification);
                    let newUnreadNotification = { 
                       transaction_type_id: notification.data.transaction_type_id,
                                product_id: notification.data.product_id,
                                description: notification.data.description,
                                price: notification.data.price,
                                user: notification.data.user 
                   };
                    that.unreadNotifications.push({"data": newUnreadNotification});
                    // console.log('here: '+this.unreadNotifications);
            });
        }, 
        methods : {
          markAsRead() {
            let that = this;
            axios.post(`/mark-as-read/${this.userId}`, {
            }).then(function(response){
              console.log(response);
              that.unreadNotifications = [];
            }).catch(function(error){

            })
          }
        }
    }
</script>

<style type="text/css">
    .no-noti::after {
        background: #222;
        color: #fff; 
    }

</style>
