function sell_toggler(user_id, callback) {
    $('.trade-modal-toggler-for-sell').click(function(e) {
        e.preventDefault();
        
        console.log($(this).data('security-id'));
        $.ajax({
            url: '/simulation/fetch-trade-list-for-security',
            type: 'POST',
            dataType: 'JSON',
            data: {
                TransactionTypeID: 1,
                SecurityID: $(this).data('security-id')
            },
        }).done(function(data, status, jqXHR) {
            console.log(data);

            // clear modal
            $("#trademodal #bucketDetails tbody").html(' ');
            if (jqXHR.status == 200) {
                // return callback
                
                // load modal with data in loop
                $.each(data, function(index, val) {
                    $("#trademodal #bucketDetails tbody").append(`
                             <tr>
                               <!-- <td class="">${accounting.formatNumber(val.Quantity)}</td> -->
                                <td><a href="#" class="iSell" onclick="trade_proceed(1,11.45)">${accounting.formatNumber(val.Price, 2)}</a></td>
                                <td><input type="text" name="volume" autocomplete="off" class="form-control" /></td>            
                                <td>
                                <input type="hidden" name="DealSellQuantity" />

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
                                        class="btn btn-sm btn-w-md btn-success btn-rounded deal-btn"
                                    >iSell</a>
                                </td>            
                            </tr>
                        `);
                });
                $("#trademodal .modal-footer .security-name").html(data[0].Description);
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
                        $('#trademodal .cost_details').html('Consideration '+ 0.00);
                    }
                }).start()
                // magic

                // 
                $('.deal-btn').click(function(e) {
                    e.preventDefault();
                    // send params for deals
                    var that = $(this);
                    $.ajax({
                        url: '/simulation/post-deal',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            Pin: $("[name=trading-pin-sell]").val(),
                            TradeListRef: $(this).data('tradelist-ref'),
                            SecurityID: $(this).data('security-id'),
                            TransactionTypeID: $(this).data('transaction-type-id'),
                            CustomerID: $(this).data('customer-id'),
                            PriceMakerID: $(this).data('price-maker-id'),
                            Quantity: accounting.unformat($(this).parent().parent().find("[name=volume]").val()),
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
                        } else if (data[0].Status == 200) {
                            that.parent().parent().find("[name=volume]").val(0)
                            toastr.success("Deal Done");
                             that.text('iSell');
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
            url: '/simulation/fetch-trade-list-for-security',
            type: 'POST',
            dataType: 'JSON',
            data: {
                TransactionTypeID: 2,
                SecurityID: $(this).data('security-id')
            },
        }).done(function(data, status, jqXHR) {
            console.log(data);
            // clear modal
            $("#trademodal-buy #bucketDetails-buy tbody").html(' ');
            if (jqXHR.status == 200) {
                // load modal with data in loop
                $.each(data, function(index, val) {
                    $("#trademodal-buy #bucketDetails-buy tbody").append(`
                             <tr>
                               <!-- <td class="">${accounting.formatNumber(val.Quantity)}</td> -->
                                <td><a href="#" class="iSell">${accounting.formatNumber(val.Price, 2)}</a></td>
                                <td><input type="text" name="volume" class="form-control" value="${ that.data('volume') === undefined ? 0 : that.data('volume')}"/></td>            
                                <td>
                                <input type="hidden" name="DealSellQuantity" />

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
                                        class="btn btn-sm btn-w-md btn-success btn-rounded deal-btn"
                                    >iBuy</a>
                                </td>            
                            </tr>
                        `);
                });
                $("#trademodal-buy .modal-footer .security-name").html(data[0].Description);
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
                    var pin = $("[name=trading-pin-buy]").val();
                    // console.log(pin)
                    $.ajax({
                        url: '/simulation/post-deal',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            Pin: $("[name=trading-pin-buy]").val(),
                            TradeListRef: $(this).data('tradelist-ref'),
                            SecurityID: $(this).data('security-id'),
                            TransactionTypeID: $(this).data('transaction-type-id'),
                            CustomerID: $(this).data('customer-id'),
                            PriceMakerID: $(this).data('price-maker-id'),
                            Quantity: accounting.unformat($(this).parent().parent().find("[name=volume]").val()),
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
                        } else if (data[0].Status == 200) {
                            that.parent().parent().find("[name=volume]").val(0)
                            toastr.success("Deal Done");
                            that.text('iBuy');
                        }
                    }).fail(function(error) {
                        console.log(error);
                        that.text('iBuy');
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
}