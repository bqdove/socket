<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-17 16:04
 */
namespace Notadd\Socket\Commands;
use Illuminate\Support\Collection;
use Notadd\Foundation\Console\Abstracts\Command;
use Psr\Log\LoggerInterface;
use Swoole\Server;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class SocketServerCommand
 * @package Notadd\Socket\Commands
 */
class SocketServerCommand extends Command {
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;
    /**
     * SocketServerCommand constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger) {
        parent::__construct();
        $this->logger = $logger;
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->addOption('host', null, InputOption::VALUE_REQUIRED, '指定监听的IP地址', '127.0.0.1');
        $this->addOption('port', null, InputOption::VALUE_REQUIRED, '指定监听的端口', '9501');
        $this->addOption('connection', null, InputOption::VALUE_OPTIONAL, '最大连接数', 10000);
        $this->addOption('daemonize', null, InputOption::VALUE_OPTIONAL, '守护进程化', 1);
        $this->addOption('reactor', null, InputOption::VALUE_OPTIONAL, 'Reactor线程数', 2);
        $this->addOption('worker', null, InputOption::VALUE_OPTIONAL, 'Worker进程数', 4);
        $this->addOption('request', null, InputOption::VALUE_OPTIONAL, '最大请求数', 0);
        $this->addOption('backlog', null, InputOption::VALUE_OPTIONAL, 'Listen队列长度', 128);
        $this->setDescription('Start a Swoole Socket Server');
        $this->setName('socket:server');
    }
    /**
     * @return bool
     */
    protected function fire() {
        if(!extension_loaded('swoole')) {
            $this->error('PHP extension swoole is not installed!');
            return false;
        }
        $host = $this->input->getOption('host');
        $port = $this->input->getOption('port');
        $server = new Server($host, $port);
        $server->shutdown();
        $setting = new Collection();
        $setting->put('max_conn', $this->input->getOption('connection'));
        $setting->put('daemonize', $this->input->getOption('daemonize'));
        $setting->put('reactor_num', $this->input->getOption('reactor'));
        $setting->put('worker_num', $this->input->getOption('worker'));
        $setting->put('max_request', $this->input->getOption('request'));
        $setting->put('backlog', $this->input->getOption('backlog'));
        $server->set($setting->toArray());
        $server->on('Start', function() {
            $this->logger->info("Swoole Socket Server Started!");
        });
        $server->on('Connect', function(Server $server, $fd) {
            $server->send($fd, "Welcome {$fd}!");
            $this->logger->info("Client {$fd} Connected!", [$server, $fd]);
        });
        $server->on('Receive', function (Server $server, $fd, $from_id, $data) {
            $this->logger->info("Received from client {$fd}, data: {$data}", [$server, $fd, $from_id, $data]);
            $server->send($fd, $data);
            $this->logger->info("Send data to client {$fd}");
        });
        $server->on('Close', function(Server $server, $fd) {
            $this->logger->info("Client {$fd} disconnected!", [$server, $fd]);
        });
        $server->start();
        return true;
    }
}