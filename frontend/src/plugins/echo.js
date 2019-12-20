/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import EchoLibrary from 'laravel-echo'

if (typeof io !== 'undefined') {
  window.Echo = new EchoLibrary({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':65080'
  })
}
