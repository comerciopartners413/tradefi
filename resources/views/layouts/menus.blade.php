<ul class="nav luna-nav">
  <li class="">
      <a href="#" href="#" data-toggle="modal" data-target="#fundmodal"> <i class="pe-7s-piggy c-accent"> </i>&nbsp; Wallet</a>
  </li>
  <li class="active">
      <a href="{{ route('home') }}"> <i class="pe-7s-display1 c-accent"> </i>&nbsp; My Dashboard</a>
  </li>

  @foreach ($parent_menus as $menu)
      <li>
        <a href="{{ ($menu->route != '#')? route($menu->route) : "#menu".$menu->id }}" data-toggle="collapse" aria-expanded="false">
          {{ $menu->name }}
          @if (count($menu->children) > 0)<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>@endif
        </a>
        <ul id="menu{{ $menu->id }}" class="nav nav-second collapse">
          @forelse ($menu->children as $child)
            @if (auth()->user()->hasMenu($child->id) || auth()->id() == '1')
              <li>
                  <a href="{{ route($child->route) }}"> <i class="pe-7s-user"> </i>&nbsp;&nbsp; {{ $child->name }}</a>
              </li>
            @endif
          @empty  
          @endforelse
        </ul>
      </li>
    
  @endforeach

  
  @if(!auth()->user()->admin)
  <li>
      <a href="#tables" data-toggle="collapse" aria-expanded="false">
        My Information<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
      </a>
      <ul id="tables" class="nav nav-second collapse">
          <li>
              <a href="{{ route('profile.index') }}"> <i class="pe-7s-user"> </i>&nbsp;&nbsp; My Profile</a>
          </li>
          <li><a href="{{ route('portfolio.index') }}"><i class="pe-7s-wallet"></i>&nbsp; My Portfolio</a></li>
          <li><a href="{{ route('blotter.index') }}"><i class="pe-7s-display2"></i>&nbsp; My Blotter</a></li>
          <li><a href="{{ route('transactions.index') }}"><i class="pe-7s-date"></i>&nbsp; My Transactions</a></li>
          <li><a href="{{ url('report') }}"><i class="fa fa-line-chart"></i>&nbsp;My Reports</a></li>
          
      </ul>
  </li>

   <li class="">
      <a href="{{ url('/forum') }}"> <i class="pe-7s-users c-accent"> </i>&nbsp; Forum</a>
  </li>
  
  @endif

  @if (\Entrust::can(['upload_prices', 'approve_prices', 'view_price_history', 'view_inventory']))
  <li>
      <a href="#upload" data-toggle="collapse" aria-expanded="false">
        Price Upload<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
      </a>
      
      <ul id="upload" class="nav nav-second collapse">
          @if (\Entrust::can(['upload_prices']))
            <li><a href="{{ route('compose_message') }}"> <i class="pe-7s-cloud-upload c-accent"> </i>&nbsp;&nbsp; Upload Price List</a></li>
            <li><a href="{{ route('confirm_upload') }}"><i class="pe-7s-note2 c-accent"></i>&nbsp; Confirm Price Upload</a></li>
          @endif

          @if (\Entrust::can(['approve_prices']))
          <li><a href="{{ route('price_upload.first_approval') }}"><i class="pe-7s-check c-accent"></i>&nbsp; Approve Price Upload</a></li>
          @endif
          
          @if (\Entrust::can(['approve_prices']))
          <li><a href="{{ route('price_upload.history') }}"><i class="pe-7s-clock c-accent"></i>&nbsp; Price Upload History</a></li>
          @endif

          @if (\Entrust::can(['view_inventory']))
          <li>
              <a href="{{ route('inventory_today') }}"><i class="fa fa-genderless c-accent"></i>&nbsp; Today's Inventory
              </a>
          </li>
          @endif
          
      </ul>
  </li>
  @endif



