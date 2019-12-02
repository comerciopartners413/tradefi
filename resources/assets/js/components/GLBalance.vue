<template>
    <span>₦{{ gl_balance }}</span>
</template>

<script>
import Accounting from 'accounting-js';
    export default {
        data() {
            return {
                gl_balance: 0
            }
        },
        props: ['main_balance', 'user_id'],
        created(){
                // this.gl_balance = this.main_balance
                 Echo.private(`deal-executed.${this.user_id}`).listen('DealExecuted', (e) => {
                console.log('data',e);
                this.gl_balance = Accounting.formatNumber(e.data.ClearedBalance);
            });
        },
        mounted() {
           this.gl_balance = this.main_balance
        }
    }
</script>
