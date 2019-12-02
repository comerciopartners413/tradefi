<template>
    <div>
        <div class="panel panel-filled" v-if="tradedata.length <= 0" style="padding: 10px; text-align: center ">
            No Deals for today...
        </div>
        <div class="vertical-timeline-block" v-for="trade in tradedata">

        <transition name="fade">
                    <div class="vertical-timeline-content tradeCard">
                        <div style=" padding: 0px 15px !important">
                            <span class="vertical-date pull-right"> <small></small> </span>

                            <!-- <h2><b>Placeholder</b></h2> -->
                            <div class="row" v-if="trade.TransactionTypeID == 1">
                                <div class="col-md-12 " align="">

                                    <h5 class="m-b-none server1" style="color: gold">{{ trade.Description }}</h5>

                                     <h1 style="font-size: 15px;" class="m-b-none server1">{{ trade.Quantity }}</h1>

                                    <h3 style="font-size: 12px;"><span style="font-size:12px">Bought @</span> <span style="color:#8CCA1D; font-size: 12px;" class="usage21">{{ trade.ProductID === "1" ? parseFloat(trade.Yield).toFixed(2) : parseFloat(trade.Price).toFixed(2)  }}%</span></h3>

                                </div>

                            </div>

                             <div class="row" v-if="trade.TransactionTypeID == 2">
                                <div class="col-md-12 " align="">

                                    <h5 class="m-b-none server1" style="color: gold">{{ trade.Description }}</h5>

                                     <h1 style="font-size: 15px;" class="m-b-none server1">{{ trade.Quantity }}</h1>
        
                                    <h3 style="font-size: 12px;"><span style="font-size:12px">Sold @</span> <span style="color:rgb(255, 0, 87); " class="usage21">{{ trade.ProductID == 1 ? parseFloat(trade.Yield).toFixed(2) : parseFloat(trade.Price).toFixed(2)  }}%</span></h3>
                                    
                                </div>

                            </div>

                        </div>

                    </div>
                </transition>
                </div>

    </div>
</template>

<script>
import Accounting from 'accounting-js';
import moment from 'moment';
    export default {
        data() {
            return {
                tradedata: []
            }
        },
        updated(){
            let vm = this;
            Echo.channel('general-executed-deal').listen('GeneralExecutedDeal', (e) => {
              console.log(e)
                if(vm.tradedata.length >= 3){
                    vm.tradedata.pop();
                }
                vm.tradedata.unshift({
                        ProductID: e.ProductID,
                        Description: e.Description,
                        InputDatetime:e.InputDatetime.date,
                        Price: e.Price,
                        Yield:e.Yield ,
                        Quantity: e.Quantity,
                        TransactionTypeID:e.TransactionTypeID,
                        ReadableTime: moment(e.InputDatetime.date).fromNow()
                    });

            });   
               
        },
        created(){
           
        },
        mounted() {
           let vm = this;
              axios.get('/last-5-trades', {

           }).then(function(response){
                 vm.tradedata = response.data
                 vm.tradedata.forEach(function(i,v){
                    i["ReadableTime"] = moment(i.InputDatetime).fromNow();
                    i["Yield"] = parseFloat(e.Yield).toFixed(4);
                    })
                 // console.log(vm.tradedata)
           }).catch(function(error){
            // console.log(error)
           });

           setInterval(function(){
            vm.tradedata.filter(function(index) {
                return index.ReadableTime = moment(index.InputDatetime).fromNow();
            });

           }, 1000);

        }, 
        methods: {
           fromMoment(v = new Date) {
            return moment(v).fromNow();
           }
        },
        computed: {
            
        },
        filters: {
           
        }

    }
</script>
<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
    small {
            color: #ffffff;
    font-weight: 600;
    font-size: 10px;
    position: absolute;
    top: 20px;
    right: 12px;
    }

    .tradeCard {
        /*border: 0;*/
       background-image: linear-gradient(to top, #09203f 0%, #537895 100%);
   }

   .vertical-timeline-content:after, .vertical-timeline-content:before {
border: 0;
content: none;
   }
</style>
