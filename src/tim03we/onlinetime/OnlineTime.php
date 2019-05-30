<?php

/*
 * Copyright (c) 2019 tim03we  < https://github.com/tim03we >
 * Discord: tim03we | TP#9129
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * OnlineTime is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 */

namespace tim03we\onlinetime;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class OnlineTime extends PluginBase implements Listener {

    public $time = [];

    public function onLoad() {
        foreach ($this->getServer()->getOnlinePlayers() as $player) {
            $this->time[$player->getName()] = 0;
        }
    }

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder() . "players/");
        $this->saveResource("settings.yml");
        $this->cfg = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->getScheduler()->scheduleRepeatingTask(new TimeTask($this), 20);
        if($this->cfg->getNested("command.enable", !false)) {
            $this->getServer()->getCommandMap()->register("onlinetime", new Command($this));
        }
    }

    public function onLogin(PlayerPreLoginEvent $event) {
        $player = $event->getPlayer();
        if(!file_exists($this->getDataFolder() . "players/" . $player->getName() . ".yml")) {
            $cfg = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
            $cfg->set("time", 0);
            $cfg->save();
        }
        $this->time[$player->getName()] = 0;
    }

    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $cfg = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
        $getTime = $cfg->get("time") + $this->time[$player->getName()];
        $cfg->set("time", $getTime);
        $cfg->save();
    }

    public function onDisable() {
        foreach ($this->getServer()->getOnlinePlayers() as $player) {
            $cfg = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
            $getTime = $cfg->get("time") + $this->time[$player->getName()];
            $cfg->set("time", $getTime);
            $cfg->save();
        }
    }

    public function getTime(Player $player) {
        $name = $player->getName();
        $cfg = new Config($this->getDataFolder() . "players/$name.yml", Config::YAML);
        $get = $cfg->get("time") + $this->time[$player->getName()];
        return "$get";
    }

    public function getRealTimeHours($player) {
        $cfg = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
        $hours = floor($cfg->get("time") + $this->time[$player->getName()] / 3600);
        return "$hours";
    }

    public function getRealTimeMinutes($player) {
        $cfg = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
        $minutes = floor(($cfg->get("time") + $this->time[$player->getName()] / 60) % 60);
        return "$minutes";
    }

    public function getRealTimeSeconds($player) {
        $cfg = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
        $seconds = $cfg->get("time") + $this->time[$player->getName()] % 60;
        return "$seconds";
    }

    public function getRealTime($player) {
        $cfg = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
        $hours = floor(($cfg->get("time") + $this->time[$player->getName()]) / 3600);
        $minutes = floor((($cfg->get("time") + $this->time[$player->getName()]) / 60) % 60);
        $seconds = ($cfg->get("time") + $this->time[$player->getName()]) % 60;
        $format = $this->cfg->get("time-format");
        $format = str_replace("{hours}", $hours, $format);
        $format = str_replace("{minutes}", $minutes, $format);
        $format = str_replace("{seconds}", $seconds, $format);
        return "$format";
    }
}