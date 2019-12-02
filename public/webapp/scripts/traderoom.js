/* ------------------------ The modal with date graph --------------------- */

$(window).load(function() {
	$(".customloader").fadeOut("slow");
});

var chartData = [];

function generateChartData() {
  var firstDate = new Date();
  firstDate.setHours( 0, 0, 0, 0 );
  firstDate.setDate( firstDate.getDate() - 2000 );

  for ( var i = 0; i < 2000; i++ ) {
    var newDate = new Date( firstDate );

    newDate.setDate( newDate.getDate() + i );

    var open = Math.round( Math.random() * ( 30 ) + 100 );
    var close = open + Math.round( Math.random() * ( 15 ) - Math.random() * 10 );

    var low;
    if ( open < close ) {
      low = open - Math.round( Math.random() * 5 );
    } else {
      low = close - Math.round( Math.random() * 5 );
    }

    var high;
    if ( open < close ) {
      high = close + Math.round( Math.random() * 5 );
    } else {
      high = open + Math.round( Math.random() * 5 );
    }

    var volume = Math.round( Math.random() * ( 1000 + i ) ) + 100 + i;


    chartData[ i ] = ( {
      "date": newDate,
      "open": open,
      "close": close,
      "high": high,
      "low": low,
      "volume": volume
    } );
  }
}

generateChartData();

var chart = AmCharts.makeChart( "chartdiv", {
  "type": "stock",
  "theme": "black",
  "dataSets": [ {
    "fieldMappings": [ {
      "fromField": "open",
      "toField": "open"
    }, {
      "fromField": "close",
      "toField": "close"
    }, {
      "fromField": "high",
      "toField": "high"
    }, {
      "fromField": "low",
      "toField": "low"
    }, {
      "fromField": "volume",
      "toField": "volume"
    }, {
      "fromField": "value",
      "toField": "value"
    } ],
    "color": "#7f8da9",
    "dataProvider": chartData,
    "categoryField": "date"
  } ],
  "balloon": {
    "horizontalPadding": 13
  },
  "panels": [ {
    "title": "Value",
    "stockGraphs": [ {
      "id": "g1",
      "type": "candlestick",
      "openField": "open",
      "closeField": "close",
      "highField": "high",
      "lowField": "low",
      "valueField": "close",
      "lineColor": "#7f8da9",
      "fillColors": "#7f8da9",
      "negativeLineColor": "#db4c3c",
      "negativeFillColors": "#db4c3c",
      "fillAlphas": 1,
      "balloonText": "open:<b>[[open]]</b><br>close:<b>[[close]]</b><br>low:<b>[[low]]</b><br>high:<b>[[high]]</b>",
      "useDataSetColors": false
    } ]
  } ],
  "scrollBarSettings": {
    "graphType": "line",
    "usePeriod": "WW"
  },
  "panelsSettings": {
    "panEventsEnabled": true
  },
  "cursorSettings": {
    "valueBalloonsEnabled": true,
    "valueLineBalloonEnabled": true,
    "valueLineEnabled": true
  },
  "periodSelector": {
    "position": "bottom",
    "periods": [ {
      "period": "DD",
      "count": 10,
      "label": "10 days"
    }, {
      "period": "MM",
      "selected": true,
      "count": 1,
      "label": "1 month"
    }, {
      "period": "YYYY",
      "count": 1,
      "label": "1 year"
    }, {
      "period": "YTD",
      "label": "YTD"
    }, {
      "period": "MAX",
      "label": "MAX"
    } ]
  }
} );

function addPanel() {
  var chart = AmCharts.charts[ 0 ];
  if ( chart.panels.length == 1 ) {
    var newPanel = new AmCharts.StockPanel();
    newPanel.allowTurningOff = true;
    newPanel.title = "Volume";
    newPanel.showCategoryAxis = false;

    var graph = new AmCharts.StockGraph();
    graph.valueField = "volume";
    graph.fillAlphas = 0.15;
    newPanel.addStockGraph( graph );

    var legend = new AmCharts.StockLegend();
    legend.markerType = "none";
    legend.markerSize = 0;
    newPanel.stockLegend = legend;

    chart.addPanelAt( newPanel, 1 );
    chart.validateNow();
  }
}

