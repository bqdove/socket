<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-17 14:46
 */
namespace Notadd\Socket;

use Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar;
use Notadd\Socket\Commands\SocketServerCommand;

/**
 * Class Extension.
 */
class Extension extends ExtensionRegistrar
{
    /**
     * @return array
     */
    public function getExtensionInfo()
    {
        return [
            'author' => 'twilroad <269044570@qq.com>',
            'description' => 'A module for Notadd',
        ];
    }

    /**
     * @return string
     */
    public function getExtensionName()
    {
        return 'notadd/socket';
    }

    /**
     * @return string
     */
    public function getExtensionPath()
    {
        return realpath(__DIR__ . '/../');
    }

    /**
     * @return array
     */
    public function loadCommands()
    {
        return [
            SocketServerCommand::class
        ];
    }
}
