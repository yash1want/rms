var session_timeout_value = document.getElementById("session_timeout_value").value;
var minutesToAdd=session_timeout_value;
var currentDate = new Date();
var futureDate = new Date(currentDate.getTime() + parseInt(minutesToAdd));

// Set the date we're counting down to
var countDownDate = new Date(futureDate).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  //document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  //+ minutes + "m " + seconds + "s ";
    
  // document.getElementById("session_timer").innerHTML = minutes + "m " + seconds + "s ";
  // document.getElementById("session_timer_counter").innerHTML = minutes + "m " + seconds + "s ";
  secondsFormatted = (String(seconds).length == 1) ? "0" + String(seconds) : seconds;
  minutesFormatted = (String(minutes).length == 1) ? "0" + String(minutes) : minutes;
  document.getElementById("session_timer_counter").innerHTML = minutesFormatted + " : " + secondsFormatted;
  
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("session_timer_counter").innerHTML = "EXPIRED";
    
    // Call logout function on session expired, Added on 11-10-2022 by Aniket.
    var sessionLogoutUrl = $('#session_timer_logout_url').val();
    var sessionToken = $('#session_timer_id').val();
    var sessionLogoutStatus = $('#session_timer_status').val();
    var sessionUsertype = $('#session_usertype').val();
    var sessionUsername = $('#session_username').val();
    var sessionSupportTeamLogin = $('#session_support_team_login').val();
    var sessionLeaseUsername = $('#session_lease_user_name').val();
    if(sessionLogoutStatus == 0){
      $.ajax({
        type: "POST",
        url: sessionLogoutUrl,
        data: {'action':'session_logout','session_token':sessionToken,'session_usertype':sessionUsertype,'session_username':sessionUsername,'session_support_team_login':sessionSupportTeamLogin,'session_lease_username':sessionLeaseUsername},
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function (data) {
          $('#session_timer_status').val('1');
        }
      });
    }
    
  }
}, 1000);