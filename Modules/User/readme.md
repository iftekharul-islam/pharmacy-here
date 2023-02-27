**Instructions**

Please remove the users migration from the root migraton folder if you use this module.

- Update config/auth.php by `'model' => Modules\User\Models\User::class,`

- Run this: `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"`

- Add this in the app/Http/Kernel.php
```
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,

```
