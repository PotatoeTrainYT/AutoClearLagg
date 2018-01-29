<?php

declare(strict_types=1);

namespace AutoClearLagg;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

use pocketmine\utils\TextFormat;

class Main extends PluginBase {

    public function onEnable() : void {
        $this->getLogger()->info(TextFormat::GREEN . "AutoClearLagg Enabled.");
        $this->getLogger()->info(TextFormat::YELLOW . "Download: " . TextFormat::AQUA . "https://github.com/PotatoeTrainYT/AutoClearLagg/");
        $this->getLogger()->info(TextFormat::YELLOW . "Author: " . TextFormat::AQUA . "Potatoe");
        @mkdir($this->getDataFolder());
        $this->saveResource("settings.yml");
        $this->settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->scheduler();
    }

    public function scheduler() {
        if(is_numeric($this->settings->get("seconds"))) {
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new ClearLaggTask($this), $this->settings->get("seconds") * 20);
        } else {
            $this->getLogger()->warning("Plugin disabling, Seconds is not a numeric value please edit");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }
}
