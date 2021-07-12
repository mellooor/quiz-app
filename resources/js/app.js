require('./bootstrap');

// Import Body Scroll Lock Functions
const bodyScrollLock = require('body-scroll-lock');
const disableBodyScroll = bodyScrollLock.disableBodyScroll;
const enableBodyScroll = bodyScrollLock.enableBodyScroll;

const targetScrollLockElementOne = document.querySelector('#delete-user-modal-container');
const targetScrollLockElementTwo = document.querySelector('#add-quiz-topic-modal-container');
const targetScrollLockElementThree = document.querySelector('#edit-quiz-topic-modal-container');


if (document.getElementById('delete-user-btn'))
{
    document.getElementById('delete-user-btn').addEventListener('click', function() {
        window.scrollTo(0, 0);
        disableBodyScroll(targetScrollLockElementOne);
    });
}

if (document.getElementById('delete-user-btn-cancel'))
{
    document.getElementById('delete-user-btn-cancel').addEventListener('click', function() {
        enableBodyScroll(targetScrollLockElementOne);
    });
}

if (document.getElementById('add-quiz-topic-btn'))
{
    document.getElementById('add-quiz-topic-btn').addEventListener('click', function() {
        window.scrollTo(0, 0);
        disableBodyScroll(targetScrollLockElementTwo);
    });
}

if (document.getElementById('add-quiz-topic-btn-cancel'))
{
    document.getElementById('add-quiz-topic-btn-cancel').addEventListener('click', function() {
        enableBodyScroll(targetScrollLockElementTwo);
    });
}

if (document.getElementById('edit-quiz-topic-btn'))
{
    document.getElementById('edit-quiz-topic-btn').addEventListener('click', function() {
        window.scrollTo(0, 0);
        disableBodyScroll(targetScrollLockElementThree);
    });
}

if (document.getElementById('edit-quiz-topic-btn-cancel'))
{
    document.getElementById('edit-quiz-topic-btn-cancel').addEventListener('click', function() {
        enableBodyScroll(targetScrollLockElementThree);
    });
}
