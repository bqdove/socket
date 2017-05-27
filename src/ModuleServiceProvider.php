<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-27 19:54
 */
namespace Notadd\Socket;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Module\Abstracts\Module;
use Notadd\Socket\Listeners\PermissionGroupRegister;
use Notadd\Socket\Listeners\PermissionModuleRegister;
use Notadd\Socket\Listeners\PermissionRegister;
use Notadd\Socket\Listeners\PermissionTypeRegister;

/**
 * Class ModuleServiceProvider.
 */
class ModuleServiceProvider extends Module
{
    /**
     * Boot module.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(PermissionGroupRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionModuleRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionTypeRegister::class);
    }

    /**
     * Description of module
     *
     * @return string
     */
    public static function description()
    {
        // TODO: Implement description() method.
    }

    /**
     * Install for module.
     *
     * @return string
     */
    public static function install()
    {
        // TODO: Implement install() method.
    }

    /**
     * Name of module.
     *
     * @return string
     */
    public static function name()
    {
        // TODO: Implement name() method.
    }

    /**
     * Uninstall for module.
     *
     * @return string
     */
    public static function uninstall()
    {
        // TODO: Implement uninstall() method.
    }

    /**
     * Version of module.
     *
     * @return string
     */
    public static function version()
    {
        // TODO: Implement version() method.
    }
}
