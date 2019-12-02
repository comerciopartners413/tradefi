
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Accounting from 'accounting-js';
require('smartinput/smartinput');
Vue.component('gl-component', require('./components/GLBalance.vue'));
Vue.component('trade-room-activated-notification', require('./components/TradeRoomActivatedNotification.vue'));
Vue.component('trade-aside', require('./components/Aside.vue'));
Vue.component('notification', require('./components/Notification.vue'));
Vue.component('notification-item', require('./components/NotificationItem.vue'));
Vue.component('genie-component', require('./components/BotManTinker.vue'));

Vue.component('modify-users', require('./components/AdminModifyUsersComponent.vue'));
Vue.component('subscribe-button', require('./components/SubscribeButtonComponent.vue'));
Vue.component('report-topic-button', require('./components/ReportTopicComponent.vue'));
Vue.component('report-post-button', require('./components/ReportPostComponent.vue'));
Vue.component('delete-report', require('./components/ModeratorDeleteReportButtonComponent.vue'));
Vue.component('messaging', require('./components/UserMessagingComponent.vue'));

var VueResource = require('vue-resource');

const app = new Vue({
    el: '#tradeFIapp',
    data: {
    	gl_balance: Accounting.formatNumber(0)
    },
    created() {

    }
});


$('.smartinput').smartInput();

