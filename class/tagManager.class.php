<?php
	class tagManager {

		const ERR_DB_PROBLEM = -1;
		const ERR_VALUE = 2;
		const ERR_VALUE_TAG = 3;

		protected $db;

		public function __construct(PDO $db) {
			$this->db = $db;
		}

		public function getAll($onlyArray = false, $getObjects = true, $keyAreIds = false, $limitStart=false, $limitCount=false) {
			
			$limitQuery = '';
			
			if( $limitStart !== false ) {
				$limitQuery = 'LIMIT '.( (int) $limitStart );
				if( $limitCount !== false ) {
					$limitQuery .= ','.( (int) $limitCount );
				}
			}
			
			if( (bool) $getObjects ) {
				
				
				$ids = array();
				
				if($limitStart !== false){
					$sql = $this->db->prepare('
								SELECT ID
								FROM tags
								ORDER BY name ASC
								' . $limitQuery . '
					');
					$sql->execute();
					
					while( is_array($data = $sql->fetch()) ){
						$ids[] = $data['ID'];
					}
				}
				
				$sql = $this->db->prepare('
							SELECT t.ID, t.name name, o.ID oID, o.name oName, o.description
							FROM tags t
							LEFT JOIN memberchiptags mt ON mt.IDTag = t.ID
							LEFT JOIN objects o ON o.ID = mt.IDObject
							' . 
							( $limitStart !== false ? '
							WHERE t.ID IN ( 
								' . implode(', ', $ids) . '
							) ' : '' ) .'
							ORDER BY t.name ASC, o.name ASC
				');
				$sql->execute();
				
				$return = array();
				$dataTag = array('ID' => '');
				$dataFetch = $sql->fetch();
				
				while(false !== $dataFetch) {
					if($dataFetch['ID'] != $dataTag['ID']) {
						$dataTag = $dataObject = $dataFetch;
						$dataObject['ID'] = $dataObject['oID'];
						$dataObject['name'] = $dataObject['oName'];
						
						unset($dataObject['oID'], $dataObject['oName'], $dataTag['oID'], $dataTag['oName'], $dataTag['description']);
						
						if( !empty($dataObject['name']) ){
							if((bool)$onlyArray)
								$dataTag['objects'] = array( $dataObject );
							else
								$dataTag['objects'] = array( new object ( $dataObject ) );
						}
					}
					
					$dataFetch = $sql->fetch();
					
					if($dataFetch['ID'] == $dataTag['ID']) {
						$dataObject = $dataFetch;
						$dataObject['ID'] = $dataObject['oID'];
						$dataObject['name'] = $dataObject['oName'];
						
						unset($dataObject['oID'], $dataObject['oName']);
						
						if((bool)$onlyArray)
							$dataTag['objects'][] = $dataObject;
						else
							$dataTag['objects'][] = new object ( $dataObject );
					}
					elseif($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataTag['ID']] = $dataTag;
						else
							$return[$dataTag['ID']] = new tag ( $dataTag );
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataTag;
						else
							$return[] = new tag ( $dataTag );
					}
				}
				unset($dataFetch, $dataObject, $dataTag);
			}
			else {
				$sql = $this->db->prepare('
							SELECT ID, name
							FROM tags
							ORDER BY name ASC
							' . $limitQuery . '
				');
				$sql->execute();
				
				$return = array();
				while(false !== ( $dataTag = $sql->fetch() ) ) {
					$dataTag['objects'] = array();
					if($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataTag['ID']] = $dataTag;
						else
							$return[$dataTag['ID']] = new tag ( $dataTag );
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataTag;
						else
							$return[] = new tag ( $dataTag );
					}
				}
				unset($dataTag);
			}
			return $return;
		}

		public function getBy($by, $value, $onlyArray = false, $getObjects = true, $keyAreIds = false, $limitStart=false, $limitCount=false) {
			
			$arrayBy = array('ID', 'name', 'o-ID', 'o-name', 'o-description');
			if(!in_array($by,$arrayBy)) {
				return self::ERR_VALUE;
			}
			
			if( strpos($by, 'o-') === 0 ) {
				$by = 'o.' . substr( $by, strlen($by, 'o-') );
			}
			else {
				$by = 't.' . $by;
			}
			
			$limitQuery = '';
			
			if($limitStart){
				$limitQuery = 'LIMIT '.( (int) $limitStart );
				if($limitCount){
					$limitQuery .= ','.( (int) $limitCount );
				}
			}
			
			if( (bool) $getObjects) {
				if(strpos($by, 'o.') === 0 ) {
					return self::ERR_NOT_IMPLEMENTED;
				}
				else {
					$sql = $this->db->prepare('
								SELECT t.ID, t.name, o.ID oID, o.name oName, o.description
								FROM tags t
								LEFT JOIN memberchiptags mt ON mt.IDTag = t.ID
								LEFT JOIN objects o ON o.ID = mt.IDObject
								WHERE t.ID IN ( -- == LIMIT
									SELECT ID
									FROM tags t
									WHERE BINARY ' . $by . ' = :value
									ORDER BY name
									' . $limitQuery . '
								)
								ORDER BY t.name ASC, o.name ASC
					');
				}
				$sql->bindValue(':value', $value, PDO::PARAM_STR);
				$sql->execute();
				
				$return = array();
				$dataTag = array('ID' => '');
				$dataFetch = $sql->fetch();
				
				while(false !== $dataFetch) {
					if($dataFetch['ID'] != $dataTag['ID']) {
						$dataTag = $dataObject = $dataFetch;
						$dataObject['ID'] = $dataObject['oID'];
						$dataObject['name'] = $dataObject['oName'];
						
						unset($dataObject['oID'], $dataObject['oName'], $dataTag['oID'], $dataTag['oName'], $dataTag['description']);
						
						if( !empty($dataObject['name']) ){
							if((bool)$onlyArray)
								$dataTag['objects'] = array( $dataObject );
							else
								$dataTag['objects'] = array( new object ( $dataObject ) );
						}
					}
					
					$dataFetch = $sql->fetch();
					
					if($dataFetch['ID'] == $dataTag['ID']) {
						$dataObject = $dataFetch;
						$dataObject['ID'] = $dataObject['oID'];
						$dataObject['name'] = $dataObject['oName'];
						
						unset($dataObject['oID'], $dataObject['oName']);
						
						if((bool)$onlyArray)
							$dataTag['objects'][] = $dataObject;
						else
							$dataTag['objects'][] = new object ( $dataObject );
					}
					elseif($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataTag['ID']] = $dataTag;
						else
							$return[$dataTag['ID']] = new tag ( $dataTag );
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataTag;
						else
							$return[] = new tag ( $dataTag );
					}
				}
				unset($dataFetch, $dataObject, $dataTag);
			}
			else{
				if( strpos($by, 'o.') === 0 ) {
					return self::ERR_NOT_IMPLEMENTED;
				}
				else{
					$sql = $this->db->prepare('
								SELECT ID, name
								FROM tags t
								WHERE BINARY ' . $by . ' = :value
								ORDER BY name ASC
								' . $limitQuery . '
					');
				}
				$sql->bindValue(':value', $value, PDO::PARAM_STR);
				$sql->execute();
				
				$return = array();
				while(false !== ( $dataTag = $sql->fetch() ) ) {
					$dataTag['objects'] = array();
					if($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataTag['ID']] = $dataTag;
						else
							$return[$dataTag['ID']] = new tag ( $dataTag );
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataTag;
						else
							$return[] = new tag ( $dataTag );
					}
				}
				unset($dataTag);
			}
			return $return;
		}

		public function set($name, $onlyArray = false, $getObjects = true) {
			
			$sql = $this->db->prepare('
							SELECT COUNT(ID) count
							FROM tags
							WHERE BINARY name = :name
							LIMIT 0,1
						');
			$sql->bindValue(':name', $name, PDO::PARAM_STR);
			
			$sql->execute();
			$data = $sql->fetch();
			
			if( !is_array($data) || $data['count'] > 0 ) {
				return self::ERR_VALUE_TAG;
			}
			
			$sql = $this->db->prepare('
							INSERT INTO tags (
								name
							)
							VALUES (
								:name
							)
					');
			$sql->bindValue(':name', $name, PDO::PARAM_STR);
			$sql->execute();
			
			$objInsertList = $this->getBy('name', $name, $onlyArray, $getObjects);
			return $objInsertList[0];
		}

		public function update($typeChange, $valueChange, $typeID, $valueID, $onlyArray = false, $getObjects = true) {
		
			$arrayTypeChange = array('ID', 'name');
			$arrayTypeID = array('ID', 'name');
			
			if( !in_array( $typeChange, $arrayTypeChange ) || !in_array( $typeID, $arrayTypeID ) ) {
				return self::ERR_VALUE;
			}
			
			if( in_array( $typeChange, $arrayTypeID ) ) { //verification of the uniq clause
				$sql = $this->db->prepare('
							SELECT COUNT(ID) count
							FROM tags
							WHERE BINARY '.$typeChange.' = :valueChange
							LIMIT 0,1
					');
				$sql->bindValue(':valueChange',$valueChange,PDO::PARAM_STR);
				
				$sql->execute();
				$data = $sql->fetch();
				if( !is_array($data) || $data['count'] > 0 ) {
					return self::ERR_VALUE;
				}
			}
			
			$sql = $this->db->prepare('
						UPDATE tags
						SET '.$typeChange.' = :valueChange
						WHERE BINARY '.$typeID.' = :valueID
				');
			
			$sql->bindValue(':valueChange',$valueChange,PDO::PARAM_STR);
			$sql->bindValue(':valueID',$valueID,PDO::PARAM_STR);
			$sql->execute();
			
			
			if( $typeChange == $typeID ) {
				$valueID = $valueChange;
			}
			
			$objInsertList = $this->getBy($typeID, $valueID, $onlyArray, $getObjects);
			return $objInsertList[0];
		}

		public function delete($typeID, $valueID) {
			
			$arrayTypeID = array('ID', 'name');
			
			if( !in_array( $typeID, $arrayTypeID ) ) {
				return self::ERR_VALUE; 
			}
			
			$DDos = fopen('./offline/delete.log','a');
			fseek($DDos, 0);
			fputs($DDos, 'DELETE in '.__FILE__.' : "'.__METHOD__.'( '.var_export($typeID, true).', '.var_export($valueID, true).')" (l.'.__LINE__.') called at '.$_SERVER['REQUEST_TIME'].' by '.$_SERVER['REMOTE_ADDR'].' ('.gethostbyaddr($_SERVER['REMOTE_ADDR']).') on an '.$_SERVER['SERVER_PROTOCOL'].' ('.$_SERVER['REQUEST_METHOD'].') request to '.$_SERVER['REQUEST_URI'].'.'."\n\n");
			fclose($DDos);
			
			
			$sql = $this->db->prepare('
						DELETE
						FROM tags
						WHERE BINARY '.$typeID.' = :value
				');
			$sql->bindValue(':value', $valueID, PDO::PARAM_STR);
			
			return $sql->execute();
		}

		public function count() {
			$sql = $this->db->prepare('
							SELECT COUNT(ID) count
							FROM tags
					');
			
			$sql->execute();
			
			
			if( !is_array( $data = $sql->fetch() ) || !isset($data['count']) ) {
				return self::ERR_DB_PROBLEM;
			}
			
			return $data['count'];
		}

	}