<li>
    <a href="#uielements" data-toggle="collapse" aria-expanded="false">
   {{ auth()->user()->admin ? 'Trades' : 'My Trade Room' }}<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
  </a>
    <ul id="uielements" class="nav nav-second collapse">
         @if(auth()->user()->admin)
            <li>
                <a href="{{ url('/trade-room') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Trade Room</a>
            </li>
            {{-- <li>
                <a href="{{ url('/admin/trades') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;View Trades</a>
            </li> --}}
            {{-- <li>
                <a href="{{ url('/download-trades')}}" >
                <i class="pe-7s-cloud-download c-accent"> </i>&nbsp;Download Trades </a>        
            </li> --}}
            {{-- <li>
                <a href="{{ url('/spread-income')}}" >
                <i class="pe-7s-cloud-download c-accent"> </i>&nbsp;Spread Income </a>        
            </li>
             <li>
                <a href="{{ url('/trade-room/create') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Modify Prices</a>
            </li> --}}
            {{-- <li>
                <a href="{{ url('/admin/pricelog') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Price Log</a>
            </li> --}}
            {{-- <li>
                <a href="{{ url('/admin/trades/custodyfees') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Custody Fees. Report</a>
            </li> --}}
            <li>
                <a href="{{ route('reports.settlement') }}"><i class="fa fa-genderless c-accent"></i>&nbsp; Settlement Instructions - Trades
                </a>
            </li>
            <li>
                <a href="{{ route('reports.settlement_gis') }}"><i class="fa fa-genderless c-accent"></i>&nbsp; Valuation Report - GIS
                </a>
            </li>
            <li>
                <a href="{{ route('instructions.aggregate') }}"><i class="fa fa-genderless c-accent"></i>&nbsp; Aggregate Instructions
                </a>
            </li>
        @else
            <li>
                <a href="{{ url('/trade-room') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Start Trade</a>
            </li>
            {{-- <li>
                <a href="{{ url('/trade-room/easymode') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Easy Mode</a>
            </li> --}}
         @endif
    </ul>
</li>


 @if(auth()->user()->admin)
 <li>
      <a href="#users" data-toggle="collapse" aria-expanded="false">
      Users <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
      </a>
      <ul id="users" class="nav nav-second collapse">
          

          <li>
              <a href="{{ url('admin/users') }}"> <i class="pe-7s-users c-accent"> </i>&nbsp; View Users<br></a>
          </li>
          {{-- <li>
              <a href="{{ url('/download-users')}}" >
              <i class="pe-7s-cloud-download c-accent"> </i>&nbsp;Download Users </a>        
          </li> --}}
          <li>
              <a href="{{ url('/not_profiled')}}" >
              <i class="pe-7s-next c-accent"> </i>&nbsp;Send Users </a>        
          </li>
          {{-- <li>
              <a href="{{ url('/profiled_accounts')}}" >
              <i class="pe-7s-cloud-download c-accent"> </i>&nbsp;Download Users </a>         --}}
          {{-- </li>
               <li>
              <a href="{{ url('users/approve') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Approve Updates</a>
          </li>

          <li>
              <a href="{{ url('/approvallist') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Approval List Security</a>
          </li>

           <li>
              <a href="{{ url('/approvallist-inventory') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Approval List Inventory</a>
          </li> --}}
      </ul>
  </li>

  <li>
    <a href="#userman" data-toggle="collapse" aria-expanded="false">
      User Management <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
    </a>
    <ul id="userman" class="nav nav-second collapse">
      {{-- <li>
          <a href="{{ url('/not_profiled') }}"><i class="pe-7s-user c-accent"> </i>&nbsp; Not Profiled<br></a>
      </li> --}}
      <li>
          <a href="{{ url('/pending_accounts') }}"><i class="pe-7s-user c-accent"> </i>&nbsp; Pending Accounts<br></a>
      </li>
      <li>
          <a href="{{ url('/profiled_accounts') }}"><i class="pe-7s-user c-accent"> </i>&nbsp; Profiled Accounts<br></a>
      </li>
    </ul>
  </li>

  {{-- <li>
      <a href="#deposits" data-toggle="collapse" aria-expanded="false">
      Dep. &amp; Withdrawals <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
  </a>
      <ul id="deposits" class="nav nav-second collapse">
          
          <li>
              <a href="{{ url('admin/deposits') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Deposits</a>
          </li>

          <li>
              <a href="{{ url('admin/custody') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Custody Fees</a>
          </li>

          <li>
              <a href="{{ url('deposit/bank-deps') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Direct Deposits</a>
          </li>

          <li>
              <a href="{{ url('/withdrawals') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Withdrawals</a>
          </li>

          <li>
              <a href="{{ url('cash_entries/customer_transfer') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Post Cash</a>
          </li>

           <li>
              <a href="{{ url('cash_entries/bonds_custody_transfer') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Post Custody Fees (Bonds)</a>
          </li>

          <li>
              <a href="{{ url('/transactions/multipost') }}"><i class="fa fa-genderless c-accent"> </i>&nbsp;Reverse Withdrawal</a>
          </li>
      </ul>
  </li> --}}


  {{-- <li>
      <a href="#dash-data" data-toggle="collapse" aria-expanded="false">
        Dashboard Data <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
      </a>
      <ul id="dash-data" class="nav nav-second collapse">
          <li><a href="{{ route('admin.macros.index') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Update Macros</a></li>
          <li><a href="{{ route('admin.fx.index') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;Update FX Prices</a></li>
          <li>
      </ul>
  </li> --}}

  {{-- <li>
      <a href="/admin/coupon-payment">
        Coupon Payment 
      </a>
  </li>

  <li>
      <a href="/admin/cash-release">
        Cash Release
      </a>
  </li>

  <li>
      <a href="{{ route('execeod') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
         Run EOD
      </a>
  </li> --}}

  
 
  <li>
      <a href="#setup" data-toggle="collapse" aria-expanded="false">
      Setup <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
  </a>
      <ul id="setup" class="nav nav-second collapse">
          <li>
              <a href="{{ url('roles/create') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
               Roles
              </a>
          </li>
          {{-- <li>
              <a href="{{ url('permissions/create') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
               Permissions
              </a>
          </li> --}}

          <li>
              <a href="{{ url('workflow/create') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
               Workflow
              </a>
          </li>
          <li>
              <a href="{{ url('admin/users/create') }}"><i class="pe-7s-user c-accent"> </i>&nbsp; Create Admins<br></a>
          </li>

          {{-- <li>
              <a href="{{ route('securities.index') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
                  Instruments
              </a>
          </li>

          <li>
              <a href="{{ route('admin.inventory.create') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
                  Inventory
              </a>
          </li>

          <li>
              <a href="{{ route('securities.makeSpread') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
                  Make Spread
              </a>
          </li>

          <li>
              <a href="{{ route('config.create') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
                 Modify Trade Date
              </a>
          </li>


          <li>
              <a href="{{ url('/admin/news') }}"><i class="fa fa-genderless c-accent"></i>&nbsp;
                  Create News
              </a>
          </li> --}}


          
      </ul>
  </li>
  
 @endif
  <!-- <li class="nav-category">
  Support Section
