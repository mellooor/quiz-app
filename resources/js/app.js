require('./bootstrap');

// Import Body Scroll Lock Functions
const bodyScrollLock = require('body-scroll-lock');
const disableBodyScroll = bodyScrollLock.disableBodyScroll;
const enableBodyScroll = bodyScrollLock.enableBodyScroll;

const targetElement = document.querySelector('#delete-user-modal-container');

document.getElementById('delete-user-btn').addEventListener('click', function() {
    window.scrollTo(0, 0);
    disableBodyScroll(targetElement);
});

document.getElementById('delete-user-btn-cancel').addEventListener('click', function() {
    enableBodyScroll(targetElement);
});
