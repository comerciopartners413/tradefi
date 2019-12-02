function sell_toggler(user_id, callback) {
    $('.trade-modal-toggler-for-sell').click(function(e) {
        e.preventDefault();
        
        console.log($(this).data('security-id'));
        $.ajax({
            url: '/trade-room/fetch-trade-list-for-security',
            type: 'POST',
            dataType: 'JSON',
            data: {
                TransactionTypeID: 1,
                SecurityID: $(this).data('security-id')
            },
        }).done(function(data, status, jqXHR) {
            console.log(data[0]);
            // if(data[0].TransactionTypeID == 1) {
                // BUY
                $('.yield-value').html(accounting.formatNumber(data[0].Yield, 2)+'%');
            // }  
            // if(data[0].TransactionTypeID == 2) {
                // BUY
                $('.discount-rate-value').html(accounting.formatNumber(data[0].Price, 2)+'%');
            // }
            if(data[0].ProductID == 1){
                // bonds was chosen
                $('.yield-view').show('fast');
                $('.discount-rate-view').hide('fast');
            } else {
                $('.yield-view').hide('fast');
                $('.discount-rate-view').show('fast');
            }
            // clear modal
            $("#trademodal #bucketDetails tbody").html(' ');
            if (jqXHR.status == 200) {
                // return callback
                // load modal with data in loop
                $.each(data, function(index, val) {
                    $("#trademodal #bucketDetails tbody").append(`
                             <tr>
                               <!-- <td class="">${accounting.formatNumber(val.Quantity)}</td> -->
                                <td><a href="#" class="iSell" onclick="trade_proceed(1,11.45)">${ data[index].ProductID == 1 ? accounting.formatNumber(val.Price, 2) : accounting.formatNumber(val.DirtyPrice, 2) }</a></td>
                                <td><input type="text" name="volume" autocomplete="off" class="form-control" /></td> 
                                <td>
                                <td><input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-sell" autocomplete="off" style="height: 30px">
                                <input type="hidden" name="DealSellQuantity" /> 
                                </td>            
                            </tr>
                            <tr> 
                             <td></td>
                                <td colspan="3">
                                <a  href="#"
                                        data-tradelist-ref = "${val.TradeListRef}"
                                        data-security-id="${val.SecurityID}"
                                        data-product-id="${val.ProductID}"
                                        data-price="${val.Price}"
                                        data-dirty-price="${val.DirtyPrice}"
                                        data-quantity=""
                                        data-price-maker-id="1"
                                        data-customer-id="${user_id}"
                                        data-transaction-type-id = "2"
                                        class="btn btn-sm btn-w-md btn-danger btn-block deal-btn"
                                    >iSell</a>
                                </td>
                            </tr>
                        `);
                });
                $("#trademodal .modal-body .security-name").html(data[0].Description);
                $("#trademodal").modal('show');
                callback();
                $(".countdown-sell").countdown360({
                    radius: 20,
                    seconds: 60,
                    fontColor: '#000000',
                    fillStyle: '#ffffff',
                    strokeStyle: '#f6a821',
                    autostart: false,
                    onComplete: function() {
                        $("#trademodal").modal('hide');
                        $('#trademodal .cost_details').html('Consideration ₦'+ 0.00);
                    }
                }).start()
                // magic

                // 
                $('.deal-btn').click(function(e) {
                    e.preventDefault();
                    // send params for deals
                    var that = $(this);
                    $.ajax({
                        url: '/trade-room/post-deal',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            Pin: $("[name=trading-pin-sell]").val(),
                            TradeListRef: $(this).data('tradelist-ref'),
                            SecurityID: $(this).data('security-id'),
                            TransactionTypeID: $(this).data('transaction-type-id'),
                            CustomerID: $(this).data('customer-id'),
                            PriceMakerID: $(this).data('price-maker-id'),
                            Quantity: accounting.unformat($(this).parent().parent().parent().find("[name=volume]").val()),
                            Price: $(this).data('price')
                        },
                        beforeSend: function(){
                            that.html('<i style="font-size: 16px" class="fa fa-circle-o-notch fa-spin"></i>');
                        }
                    }).done(function(data) {
                        console.log("deal done");
                        console.log(data[0].Status);
                        if (data[0].Status == 500) {
                            toastr.error("Insufficient Balance");
                         } else if(data[0].Status == 300){
                            toastr.error("Insufficient Market Volume");
                        } else if (data[0].Status == 200) {
                            that.parent().parent().find("[name=volume]").val(0)
                            toastr.success("Deal Done");
                             that.text('iSell');
                             $("#trademodal").modal('hide');
                             show_ticket(data[0].TradeDataRef);
                        }
                    }).fail(function(error) {
                        console.log(error);
                        that.text('iSell');
                        if (error.status == 500) {
                            toastr.error(error.statusText)
                        }
                    }).always(function() {
                        console.log("complete");
                    });
                });
            }
        }).fail(function() {
            console.log("error");

        }).always(function() {
            console.log("complete");
        });
    });
 callback;
}

