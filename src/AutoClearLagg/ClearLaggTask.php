<?php

declare(strict_types=1);

namespace AutoClearLagg;

use pocketmine\entity\Creature;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;

use pocketmine\scheduler\PluginTask;

class ClearLaggTask extends PluginTask {

	private $plugin;

	public function __construct(Main $main){
		$this->main = $main;
		parent::__construct($main);
	}

	public function onRun(int $currentTick) {
        $main = $this->main;
          $settings = $main->settings;
		if($settings->get("items") == true and $settings->get("mobs") == true) {
              $this->clearItems();
              $this->clearMobs();
              $main->getServer()->broadcastMessage($settings->get("all-cleared-message"));
          }
		if($settings->get("items") == true and $settings->get("mobs") == false) {
              $this->clearItems();
              $main->getServer()->broadcastMessage($settings->get("items-cleared-message"));
          }
		if($settings->get("mobs") == true and $settings->get("items") == false) {
              $this->clearMobs();
              $main->getServer()->broadcastMessage($settings->get("mobs-cleared-message"));
          }
    }
    
    public function clearItems() : int {
        $main = $this->main;
        $i = 0;
        foreach($main->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if(!$this->isEntityExempted($entity) && !($entity instanceof Creature)) {
                    $entity->close();
                    $i++;	
                }
            }		
        }	
        return $i;
    }

    public function clearMobs() : int {
        $main = $this->main;
        $i = 0;
        foreach($main->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if(!$this->isEntityExempted($entity) && $entity instanceof Creature && !($entity instanceof Human)) {
                    $entity->close();
                    $i++;	
                }
            }		
        }	
        return $i;
    }

    public function exemptEntity(Entity $entity) : void {
        $this->exemptedEntities[$entity->getID()] = $entity;
    }

    public function isEntityExempted(Entity $entity) : bool {
        return isset($this->exemptedEntities[$entity->getID()]);
    }
}

