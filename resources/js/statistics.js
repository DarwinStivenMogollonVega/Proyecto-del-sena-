import Echo from 'laravel-echo';

// This file expects you to have configured window.Pusher or another broadcaster
// and imported this module from your main app entry (resources/js/app.js).

window.initStatisticsRealtime = function (options = {}) {
    if (!window.Echo) {
        // Create Echo if not already created by app
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: options.key || process.env.MIX_PUSHER_APP_KEY,
            wsHost: options.host || window.location.hostname,
            wsPort: options.port || (window.location.protocol === 'https:' ? 6001 : 6001),
            forceTLS: options.forceTLS || false,
            disableStats: true,
        });
    }

    window.Echo.channel('admin-statistics')
        .listen('StatisticsUpdated', (payload) => {
            // Dispatch a DOM event with the payload so views can listen
            window.dispatchEvent(new CustomEvent('statistics.updated', { detail: payload }));
        });
};

export default window.initStatisticsRealtime;
