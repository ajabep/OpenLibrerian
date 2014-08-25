<?php
	class tag {

		protected $ID;
		protected $name;
		protected $objects=array();

		public function ID() {return $this->ID;}
		public function name() {return $this->name;}
		public function objects() {return $this->objects;}

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
		
		protected function setObjects($objects) {
			if(is_array($objects)){
				$this->objects=$objects;
			}
			elseif($objects instanceof object) {
				$this->objects[]=$objects;
			}
		}
		
	
		protected function setObject($object) {
			$this->setObjects($object);
		}
	}