function buy_toggler(user_id, callback) {
    $('.trade-modal-toggler-for-buy').click(function(e) {
        e.preventDefault();
        console.log($(this).data('volume'));
        var that = $(this);
        $.ajax({
            url: '/trade-room/fetch-trade-list-for-security',
            type: 'POST',
            dataType: 'JSON',
            data: {
                TransactionTypeID: 2,
                SecurityID: $(this).data('security-id')
            },
        }).done(function(data, status, jqXHR) {
            console.log(data);
             // if(data[0].TransactionTypeID == 1) {
                // BUY
                $('.yield-value').html(accounting.formatNumber(data[0].Yield, 2)+'%');
            // }  
            // if(data[0].TransactionTypeID == 2) {
                // BUY
                $('.discount-rate-value').html(accounting.formatNumber(data[0].Price, 2)+'%');
            // }
            if(data[0].ProductID == 1){
                // bonds was chosen
                $('.yield-view').show('fast');
                $('.discount-rate-view').hide('fast');
            } else {
                $('.yield-view').hide('fast');
                $('.discount-rate-view').show('fast');
            }
            // clear modal
            $("#trademodal-buy #bucketDetails-buy tbody").html(' ');
            if (jqXHR.status == 200) {
                // load modal with data in loop
                $.each(data, function(index, val) {
                    if(val.buy_quantity > 100000) {
                        $("#trademodal-buy #bucketDetails-buy tbody").append(`
                             <tr>
                               <!-- <td class="">${accounting.formatNumber(val.Quantity)}</td> -->
                                <td><a href="#" class="iSell">${ data[index].ProductID == 1 ? accounting.formatNumber(val.Price, 2) : accounting.formatNumber(val.DirtyPrice, 2) }</a></td>
                                <td><input style="height: 30px; cursor: pointer;" type="text" name="volume" class="form-control" value="${ that.data('volume') === undefined ? 0 : that.data('volume')}"/></td>            
                                <td>
                                <td><input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-buy" autocomplete="off" style="height: 30px">
                                <input type="hidden" name="DealSellQuantity" /> 
                                </td> 
                                      
                            </tr>
                             <tr> 
                             <td></td>
                                <td colspan="3">
                                <a  href="#"
                                        data-tradelist-ref = "${val.TradeListRef}"
                                        data-security-id="${val.SecurityID}"
                                        data-product-id="${val.ProductID}"
                                        data-price="${val.Price}"
                                        data-dirty-price="${val.DirtyPrice}"
                                        data-quantity=""
                                        data-price-maker-id="1"
                                        data-customer-id="${user_id}"
                                        data-transaction-type-id = "1"
                                        class="btn btn-block btn-sm btn-w-md btn-success deal-btn"
                                    >iBuy</a>
                                </td>    
                            </tr>
                           
                        `);
                    } else {
                    $("#trademodal-buy #bucketDetails-buy tbody").append(`
                             <tr>
                               <!-- <td class="">${accounting.formatNumber(val.Quantity)}</td> -->
                                <td><a href="#" class="iSell">${ data[index].ProductID == 1 ? accounting.formatNumber(val.Price, 2) : accounting.formatNumber(val.DirtyPrice, 2) }</a></td>
                                <td><input style="height: 30px; cursor: pointer;" type="text" name="volume" class="form-control" value="${ that.data('volume') === undefined ? 0 : that.data('volume')}"/></td>            
                                <td>
                                <td><input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-buy" autocomplete="off" style="height: 30px">
                                <input type="hidden" name="DealSellQuantity" /> 
                                </td> 
                                      
                            </tr>
                             <tr> 
                             <td></td>
                                <td colspan="3">
                                <a  href="#"
                                        
                                        class="btn grey-class disabled btn-block btn-sm btn-w-md btn-success"
                                    >Low Voume</a>
                                </td>    
                            </tr>
                           
                        `);
                }
                });
                $("#trademodal-buy .modal-body .security-name").html(data[0].Description);
                $("#trademodal-buy").modal('show');
                callback();
                $(".countdown-buy").countdown360({
                    radius: 20,
                    seconds: 60,
                    fontColor: '#000000',
                    fillStyle: '#ffffff',
                    strokeStyle: '#f6a821',
                    autostart: false,
                    onComplete: function() {
                        $("#trademodal-buy").modal('hide');
                    }
                }).start()
                $('.deal-btn').click(function(e) {
                    e.preventDefault();
                    // send params for deals
                    var that = $(this);
                    var pin = $("#trademodal-buy #bucketDetails-buy tbody").find("[name=trading-pin-buy]").val();
                    console.log('pin',pin)
                    console.log('quantity', $(this).parent().parent().parent().find("[name=volume]").val());
                    $.ajax({
                        url: '/trade-room/post-deal',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            Pin: pin,
                            TradeListRef: $(this).data('tradelist-ref'),
                            SecurityID: $(this).data('security-id'),
                            TransactionTypeID: $(this).data('transaction-type-id'),
                            CustomerID: $(this).data('customer-id'),
                            PriceMakerID: $(this).data('price-maker-id'),
                            Quantity: accounting.unformat($(this).parent().parent().parent().find("[name=volume]").val()),
                            Price: $(this).data('price')
                        },
                        beforeSend: function(){
                            that.html('<i style="font-size: 16px" class="fa fa-circle-o-notch fa-spin"></i>');
                        }
                    }).done(function(data) {

                        if (data[0].Status == 500) {
                            toastr.error("Insufficient Balance");
                        } else if(data[0].Status == 300){
                            toastr.error("Insufficient Market Volume");
                        } else if (data[0].Status == 200) {
                            that.parent().parent().find("[name=volume]").val(0)
                            toastr.success("Deal Done");
                            that.text('iBuy');
                            $("#trademodal-buy").modal('hide');
                            show_ticket(parseInt(data[0].TradeDataRef));
                        }

                    }).fail(function(error) {
                        console.log(error);
                        that.text('iBuy');
                        if (error.status == 500) {
                            toastr.error(error.statusText)
                        }

                        if (error.status == 300) {
                            toastr.error(error.statusText)
                        }

                        if (error.status == 502) {
                            toastr.error(error.responseJSON.Quantity)
                        }
                    }).always(function() {
                        console.log("complete");
                    });
                });
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    });
}

// ticket after trade has been executed

function show_ticket(deal_id) {
    // alert('show ticket');
    // create a modal on the fly
    var ticket_modal = $("#trade-ticket");
    $.ajax({
        url: '/trade-room/get-ticket-details',
        type: 'POST',
        data: {
            TradeDataRef : deal_id
        }
    })
    .done(function(data) {
        // populate modal with ticket details
        console.log('tradedata', data);
        ticket_modal.find('.modal-body').html(`
            <table class="table table-striped table-condensed samp">
                <tbody>
                 <tr>
                        <td>Maturity</td>
                        <td>${data.maturity}</td>
                    </tr>
                    <tr>
                        <td>Transaction Type</td>
                        <td>${  data.trade.TransactionTypeID == 1 ? '<label class="label label-success">PURCHASE</label>' : '<label class="label label-danger">SALE</label>' }</td>
                    </tr>
                    <tr>
                        <td>Trade Date</td>
                        <td>${moment(data.trade.TradeDate).format("MMM Do, YYYY") }</td>
                    </tr>
                    <tr>
                        <td>Settlement Date</td>
                        <td>${moment(data.trade.SettlementDate).format("MMM Do, YYYY") }</td>
                    </tr>
                    <tr>
                        <td>Nominal Amount</td>
                        <td>${accounting.formatNumber(data.trade.Quantity, 2)}</td>
                    </tr>
                    
                    

                    <tr>
                        <td>${ parseFloat(data.trade.DiscountRate) == 0 ? 'Yield' : 'Discount Rate' }</td>
                        <td>${ parseFloat(data.trade.DiscountRate) == 0 ? accounting.formatNumber(data.trade.Yield, 2) : accounting.formatNumber(data.trade.DiscountRate, 2) }</td>
                    </tr>
                     ${ data.trade.TransactionTypeID == 1 ? 
                         `<tr>
                            <td>Custody Fee</td>
                            <td>₦${accounting.formatNumber(data.trade.CustodyFee, 2)}</td>
                        </tr>` :
                        ``

                        }
                    ${parseFloat(data.trade.DiscountRate) == 0 ? 
                        `<tr>
                            <td>Clean Price</td>
                            <td>${accounting.formatNumber(data.trade.CleanPrice, 2)}</td>
                        </tr>
                        <tr>
                            <td>Dirty Price</td>
                            <td>${accounting.formatNumber(data.trade.DirtyPrice, 2)}</td>
                        </tr>
                        <tr>
                            <td>Consideration</td>
                            <td>₦${accounting.formatNumber(data.trade.SettlementAmount, 2) }</td>
                        </tr>
                       
                        <tr>
                            <td>Total Chargeable Fee</td>
                            <td>₦${accounting.formatNumber((parseFloat(data.trade.SettlementAmount) + parseFloat(data.trade.CustodyFee)), 2) }</td>
                        </tr>
                        <tr>
                        <td>Next Coupon Date</td>
                        <td>${moment(data.trade.NextCouponDate).format("MMM Do, YYYY") }</td>
                        </tr>` 
                        :
                        `
                        <tr>
                            <td>Total Chargeable Fee</td>
                            <td>₦${accounting.formatNumber((parseFloat(data.trade.SettlementAmount) + parseFloat(data.trade.CustodyFee)), 2) }</td>
                        </tr>
                        <tr>
                            <td>Bills Price</td>
                            <td>${accounting.formatNumber(data.trade.DirtyPrice, 2)}</td>
                        </tr>
                        <tr>
                            <td>Yield</td>
                            <td>${accounting.formatNumber(data.trade.Yield * 100, 2)}</td>
                        </tr>
                        <tr>
                            <td>Discounted Value</td>
                            <td>${accounting.formatNumber(data.trade.DiscountAmount, 2)}</td>
                        </tr>` 
                    }
                </tbody>
            </table>
        `);
         ticket_modal.modal();
    })
    .fail(function(error) {
        console.log(error);
    })
    .always(function() {
        console.log("complete");
    });
    

   
}