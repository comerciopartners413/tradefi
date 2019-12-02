<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tab-buy" aria-expanded="false">Buy</a></li>
    <li class=""><a data-toggle="tab" href="#tab-sell" aria-expanded="false">Sell</a></li>
    {{-- <li class=""><a data-toggle="tab" href="#tab-rejected" aria-expanded="false">Unsent/Rejected</a></li> --}}
</ul>
<div class="tab-content">
    <div id="tab-buy" class="tab-pane active">
        <div class="panel-body" style="padding: 20px 15px">
            <div class="table-responsive">

                <table  class="table datatable">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Security</th>
                        <th>Balance</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buy_inventory as $inventory)
                        <tr class="{{ (Carbon::parse($inventory->Date)->isToday())? 'today-bg' : ''  }}">
                          <td>
                              <button type="button" class="security-detail-btn btn btn-warning btn-sm" data-security-id="{{ $inventory->SecurityID }}">View Trail</button>
                          </td>
                          <td>{{ $inventory->Security }}</td>
                          <td class="c-accent">{{ number_format($inventory->Quantity, 2) }}</td>
                          <td>{{ \Carbon\Carbon::parse($inventory->Date)->toFormattedDateString() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
                                </div>
                            </div>
                            <div id="tab-sell" class="tab-pane">
                                <div class="panel-body" style="padding: 20px 15px">
                                    <div class="table-responsive">

                <table  class="table datatable">
                <thead>
                    <tr>
                        <th>Security</th>
                        <th>Balance</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sell_inventory as $inventory)
                        <tr>
                          <td>{{ $inventory->Security }}</td>
                          <td class="c-accent">{{ number_format($inventory->Quantity, 2) }}</td>
                          <td>{{ \Carbon\Carbon::parse($inventory->Date)->toFormattedDateString() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
          </div>
        
      </div>

  </div>