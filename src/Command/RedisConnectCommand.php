<?php
// src/Command/RedisConnectCommand.php

namespace App\Command;

use Predis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RedisConnectCommand extends Command
{
    /**
     * In this method setup command, description and its parameters
     */
    protected function configure()
    {
        $this->setName('redis:cek');
        $this->setDescription('Cek redis server aktif atau tidak');
        // $this->addArgument('password', InputArgument::REQUIRED, 'Password to be hashed.');
    }

    /**
     * Here all logic happens
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);

        $output->writeln(sprintf(
            'Koneksi: %s', $client->auth('')
        ));

        
        return 0;
    }
}

final class CheckKeyCommand extends Command
{
    /**
     * In this method setup command, description and its parameters
     */
    protected function configure()
    {
        $this->setName('redis:keys');
        $this->setDescription('Check list key redis');
        // $this->addArgument('password', InputArgument::REQUIRED, 'Password to be hashed.');
    }

    /**
     * Here all logic happens
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
            'password'   => '',
        ]);

        $output->writeln(sprintf(
            'Koneksi: %s', print_r($client->keys('*'))
        ));

        
        return 0;
    }
}

final class RedisDeleteCommand extends Command
{
    /**
     * In this method setup command, description and its parameters
     */
    protected function configure()
    {
        $this->setName('redis:delete');
        $this->setDescription('Hapus data key redis');
        $this->addArgument('keys', InputArgument::REQUIRED, 'Silahkan masukan keys.');
    }

    /**
     * Here all logic happens
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $keys = $input->getArgument('keys');
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
            'password'   => '',
        ]);

        $output->writeln(sprintf(
            'Hapus Keys : %s', $client->del($keys)
        ));

        return 0;
    }
}

final class RedisSetCommand extends Command
{
    /**
     * In this method setup command, description and its parameters
     */
    protected function configure()
    {
        $this->setName('redis:set');
        $this->setDescription('Set data key redis');
        // $this->addArgument('keys', InputArgument::REQUIRED, 'Silahkan masukan keys.');
    }

    /**
     * Here all logic happens
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $keys = $input->getArgument('keys');
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
            'password'   => '',
        ]);

        

        $array = array(

            'message' =>  "My message",
            'to_send' => 2,
            'from_send' => 1,                            
            'create_time' => date('Y-m-d H:i:s')
        );

        $encode_message =json_encode($array);

        // $redis->SET("messages",$encode_message);

        // $getMessages = $redis ->GET("messages");
        // $decodeMessages = json_decode($getMessages,true);

        $output->writeln(sprintf(
            'data : %s', $client->set("messages",$encode_message)
        ));
        return 0;
    }
}

final class RedisGetCommand extends Command
{
    /**
     * In this method setup command, description and its parameters
     */
    protected function configure()
    {
        $this->setName('redis:get');
        $this->setDescription('Get data key redis');
        $this->addArgument('keys', InputArgument::REQUIRED, 'Silahkan masukan keys.');
    }

    /**
     * Here all logic happens
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $keys = $input->getArgument('keys');
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
            'password'   => '',
        ]);

        $getMessages = $client->get($keys);
        $decodeMessages = json_decode($getMessages,true);

        $output->writeln(sprintf(
            'data : %s', print_r($decodeMessages)
        ));
        return 0;
    }
}