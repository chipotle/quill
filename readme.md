# Quill

"Quill" is the back end software for Claw & Quill, an online magazine; while plans are for it to be abstracted to a more general purpose online magazine publishing system, right now there are bits of code which are very C&Q-specific, most notably the CSS/Typekit styling.

**Quill** is being developed with the [Laravel 4][l4] framework and requires PHP 5.4 and MySQL/MariaDB 5.5. (It *should* work with other database back ends, although create table migrations may need to be modified.) It also requires an [IronMQ][mq] message queue available and defined in `app/config/queue.php`.

[l4]: http://laravel.com/
[mq]: http://www.iron.io/mq

As written, **Quill** makes the following deployment assumptions: the production and staging server are both a shared Linode VPS running Nginx and PHP-FPM on Arch Linux, and deployment is handled via Capistrano. The Capistrano configurations are in the repository.
