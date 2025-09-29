(function () {
    "use strict";
    var options = {}
    var notifier = new AWN(options);
    
    /* Basic notifications */
    document.querySelector('#basic').addEventListener('click', function () {
    notifier.tip('This is an example of tip')
    })
    
    /* Async notifications */
    document.querySelector('#async-error').addEventListener('click', function () {
    notifier.async(Promise.reject("some error"))
    })
    /* Async notifications */
    document.querySelector('#async-success').addEventListener('click', function () {
    notifier.async(Promise.resolve("some message"))
    })
    
    /* Info notifications */
    document.querySelector('#info').addEventListener('click', function () {
    notifier.info('This Is An Example Of Info')
    })
    
    /* Success notifications */
    document.querySelector('#success').addEventListener('click', function () {
    notifier.success('This Is An Example Of Success')
    })
    
    /* Warning notifications */
    document.querySelector('#warning').addEventListener('click', function () {
    notifier.warning('This Is An Example Of Warning')
    })
    
    /* Error notifications */
    document.querySelector('#error').addEventListener('click', function () {
    notifier.alert('This Is An Example Of Error')
    })
    
    /* Confirmation notifications */
    document.querySelector('#confirm').addEventListener('click', function () {
    notifier.confirm('Are you sure you want to reset the password')
    })
    
    /* Popup notifications */
    document.querySelector('#popup').addEventListener('click', function () {
    notifier.modal(`<h4 class="fw-semibold mb-1 text-xl">Welcome To Bootstrap Admin Template </h4><small class="text-gray-500 text-sm">Click outside the modal window to close it.</small>`, 'demo')
    })
    
    /* Async Block With Error notifications */
    document.querySelector('#async').addEventListener('click', function () {
    new AWN().asyncBlock(Promise.reject("some error"))
    })
    
    /* Async Block With Success notifications */
    document.querySelector('#async-block').addEventListener('click', function () {
    new AWN().asyncBlock(Promise.resolve("some message"))
    })
    
})();