<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
set_time_limit(0);
echo("   __            _           _   \r\n");
echo("  / _|          | |         | |  \r\n");
echo(" | |_ ___ __  __| |__   ___ | |_ \r\n");
echo(" |  _/ _ \\\\ \\/ /| '_ \\ / _ \\| __|\r\n");
echo(" | || (_) |>  < | |_) | (_) | |_ \r\n");
echo(" |_| \___//_/\_\|_.__/ \___/ \__|\r\n");
echo("A poorly-coded PHP bot!\r\n");


	class fox {
		var $socket;
		var $ex = array();

		function __construct()
		{	
			global $config;
			$this->connect();
			$this->sql_connect();
			$this->b = "\002";
			$this->o = "\002";

			$this->main();
		}
		function main()
		{
			global $config;
			while (true)
			{
				$this->date = date("n j Y g i s a");
				if (!$this->socket || !$this->mysql) {
					die("Fail server or fail mysql\r\n");
				}

				$data = fgets($this->socket, 4096);
				echo("[~R] ".$data);
				flush();
				$this->ex = explode(' ', $data);

				foreach ($this->ex as &$trim)
				{
					$trim = trim($trim);
				}

				if ($this->ex[0] == 'PING')
				{
					$this->send_data('PONG', $this->ex[1]);
				}

				if ($this->ex[1] == '376' || $this->ex[1] == '422')
				{
					$this->idandjoin();
				}
				// PRIVMSG ~~~~~~~~~~~~
				if ($this->ex[1] == 'PRIVMSG') {

					preg_match("/^:(.*?)!(.*?)@(.*?)[\s](.*?)[\s](.*?)[\s]:(.*?)$/", $data, $rawdata);
					$this->nick[$data] = $rawdata[1];
					$this->ident[$data] = $rawdata[2];
					$this->host[$data] = $rawdata[3];
					$this->h[$this->nick[$data]] = $this->host[$data];
					$msg_type[$data] = $rawdata[4];
					$this->channel[$data] = $rawdata[5]; 
					$this->args[$data] = trim($rawdata[6]);
	if (!$this->ignore[$this->h[$this->nick[$data]]]) {
					if (strtolower($this->ex[3]) == ":.ignore") {
						if (strtolower($this->host[$data]) == strtolower($config->ownerhost)) {
							if ($this->ex[4]) {
								if ($this->h[$this->ex[4]]) {
									$this->ignore[$this->h[$this->ex[4]]] = true;
									$this->privmsg($this->channel[$data], $this->b."*!*@".$this->h[$this->ex[4]].$this->o." was added to the ignore list.");
								} else { $this->privmsg($this->channel[$data], "I do not recognize ".$this->b.$this->ex[4].$this->o."."); }			
							} else { $this->notice($this->nick[$data], "Incorrect syntax. ".$this->b.".ignore <nick>"); }			
						} else { $this->notice($this->nick[$data], "You are not a fox admin."); }					
					}	
					elseif (strtolower($this->ex[3]) == ":.unignore") {
						if (strtolower($this->host[$data]) == strtolower($config->ownerhost)) {
							if ($this->ex[4]) {
								if ($this->h[$this->ex[4]]) {
									unset($this->ignore[$this->h[$this->ex[4]]]);
									$this->privmsg($this->channel[$data], $this->b."*!*@".$this->h[$this->ex[4]].$this->o." was removed from the ignore list.");
								} else { $this->privmsg($this->channel[$data], "I do not recognize ".$this->b.$this->ex[4].$this->o."."); }			
							} else { $this->notice($this->nick[$data], "Incorrect syntax. ".$this->b.".ignore <nick>"); }			
						} else { $this->notice($this->nick[$data], "You are not a fox admin."); }					
					}	
					elseif (strtolower($this->ex[3]) == ":.assign") {
						if (strtolower($this->host[$data]) == strtolower($config->ownerhost)) {
							if ($this->ex[4]) {
								$this->assign(trim($this->ex[4]), $this->channel[$data], $this->nick[$data]);
							} else { $this->notice($this->nick[$data], "Incorrect syntax. ".$this->b.".assign <channel>"); }	
						}
						else { $this->notice($this->nick[$data], "You are not a fox admin."); }	
					}
					elseif (strtolower($this->ex[3]) == ":.unassign") {
						if (strtolower($this->host[$data]) == strtolower($config->ownerhost)) {
							if ($this->ex[4]) {
								$this->unassign(trim($this->ex[4]), $this->channel[$data], $this->nick[$data]);
							} else { $this->notice($this->nick[$data], "Incorrect syntax. ".$this->b.".unassign <channel>"); }	
						}
						else { $this->notice($this->nick[$data], "You are not a fox admin."); }	
					}
					elseif (strtolower($this->ex[3]) == ":.clear") {
						if (strtolower($this->host[$data]) == strtolower($config->ownerhost)) {
							if ($this->ex[4] == "quotes") {
								mysql_query("delete from quotes");
								$this->privmsg($this->channel[$data], "All quotes have been deleted.");
							} elseif ($this->ex[4] == "pics") {
								mysql_query("delete from pics");
								$this->privmsg($this->channel[$data], "All pictures have been deleted.");
							} else {
								$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".clear quotes|pics");
							}
							
						} else { $this->notice($this->nick[$data], "You are not a fox admin."); }					
					}
					elseif (strtolower($this->ex[3]) == ":.eval") {
						if (strtolower($this->host[$data]) == strtolower($config->ownerhost)) {
							$eval = substr($this->args[$data], 6);
							$this->notice($this->nick[$data], $this->b."[Eval] ".$this->o.$eval);
							eval($eval);
						}
					}
					elseif (strtolower($this->ex[3]) == ":.help") {
						$this->privmsg($this->channel[$data], ".add <command> <response>".$this->b." | ".$this->o.".del <command>".$this->b." | ".$this->o.".info <command>".$this->b." | ".$this->o.".amnt".$this->b." | ".$this->o.".addme <command> <response>".$this->b." | ".$this->o.".addact <command> <response>".$this->b." | ".$this->o.".infoact <command>".$this->b." | ".$this->o.".addactme <command> <response>".$this->b." | ".$this->o.".delact <command>".$this->b." | ".$this->o.".q add|del|<id>"); $this->privmsg($this->channel[$data], ".pic add|del|<id>".$this->b." | ".$this->o.".eval <eval>".$this->b." | ".$this->o.".ignore <nick>".$this->b." | ".$this->o.".unignore <nick>".$this->b." | ".$this->o.".clear pics|quotes".$this->b." | ".$this->o.".assign <channel>".$this->b." | ".$this->o.".unassign <channel>".$this->b." | ".$this->o.".addwild <command> <response>".$this->b." | ".$this->o.".addwildme <command> <response>");
					}
					elseif (strtolower($this->ex[3]) == ":.invite") {
						if ($this->ex[4]) {
							$this->send_data("INVITE ".$this->ex[4]." ".$this->channel[$data]);
						} else { $this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".invite <nick>."); }
					}
					elseif (strtolower($this->ex[3]) == ":.amnt") {
						$q = mysql_query("SELECT * FROM commands WHERE channel='".$this->channel[$data]."'");
						$num = mysql_num_rows($q);
						$this->privmsg($this->channel[$data], "I respond to ".$this->b.$num.$this->o." commands in ".$this->b.$this->channel[$data].$this->o.".");
					}
					elseif (strtolower($this->ex[3]) == ":.addact") {
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", "\001ACTION ".addslashes($this->ex[4])."\001");
							if ($check) {
							if (!$check2['command']) {
								if ($this->ex[4] && $this->ex[5]) {
									$this->command[$data] = $this->ex[4];
									$this->command[$data] = str_replace("[]", " ", $this->command[$data]);
									$this->response[$data] = substr($this->args[$data], 9+strlen($this->ex[4]));
									$this->privmsg($this->channel[$data], "If someone acts \"".$this->b.$this->command[$data].$this->o."\", I will now respond with \"".$this->b.$this->response[$data].$this->o."\" in ".$this->b.$this->channel[$data].$this->o.".");
									$this->response[$data] = addslashes($this->response[$data]);
									$this->command[$data] = addslashes("\001ACTION ".$this->command[$data]."\001");
									$this->sql_insert("commands", "'".$this->command[$data]."','".$this->response[$data]."','".addslashes($this->channel[$data])."','".$this->nick[$data]."','".$this->date."','false','false'");
								}
								else {
									$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".add <command> <response>");
								}
							}
							else {
								$this->privmsg($this->channel[$data], "I already respond to that in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
					}
					elseif (strtolower($this->ex[3]) == ":.addactme") {
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", "\001ACTION ".addslashes($this->ex[4])."\001");
							if ($check) {
							if (!$check2['command']) {
								if ($this->ex[4] && $this->ex[5]) {
									$this->command[$data] = $this->ex[4];
									$this->command[$data] = str_replace("[]", " ", $this->command[$data]);
									$this->response[$data] = substr($this->args[$data], 11+strlen($this->ex[4]));
									$this->privmsg($this->channel[$data], "If someone acts \"".$this->b.$this->command[$data].$this->o."\", I will now respond with the action \"".$this->b.$this->response[$data].$this->o."\" in ".$this->b.$this->channel[$data].$this->o.".");
									$this->response[$data] = addslashes("\001ACTION ".$this->response[$data]."\001");
									$this->command[$data] = addslashes("\001ACTION ".$this->command[$data]."\001");
									$this->sql_insert("commands", "'".$this->command[$data]."','".$this->response[$data]."','".$this->channel[$data]."','".$this->nick[$data]."','".$this->date."','false','false'");
								}
								else {
									$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".add <command> <response>");
								}
							}
							else {
								$this->privmsg($this->channel[$data], "I already respond to that in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
					}
					elseif (strtolower($this->ex[3]) == ":.add") {
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->ex[4]));
							if ($check) {
							if (!$check2['command']) {
								if ($this->ex[4] && $this->ex[5]) {
									$this->command[$data] = $this->ex[4];
									$this->command[$data] = str_replace("[]", " ", $this->command[$data]);
									$this->response[$data] = substr($this->args[$data], 6+strlen($this->ex[4]));
									$this->privmsg($this->channel[$data], "If someone says \"".$this->b.$this->command[$data].$this->o."\", I will now respond with \"".$this->b.$this->response[$data].$this->o."\" in ".$this->b.$this->channel[$data].$this->o.".");
									$this->response[$data] = addslashes($this->response[$data]);
									$this->command[$data] = addslashes($this->command[$data]);
									$this->sql_insert("commands", "'".$this->command[$data]."','".$this->response[$data]."','".$this->channel[$data]."','".$this->nick[$data]."','".$this->date."','false','false'");
								}
								else {
									$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".add <command> <response>");
								}
							}
							else {
								$this->privmsg($this->channel[$data], "I already respond to that in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
					}
					elseif (strtolower($this->ex[3]) == ":.addwild") {
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->ex[4]));
							if ($check) {
							if (!$check2['command']) {
								if ($this->ex[4] && $this->ex[5]) {
									$this->command[$data] = $this->ex[4];
									$this->response[$data] = substr($this->args[$data], 10+strlen($this->ex[4]));
									$this->privmsg($this->channel[$data], "If someone says \"".$this->b.$this->command[$data].$this->o."\" anywhere in their message, I will now respond with \"".$this->b.$this->response[$data].$this->o."\" in ".$this->b.$this->channel[$data].$this->o.".");
									$this->response[$data] = addslashes($this->response[$data]);
									$this->command[$data] = addslashes($this->command[$data]);
									$this->sql_insert("commands", "'".$this->command[$data]."','".$this->response[$data]."','".$this->channel[$data]."','".$this->nick[$data]."','".$this->date."','true','false'");
								}
								else {
									$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".add <command> <response>");
								}
							}
							else {
								$this->privmsg($this->channel[$data], "I already respond to that in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
					}
					elseif (strtolower($this->ex[3]) == ":.addwildme") {
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->ex[4]));
							if ($check) {
							if (!$check2['command']) {
								if ($this->ex[4] && $this->ex[5]) {
									$this->command[$data] = $this->ex[4];
									$this->response[$data] = substr($this->args[$data], 12+strlen($this->ex[4]));
									$this->privmsg($this->channel[$data], "If someone says \"".$this->b.$this->command[$data].$this->o."\" anywhere in their message, I will now respond with the action \"".$this->b.$this->response[$data].$this->o."\" in ".$this->b.$this->channel[$data].$this->o.".");
									$this->response[$data] = addslashes($this->response[$data]);
									$this->command[$data] = addslashes($this->command[$data]);
									$this->sql_insert("commands", "'".$this->command[$data]."','".$this->response[$data]."','".$this->channel[$data]."','".$this->nick[$data]."','".$this->date."','true','true'");
								}
								else {
									$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".add <command> <response>");
								}
							}
							else {
								$this->privmsg($this->channel[$data], "I already respond to that in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
					}
					elseif (strtolower($this->ex[3]) == ":.addme") {
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->ex[4]));
							if ($check) {
							if (!$check2['command']) {
								if ($this->ex[4] && $this->ex[5]) {
									$this->command[$data] = $this->ex[4];
									$this->command[$data] = str_replace("[]", " ", $this->command[$data]);
									$this->response[$data] = substr($this->args[$data], 8+strlen($this->ex[4]));
									$this->privmsg($this->channel[$data], "If someone says \"".$this->b.$this->command[$data].$this->o."\", I will now respond with the action \"".$this->b.$this->response[$data].$this->o."\" in ".$this->b.$this->channel[$data].$this->o.".");
									$this->response[$data] = addslashes($this->response[$data]);
									$this->command[$data] = addslashes($this->command[$data]);
									$this->sql_insert("commands", "'".$this->command[$data]."','".$this->response[$data]."','".$this->channel[$data]."','".$this->nick[$data]."','".$this->date."','false','true'");
								}
								else {
									$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".add <command> <response>");
								}
							}
							else {
								$this->privmsg($this->channel[$data], "I already respond to that in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
					}
					elseif (strtolower($this->ex[3]) == ":.del") {
						$this->command[$data] = substr($this->args[$data], 5);
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->command[$data]));
						if ($this->ex[4]) {
							if ($check) {
							if ($check2['command']) {
								$this->privmsg($this->channel[$data], $this->b.$this->command[$data].$this->o." was deleted from the ".$this->b.$this->channel[$data].$this->o." command list.");
								$this->sql_delete("commands", "channel", $this->channel[$data], "command", addslashes($this->command[$data]));
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->command[$data].$this->o." does not exist in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
						}
						else {
							$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".del <command>");
						}
					}
					elseif (strtolower($this->ex[3]) == ":.delact") {
						$this->command[$data] = substr($this->args[$data], 8);
						$this->command[$data] = "\001ACTION ".$this->command[$data]."\001";
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->command[$data]));
						if ($this->ex[4]) {
							if ($check) {
							if ($check2['command']) {
								$this->privmsg($this->channel[$data], $this->b.$this->command[$data].$this->o." was deleted from the ".$this->b.$this->channel[$data].$this->o." command list.");
								$this->sql_delete("commands", "channel", $this->channel[$data], "command", addslashes($this->command[$data]));
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->command[$data].$this->o." does not exist in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
						}
						else {
							$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".del <command>");
						}
					}
					elseif (strtolower($this->ex[3]) == ":.info") {
						$this->command[$data] = substr($this->args[$data], 6);
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->command[$data]));
						if ($this->ex[4]) {
							if ($check) {
							if ($check2['command']) {
								$this->command[$data] = addslashes($this->command[$data]);
								$c = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", $this->command[$data]);
								$this->privmsg($this->channel[$data], "Command = \"".$this->b.$c['command'].$this->o."\" | Response = \"".$this->b.$c['response'].$this->o."\" | Added by ".$this->b.$c['nick'].$this->o." on ".$this->b.$this->convert_date($c['date']));
							 } else {
								$this->privmsg($this->channel[$data], $this->b.$this->command[$data].$this->o." does not exist in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
						}
						else {
							$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".info <command>");
						}
					}
					elseif (strtolower($this->ex[3]) == ":.infoact") {
						$this->command[$data] = substr($this->args[$data], 9);
						$this->command[$data] = "\001ACTION ".$this->command[$data]."\001";
						$check = $this->sql_get("channels", "channel", "channel", $this->channel[$data]);
						$check2 = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->command[$data]));
						if ($this->ex[4]) {
							if ($check) {
							if ($check2['command']) {
								$c = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", $this->command[$data]);
								$this->privmsg($this->channel[$data], "Command = \"".$this->b.$c['command'].$this->o."\" | Response = \"".$this->b.$c['response'].$this->o."\" | Added by ".$this->b.$c['nick'].$this->o." on ".$this->b.$this->convert_date($c['date']));
							 } else {
								$this->privmsg($this->channel[$data], $this->b.$this->command[$data].$this->o." does not exist in ".$this->b.$this->channel[$data].$this->o.".");
							}
							}
							else {
								$this->privmsg($this->channel[$data], $this->b.$this->channel[$data].$this->o." is not in my database.");
							}
						}
						else {
							$this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".infoact <command>");
						}
					}
					elseif (strtolower($this->ex[3]) == ":.q") {
						if (strtolower($this->ex[4]) == "add") {
							if ($this->ex[5]) {
								$this->quote[$data] = substr($this->args[$data], 7);
								$n = mysql_query("select * from quotes");
								$quoteid = mysql_num_rows($n);
								if (intval($quoteid) != 0) { $quoteid++; } else { $quoteid = 1; }
								$this->privmsg($this->channel[$data], $this->b."Added quote #".$quoteid."/".$quoteid.": ".$this->o.$this->quote[$data]);
								$quote[$data] = str_replace("", "", $quote[$data]);
								$quote[$data] = addslashes($quote[$data]);
								$this->sql_insert("quotes", "'".$quoteid."','".$this->quote[$data]."','".$this->channel[$data]."','".$this->nick[$data]."','".$this->date."'");
							} else { $this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".quote add <quote>"); }
						}
						elseif (strtolower($this->ex[4]) == "del") {
							if ($this->ex[5]) {
							} else { $this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".quote del <quote id>"); }
						}
						elseif (strtolower($this->ex[4]) == "rand") {
							$this->quote_rand($this->channel[$data]);
						}
						elseif (strtolower($this->ex[4]) == "amnt") {
							$this->quote_amnt($this->channel[$data]);
						}
						else {
							if ($this->ex[4]) {
								$this->quote_view($this->ex[4], $this->channel[$data]);
							} else { $this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".quote add|del|rand|amnt <quote>|<quote id>"); }
						}
					}
					elseif (strtolower($this->ex[3]) == ":.pic") {
						if (strtolower($this->ex[4]) == "add") {
							if ($this->ex[5]) {
								$this->pic[$data] = substr($this->args[$data], 9);
								$n = mysql_query("select * from pics");
								$picid = mysql_num_rows($n);
								if (intval($picid) != 0) { $picid++; } else { $picid = 1; }
								$this->privmsg($this->channel[$data], $this->b."Added picture #".$picid."/".$picid.": ".$this->o.$this->pic[$data]);
								$pic[$data] = addslashes($pic[$data]);
								$this->sql_insert("pics", "'".$picid."','".$this->pic[$data]."','".$this->channel[$data]."','".$this->nick[$data]."','".$this->date."'");
							} else { $this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".pic add <pic>"); }
						}
						elseif (strtolower($this->ex[4]) == "del") {
							if ($this->ex[5]) {
							} else { $this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".pic del <pic id>"); }
						}
						elseif (strtolower($this->ex[4]) == "rand") {
							$this->pic_rand($this->channel[$data]);
						}
						elseif (strtolower($this->ex[4]) == "amnt") {
							$this->pic_amnt($this->channel[$data]);
						}
						else {
							if ($this->ex[4]) {
								$this->pic_view($this->ex[4], $this->channel[$data]);
							} else { $this->privmsg($this->channel[$data], "Incorrect syntax. ".$this->b.".pic add|del|rand|amnt <pic>|<pic id>"); }
						}
					}
					else {
						$fetch = $this->sql_fetch("commands", "channel", $this->channel[$data], "command", addslashes($this->args[$data]));

						if ($fetch['response'] && $fetch['wild'] == "false") {
							$this->response[$data] = str_replace("\$nick", $this->nick[$data], $fetch['response']);
							$this->response[$data] = str_replace("\$capsnick", strtoupper($this->nick[$data]), $this->response[$data]);
							$this->response[$data] = str_replace("\$ident", $this->ident[$data], $this->response[$data]);
							$this->response[$data] = str_replace("\$host", $this->host[$data], $this->response[$data]);
							$this->response[$data] = str_replace("\$sexuality", $this->sexuality($this->nick[$data]), $this->response[$data]);
							$this->response[$data] = str_replace("\$lol", $this->lol(), $this->response[$data]);
							$this->response[$data] = str_replace("\$rand", rand(1,99), $this->response[$data]);


							if ($fetch['me'] == "true") {
								$this->privmsg($this->channel[$data], "\001ACTION ".$this->response[$data]."\001");
							}
							else {
							$this->response[$data] = str_replace(" \$line ", "\nPRIVMSG ".$this->channel[$data]." :", $this->response[$data]);
							
	$this->privmsg($this->channel[$data], $this->response[$data]);
							}
						}
					$ex = explode(" ", $this->args[$data]);
					foreach ($ex as $word) { $this->wild($word, $this->channel[$data], $this->nick[$data], $this->ident[$data], $this->host[$data]); }
					}
				$this->clear();
	}
				} // end privmsg
			}
		}
	// mysql functions

		function sql_connect () {
			global $config;
			$this->mysql = mysql_connect($config->mysql['address'], $config->mysql['user'], $config->mysql['password']);
			mysql_select_db($config->mysql['database']);
		}

		function sql_fetch ($table, $a, $b, $c, $d) {
			if ($a && $b && $c && $d) {
				$q = mysql_query("SELECT * FROM ".$table." WHERE ".$a."='".$b."' AND ".$c."='".$d."'");
				return mysql_fetch_assoc($q);
			}

			elseif ($a && $b && !$c && !$d) {
				$q = mysql_query("SELECT * FROM ".$table." WHERE ".$a."='".$b."'");
				return mysql_fetch_assoc($q);
			}
			
		}
		
		function sql_get ($table, $a, $b, $c) {
			$q = mysql_query("SELECT * FROM ".$table." WHERE ".$b."='".$c."'");
			$qr = mysql_fetch_assoc($q);
				return ($qr[$a]);
		}
		
		function sql_delete ($table, $a, $b, $c, $d) {
			if ($a && $b && $c && $d) {
				$q = mysql_query("DELETE FROM ".$table." WHERE ".$a."='".$b."' AND ".$c."='".$d."'");
				return mysql_fetch_assoc($q);
			}

			elseif ($a && $b && !$c && !$d) {
				$q = mysql_query("DELETE FROM ".$table." WHERE ".$a."='".$b."'");
				return mysql_fetch_assoc($q);
			}
		}

		function sql_insert ($table, $args) {
			mysql_query("INSERT INTO ".$table." VALUES (".$args.")");
		}

	// main functions

		function wild ($word, $channel, $nick, $ident, $host) {
			$check = mysql_query("SELECT * FROM commands WHERE channel='".$channel."' AND command='".$word."' AND wild='true'");
				$cr = mysql_fetch_assoc($check);
					if ($cr['response']) {
						$response = str_replace("\$nick", $nick, $cr['response']);
						$response = str_replace("\$capsnick", strtoupper($nick), $response);
						$response = str_replace("\$ident", $ident, $response);
						$response = str_replace("\$host", $host, $response);
						$response = str_replace("\$sexuality", $this->sexuality($nick), $response);
						$response = str_replace("\$lol", $this->lol(), $response);
						$response = str_replace("\$rand", rand(1,99), $response);

						if ($cr['me'] == "false") {
						$response = str_replace(" \$line ", "\nPRIVMSG ".$channel." :", $response);
						$this->privmsg($channel, $response);
						} else {
						$this->privmsg($channel, "\001ACTION ".$response."\001");
						}
					}
		}

		function assign ($channel, $rchannel, $nick) {
			global $config;
			$c = mysql_fetch_assoc(mysql_query("SELECT * FROM channels WHERE channel='".addslashes($channel)."' AND network='".addslashes($config->network)."'"));
			$check = str_split($channel);
				if ($check[0] == "#") {
					if (!$c['channel']) {
						$this->join($channel);
						$this->privmsg($rchannel, $this->b.$channel.$this->o." has been added to my database.");
						$this->sql_insert("channels", "'".$channel."','".$this->date."','".$nick."','".$config->network."'");
					} else { $this->privmsg($rchannel, $this->b.$channel.$this->o." is already in my database."); }
				} else { $this->privmsg($rchannel, $this->b.$channel.$this->o." is not a valid channel name."); }
		}

		function unassign ($channel, $rchannel, $nick) {
			global $config;
			$c = $this->sql_fetch("channels", "channel", $channel, "network", $config->network);
			$check = str_split($channel);
				if ($check[0] == "#") {
					if ($c) {
						$this->part($channel);
						$this->privmsg($rchannel, $this->b.$channel.$this->o." has been removed from my database.");
						$this->sql_delete("channels", "channel", $channel);
						$this->sql_delete("commands", "channel", $channel);
					} else { $this->privmsg($rchannel, $this->b.$channel.$this->o." is not in my database."); }
				} else { $this->privmsg($rchannel, $this->b.$channel.$this->o." is not a valid channel name."); }
		}

		function quote_view ($quote, $channel) {
			$n = mysql_query("select * from quotes");
			$totalquotes = mysql_num_rows($n);
			if (intval($quote) != 0) {
			$q = $this->sql_fetch("quotes", "id", $quote);
				if ($q['quote']) {
					$this->privmsg($channel, $this->b."Quote #".$quote."/".$totalquotes.": ".$this->o.$q['quote']);
				}
				else { $this->privmsg($channel, "Quote ".$this->b."#".$quote.$this->o." does not exist."); }
			 } else { $this->privmsg($channel, "The quote ID must be an integer."); }
		}
		function quote_rand ($channel) {
			$n = mysql_query("select * from quotes");
			$num = mysql_num_rows($n);
			$quoteid = rand(1, $num);
			$this->quote_view($quoteid, $channel);
		}
		function quote_amnt ($channel) {
			$n = mysql_query("select * from quotes");
			$num = mysql_num_rows($n);
			$this->privmsg($channel, "There are ".$this->b.$num.$this->o." quotes in my database.");
		}
		function pic_view ($quote, $channel) {
			if (intval($quote) != 0) {
			$n = mysql_query("select * from pics");
			$totalquotes = mysql_num_rows($n);
			$q = $this->sql_fetch("pics", "id", $quote);
				if ($q['pic']) {
					$this->privmsg($channel, $this->b."Picture #".$quote."/".$totalquotes.": ".$this->o.$q['pic']);
				}
				else { $this->privmsg($channel, "Picture ".$this->b."#".$quote.$this->o." does not exist."); }
			} else { $this->privmsg($channel, "The picture ID must be an integer."); }
		}
		function pic_rand ($channel) {
			$n = mysql_query("select * from pics");
			$num = mysql_num_rows($n);
			$quoteid = rand(1, $num);
			$this->pic_view($quoteid, $channel);
		}
		function pic_amnt ($channel) {
			$n = mysql_query("select * from pics");
			$num = mysql_num_rows($n);
			$this->privmsg($channel, "There are ".$this->b.$num.$this->o." pictures in my database.");
		}
		function mode ($a, $b) {
			$this->send_data("MODE ".$a." ".$b);
		}

		function join ($channel, $password) {
			$this->send_data("JOIN :".$channel." ".$password);
		}

		function quit ($msg) {
			$this->send_data("QUIT :".$msg);
		}

		function part ($channel, $msg) {
			if ($msg) {
				$this->send_data("PART ".$channel." :".$msg);
			}
			else {
				$this->send_data("PART ".$channel);
			}
		}

		function privmsg($a, $b) {
			$this->send_data("PRIVMSG ".$a." :".$b);
		}

		function notice($a, $b) {
			$this->send_data("NOTICE ".$a." :".$b);
		}

		function convert_date ($date) {
			// month, day, year, hour, minute, second, am/pm
			$d = explode(" ", $date);
			$month = $d[0];
				if (intval($month) == 1) { $month = "January"; }
				elseif (intval($month) == 2) { $month = "February"; }
				elseif (intval($month) == 3) { $month = "March"; }
				elseif (intval($month) == 4) { $month = "April"; }
				elseif (intval($month) == 5) { $month = "May"; }
				elseif (intval($month) == 6) { $month = "June"; }
				elseif (intval($month) == 7) { $month = "July"; }
				elseif (intval($month) == 8) { $month = "August"; }
				elseif (intval($month) == 9) { $month = "September"; }
				elseif (intval($month) == 10) { $month = "October"; }
				elseif (intval($month) == 11) { $month = "November"; }
				elseif (intval($month) == 12) { $month = "December"; }
				else { $month = "N/A"; }
			$date = $month." ".$d[1].", ".$d[2]." at ".$d[3].":".$d[4].":".$d[5]." ".strtoupper($d[6]).$this->o.".";
			return $date;
		}

		function idandjoin () {
			global $config;
				$this->send_data("PRIVMSG NickServ :IDENTIFY ".$config->serv_nickpass);
				sleep(1);
					$q = mysql_query("SELECT * FROM channels WHERE network='".$config->network."'");
					$channels = null;
					$b = 0;
						while ($c = mysql_fetch_assoc($q)) {
							$this->join($c['channel']);
							if ($channels != null) { $channels = $channels.",".$c['channel']; }
							else { $channels = $c['channel']; }
							$b++;
						}
					$this->join($channels);
		}
		function clear () {
			unset($this->command);
			unset($this->quote);
			unset($this->response);
			unset($this->channel);
			unset($this->nick);
			unset($this->ident);
			unset($this->host);
			unset($this->args);
		}
		function connect () {
			global $config;
			$this->socket = fsockopen($config->server, $config->serv_port);
			$this->send_data("USER", $config->serv_ident." * * :".$config->serv_realname);
			$this->send_data("NICK", $config->serv_nick);
		}

		function send_data($cmd, $msg = null) 
		{
			fputs($this->socket, trim($cmd.' '.$msg)."\r\n");
			echo("[~S] ".trim($cmd.' '.$msg)."\r\n");
		}
	// other functions


		function truncate ($string, $chan, $order = null) {
			global $MaxStrlen;
			if (strlen($string) > $MaxStrlen){
				$msg1 = substr($string, 0, $MaxStrlen);
				$end = strrpos($msg1, " ");
				if($order == 1){ $msg1 = "..." . substr(trim($msg1), 0, $end); } else { $msg1 = substr($msg1, 0, $end); }
				$msg2 = substr($string, $end);
				$this->privmsg($chan." :".$msg1);
			} else {
				$this->privmsg($chan." :".$string);
				}
			if (strlen($msg2) > $MaxStrlen){
				$this->Truncate($msg2, $chan, 1);
			} elseif (!empty($msg2)) {
				$this->privmsg($chan, "..." . trim($msg2));
				}
		}

		function sexuality ($nick) {
			$s = rand(1, 4);
				if ($s == 1) {
					return "straight";
				}
				elseif ($s == 2) {
					return "gay";
				}
				elseif ($s == 3) {
					return "lesbian";
				}
				elseif ($s == 4) {
					return "bi";
				}
		}

		function lol () {
			$s = rand(1, 6);
				if ($s == 1) {
					return "hoe";
				}
				elseif ($s == 2) {
					return "hooker";
				}
				elseif ($s == 3) {
					return "whore";
				}
				elseif ($s == 4) {
					return "bitch";
				}
				elseif ($s == 5) {
					return "slut";
				}
				elseif ($s == 6) {
					return "pimp";
				}
		}

	}
	$fox = new fox();
?>
