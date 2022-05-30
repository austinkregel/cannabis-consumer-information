window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.activityLogSimplifier = function (activityLog) { 
    const classes = ['created', 'updated', 'deleted', 'restored'];
    const identifyClass = classes.indexOf(activityLog.description) > -1 ? activityLog.description : 'custom';
    
    if (identifyClass === 'custom') {
        if (activityLog.description?.indexOf('recall') > -1) {
            return 'recall';
        }

        if (activityLog.name) {
            return activityLog.name;
        }

        if (activityLog.description === 'released') {
            return 'released';
        }

        return 'custom';
    }

    return identifyClass;
}

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
