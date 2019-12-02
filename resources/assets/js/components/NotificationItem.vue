<template>
     <li class="notification clearfix">
        <div class="media">
            <div class="media-left">
                <div class="media-object">
                    <img data-src="holder.js/50x50?bg=cccccc" class="img-circle" alt="50x50" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2250%22%20height%3D%2250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2050%2050%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15e7acd5c97%20text%20%7B%20fill%3A%23919191%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15e7acd5c97%22%3E%3Crect%20width%3D%2250%22%20height%3D%2250%22%20fill%3D%22%23cccccc%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%226.46875%22%20y%3D%2229.5%22%3E50x50%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="width: 50px; height: 50px;">
                </div>
            </div>
            <div class="media-body">
                <span class="notification-title"><a href="#">You</a> 
                <span v-if="unread.data.transaction_type_id == 1" style="color: green">Purchased</span>
                    <span style="color: red" v-else> Sold</span> 
                  <strong>
                    <span v-if="unread.data.product_id == 1">Bonds</span>
                    <span v-else>TBills</span>
                  </strong>
                </span>

                <p class="notification-desc"><b>{{ unread.data.description }}</b> at rate <b>{{ unread.data.price }}</b></p>
                <div class="clearfix"></div>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: ['unread'],
    }
</script>

<style scoped>
  .notification-item > .heading {
    padding-bottom: 15px;
    font-size: 12px !important;
  }
</style>
