// Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

// SCSS
import '../scss/app.scss';

// jQuery UI
import './bootstrap';
import 'jquery-ui/dist/jquery-ui';

// JS
$(function () {

    const page = $('.page').data('page')

    const pages = {
        index: () => import('./pages/index'),
        song: () => import('./pages/song'),
        album: () => import('./pages/album'),
        artist: () => import('./pages/artist'),
        home: () => import('./pages/home'),
        profile: () => import('./pages/profile'),
        dashboard: () => import('./pages/dashboard')
    }

    pages[page]?.()
})