</li> -->
  <li>
      <a href="#extras1" data-toggle="collapse" aria-expanded="false">
      Support <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
  </a>
      <ul id="extras1" class="nav nav-second collapse">
          <li>
              <a href="{{ auth()->user()->admin == 0 ? route('ticket.index') : url('/admin/tickets') }}"> <i class="fa fa-sticky-note-o "> </i>&nbsp; Tickets</a>
          </li>
          <li>
              <a href="/faqs/"> <i class="fa fa-support"> </i>&nbsp; FAQs</a>
          </li>
          <li>
              <a href="/tradefi-guide" target="_blank"> <i class="fa fa-support"> </i>&nbsp; User Guide</a>
          </li>

      </ul>
  </li>
  @if(auth()->user()->admin)
  <li>
      <a href="#reports" data-toggle="collapse" aria-expanded="false">
          Reports <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
      </a>
          <ul id="reports" class="nav nav-second collapse">
              <li>
                  <a href="{{ url('/audit-trail') }}"><i class="pe-7s-hourglass c-accent"> </i>&nbsp; Audit Trail<br></a>
              </li>
            </ul>
      {{-- <a href="#" target="_blank">
          <!-- <span class="badge pull-right">2</span> -->
          <i class="fa fa-line-chart"></i>&nbsp; Reports <span class="nav-icon"> </span>
      </a> --}}
  </li>
  
  @endif
  <li class="hide">
      <a href="/tradefi-guide" target="_blank">
          <!-- <span class="badge pull-right">2</span> -->
          TradeFi Guide &nbsp; <span class="nav-icon"> <i class="fa fa-external-link"></i> </span>
      </a>
  </li>



  <li class="nav-info">
      {{-- News section --}}
      <div class="">
          <h5 style="color: gold;">Time</h5>
          <b class="current-time" style="">

          </b>
          <hr>
          <h5 style="color: gold;">Trade Date</h5>
          <b>{{ \Carbon\Carbon::parse(TradefiUBA\Config::first()->TradeDate)->toFormattedDateString() }}</b>
          <hr>
          @if(auth()->user()->admin)
          <h5 style="color: gold;">Settlement Date</h5>
          <b>{{ \Carbon\Carbon::parse((\DB::select('Exec procSettlementDate')[0])->SettlementDate)->toFormattedDateString() }}</b> <hr>
          @endif

      </div>

       <div class="">
          <h5 style="color: gold;">TradeFI News.</h5>
          <ul id="demo4" class="list-unstyled" style="margin-bottom: 20px">
              @foreach($tradefi_news as $news)
              <li>
                  <h6 class="c-accent" >{{ $news->title }}</h6>
                      @php
                      $real_content =  strip_tags($news->body);
                      echo "<p>". str_limit($real_content, 20, '.. <br><a href="news/'.$news->id.'">read more</a>')."</p>";
                      @endphp
                  
              </li>
              @endforeach
          </ul>
      </div>
      <div align="center"> <img src="{{ asset('webapp/images/genie1.png') }}" width="50px" align="middle">
          <br/>
          <div class="m-t-xs">
              <!--  <span class="security">FGN Bonds  </span> interests has marked up by <span class="gr"> 3%  </span>in the <span class="c-white"> last 7days...</span>It will be wise to have a peice of the pie.  -->
             <!-- <span class="security"> How can I advise you? </span>--> </div>
      </div>
  </li>
</ul>