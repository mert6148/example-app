/**
 * Kernel - Uygulama başlatıcısı
 */
export class Kernel {
    constructor() {
        this.router = null;
        this.middlewares = [];
        this.ready = false;
    }

    /**
     * Router'ı döndür
     */
    getRouter() {
        if (!this.router) {
            this.router = new Router();
        }
        return this.router;
    }

    /**
     * Middleware ekle
     */
    use(middleware) {
        this.middlewares.push(middleware);
        return this;
    }

    /**
     * Kernel'ı başlat
     */
    bootstrap() {
        if (this.ready) return;

        this.middlewares.forEach(middleware => {
            if (typeof middleware === 'function') {
                middleware();
            }
        });

        this.ready = true;
        this.dispatch('kernel:ready');
    }

    /**
     * Event gönder
     */
    dispatch(eventName, detail = {}) {
        const event = new CustomEvent(eventName, { detail });
        window.dispatchEvent(event);
    }
}

/**
 * Router Sınıfı
 */
export class Router {
    constructor() {
        this.routes = [];
        this.currentRoute = null;
    }

    /**
     * Route tanımla
     */
    define(path, handler) {
        this.routes.push({ path, handler });
        return this;
    }

    /**
     * Router'ı başlat
     */
    init() {
        this.matchCurrentRoute();
        window.addEventListener('popstate', () => this.matchCurrentRoute());
    }

    /**
     * Mevcut route'u bulve çalıştır
     */
    matchCurrentRoute() {
        const currentPath = window.location.pathname;
        const route = this.routes.find(r => r.path === currentPath);

        if (route && typeof route.handler === 'function') {
            this.currentRoute = route;
            route.handler();
        }
    }

    /**
     * Navigasyon yap
     */
    navigate(path) {
        window.history.pushState({}, '', path);
        this.matchCurrentRoute();
    }
}

/**
 * DOM Ready'de Kernel başlat
 */
document.addEventListener('DOMContentLoaded', () => {
    const kernel = new Kernel();
    const router = kernel.getRouter();

    // Örnek middleware'ler
    kernel.use(() => console.log('✓ Kernel hazırlanıyor...'));
    kernel.use(() => console.log('✓ Router başlatılıyor...'));

    // Router'ı başlat
    router.init();

    // Kernel'ı başlat
    kernel.bootstrap();

    window.kernel = kernel;
    window.router = router;
});
