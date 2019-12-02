'use strict';
$(document).ready(function() {
    $('#start_tour').click(function() {
        $("#tour_section").velocity("scroll", {
            duration: 800
        });
    }),
    $('#practice').click(function() {
        $("#practice_section").velocity("scroll", {
            duration: 800
        });
    }),

     $('#trade').click(function() {
        $("#trade_section").velocity("scroll", {
            duration: 800
        });
    }),

     $('#login').click(function() {
        /*$("#login_section").velocity("scroll", {
            duration: 800
        }); */   
         $('#modalSlideUpSmall').modal('show'); 
 
    }),

   $('#signup').click(function() {
        //  alert('test');
         $('#signupmodal').modal('show'); 
 
    })

});


