<?php
declare(strict_types=1);

namespace twisted\autoclearlagg;

class LagClearEvent extends \pocketmine\event\plugin\PluginEvent {

	public function __construct(\twisted\autoclearlagg\AutoClearLagg $plugin, int $entitiesCleared) {
		unset($plugin);
		$this->count = $entitiesCleared;
		unset($entitiesCleared);
	}

	public function getEntitiesCleared() : int {
		return $this->count;
	}
}