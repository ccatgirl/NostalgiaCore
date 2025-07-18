<?php

class CobblestoneBlock extends SolidBlock{
	public static $blockID;
	public function __construct(){
		parent::__construct(COBBLESTONE, 0, "Cobblestone");
		$this->hardness = 30;
		$this->breakTime = 2;
		$this->material = Material::$stone;
		$this->lightBlock = 255;
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}
		return match ($item->getPickaxeLevel()) {
			5 => 0.4,
			4 => 0.5,
			3 => 0.75,
			2 => 0.25,
			1 => 1.5,
			default => 10,
		};
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array(COBBLESTONE, 0, 1),
			);
		}else{
			return array();
		}
	}
}
