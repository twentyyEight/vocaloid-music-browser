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
        index: () => import('./index'),
        song: () => import('./song'),
        album: () => import('./album'),
        artist: () => import('./artist'),
        home: () => import('./home')
    }

    pages[page]?.()
})