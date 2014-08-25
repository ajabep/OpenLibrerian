<?php
	class object {

		protected $ID;
		protected $name;
		protected $description;
		protected $tags = array();

		public function ID() {return $this->ID;}
		public function name() {return $this->name;}
		public function description() {return $this->description;}
		public function tags() {return $this->tags;}

		public function __construct(array $infos) {
			$this->hydrate($infos);
		}
		protected function hydrate(array $donnees) {
			foreach($donnees as $cle => $valeur) {
				$methode = 'set'.ucfirst(strtolower($cle));
				if(method_exists($this, $methode)){
					$this->$methode($valeur);
				}
			}
		}

		protected function setId($ID) {
			$this->ID = (int) $ID;
		}

		protected function setName($name) {
			$this->name = htmlentities($name);
		}

		protected function setDescription($description) {
			$this->description = nl2br( htmlentities($description) );
		}
		
		protected function setTags($tags) {
			if(is_array($tags)){
				$this->tags = $tags;
			}
			elseif( $tags instanceof tag ) {
				$this->tags[] = $tags;
			}
		}
		
	
		protected function setTag($tag) {
			$this->setTags($tag);
		}
	}