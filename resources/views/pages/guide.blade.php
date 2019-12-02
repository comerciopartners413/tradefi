<html>
    <head>
        <meta charset="utf-8">
            <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
                <title>
                    TradeFi- Guide
                </title>
                <meta content="" name="description">
                    <meta content="width=1200, maximum-scale=1" name="viewport"/>
                    <link href="{{ asset('docs/assets/plugins/bootstrapv3/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
                    <link href="../assets/favicon.ico" rel="icon" type="image/x-icon"/>
                    <link href="{{ asset('docs/assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/bootstrap-select2/select2.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/ion-slider/css/ion.rangeSlider.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/ion-slider/css/ion.rangeSlider.skinFlat.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/jquery-nouislider/jquery.nouislider.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/bootstrap3-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/bootstrap-tag/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/dropzone/css/dropzone.css') }}" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/switchery/css/switchery.min.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('docs/assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css">
                        <link href="{{ asset('docs/assets/plugins/summernote/css/summernote.css') }}" media="screen" rel="stylesheet" type="text/css">
                            <link href="{{ asset('docs/assets/plugins/jquery-dynatree/skin/ui.dynatree.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                            <link href="{{ asset('docs/assets/plugins/jquery-dynatree/skin/ui.dynatree.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                            <link href="{{ asset('docs/assets/plugins/jquery-dynatree/skin/ui.dynatree.css') }}" media="screen" rel="stylesheet" type="text/css"/>
                            <link href="{{ asset('docs/pages/css/pages.css') }}" rel="stylesheet" type="text/css"/>
                            <link href="{{ asset('docs/assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
                            <link href="{{ asset('docs/assets/css/print.css') }}" rel="stylesheet" type="text/css"/>
                            <link href="{{ asset('docs/assets/plugins/highlight/styles/github.css') }}" rel="stylesheet" type="text/css"/>
                        </link>
                    </link>
                </meta>
            </meta>
        </meta>
    </head>
    <body class="index" data-spy="scroll" data-target=".sidebar">
        <header>
            <div class="container">
                <a class="logo" href="../index.html">
                    <!--<img src="assets/img/pages_logo_white.png" width="78" height="22"> -->
                    <img src="{{ asset('assets/images/logo-no-bg.jpg') }}" width="100px">
                    </img>
                </a>
            </div>
        </header>
        <div class="container p-t-70">
            <div class="container-inner">
                <nav class="sidebar ">
                    <div class="pg_scrollable">
                        <ul class="nav">
                            <li>
                                <ul class="nav" style="overflow: hidden; display: block;">
                                    <li class="active">
                                        <a href="#getting_started">
                                            Getting Started
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#pft">
                                            Placing Your First Trade
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#funding">
                                            Funding Your Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#buying">
                                            Buying A Security
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#selling">
                                            Selling A Security
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#withdrawing">
                                           Withdrawing From Your Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#info">
                                            My Information
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#portfolio">
                                            Checking Your Position
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#blotter">
                                           My Blotter
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#transactions">
                                            My Transactions
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#support">
                                            Submitting a Query or Complaint
                                        </a>
                                    </li>
                                </ul>
                        </ul>
                    </div>
                </nav>
                <div class="row">
                    <div class="col-md-9 col-sm-8 col-md-offset-3 col-sm-offset-4">
                        <div class="content">
                            <section id="introduction" style="padding-top:30px">
                                <h2 class="text-center">
                                    TrafeFi User Guide Documentation
                                </h2>
                                <h5 class="text-center">
                                    Designed to help investors trade better
                                </h5>
                                <hr>
                                    <h3 id="getting_started">
                                        Getting Started
                                    </h3>
                                    <p>
                                       Once you have created your account, you will be redirected to a page similar to the one below. This is your Dashboard which shows:
                                        <ul>
                                            <li>Closing prices for securities</li>
                                            <li>Your Portfolio: The securities on your portfolio</li>
                                            <li>Watch list: The securities you would like to keep a close eye on</li>
                                            <li>News: A news feed to keep you abreast of everything</li>
                                        </ul>
                                    </p>
                                    <div>
                                        <img src="{{ asset('assets/images/dashboard.svg') }}" class="img-responsive" alt="">
                                    </div>
                                </hr>
                            </section>
                            <section id="pft" style="padding-top:10px">
                                <h3 class="page-title">
                                    Placing your first trades

                                </h3>
                                    <h5 id="funding">
                                        Funding Your Account
                                    </h5>
                                    
                                        <p>
                                            There are two ways to fund your account. Either by using your card to make an online payment or sending the funds to our account.
                                        </p>

                                        <p>
                                            To fund your TradeFi account, you need to click on the ‘Available Balance’ in the top right of your screen.  Upon clicking, a window similar to the one shown below will pop up. Enter the value you would like to fund your account with and you would be redirected to the secure payment gateway to complete your payment.
                                        </p>
                                        <div>
                                            <img class="img-responsive" src="{{ asset('assets/images/funding.svg') }}">
                                        </div>
                                        <p>The NIBSS supported payment portal will be used to fund your account for the amount you stated.
 
</p>
                                        <div>
                                            <img class="img-responsive" src="{{ asset('assets/images/pay.svg') }}">
                                        </div>
                                        <p>
                                            Alternatively, you may also choose to fund your accounts through the direct deposit option. You would need to upload proof of payment made to the TradeFi bank account to ensure you get value in your account on TradeFi.
                                        </p>
                                        <div>
                                            <img class="img-responsive" src="{{ asset('assets/images/deposit.svg') }}">
                                        </div>
                                        
                                            <h4 id="buying">
                                                Buying a security
                                            </h4>
                                            <p>
                                                To purchase a security, from your dashboard, click on ‘My Trade Room’ and ‘Start trade’ this will bring you to “My Trade Room” shown below. The securities are Treasury bills and Bonds. Pick a security to buy by clicking “iBuy”. 
                                            </p>

                                            <div>
                                                <img class="img-responsive" src="{{ asset('assets/images/securities.png') }}">
                                            </div>

                                                <p>
                                                    Choose the volume and enter your transaction pin which you set up after your first sign in. 
                                                </p>
                                                <div>
                                                    <img class="img-responsive" src="{{ asset('assets/images/ibuy.png') }}">
                                                </div>
                                                <p>Once the purchase is successful, a ticket will be generated for your records.</p>
                                                <div>
                                                    <img class="img-responsive" src="{{ asset('assets/images/buy_ticket.png') }}">
                                                </div>

                                                <div class="m-b-20" id="g-tree">
                                                    <ul id="gdata" style="display: none;">
                                                        <li class="folder expanded">
                                                            Sellin
                                                            <ul>
                                                                <li class="folder expanded">
                                                                    My Information
                                                                    <ul>
                                                                        <li class="folder">
                                                                            My Portfolio
                                                                            <ul>
                                                                                <li class="folder">
                                                                                    pie chart composition
                                                                                </li>
                                                                                <li class="folder">
                                                                                    securities held
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                        <li class="folder">
                                                                            My Transactions
                                                                        </li>
                                                                        <li class="folder">
                                                                            My Reports
                                                                        </li>
                                                                        <li>
                                                                            Cashflow Report
                                                                        </li>
                                                                        <li>
                                                                            Profit or Loss
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                        <h4 id="selling">
                                                            Selling a security
                                                        </h4>
                                                        <br>
                                                        <p>
                                                            To sell a security, from your dashboard, clicking on ‘My Trade Room’ and  ‘Start trade’ this will bring you to “My Trade Room” shown below. 
                                                        </p>
                                                        <p>
                                                            Your security balance shows the available balance you have to sell.
                                                            Pick a security to buy by clicking “iSell”. 
                                                            Choose the volume and enter your transaction pin which you set up after your first sign in.
                                                        </p> <br>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/isell.png') }}">
                                                        </div>
                                                        <p>Once the purchase is successful, a ticket will be generated for your records. </p>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/sell_ticket.png') }}">
                                                        </div>

                                                        <h4 id="withdrawal">
                                                            Withdrawing from your account
                                                        </h4>
                                                        <br>
                                                        <p>
                                                            Withdrawing your money from the platform is quick and easy. Click “available balance”, enter the value you would like to withdraw, the bank account you filled out after your registration would be credited. Note that if you have not updated your bank details, uploaded your Identification and a photgraph of yourself, your withdrawal attempt would be unsuccessful.

                                                        </p><br>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/withdrawal.svg') }}">
                                                        </div>
                                                        <p>Once the purchase is successful, a ticket will be generated for your records. </p>
                                                        
                                                        <h4 id="info">Managing your account</h4>
                                                        <h5>My Information</h5>
                                                        <p>You can manage the details of your account by clicking on your picture or initials located at the top right corner of your screen. A drop down menu will be shown for you to access your profile. Alternatively, you can access your profile under “My Profile” which is located on the menu under the “My Information” main menu option.</p><br>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/dropdown.svg') }}">
                                                        </div>
                                                        <p>Your personal details, banking details, password reset and transaction pin can be edited from the tabs below</p>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/profile.svg') }}">
                                                        </div>

                                                        <h4 id="portfolio">Checking Your Position</h4>
                                                        <p>You can view your portfolio under “My Information” and the sub menu “My Portfolio”. The information shows the current securities you have in your account. Your portfolio can be viewed as a mix of bonds and treasury bills or as bonds or treasury bills. </p><br>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/position.png') }}">
                                                        </div>

                                                        <h4 id="blotter">My Blotter</h4>
                                                        <p>This is a report which shows all the details of your transactions by day. If you bought or sold any securitues they will be displayed on your blotter. You can search by date range to see your transactions.</p><br>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/blotter.png') }}">
                                                        </div>

                                                        <h4 id="transactions">My Transactions</h4>
                                                        <p>You can view all your transaction history by clicking ‘My Information’, then clicking on ‘My Transactions’. You will be able to see your cash deposits, cash account which shows all your cash transactions and your bonds and treasury bill account transactions.</p>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/transactions.png') }}">
                                                        </div>

                                                        <h4 id="support">Submitting a Query or Complaint</h4>

                                                        <p>Upon experiencing some difficulty, you are able to simply submit a ticket by clicking on the “support” link, then clicking on ‘Tickets’. Open a new ticket which is located at the top right hand of the screen. The ticket will pop up for you to fill in. Choose the category and give a detailed explanation of your issue. In order to get the best help for your issues, be as descriptive as possible when submitting your ticket and the TradeFi team will get back to you as soon as possible.</p>
                                                        <div>
                                                            <img class="img-responsive" src="{{ asset('assets/images/support.png') }}">
                                                        </div>


                                </hr>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            Copyright Reserved TradeFi {{ \Carbon\Carbon::now()->format('Y') }}
        </footer>
        <script src=" {{ asset('doc/assets/plugins/jquery/jquery-1.11.1.min.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/plugins/modernizr.custom.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/plugins/bootstrapv3/js/bootstrap.min.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/plugins/highlight/highlight.pack.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/plugins/jquery-actual/jquery.actual.min.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/plugins/bootstrap-select2/select2.min.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/plugins/classie/classie.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}">
        </script>
        <script src=" {{ asset('doc/pages/js/pages.min.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/js/sidebar.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/plugins/jquery-dynatree/jquery.dynatree.min.js') }}" type="text/javascript">
        </script>
        <script src=" {{ asset('doc/assets/js/portlets.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('../assets/js/custom.js') }}" type="text/javascript">
        </script>
        <script>
            $(document).ready(function() {
        $.fn.scrollbar && $('.pg_scrollable').scrollbar({
            ignoreOverlay: false
        });
        //Initialize Pages core
        hljs.initHighlightingOnLoad();
         $("#default-tree").dynatree();
          $("#angular-tree").dynatree();
    $("#g-tree").dynatree();
    $("#b-tree").dynatree();
    });
        </script>
    </body>
</html>