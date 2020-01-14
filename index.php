<!DOCTYPE html>
<html>
<head>
	<title>TGN NOTIFICATION</title>
  <link rel="manifest" href="../../manifest.json">
</head>
<body>
  <?php require_once('config.php'); ?>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/7.6.2/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>
  
  <script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyCZf5hepBKclAQxGRv6QKLfD6THYM1JoOg",
    authDomain: "tgn-grow-notification.firebaseapp.com",
    databaseURL: "https://tgn-grow-notification.firebaseio.com",
    projectId: "tgn-grow-notification",
    storageBucket: "tgn-grow-notification.appspot.com",
    messagingSenderId: "550899249744",
    appId: "1:550899249744:web:e90798b3fb2834a51e9755"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  
  const messaging = firebase.messaging();

  // Add the public key generated from the console here.
  /*messaging.usePublicVapidKey("BHq0Ipe_r5nFNpaQEJtBOQK3zpEdgeCVO0kRwoV5zczPBsGu-ydkz4eW-HvsTTkbXLg-i1aucF0rUjk0QxpqrOk");*/
  Notification.requestPermission().then((permission) => {
    if (permission === 'granted') {
      console.log('Notification permission granted.');
      getRegisterToken();
    // TODO(developer): Retrieve an Instance ID token for use with FCM.
    // ...
  } else {
    console.log('Unable to get permission to notify.');
  }
});
  function getRegisterToken(){
  // Get Instance ID token. Initially this makes a network call, once retrieved
  // subsequent calls to getToken will return from cache.
  messaging.getToken().then((currentToken) => {
    if (currentToken) {
      console.log(currentToken);
      if(isTokenSentToServer()){
        console.log('Token already sent.');
      }else{
        sendTokenToServer(currentToken);
        //save token to database
        saveToken(currentToken);
      }
     // updateUIForPushEnabled(currentToken);
   } else {
      // Show permission request.
      console.log('No Instance ID token available. Request permission to generate one.');
      // Show permission UI.
      //updateUIForPushPermissionRequired();
      setTokenSentToServer(false);
    }
  }).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    showToken('Error retrieving Instance ID token. ', err);
    setTokenSentToServer(false);
  });
}

function sendTokenToServer(currentToken) {
  if (!isTokenSentToServer()) {
    console.log('Sending token to server...');
    // TODO(developer): Send the current token to your server.
    setTokenSentToServer(true);
  } else {
    console.log('Token already sent to server so won\'t send it again ' +
      'unless it changes');
  }
}

function isTokenSentToServer() {
  return window.localStorage.getItem('sentToServer') === '1';
}

function setTokenSentToServer(sent) {
  window.localStorage.setItem('sentToServer', sent ? '1' : '0');
}
function saveToken(deviceToken){
  jQuery.ajax({
    data: {
      "token": deviceToken 
    },
    type:"post",
    url:"save_fcm_token.php",
    success:function(result){
      console.log(result);
    }
  });
}

messaging.onMessage(function(payload) {
  console.log('Message received. ', payload);
  var title = payload.data.title;
  var options ={
    body: payload.data.body,
    icon: payload.data.icon,
    image: payload.data.image,
    data: { 
      time: new Date(Date.now()).toString(),
      click_action:payload.data.click_action
    }
    //data: { action:payload.data.click_action}
  }
  var myNotification = new Notification(title, options);
  //on click notification open in new tab
  myNotification.onclick = function(event) {
      event.preventDefault(); // prevent the browser from focusing the Notification's tab
      window.open(payload.data.click_action, '_blank');
    }
  });


function send_notification(){
  jQuery.ajax({
    type:"post",
    url:"sendnotification.php",
    success:function(result){
      //console.log(result);
    }
  });
}


</script>

<button id="send" onclick="send_notification();">Click</button>


</body>
</html>