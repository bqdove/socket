<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-17 14:46
 */
namespace Notadd\Socket;

use Notadd\Foundation\Extension\Abstracts\Extension as AbstractExtension;
use Notadd\Socket\Commands\SocketServerCommand;

/**
 * Class Extension.
 */
class Extension extends AbstractExtension
{
    /**
     * Boot extension.
     */
    public function boot()
    {
        $this->commands(SocketServerCommand::class);
    }
}
