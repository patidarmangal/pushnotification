# pushnotification
Complete push notification
There are following things are necessary and important to configure push notification with firebase.
1) Create account at firebase https://console.firebase.google.com/
2) Create project for your website push notifcation if project dosen't exist.
3) manifest and firebase-messaging-sw.js files are very very important so place this file at root of the site.
   a) manifest file consist the gcm sender key which is very important.
   b) firebase-messaging-sw.js this file includes below code which is very important in prospect of background when site is opened
