        function Timer(holder, pre_text, post_text) {
            var controller = {
                holder: holder,
                end: null,
                intervalID:0,
                display: function () {
                    var _second = 1000;
                    var _minute = _second * 60;
                    var _hour = _minute * 60;
                    var _day = _hour * 24;

                    var msg = "";
                   
                    var distance = controller.end - new Date();
                    if (distance < 0) {

                        clearInterval(controller.intervalID);
                        controller.holder.innerHTML = '<span class="time-labels">'+ post_text+'</span>';

                        return;
                    }

                    var days = Math.floor(distance / _day);
                    var hours = Math.floor((distance % _day) / _hour);
                    var minutes = Math.floor((distance % _hour) / _minute);
                    var seconds = Math.floor((distance % _minute) / _second);
                    controller.holder.innerHTML = '<b>'+pre_text+'</b>:  <span class="time-labels">' + hours + '</span> Hours  <span class="time-labels">' + minutes + '</span> Minutes  <span class="time-labels">' + seconds + '</span> Seconds ';

                }
            }

            this.countDown = function (end) {
                controller.end = end;
                controller.intervalID = setInterval(controller.display, 1000);
            }

            
        }




        
