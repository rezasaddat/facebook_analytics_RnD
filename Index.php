<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - facebook analytics</title>
    <!-- ui kit -->
    <link rel="stylesheet" href="css/uikit.css">
    <!-- material design -->
    <link rel="stylesheet" href="css/materialdesignicons.min.css">
    <!-- highchart -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css">
    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="css/datatables.css"/>
    <!-- Datetime picker -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <!-- datetime picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="js/main.js"></script>
    <!-- ui kit -->
    <script src="js/uikit.js"></script>
    <!-- uikit icon -->
    <script src="js/uikit-icons.js"></script>
    <!-- jquery session -->
    <script src="js/jquerysession.js"></script>
    <!-- datatables -->
    <script type="text/javascript" src="js/datatables.js"></script>

    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v4.0&appId=<cliend-id>&autoLogAppEvents=1"></script>

</head>
<body>
    <!-- layout menu -->
    <?php include_once('template/menu.php')?>
    <!-- layout head -->
    <?php include_once('template/head.php')?>
    <!-- layout main -->
    <div class="uk-padding"
        style="position: relative;
                min-height: calc(100vh - 65px);
                border-left: 265px solid transparent;
                padding-bottom: 70px !important;"> 

        <div class="uk-background-default" uk-sticky="offset: 65; bottom: #top">
            <div class="uk-inline">
                <h3 class="uk-margin-remove-top">
                    <a href="#" class="uk-text-danger">
                    <span class="mdi mdi-arrow-left mdi-24px uk-margin-small-right"></span>
                        Dummy Dashboard
                    </a>
                    <span class="uk-text-meta">/ Dashboard</span>
                </h3>
            </div>
            <div class="toolbar uk-align-right uk-margin-remove">
                <div class="uk-button-group">
                    <div class="uk-width-medium">
                        <input class="uk-input uk-form-small uk-text-center" type="datetimepicker" value="" id="daterange">
                    </div>
                    <div id="active-users" class="uk-text-small uk-text-primary uk-text-middle uk-input uk-form-small uk-width-small"></div>
                </div>
            </div>
        </div>

        <div>
          <div class="fb-login-button" data-width="" data-size="medium" data-button-type="continue_with" data-auto-logout-link="false" data-use-continue-as="false" onLogin="checkLoginState()"></div>
          <div id="status"></div>
        </div>

        <div class="uk-width-expand@s uk-margin uk-animation-slide-bottom-medium">
            <ul uk-tab>
                <li class="uk-active"><a href="#" class="uk-text-small">Visitor</a></li>
                <li><a href="#" class="uk-text-small">Product Afinity</a></li>
                <!-- <li><a href="#" class="uk-text-small">Pendapatan</a></li> -->
            </ul>

            <ul class="uk-switcher">
            </ul>
        </div>
        <!-- section 2 chart -->
        <!-- section 3 chart -->
        <!-- section 4 chart -->
        
    </div>
    <!-- layout footer -->
    <?php include_once('template/footer.php')?>
</body>
</html>

<script>
    let userID = $.session.get('userID');
    let accessToken = $.session.get('accessToken');
    var date = moment();

    var dateRangeStart = null;
    var dateRangeEnd = null;

    var startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
    var endOfMonth   = moment().endOf('month').format('YYYY-MM-DD');

    var startOfMonth_compered = moment().startOf('month').subtract(1, 'month').format('YYYY-MM-DD');
    var endOfMonth_compered = moment().endOf('month').subtract(1, 'month').format('YYYY-MM-DD');

    var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
</script>

<script>

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<cliend-id>',
      cookie     : true,                     // Enable cookies to allow the server to access the session.
      xfbml      : true,                     // Parse social plugins on this webpage.
      version    : 'v4.0'           // Use this Graph API version for this call.
    });
    check_status_token(); //check status token
  };

  function check_status_token() {
    console.log(accessToken);
    FB.api(`/debug_token?input_token=${accessToken}&access_token=${accessToken}`,
      function (response) {
        if (response.data != null) {
          getProfile(accessToken);
        } else {
          let messageErr = response.error['message'];
          document.getElementById('status').innerHTML = messageErr;
        }
      }
    );
  }

  function checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
      statusChangeCallback(response);
    });
  }

  function getProfile() {
    FB.api(`/me?access_token=${accessToken}`, function(response) {
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }

  function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      $.session.set('userID', response.authResponse['userID']);
      $.session.set('accessToken', response.authResponse['accessToken']);
      getProfile(accessToken);
    } else {                                 // Not logged into your webpage or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log into this webpage.';
    }
  }

</script>