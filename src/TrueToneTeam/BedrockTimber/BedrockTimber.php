<?php

namespace TrueToneTeam\BedrockTimber;

use pocketmine\block\Block;
use pocketmine\block\Wood;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\math\Facing;
use pocketmine\plugin\PluginBase;

class BedrockTimber extends PluginBase implements Listener{

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onBreak(BlockBreakEvent $event) : void{
		$this->blockBreak($event->getBlock());
	}

	public function blockBreak(Block $block){
		$blockPos = $block->getPosition();
		if($block instanceof Wood){
			foreach(Facing::ALL as $face){
				$sideBlock = $block->getSide($face);
				if($block->hasSameTypeId($sideBlock)){
					$blockPos->getWorld()->useBreakOn($sideBlock->getPosition());
					$this->blockBreak($sideBlock);
				}
			}
		}
	}
}