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

use pocketmine\scheduler\Task;
use pocketmine\Server;

class TimeTask extends Task {

    public function __construct(OnlineTime $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick) : void
    {
        foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $this->plugin->time[$player->getName()] = $this->plugin->time[$player->getName()] + 1;
        }
    }
}