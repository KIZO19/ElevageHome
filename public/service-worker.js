const CACHE_NAME = 'elevage-home-v1';
const ASSETS_TO_CACHE = [
  '/ElevageHome/public/index.php',
  '/ElevageHome/public/css/adminlte-custom.css',
  '/ElevageHome/public/manifest.json',
];

// Installation du Service Worker
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      console.log('Service Worker: Caching core files');
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
  self.skipWaiting();
});

// Activation du Service Worker
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log('Service Worker: Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Stratégie de cache: Network First with Cache Fallback
self.addEventListener('fetch', event => {
  // Skip POST requests et les requêtes non-HTTPS
  if (event.request.method !== 'GET' || !event.request.url.startsWith('https')) {
    return;
  }

  event.respondWith(
    fetch(event.request)
      .then(response => {
        // Cache les réponses réussies
        if (!response || response.status !== 200 || response.type === 'error') {
          return response;
        }

        const responseToCache = response.clone();
        caches.open(CACHE_NAME).then(cache => {
          cache.put(event.request, responseToCache);
        });

        return response;
      })
      .catch(() => {
        // Si la requête échoue, essayer le cache
        return caches.match(event.request).then(response => {
          return response || new Response(
            'Vous êtes hors ligne. Cette page n\'est pas disponible en cache.',
            {
              status: 503,
              statusText: 'Service Unavailable',
              headers: new Headers({
                'Content-Type': 'text/plain'
              })
            }
          );
        });
      })
  );
});

// Gestion des messages depuis le client
self.addEventListener('message', event => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});
