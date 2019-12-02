<div class="modal left fade in scrollbar" id="trademodal-buy" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
            <div class="modal-dialog">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="modal-body " style="padding:10px">

                            <div class="table-responsive" id="bucketDetails-buy">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>iBuy</th>
                                            <th>Volume</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                            </div>

                            <div id="orderSelector" style="background: #ffd89b;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #19547b, #ffd89b);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #19547b, #ffd89b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
 border-radius:10px; display:none;padding: 10px 20px 10px 10px;color:white">

                                <div class="row">
                                    <div class="col-md-6">

                                        <h4 color: "#ffdead">Volume Details </h4>

                                    </div>
                                    <div class="col-md-6" align="right">
                                        <!-- <img id="cspio-logo" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" width="100px"> -->
                                    </div>
                                </div>
                                <div align="center">

                                    <table style="color:black">
                                        <tbody>

                                            <tr>
                                                <td class="tdH">Security :</td>
                                                <td class="td2"><b><span>FGN2030</span></b></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Volume : </td>
                                                <td class="td2">
                                                    <form id='myform' method='POST' action='#'>
                                                        <input type='button' value='-' class='qtyminus' field='quantity' />
                                                        <input type='text' name='quantity' value='0' class='qty' />
                                                        <input type='button' value='+' class='qtyplus' field='quantity' />
                                                    </form>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Price :</td>
                                                <td class="td2"><span>₦ 200,000</span> (<span style="color:green">₦378,000)</span>)</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                    <hr/>

                                    <div class="row" align="right" id="btnbuy1">
                                        <button class="btn btn-w-md btn-default" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="trade_action_buy(2, 2.89)">Proceed &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                </div>

                            </div>
                            <!-- order details -->

                            <div id="orderDetails" style="background: #ffd89b;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #19547b, #ffd89b);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #19547b, #ffd89b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
 border-radius:10px; color: black;display:none;padding: 10px 20px 10px 10px;">

                                <!-- <a href="#" onclick="reset_trade_action(2, 2.89)">Reset</a> -->
                                <div class="row">
                                    <div class="col-md-6">

                                        <h4>Ticket Details </h4>

                                    </div>
                                    <div class="col-md-6" align="right">
                                        <img id="cspio-logo" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" width="100px">
                                    </div>
                                </div>
                                <div align="center">

                                    <table style="color:black">
                                        <tbody>
                                            <tr>
                                                <td class="tdH"> Name :</td>
                                                <td class="td2"><span>Christopher Enaboifo</span></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Security :</td>
                                                <td class="td2"><b><span>FGN2030</span></b></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Volume : </td>
                                                <td class="td2">
                                                    <!--  <form id='myform' method='POST' action='#'>
                                                  <input type='button' value='-' class='qtyminus' field='quantity' />
                                                  <input type='text' name='quantity' value='0' class='qty' />
                                                  <input type='button' value='+' class='qtyplus' field='quantity' />
                                              </form> -->
                                                    <b><span>30</span></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Price :</td>
                                                <td class="td2"><span>₦ 600,000</span></td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Yield :</td>
                                                <td class="td2">11.23</td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Settlement :</td>
                                                <td class="td2"><span>January 1, 2019</span></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Principal Accrued:</td>
                                                <td class="td2"><span id="prefix" contenteditable=""></span><span>Nil</span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr/>

                                    <div class="row" align="right" id="btnbuy" style="display:none">
                                        <button class="btn btn-w-md btn-default" style="background-color:brown; border-color:brown;color:white" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:snow; border-color:snow;color:black" onclick="trade_proceed(2, 2.89)"><i class="fa fa-arrow-circle-o-left"></i> Go Back &nbsp; </button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="pay()">iBuy &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                    <div class="row" align="right" id="btnsell" style="display:none">
                                        <button class="btn btn-w-md btn-default" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="pay()">iSell &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                </div>

                            </div>
                            <!-- order details -->

                        </div>

                        <div class="modal-footer">
                            <span class="pull-left security-name">
                                
                            </span>
                            <a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded">Dismiss Window</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>