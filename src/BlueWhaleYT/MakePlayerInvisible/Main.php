<?php

namespace BlueWhaleYT\MakePlayerInvisible;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\item\Item;
use pocketmine\item\ItemIds;

use pocketmine\level\Level;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;

use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase implements Listener{
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function onInteract(PlayerInteractEvent $event){
    $player = $event->getPlayer();
    $itemIds = $player->getInventory()->getItemInHand()->getId();
    $itemName = $player->getInventory()->getItemInHand()->getName();
    
    if($itemIds == 369 and $itemName == "Invisible"){
      $player->getLevel()->addSound(new PopSound(new Vector3($player->getX(), $player->getY(), $player->getZ())));
      $this->onInvisible($player);
      $player->getInventory()->setItem(7, Item::get(280, 0, 1)->setCustomName("Visible"));
    }
    if($itemIds == 280 and $itemName == "Visible"){
      $player->getLevel()->addSound(new PopSound(new Vector3($player->getX(), $player->getY(), $player->getZ())));
      $this->onVisible($player);
      $player->getInventory()->setItem(7, Item::get(369, 0, 1)->setCustomName("Invisible"));
    }
    
  }
  
  public function onJoin(PlayerJoinEvent $event){
    $player = $event->getPlayer();
    $player->getInventory()->setItem(7, Item::get(369, 0, 1)->setCustomName("Invisible"));
    
  }
  
  public function onInvisible($player){
    foreach($this->getServer()->getOnlinePlayers() as $players){
$player->hidePlayer($players);
    }
    $player->addTitle("Player Invisible", TF::GREEN . "Enabled", 20, 20, 20);
  }
  
  public function onVisible($player){
    foreach($this->getServer()->getOnlinePlayers() as $players){
$player->showPlayer($players);
    }
    $player->addTitle("Player Invisible", TF::RED . "Disabled", 20, 20, 20);
  }
  
}
