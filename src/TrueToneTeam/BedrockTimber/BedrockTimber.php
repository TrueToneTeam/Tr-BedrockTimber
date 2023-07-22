<?php

namespace TrueToneTeam\BedrockTimber;

use pocketmine\block\Block;
use pocketmine\block\Wood;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\Axe;
use pocketmine\math\Facing;
use pocketmine\plugin\PluginBase;

class BedrockTimber extends PluginBase implements Listener{

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onBreak(BlockBreakEvent $event) : void{
		$block = $event->getBlock();
		$playerInventory = $event->getPlayer()->getInventory();
		if($playerInventory->getItemInHand() instanceof Axe && $block instanceof Wood){
			$this->blockBreak($block);
		}
	}

	public function blockBreak(Block $block){
		$blockPos = $block->getPosition();
		foreach(Facing::ALL as $face){
			$sideBlock = $block->getSide($face);
			if($block->hasSameTypeId($sideBlock)){
				$blockPos->getWorld()->useBreakOn($sideBlock->getPosition());
				$this->blockBreak($sideBlock);
			}
		}
	}
}