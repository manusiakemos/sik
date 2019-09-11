var staticCacheName = "pwa-v" + new Date().getTime();
// var staticCacheName = "pwa-v2.0";
var filesToCache = [
    '/',
    // '/manifest.json',
    '/css/style.css',
    '/js/main.js',
    // '/js/akthermal.lib.js',
    '/images/tabalong-square.png',
    '/images/tabalong.png',
    '/app-images/images/icons/icon-72x72.png',
    '/app-images/images/icons/icon-96x96.png',
    '/app-images/images/icons/icon-128x128.png',
    // '/images/icons/icon-144x144.png',
    // '/images/icons/icon-152x152.png',
    // '/app-images/images/icons/icon-192x192.png',
    '/app-images/images/icons/icon-384x384.png',
    '/app-images/images/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('/');
            })
    )
});
