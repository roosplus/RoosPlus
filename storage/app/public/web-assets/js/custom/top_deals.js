$(document).ready(function () {

  (function () {

    if (deal_type == 2) {
      var dealstartdate = new Date(current_date + " " + start_time).getTime();

      var countDownDate = new Date(current_date + " " + end_time).getTime();
    } else {
      var dealstartdate = new Date(start_date + " " + start_time).getTime();

      var countDownDate = new Date(end_date + " " + end_time).getTime();
    }


    // Update the count down every 1 second

    var x = setInterval(function () {

      var nowdate = new Date().toLocaleString("en-US", { timeZone: time_zone });

      now = new Date(nowdate).getTime();

      // Time to the date

      var timeToDate = countDownDate - now;

      if (timeToDate > 0 && now >= dealstartdate) {

        $("#nodata").addClass("d-none");

        $("#topdeals").removeClass("d-none");

        // Time calculations for days, hours, minutes and seconds

        var days = Math.floor(timeToDate / (1000 * 60 * 60 * 24));

        var hours = Math.floor(

          timeToDate % (1000 * 60 * 60 * 24) / (1000 * 60 * 60)

        );

        var minutes = Math.floor(timeToDate % (1000 * 60 * 60) / (1000 * 60));

        var seconds = Math.floor(timeToDate % (1000 * 60) / 1000);

        // Display the result in the element with id="counter"

        if (topdeals == 1) {
          var html = `
          <div class="eapps-countdown-timer-item-group text-center eapps-countdown-timer-item-group-days">
              <div class="eapps-countdown-timer-item-group-inner d-flex flex-column align-items-center justify-content-center">
                  <div class="eapps-countdown-timer-item-first eapps-countdown-timer-item-days">
                      <div class="eapps-countdown-timer-item-value js-days">
                          <span class="eapps-countdown-timer-item-value-base">${days}</span>
                      </div>
                  </div>
              </div>
              <div class="eapps-countdown-timer-item-group-label" title="Days">Days</div>
          </div>
          <div class="eapps-countdown-timer-item-group text-center eapps-countdown-timer-item-group-hours">
              <div class="eapps-countdown-timer-item-group-inner d-flex flex-column align-items-center justify-content-center">
                  <div class="eapps-countdown-timer-item-first eapps-countdown-timer-item-hours">
                      <div class="eapps-countdown-timer-item-value js-hours">
                          <span class="eapps-countdown-timer-item-value-base">${hours}</span>
                      </div>
                  </div>
              </div>
              <div class="eapps-countdown-timer-item-group-label" title="Hours">Hours</div>
          </div>
          <div class="eapps-countdown-timer-item-group text-center eapps-countdown-timer-item-group-minutes">
              <div class="eapps-countdown-timer-item-group-inner d-flex flex-column align-items-center justify-content-center">
                  <div class="eapps-countdown-timer-item-first eapps-countdown-timer-item-minutes">
                      <div class="eapps-countdown-timer-item-value js-minutes">
                          <span class="eapps-countdown-timer-item-value-base">${minutes}</span>
                      </div>
                  </div>
              </div>
              <div class="eapps-countdown-timer-item-group-label" title="Minutes">Minutes</div>
          </div>
          <div class="eapps-countdown-timer-item-group text-center eapps-countdown-timer-item-group-seconds">
              <div class="eapps-countdown-timer-item-group-inner d-flex flex-column align-items-center justify-content-center">
                  <div class="eapps-countdown-timer-item-first eapps-countdown-timer-item-seconds">
                      <div class="eapps-countdown-timer-item-value js-seconds">
                          <span class="eapps-countdown-timer-item-value-base">${seconds}</span>
                      </div>
                  </div>
              </div>
              <div class="eapps-countdown-timer-item-group-label" title="Seconds">Seconds</div>
          </div>`;

          document.getElementById("countdown").innerHTML = html;

        }

      } else {


        var nowdate = new Date().toLocaleString("en-US", {
          timeZone: time_zone
        });
        var now = new Date(nowdate);
        var month = now.getMonth() + 1;
        var date = now.getDate();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        if (date < 10) {
          date = '0' + date;
        }
        if (month < 10) {
          month = "0" + month;
        }
        if (hours < 10) {
          hours = "0" + hours;
        }
        if (minutes < 10) {
          minutes = "0" + minutes;
        }
        if (seconds < 10) {
          seconds = "0" + seconds;
        }
        var current_date = now.getFullYear() + "-" + month + "-" + date;
        var current_time = hours + ":" + minutes + ":" + seconds;
        if (deal_type == 1) {
          if (current_date == enddate) {
            if (current_time == endtime) {
              window.location.href = siteurl;
            }
          }
        } else {
          if (current_time == endtime) {
            window.location.href = siteurl;
          }

        }
        // clearInterval(x);

        // $("#topdeals").addClass("d-none");

        // $("#nodata").removeClass("d-none");

      }

    }, 1000);

  })();

});

