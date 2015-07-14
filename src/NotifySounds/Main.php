<?php

namespace NotifySounds;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\PlayerChatEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\Level;

use pocketmine\level\sound\BatSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\DoorSound;
use pocketmine\level\sound\FizzSound;
use pocketmine\level\sound\LaunchSound;
use pocketmine\level\sound\PopSound;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->saveDefaultConfig();
		$this->getLogger()->info(TextFormat::BLUE . "NotifySound enabled");
	}
	public function onDisable(){
		$this->getLogger()->info(TextFormat::RED . "NotifySound disabled");
	}
	
	// Is NotifySounds enabled?
	private $enabled = true;
	
	// Command to disable / enable NotifySounds
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		if(strtolower($command->getName()) == "nf"){
			if(!($sender->hasPermission("notify") || $sender->hasPermission("notify.command") || $sender->hasPermission("notify.command.nf"))){
				$sender->sendMessage(TextFormat::RED . "You don't have permission to use that command!");
				return true;
			}else{
				if(!(isset($args[0]))){
					return false;
				}else{
					if($args[0] == "on"){
						if($this->enabled === true){
							$sender->sendMessage("NotifySounds are already enabled!");
							return true;
						}else{
							$this->enabled = true;
							$sender->sendMessage("NotifySounds enabled!");
							return true;
						}
					}elseif($args[0] == "off"){
						if($this->enabled[0] === false){
							$sender->sendMessage("NotifySounds are already disabled!");
							return true;
						}else{
							$this->enabled[0] = false;
							$sender->sendMessage("NotifySounds disabled");
						}
					}else{
						return false;
					}
				}
			}
		}
	}
	
	// Send the players the sound
	public function onPlayerChatEvent(PlayerChatEvent $event){
		$player = $event->getPlayer()->getDisplayName();
		$sound = $this->getConfig()->get("Sound");
		if($this->enabled === true){
			foreach($this->getServer()->getOnlinePlayers() as $p){
				if($p !== $player){
					if($p->hasPermission("notify") || $p->hasPermission("notify.sound")){
//Only attack&heal(Close his chat box) the one who sends message to the chat
$player->attack(1);
$player->heal(1);
//Add sound to all players						$p->getLevel()->addSound(new ClickSound($p), $this->getServer()->getOnlinePlayers());
					}
				}
			}
		}
	}
}
