
<?php

namespace ScoreBoard;

use pocketmine\scheduler\CallBackTask;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\Player;

class ScoreBoard extends PluginBase implements Listener{
	//* Not Done *//
	protected $tag = [];
	
	public $cfg;
	
	public function onEnable(){
		$this->getLogger()->info("§bCreated By Skiddy");
		
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "ScoreBoard")), 20 * 1);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		$this->cfg = $this->getConfig();
        $this->saveDefaultConfig();      
        
        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");

        $this->pp = $this->getServer()->getPluginManager()->getPlugin("PurePerms");

   }
   public function ScoreBoard(){
   	foreach ($this->getServer()->getDefaultLevel()->getPlayers() as $p) {
            $tps = $this->getServer()->getTicksPerSecondAverage();

   	     $date = date("m/d/y");

        	$hour = date("H");

        	$minutes = date("i");
        
            $seconds = date("s");

        	$money = $this->eco->myMoney($p);

        	$rank = $this->pp->getUserDataMgr()->getGroup($p)->getName();

        	$online = count($this->getServer()->getOnlinePlayers());

        	$max = $this->getServer()->getMaxPlayers();

        	$space = str_repeat(" ", 75);
            	$cfg = $this->getConfig();
            	$msg = str_replace("{tps}", $this->getServer()->getTicksPerSecondAverage(), $cfg->get("ScoreBoard"));
				$msg = str_replace("{pname}", $p->getName(), $msg);
			    $msg = str_replace("{space}", str_repeat(" ", 75), $msg);
			    $msg = str_replace("{rank}", $this->pp->getUserDataMgr()->getGroup($p)->getName(), $msg);
			    $msg = str_replace("{money}", $this->eco->myMoney($p), $msg);
			    $msg = str_replace("{online}", count($this->getServer()->getOnlinePlayers()), $msg);
			    $msg = str_replace("{date}", date("m/d/y"), $msg);
			    $msg = str_replace("{hour}", date("H"), $msg);
			    $msg = str_replace("{minute}", date("i"), $msg);
			    $msg = str_replace("{seconds}", date("s"), $msg);
			    $msg = str_replace("{health}", $p->getHealth(), $msg);
			    $msg = str_replace("{line}", "\n", $msg);
            	$p->sendTip("$msg");
            }
        }
    }
              
		
		
