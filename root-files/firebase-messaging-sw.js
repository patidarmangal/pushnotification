importScripts('https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js');

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

messaging.setBackgroundMessageHandler(function(payload){
	var title = payload.data.title;
	var options ={
    		body: payload.data.body,
		icon: payload.data.icon,
		image: payload.data.image,
		data: { 
			time: new Date(Date.now()).toString(),
			click_action:payload.data.click_action
		}
	}
 return self.registration.showNotification(title, options);
});


self.addEventListener('notificationclick', function(event) {
  //const clickedNotification = event.notification;
  //clickedNotification.close();
  // Do something as the result of the notification click
  var action_click = event.notification.data.click_action;
  event.waitUntil(
	clients.openWindow(action_click)
  );
});
