@extends('layouts.app')

@section('content')
<div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-help1"></i>
                            </div>
                            <div class="header-title">
                                <h3>FAQS</h3>
                                <small>
                                Frequently Asked Questions
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row hide">

                    <div class="col-md-12">

                        <div class="panel panel-filled">

                            <div class="panel-body">

                                <h3>Support </h3>

                                <p>
                                    Fill the form and find answer to your question or contact with us on support email.
                                </p>

                                <div class="form-group">
                                    <input class="form-control" placeholder="What are you looking for ?">
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                
                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            What is TradeFI?
                        </div>
                        <div class="panel-body">
                            TradeFi is a desktop and mobile application for users to learn about the fixed income market, practice how to trade and finally engage in investing and trading fixed income instruments. The securities TradeFi lets you invest in are federal government bonds and Nigerian Treasury Bills. 
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            Is TradeFI Regulated?
                        </div>
                        <div class="panel-body">
                            TradeFi is endorsed by the FMDQ, a registered OTC Securities Exchange and Self-Regulatory organization.  
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            What do I need to get started?
                        </div>
                        <div class="panel-body">
                            You can access platform on your mobile devices through the play store for android and the iOS store or apple device or you can simply visit www.tradefi.com.ng  for the desktop version
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            Who can use TradeFI?
                        </div>
                        <div class="panel-body">
                            Anyone with access to an internet connection and a computer, as well as an iOS or Android device can download and use our apps.  The app is free to download. 
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            How long does it take for my trades to settle?
                        </div>
                        <div class="panel-body">
                            All buy or sale transactions take two business days to settle and you to receive value.
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            What is processing time for my withdrawals?
                        </div>
                        <div class="panel-body">
                            Withdrawals are processed within 2 business days. All withdrawals made outside this time would be processed the following business day. 
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                           Will users be able to access their statement of accounts on their computers as well as phones?
                        </div>
                        <div class="panel-body">
                            You will be able to access their statement of accounts on their computers and phones on the TradeFi platform. 
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                           Can I edit my personal details?
                        </div>
                        <div class="panel-body">
                            Yes, you can modify your details in “My information” but your account will undergo authorization process.
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                           Why do I need to send a copy of my Passport/ID?
                        </div>
                        <div class="panel-body">
                           This is necessary as it is a part of our KYC (Know Your Customer) process. It is also a security measure so we can attach a face to a profile, to safeguard your account.
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                           How do I know if the documents and information provided are okay and sufficient?
                        </div>
                        <div class="panel-body">
                           You will get a confirmation email activating your account. In the event that unsuitable documents are provided, we will send you an e-mail stating what documents or information is outstanding.
                        </div>
                </div>

                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                           Can I open Multiple accounts?
                        </div>
                        <div class="panel-body">
                           No, you cannot open multiple accounts.
                        </div>
                </div>


                <div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Why does TradeFi need my BVN?
                             </div>
                        <div class="panel-body">
TradeFi needs your BVN for verification and security as it is a number unique to each person, almost like a digital fingerprint.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>What information do I need to open a TradeFi account?
                             </div>
                        <div class="panel-body">
Our onboarding process will have to be completed prior to being able to access the platform. This includes filling out our onboarding forms, and providing documentation including a passport photograph, identification documentation and address verification. 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Does TradeFi have access to my bank account?
                             </div>
                        <div class="panel-body">
No. We do not have any access to your bank account.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>How is user information protected?
                             </div>
                        <div class="panel-body">
Information is protected by an SSL security certificate.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Is any of my information stored on TradeFi’s servers?
                             </div>
                        <div class="panel-body">
Yes, we store your information so as to ensure smooth, seamless operation on the platform. Client information is needed as part of our KYC process.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>How secure is my TradeFi account?
                             </div>
                        <div class="panel-body">
Your TradeFi account is secure. Users are advised not to divulge their log-on and PIN details to anyone. 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Can I buy and sell stocks using TradeFi?
                             </div>
                        <div class="panel-body">
No, you can only invest in Nigerian Fixed income securities on TradeFi.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>What is the transaction fee going to be?
                             </div>
                        <div class="panel-body">
