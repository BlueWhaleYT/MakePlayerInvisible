<?php

namespace BlueWhaleYT\MakePlayerInvisible;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;

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
    $itemData = $player->getInventory()->getItemInHand()->getDamage();
    $itemName = $player->getInventory()->getItemInHand()->getName();
    $level = $player->getLevel()->getName();
    
    if($itemIds == 351 and $itemData == 10 and $itemName == "§a§lInvisible"){
      if($level === "world"){
      $player->getLevel()->addSound(new PopSound(new Vector3($player->getX(), $player->getY(), $player->getZ())));
      $this->onInvisible($player);
      $player->getInventory()->setItem(7, Item::get(351, 8, 1)->setCustomName("§7§lVisible"));
      }
    }
    if($itemIds == 351 and $itemData == 8 and $itemName == "§7§lVisible"){
      if($level === "world"){
      $player->getLevel()->addSound(new PopSound(new Vector3($player->getX(), $player->getY(), $player->getZ())));
      $this->onVisible($player);
      $player->getInventory()->setItem(7, Item::get(351, 10, 1)->setCustomName("§a§lInvisible"));
      }
    }
    
  }
  
  public function onJoin(PlayerJoinEvent $event){
    $player = $event->getPlayer();
    $player->getInventory()->setItem(7, Item::get(351, 10, 1)->setCustomName("§a§lInvisible"));
    
  }
  
  public function onDeath(PlayerDeathEvent $event){
    $player = $event->getPlayer();
    $player->getInventory()->setItem(7, Item::get(351, 10, 1)->setCustomName("§a§lInvisible"));
    
  }
  
  public function onDrop(PlayerDropItemEvent $ev){
    $player = $ev->getPlayer();
    $itemIds = $player->getInventory()->getItemInHand()->getId();
    $itemName = $player->getInventory()->getItemInHand()->getName();
    $itemData = $player->getInventory()->getItemInHand()->getDamage();
    if($itemIds == 351 and $itemData == 10 and $itemName == "§a§lInvisible"){
      $ev->setCancelled();
    }
    if($itemIds == 351 and $itemData == 8 and $itemName == "§7§lVisible"){
      $ev->setCancelled();
    }
  }
  
  public function onTransaction(InventoryTransactionEvent $ev){
    foreach($ev->getTransaction()->getActions() as $action){
      
      $itemIds = $action->getSourceItem()->getId();
    $itemName = $action->getSourceItem()->getCustomName();
    $itemData = $action->getSourceItem()->getDamage();
    
      if($itemIds == 351 and $itemData == 10 and $itemName == "§a§lInvisible"){
        $ev->setCancelled();
      }
      if($itemIds == 351 and $itemData == 8 and $itemName == "§7§lVisible"){
        $ev->setCancelled();
      }
    }
    
  }
  
  public function onInvisible($player){
    foreach($this->getServer()->getOnlinePlayers() as $players){
$player->hidePlayer($players);
    }
    $player->sendPopup("Player" . TF::GREEN . TF::BOLD . " Enabled\n\n\n");
  }
  
  public function onVisible($player){
    foreach($this->getServer()->getOnlinePlayers() as $players){
$player->showPlayer($players);
    }
    $player->sendPopup("Player" . TF::RED . TF::BOLD . " Disabled\n\n\n");
  }
  
}