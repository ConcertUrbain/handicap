<?php
	
	/*
		queries[query] > voQuery
		queries[items] > array(item)
		queries[more] > itemId
		
		item[item] > voItem
		item[comments] > voComments
		item[metas] > array(voMeta) ?
		item[vote] > rate
	*/
	
	class DatabaseData{
		var $queries;
		var $uniq; // permet de savoir si la db est à jour
		
		//debug display specific
		var $isValidColor = "#0D0";
		var $isNotValidColor = "#D00";
	
  		public function __construct(){
      if(USE_CACHE) $this->cache__reload();
      else $this->reloadQueries();
		}
		
    // ===== QUERIES


    //retourne la structure entière, avec les infos supplémentaire
    public function getQuestion($qstId){
      foreach($this->queries as $q){
        if($q["query"]["id"] == $qstId)  return $q;
      }
      return null;
    }
    
    //retourne l'objet voQuery
    public function getQuery($qstId){
      foreach($this->queries as $obj){
        if($obj["query"]["id"] == $qstId){
          //if($obj["query"]->isValid)  return $obj["query"];
          return $obj["query"];
        }
      }
      return null;
    }
    
    public function getQueries(){
      $list = array();
      foreach($this->queries as $obj){
        //if($obj["query"]->isValid)  $list[] = $obj["query"];
        $list[] = $obj["query"];
      }
      return $list;
    }

    public function reloadQueries(){
      //echo "API :: queries reloaded";
      $this->queries = array();
      $queries = api__getQueries();
      for($i=0;$i<count($queries);$i++){
        $q = $queries[$i];
        $this->queries[$i] = array();
        $this->queries[$i]["query"] = $q;
      }
      $this->save();
    }

    // ======= ITEMS

		public function getItemVoteRate($itemId){
      
			foreach($this->queries as $q){
				foreach($q["items"] as $item){
					if($item["item"]["id"] == $itemId){
						return $item["vote"];
					}
				}
			}
			return 0;
		}
		
		public function getMetas($itemId){
			foreach($this->queries as $obj){
				foreach($obj["items"] as $item){
					if($item["item"]["id"] == $itemId){
						return $item["metas"];
					}
				}
			}
			return null;
		}
		
		public function getComments($itemId){
			$list = array();
			foreach($this->queries as $obj){
				foreach($obj["items"] as $item){
        
          if(!isset($item["item"])){
            print_r($item);
          }
          
					if($item["item"]["id"] == $itemId){
            
						if(isset($item["comments"])){
							foreach($item["comments"] as $com){
								
								$com["content"] = utf8_decode($com["content"]);
								
								$list[] = $com;
							}
						}
						
					}
				}
			}
			
			//sort comments
			// ...
			
			return $list;
		}
		
		public function getItems($qstId){
      if(!USE_CACHE)  $this->reload__items($qstId);
			$list = array();
			foreach($this->queries as $query){
        //var_dump($query);
				if($query["query"]["id"] == $qstId){
					foreach($query["items"] as $item){
						$list[] = $item["item"];
					}
				}
			}
			
			return $list;
		}
		
    public function getItemMoreId($qstId){
      //echo "<br />query for more id";
      foreach($this->queries as $q){
        $queryId = $q["query"]["id"];
        //echo $queryId.",".$qstId;
        if(intval($queryId) == $qstId){
          if(!isset($q["more"])) continue;
          //echo"<br>------";
          //var_dump($q["more"]);
          $moreId = $q["more"];
          return $moreId;
        }
      }
      return -1;
    }
    
		public function getItemMore($qstId){
			//$this->reload_question($qstId);
      //echo "QST ID = ".$qstId;
      $moreId = $this->getItemMoreId($qstId);
      $q = $this->getQuestion($qstId);
      
      //echo $moreId;
      foreach($q["items"] as $item){
        //var_dump($item);
        if(intval($item["item"]["id"]) == $moreId){
          //$itemVo = str_replace("\"", "", $itemVo->title); // vire les ""
          return $item; // return all structure
        }
      }
			
			//die("Erreur : Pas d'id trouve pour la video de la question #".$qstId);
			//die("Error on getItemMore (api_class) >> no item returned for qstId:".$qstId." and moreId:".$moreId);
			return null;
		}
		
		public function getItem($itemId){
			foreach($this->queries as $q){
				foreach($q["items"] as $item){
					if($item["item"]["id"] == $itemId)	return $item;
				}
			}
			return null;
		}
		
    /* data venant directement de l'api */
		public function reloadAll(){
			//echo "API :: reloaded all";
      $this->queries = array();
			
			$queries = api__getQueries();
      for($i=0;$i<count($queries);$i++){
        $q = $queries[$i];
        $this->queries[$i] = array();
				$this->queries[$i]["query"] = $q;
				$this->queries[$i]["items"] = $this->reload__items($q->id);
			}
			
			$this->save();
		}
    
    public function reload__items($qstId){
			$qstItems = api__getItems($qstId);
			$items = array();
			
			foreach($qstItems as $item){
				$itemStruct = array();
				$itemStruct["item"] = $item;
				$itemStruct["metas"] = api__getMetas($item);
				$itemStruct["url"] = api__getMediaUrl($item->id);
        
				//get item comments
				$itemStruct["comments"] = api__getComments($item->id);
				$itemStruct["vote"] = api__getVotes($item->id);
				
        $queryIndex = -1;
        for($i=0;$i<count($this->queries);$i++){
          $query = $this->queries[$i];
          if($query["query"]["id"] == $qstId){
            $queryIndex = $i;
          }
        }

        //ref l'id de l'item qui sera la vidéo de ref de la question
        //l'item de ref est le premier qui a sa question avec des quotes
        if(strpos($item->title, '"') !== false){
          $this->queries[$queryIndex]["more"] = $item->id;
        }

				$items[] = $itemStruct;
			}
      
      $this->queries[$queryIndex]["items"] = $items;

      return $items;
    }
    
		public function save(){
      //transform all objects into assoc array
      $this->queries = Zend_Json_Decoder::decode(Zend_Json_Encoder::encode($this->queries));
			$_SESSION[DATA_CACHE] = serialize($this);
		}
		

    // ====== CACHE


    public function cache__reloadItems($qstId){
      if(!USE_CACHE)  return;
      for($i = 0; $i < count($this->queries); $i++){
        $q = $this->queries[$i];
        if($q["query"]["id"] == $qstId){
          $this->queries[$i]["items"] = $this->reload__items($qstId);
          $this->save();
          return;
        }
      }
      
      die("api_class error : Couldn't add item to query ".$qstId);
    }
    
    public function cache__reloadVotes($itemId){
      if(!USE_CACHE)  return;
      for($i = 0; $i < count($this->queries); $i++){
        $q = $this->queries[$i];
        for($j = 0; $j < count($q["items"]); $j++){
          $item = $q["items"][$j];
          if($item["item"]["id"] == $itemId){
            $this->queries[$i]["items"][$j]["vote"] = api__getVotes($itemId);
            $this->save();
            return;
          }
        }
      }
      
      die("api_class error : Couldn't add vote to item ".$itemId);
    }
    
    //permet de rajouter un commentaire au cache
    public function cache__reloadComments($itemId){
      if(!USE_CACHE)  return;
      for($i = 0; $i < count($this->queries); $i++){
        $q = $this->queries[$i];
        for($j = 0; $j < count($q["items"]); $j++){
          $item = $q["items"][$j];
          if($item["item"]["id"] == $itemId){
            //echo "found item ".$itemId." adding reloading comments";
            
            $this->queries[$i]["items"][$j]["comments"] = api__getComments($itemId);
            $this->save();
            return;
          }
        }
      }
      
      die("api_class error : Couldn't add comment to item ".$itemId);
    }
    
    /* rempli les datas local (session) à partir du fichier de cache */
    public function cache__reload(){
      if(!USE_CACHE)  return;
      //echo "<br />Get cache file";
      $content = Zend_Json_Decoder::decode(file_get_contents("cache/db_cache.json"));
      $uniq = $content["uniq"];
      
      $this->uniq = $uniq; // override
      $this->queries = $content["queries"];
    }
    
    /* Soit recharge le cache a partir de la base de donnée, soit réécrit le cache à partir des datas locales */
    static public function cache__save($reload = false){
      if($reload) $data = DatabaseData::reloadDb();
      else $data = DatabaseData::getInstance()->queries;
      
      $uniq = uniqId();
      $output = array("uniq"=>$uniq,"queries"=>$data);
      
      $filePath = CACHE_FOLDER.CACHE_FILE.".".CACHE_FILE_EXT;
      file_put_contents($filePath, Zend_Json_Encoder::encode($output));
      
      if($reload) echo "Cache updated. New id is ".$uniq." (Time is = ".date("Y-m-d").")";
    }
    
    static public function getCacheId(){
      $content = Zend_Json_Decoder::decode(file_get_contents(CACHE_FOLDER.CACHE_FILE.".".CACHE_FILE_EXT));
      return $content["uniq"];
    }
    

    // ========= STATICS

		static public function clean() {
			$_SESSION[DATA_CACHE] = "";
			//unset($_SESSION[DATA_CACHE]);
		}
		
		static public function getInstance($force = false){

      if(USE_CACHE){
        $data = unserialize($_SESSION[DATA_CACHE]);
        
        //check si l'existant est à jour
        if(!empty($data) && !$force){
          
          $cacheId = DatabaseData::getCacheId();
          //echo "<div>".$data->uniq." ?= ".$cacheId."</div>";
          //echo "<div>Queries COUNT = ".count($data->queries)."</div>";
          
          if($data->uniq != $cacheId){
            //echo "UniqId is different, need to reload cache";
            $force = true;
          }else if(count($data->queries) < 1){
            $force = true;
          }
          
        }
        
        //reload
  			if(empty($data) || $force){
  				//echo "DATABASEDATA :: getInstance > Forcing refresh of data";
  				
  				//echo "DatabaseData::getInstance >> (re)loading database";
  				$data = new DatabaseData();
          $data->save();
  			}
      }else{

        $data = new DatabaseData();
        //$data->save();

      }
      if(!isset($data)) die("getInstance :: Should have data here");
      if(empty($data))  die("getInstance :: Data should not be empty");
      
			//return OBJECT
			return $data;
		}
    
    /* Retourne une string */
    static public function reloadDb(){
      $db = DatabaseData::getInstance(true);
      $db->reloadAll();
      return $db->queries;
    }
    

    // ========= DISPLAY


    /* Affiche en string le contenu de la db en session */
    public function display(){
      
      echo "<hr />QUERIES (".count($this->queries).")";
      
      //echo $this->queries[0];
      //print_r($this->queries[1]);
      
      foreach($this->queries as $obj){
        $query = $obj["query"];
        
        $valid = $query["_isValid"] ? "V" : "O";
        $color = ($query["_isValid"]) ? $this->isValidColor : $this->isNotValidColor;
        
        echo "<div style=\"padding-top:40px;font-size:1.5em;color:$color;\">";
        echo $valid." (id:".$query["id"].") ".$query["content"];
        
        if(!isset($obj["more"])){
          echo "(no more id)";
        }else{
          $moreId = $obj["more"];
          echo "(id more : ".$moreId.")";
        }
        
        echo "</div>";
        
        if(!isset($obj["items"])){
          echo "no items found for this query";
        }else{
          foreach($obj["items"] as $item){
            
            $voItem = $item["item"];
            $coms = $this->getComments($voItem["id"]);
            
            $metas = $item["metas"];
            
            $valid = $voItem["_isValid"] ? "V" : "O";
            $color = ($voItem["_isValid"]) ? $this->isValidColor : $this->isNotValidColor;
            
            echo "<div style=\"color:$color;\">&nbsp;&nbsp;";
            
            echo $valid." (id:".$voItem["id"].") ".$voItem["title"]." (rate ".$item["vote"].") (".count($coms)." comments";
            
            $url = $item["url"];
            if(strlen($url) > 0)  echo ", mediaUrl : ".$item["url"];
            
            echo ")";
            echo "</div>";
            
            if($metas){
              echo "&nbsp;&nbsp;&nbsp;&nbsp;METAS[";
              foreach($metas as $meta){
                echo " ".$meta["name"]." -> ".$meta["content"].", ";
              }
              echo "]";
            }
            
            foreach($coms as $com){
              echo "<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$com["content"]."</div>";
            }
          }
        }
        
      }
    }
    
    public function display_stats(){
      
      foreach($this->queries as $obj){
        $query = $obj["query"];
        
        echo "<div style=\"padding:20px 0px 10px 0px;font-size:1.5em;\">";
          echo $query["content"];
        echo "</div>";
        
        $moreId = -1;
        if(isset($obj["more"])) $moreId = $obj["more"];
        
        if(isset($obj["items"])){
          foreach($obj["items"] as $item){
            
            $voItem = $item["item"];
            $coms = $this->getComments($voItem["id"]);
            
            $metas = $item["metas"];
            
            echo "<div style=\"padding-left:20px;\">";
              
              $title = $voItem["title"];
              if(strlen($title) < 1)  $title = "[Pas de titre]";
              
              echo "<div style=\"float:left;width:500px;\">".$title."</div>";
              
              echo "<div style=\"float:left;width:400px;\">";
                if($voItem["id"] != $moreId)  echo "score du vote : ".$item["vote"]." et ".count($coms)." commentaires";
                else echo "Media lié à la question";
              echo "</div>";
              
              echo "<div class=\"clear\"></div>";
              
            echo "</div>";
            
            if($metas){
              echo "<div style=\"padding-left:40px;\">";
                //print_r($metas);
                $email = $metas[0]["content"];
                echo "<div style=\"padding-left:20px;\">EMAIL = ".$email."</div>";
                
                $list = explode(",",$metas[1]["content"]);
                foreach($list as $value){
                  if($value == "cb-entourage")  $value = "Entourage (famille, aidant)";
                  if($value == "cb-pro")  $value = "Professionnel (en établissement)";
                  if($value == "cb-collec")  $value = "Collectivité publique (élu, agent)";
                  if($value == "cb-assoc")  $value = "Association sur le handicap";
                  if($value == "cb-autre")  $value = "Autre (citoyen concerné)";
                  if($value == "cb-autr")  $value = "Autre (citoyen concerné)";
                  
                  echo "<div style=\"padding-left:20px;\">".$value."</div>";
                }
              echo "</div>";
            }
            
          }
        }
        
      }
      
    }


    public function display_simple(){
      echo "[".$this->uniq."] ";
      foreach($this->queries as $obj){
        echo "QST#".$obj["query"]["id"]." (more:".$obj["more"].", items:".count($obj["items"]).") | ";
      }
    }
    



    
	}

?>