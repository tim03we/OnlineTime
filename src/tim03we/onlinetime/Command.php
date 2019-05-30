<?php

namespace tim03we\onlinetime;

use pocketmine\command\CommandSender;
use pocketmine\Player;

class Command extends \pocketmine\command\Command {

    public function __construct(OnlineTime $plugin)
    {
        parent::__construct("onlinetime", "View your online time", "/onlinetime", ["onlinet", "ot"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $msg = $this->plugin->cfg->getNested("command.message");
            $msg = str_replace("{time}", $this->plugin->getRealTime($sender), $msg);
            $sender->sendMessage($msg);
        } else {
            $sender->sendMessage("Run this command InGame!");
        }
        return true;
    }
}