There are custody fees on your transactions but they are non-refundable if you liquidate your investment before its set maturity.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>How much or how little can I invest using TradeFi?
                             </div>
                        <div class="panel-body">
TradeFi has a minimum investment value of N100,000 and a maximum of N99,000,000 based on what is available and whether you have any limits on your account. 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Can I sell my securities at any time?
                             </div>
                        <div class="panel-body">
You are allowed to liquidate your investments at any time as long as the market is open and there are willing buyers in the market.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>How many securities can I invest in using TradeFi?
                             </div>
                        <div class="panel-body">
As long as your account is sufficiently funded, you can trade on as many securities as you wish.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>What are the trading hours and Nigerian market holidays?
                             </div>
                        <div class="panel-body">
The platform is available 24/7, but you can start investing between the hours of 10.00 am and 2.00 pm on working days. You will not be able to invest on this platform on public holidays. However, you will have access to your account at any time.

Taxes and Fees
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Do I have to pay taxes on money I make through my TradeFi account?
                             </div>
                        <div class="panel-body">
No, you will not be paying any taxes on the money you make within this platform as fixed income instruments are tax free. 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>When will I be charged transaction fees?
                             </div>
                        <div class="panel-body">
Transaction fees will be charged on investment executed on this platform in real time.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>How do I withdraw money from my account?
                             </div>
                        <div class="panel-body">
TradeFi has a seamless withdrawal process. You can initiate withdrawals on the platform by clicking on the withdrawal menu located on the top right corner of the platform and this can be done any time.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Are there withdrawal fees?
                             </div>
                        <div class="panel-body">
Yes, there is a withdrawal fee of N52.50.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Why was my withdrawal unsuccessful?
                             </div>
                        <div class="panel-body">
You might have requested to withdraw an amount greater than your available balance. 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Will I be charged a fee for an inactive account?
                             </div>
                        <div class="panel-body">
No you will not be charged a fee. Users are encouraged to participate actively by investing through TradeFi Platform 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>What currency is my account denominated?
                             </div>
                        <div class="panel-body">
All investments on TradeFi are naira denominated.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>How can I get my statement?
                             </div>
                        <div class="panel-body">
Log into the platform, under “My Transactions”, statements can be exported through the platform in any of these formats – excel, pdf and word
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>How do I start Investing?
                             </div>
                        <div class="panel-body">
Once you feel like you have adequate knowledge of the Nigerian fixed income market, all you need to do is complete the onboarding process and fund your account. Once this is done, you can begin to invest. 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Which asset can I trade on TradeFi?
                             </div>
                        <div class="panel-body">
Nigerian Treasury Bills and Federal Government of Nigeria Bonds.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>What is the minimum transaction size?
                             </div>
                        <div class="panel-body">
The minimum transaction size is N100,000.00
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Can I place an order?
                             </div>
                        <div class="panel-body">
No, all transactions are consummated on a real time basis by you, therefore you cannot place an order to buy or sell any securities.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Is there a deposit fee?
                             </div>
                        <div class="panel-body">
Yes, there is a deposit fee. A convenience fee of 1.5% capped at N2000 on the payment gateway side (NIBSS).
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>I forgot my password, how can I reset this?
                             </div>
                        <div class="panel-body">
Upon clicking the forgot password link on the homepage, password reset information will be forwarded to your email address for your password to be reset. 
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Why is access to my account blocked?
                             </div>
                        <div class="panel-body">
Suspension of account will most likely be due to incomplete documentation. However, an email will be sent to you with an explanation.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Are users account segregated?
                             </div>
                        <div class="panel-body">
Yes, users' accounts are segregated. You do not have access to other users’ information.
</div>
                </div>
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>Why do I need to submit answers about my financial status before I start trading?
                             </div>
                        <div class="panel-body">
Comercio Partners Asset Management is the company that created TradeFi, which is a regulated and licensed financial institution and is required to collect financial details from clients.
</div>
                </div>
             
<div class="panel panel-filled panel-c-warning panel-collapse">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>What do I do if I am having difficulties with the website/application?
                             </div>
                        <div class="panel-body">
Log-on to TradeFi, click the support button and open a ticket. Our support representatives are always on standby to provide help or resolve complaints.
</div>
                </div>

            </div>
@endsection