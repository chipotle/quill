# Quill

"Quill" is the back end software for Claw & Quill, an online magazine; while plans are for it to be abstracted to a more general purpose online magazine publishing system, right now there are bits of code which are very C&Q-specific, most notably the CSS/Typekit styling.

**Quill** is being developed with the [Laravel 4][l4] framework and requires PHP 5.4 and MySQL/MariaDB 5.5. (It *should* work with other database back ends, although create table migrations may need to be modified.) It also requires an [IronMQ][mq] message queue available and defined in `app/config/queue.php`.

[l4]: http://laravel.com/
[mq]: http://www.iron.io/mq

As written, **Quill** makes the following deployment assumptions: the production and staging server are both a shared Linode VPS running Nginx and PHP-FPM on Arch Linux, and deployment is handled via Capistrano. The Capistrano configurations are in the repository.

Javascript and SCSS files in the `/js` and `scss/` directories repsectively are compiled to the `public/` directory using [CodeKit][ck], with the following settings:

[ck]: http://incident57.com/codekit/

* `/scss/admin.scss`: compressed output
* `/scss/bootstrap.min.scss`: do not compile directly
* `/scss/cnq-include.scss`: do not compile directly
* `/scss/cnq.scss`: compressed output
* `/scss/normalize.scss`: do not compile directly
* `/js/admin.js`: concatenate + minify; prepend bootstrap.js
* `/js/bootstrap.js`: do not compile directly
* anything in `/public/`: do not compile directly

This will (probably) eventually be a build script.
