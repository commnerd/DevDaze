import { Terminal } from 'xterm';
const io = require('socket.io')(7681);


// window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

var term = new Terminal();
term.open(document.getElementById('terminal'));
term.write('Hello from \x1B[1;3;31mxterm.js\x1B[0m $ ');

socket = io.connect();
socket.on("connect", function() {
  term.write("\r\n*** Connected to backend***\r\n");
  // Browser -> Backend
  term.on("data", function(data) {
    //console.log(data);
    //                        alert("Not allowd to write. Please don't remove this alert without permission of Ankit or Samir sir. It will be a problem for server'");
    socket.emit("data", data);
  });
  // Backend -> Browser
  socket.on("data", function(data) {
    term.write(data);
  });
  socket.on("disconnect", function() {
    term.write("\r\n*** Disconnected from backend***\r\n");
  });
});