function removePanel() {
  var chart = AmCharts.charts[ 0 ];
  if ( chart.panels.length > 1 ) {
    chart.removePanel( chart.panels[ 1 ] );
    chart.validateNow();
  }
}


 function reset_trade_action(id){
swal({
  title: 'Process Halt!',
  text: "Are you sure you want to cancel this order?",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#e45f5f',
  cancelButtonColor: '#DC9A3A',
  confirmButtonText: 'Yes, cancel it!',
  cancelButtonText: 'No, dismiss popup!'
}).then(function () {

  iziToast.warning({
    title: 'Cancelled!',
    message: 'Your order has being cancelled.',
});

  
    // $('#bucketDetails').show(); 
           // $('#orderDetails').hide(); 
            // $('#orderSelector').hide(); 

}, function (dismiss) {
  
  if (dismiss === 'cancel') {
    swal(
      'Halt Aborted',
      'Your order is safe:)',
      'error'
    )
  }
})

          
       
  }


/* -------------- button incrementer---------------- */


/* incrementer button */
jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});

 // function trade_action_sell(id,id2){

 //          $('#bucketDetails').hide(); 
 //           $('#orderDetails').show(); 
            
 //            $('#btnsell').show(); 
 //            $('#btnbuy').hide(); 
 //           $('#orderSelector').hide(); 
 //  }

 //  function trade_action_buy(id,id2){

 //          $('#bucketDetails').hide(); 
 //           $('#orderDetails').show(); 
            
 //            $('#orderSelector').hide(); 
 //            $('#btnbuy').show(); 
 //            $('#btnsell').hide();
 //  }


  function trade_proceed(id,id2){

          // $('#bucketDetails').hide(); 
            // $('#orderDetails').hide(); 
            
           // $('#orderSelector').show(); 
           // $('#btnbuy1').show(); 
            // $('#btnsell1').hide();
  }

  function switch_mode(){

   
       document.getElementById("contentdiv").style.background = "-webkit-linear-gradient(to right, #373B44, #73C8A9)"; 
       document.getElementById("contentdiv").style.background = "linear-gradient(to right, #373B44, #73C8A9)"; 
    /*   document.getElementById("contentdiv").style.background = "#73C8A9";     */    
     

   }



    function  easy_mode() {
         var x = document.getElementById('normalmodediv');
         var y = document.getElementById('easymodediv');
       if (x.style.display === 'none') {
           x.style.display = 'block';
           y.style.display = 'none';
        } else {
          x.style.display = 'none';
          y.style.display = 'block';
       }

    }

    
    function  contentselection() {
        
           var x = document.getElementById('mc1');
         var y = document.getElementById('mc2');
          var z = document.getElementById('sc');
       if (x.style.display === 'none') {
           x.style.display = 'block';
           y.style.display = 'none';
             z.style.display = 'block';
        } else {
          x.style.display = 'none';
          y.style.display = 'block';
           z.style.display = 'block';
       }


    }



    
  

  function pay(){

        var btn_id=$('button[name="payment_button"]');
        btn_id.html('Processing...');
        btn_id.attr('disabled',true);

       swal({
  title: 'Password',
  text:'You are about to purchase FGN BONDS',
  input: 'password',
  animation: false,
  width: '350px',
  color: '#44B366',
  customClass: 'animated tada',
  showCancelButton: true,
  confirmButtonText: 'Proceed',
  confirmButtonColor:	'#44B366',
  inputPlaceholder : 'Enter your Transaction Pin',
  showLoaderOnConfirm: true,
  preConfirm: function (password) {
    return new Promise(function (resolve, reject) {
      setTimeout(function() {
        if (password !== '4444') {
          reject('Password Input is wrong.')
        } else {
          
          $('#trademodal').modal('toggle');
          iziToast.show({
    theme: 'dark',
    icon: 'icon-person',
    title: 'Hey Chris,',
    message: 'Your <b>FGN 26.5% 2030 Bond </b> has being Successfull Purchased!',
    position: 'center', 
    progressBarColor: 'rgb(0, 255, 184)',
    buttons: [
        ['<button>Go to Blotter</button>', function (instance, toast) {
           window.location.assign("https://arkounting.com.ng/tradefi/webapp/blotter.html")
        }],
        ['<button>Stay in Trade room</button>', function (instance, toast) {
            instance.hide({
                transitionOut: 'fadeOutUp',
                onClosing: function(instance, toast, closedBy){
                    console.info('closedBy: ' + closedBy); //btn2
                }
            }, toast, 'close', 'btn2');
        }]
    ],
    onOpening: function(instance, toast){
        console.info('callback abriu!');
    },
    onClosing: function(instance, toast, closedBy){
        console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
    }
});

          resolve()

          
        }
      }, 2000)
    })
  },
  allowOutsideClick: false
});

         btn_id.html('Process Payment');  
         btn_id.attr('disabled',false);
   }





