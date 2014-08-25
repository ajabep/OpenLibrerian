<?php
	class objectManager {

		const ERR_DB_PROBLEM = -1;
		const ERR_VALUE = 2;
		const ERR_VALUE_ID = 3;
		const ERR_VALUE_NAME = 4;
		const ERR_NOT_IMPLEMENTED = 5;

		protected $db;

		public function __construct(PDO $db) {
			$this->db = $db;
		}

		public function getAll($onlyArray = false, $getTags = true, $keyAreIds = false, $limitStart=false, $limitCount=false) {
			
			$limitQuery = '';
			
			if( $limitStart !== false ) {
				$limitQuery = 'LIMIT ' . ( (int) $limitStart );
				if( $limitCount !== false ) {
					$limitQuery .= ',' . ( (int) $limitCount );
				}
			}
			
			if( (bool)$getTags ) {
				
				
				$ids = array();
				
				if( $limitStart !== false ) {
					$sql = $this->db->prepare('
								SELECT ID
								FROM objects
								ORDER BY name ASC
								' . $limitQuery . '
					');
					$sql->execute();
					
					while( is_array($data = $sql->fetch()) ){
						$ids[] = $data['ID'];
					}
				}
				
				$sql = $this->db->prepare('
							SELECT o.ID, o.name, o.description, t.ID tID, t.name tName
							FROM objects o
							LEFT JOIN memberchiptags mt ON mt.IDObject = o.ID
							LEFT JOIN tags t ON t.ID = mt.IDTag
							' . 
							( $limitStart !== false ? '
							WHERE o.ID IN ( 
								' . implode(', ', $ids) . '
							) ' : '' ) .'
							ORDER BY o.name ASC, t.name ASC
				');
				$sql->execute();
				$return = array();
				$dataObject = array('ID' => '');
				$dataFetch = $sql->fetch();
				while(false !== $dataFetch) {
					if($dataFetch['ID'] != $dataObject['ID']) {
						$dataObject = $dataTag = $dataFetch;
						$dataTag['ID'] = $dataTag['tID'];
						$dataTag['name'] = $dataTag['tName'];
						
						unset($dataObject['tName'], $dataObject['tID'], $dataTag['tID'], $dataTag['tName'], $dataTag['description']);
						
						if( !empty($dataTag['name']) ){
							if((bool)$onlyArray)
								$dataObject['tags'] = array( $dataTag );
							else
								$dataObject['tags'] = array( new tag($dataTag) );
						}
					}
					
					$dataFetch = $sql->fetch();
					
					if($dataFetch['ID'] == $dataObject['ID']) {
						$dataTag = $dataFetch;
						$dataTag['ID'] = $dataTag['tID'];
						$dataTag['name'] = $dataTag['tName'];
						
						unset($dataTag['tID'], $dataTag['tName'], $dataTag['description']);
						
						if((bool)$onlyArray)
							$dataObject['tags'][] = $dataTag;
						else
							$dataObject['tags'][] = new tag($dataTag);
					}
					elseif($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataObject['ID']] = $dataObject;
						else
							$return[$dataObject['ID']] = new object($dataObject);
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataObject;
						else
							$return[] = new object($dataObject);
					}
				}
				unset($dataFetch, $dataObject, $dataTag);
			}
			else {
				$sql = $this->db->prepare('
							SELECT ID, name, description
							FROM objects
							ORDER BY name ASC
							' . $limitQuery . '
				');
				$sql->execute();
				$return = array();
				while(false !== ( $dataObject = $sql->fetch() ) ) {
					$dataObject['tags'] = array();
					if($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataObject['ID']] = $dataObject;
						else
							$return[$dataObject['ID']] = new object($dataObject);
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataObject;
						else
							$return[] = new object($dataObject);
					}
				}
				unset($dataObject);
			}
			return $return;
		}

		public function getBy($by, $value, $onlyArray = false, $getTags = true, $keyAreIds = false, $limitStart=false, $limitCount=false) {
			
			$arrayBy = array('ID', 'name', 'description', 't-ID', 't-name');
			if(!in_array($by,$arrayBy)) {
				return self::ERR_VALUE;
			}
			
			if( strpos($by, 't-') === 0 ) {
				$by = 't.' . substr( $by, strlen($by, 't-') );
			}
			else {
				$by = 'o.' . $by ;
			}
			
			$limitQuery = '';
			
			if($limitStart){
				$limitQuery = 'LIMIT '.( (int) $limitStart );
				if($limitCount){
					$limitQuery .= ','.( (int) $limitCount );
				}
			}
			
			if( (bool)$getTags) {
				if(strpos($by, 't-') === 0 ) {
					return self::ERR_NOT_IMPLEMENTED;
				}
				else {
					$sql = $this->db->prepare('
								SELECT o.ID, o.name, o.description, t.ID tID, t.name tName
								FROM objects o
								LEFT JOIN memberchiptags mt ON mt.IDObject = o.ID
								LEFT JOIN tags t ON t.ID = mt.IDTag
								WHERE o.ID IN ( -- == LIMIT
									SELECT ID
									FROM objects o
									WHERE BINARY ' . $by . ' = :value
									ORDER BY ID
									' . $limitQuery . '
								)
								ORDER BY o.name ASC, t.name ASC
					');
				}
				$sql->bindValue(':value', $value, PDO::PARAM_STR);
				$sql->execute();
				$return = array();
				$dataObject = array('ID' => '');
				$dataFetch = $sql->fetch();
				while(false !== $dataFetch) {
					if($dataFetch['ID'] != $dataObject['ID']) {
						$dataObject = $dataTag = $dataFetch;
						$dataTag['ID'] = $dataTag['tID'];
						$dataTag['name'] = $dataTag['tName'];
						
						unset($dataObject['tName'], $dataObject['tID'], $dataTag['tID'], $dataTag['tName'], $dataTag['description']);
						
						if( !empty($dataTag['name']) ){
							if((bool)$onlyArray)
								$dataObject['tags'] = array( $dataTag );
							else
								$dataObject['tags'] = array( new tag($dataTag) );
						}
					}
					
					$dataFetch = $sql->fetch();
					
					if($dataFetch['ID'] == $dataObject['ID']) {
						$dataTag = $dataFetch;
						$dataTag['ID'] = $dataTag['tID'];
						$dataTag['name'] = $dataTag['tName'];
						
						unset($dataTag['tID'], $dataTag['tName'], $dataTag['description']);
						
						if((bool)$onlyArray)
							$dataObject['tags'][] = $dataTag;
						else
							$dataObject['tags'][] = new tag($dataTag);
					}
					elseif($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataObject['ID']] = $dataObject;
						else
							$return[$dataObject['ID']] = new object($dataObject);
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataObject;
						else
							$return[] = new object($dataObject);
					}
				}
				unset($dataFetch, $dataObject, $dataTag);
			}
			else{
				if( strpos($by, 't.') === 0 ) {
					return self::ERR_NOT_IMPLEMENTED;
				}
				else{
					$sql = $this->db->prepare('
								SELECT ID, name, description
								FROM objects o
								WHERE BINARY ' . $by . ' = :value
								ORDER BY name ASC
								' . $limitQuery . '
					');
				}
				$sql->bindValue(':value', $value, PDO::PARAM_STR);
				$sql->execute();
				$return = array();
				while(false !== ( $dataObject = $sql->fetch() ) ) {
					$dataObject['tags'] = array();
					if($keyAreIds) {
						if((bool)$onlyArray)
							$return[$dataObject['ID']] = $dataObject;
						else
							$return[$dataObject['ID']] = new object($dataObject);
					}
					else {
						if((bool)$onlyArray)
							$return[] = $dataObject;
						else
							$return[] = new object($dataObject);
					}
				}
				unset($dataObject);
			}
			return $return;
		}

		public function set($name, $description, array $listTags = array(), $onlyArray = false, $getTags = true) {
			
			$sql = $this->db->prepare('
							SELECT name
							FROM objects
							WHERE BINARY name = :name
							LIMIT 0,1
						');
			$sql->bindValue(':name', $name, PDO::PARAM_STR);
			
			$sql->execute();
			$data = $sql->fetch();
			
			if( !is_array($data) && $data['name'] == $name ) {
				return self::ERR_VALUE_NAME;
			}
			
			$sql = $this->db->prepare('
							INSERT INTO objects (
								name,
								description
							)
							VALUES (
								:name,
								:description
							)
					');
			$sql->bindValue(':name', $name, PDO::PARAM_STR);
			$sql->bindValue(':description', $description, PDO::PARAM_STR);
			$sql->execute();
			
			$objInsertList = $this->getBy('name', $name, true, false);
			
			$this->addTag($listTag, $objInsertList);
			
			$objInsertList = $this->getBy('name', $name, $onlyArray, $getTags);
			return $objInsertList[0];
		}

		public function update($typeChange, $valueChange, $typeID, $valueID, $onlyArray = false, $getTags = true) {
		
			$arrayTypeChange = array('ID', 'name', 'description');
			$arrayTypeID = array('ID', 'name');
			
			if( !in_array( $typeChange, $arrayTypeChange ) || !in_array( $typeID, $arrayTypeID ) ) {
				return self::ERR_VALUE;
			}
			
			if( in_array( $typeChange, $arrayTypeID ) ) { //verification of the uniq clause
				$sql = $this->db->prepare('
							SELECT COUNT(ID) count
							FROM objects
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
						UPDATE objects
						SET '.$typeChange.' = :valueChange
						WHERE BINARY '.$typeID.' = :valueID
				');
			$sql->bindValue(':valueChange',$valueChange,PDO::PARAM_STR);
			$sql->bindValue(':valueID',$valueID,PDO::PARAM_STR);
			$sql->execute();
			
			
			
			if( $typeChange == $typeID ) {
				$valueID = $valueChange;
			}
			
			$objInsertList = $this->getBy($typeID, $valueID, $onlyArray, $getTags);
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
						FROM objects
						WHERE BINARY '.$typeID.' = :value
				');
			$sql->bindValue(':value', $valueID, PDO::PARAM_STR);
			
			return $sql->execute();
		}

		public function addTag($tag, $IDObject) {
			if( is_string($tag) ) {
				
				$sql = $this->db->prepare('
							SELECT COUNT(ID) count, ID, (
								SELECT COUNT(mt.ID)
								FROM memberchiptags mt
								LEFT JOIN tags t ON mt.IDTag = t.ID
								WHERE BINARY t.name = :tag
								AND mt.IDObject = :IDObject
							) countMemberchip
							FROM tags
							WHERE BINARY name = :tag
							LIMIT 0, 1
					');
				$sql->bindValue(':tag', $tag, PDO::PARAM_STR);
				$sql->bindValue(':IDObject', $IDObject, PDO::PARAM_INT);
				$sql->execute();
				
				
				if( !is_array( $data = $sql->fetch() ) )
					return self::ERR_DB_PROBLEM;
				
				if( $data['countMemberchip'] > 0 )
					return true;
				
				
				if( $data['count'] < 1 ) {
					// create
					
					$sql = $this->db->prepare('
									INSERT INTO tags (
										name
									)
									VALUES (
										:tag
									)
							');
					$sql->bindValue(':tag', $tag, PDO::PARAM_STR);
					$sql->execute();
					
					$sql = $this->db->prepare('
								SELECT ID
								FROM tags
								WHERE BINARY name = :tag
								LIMIT 0, 1
						');
					$sql->bindValue(':tag', $tag, PDO::PARAM_STR);
					$sql->execute();
					if( !is_array( $data = $sql->fetch() ) ) {
						return self::ERR_DB_PROBLEM;
					}
				}
				
				
				$sql = $this->db->prepare('
								INSERT INTO memberchiptags (
									IDObject,
									IDTag
								)
								VALUES (
									:IDObject,
									:IDTag
								)
						');
				$sql->bindValue(':IDObject', $IDObject, PDO::PARAM_INT);
				$sql->bindValue(':IDTag', $data['ID'], PDO::PARAM_INT);
				return $sql->execute();
			}
			elseif( is_array($tag) ) {
				
				$c = count($tag);
				
				$IDTags = array();
				$i=0;
				do {
					$IDTags[] = ':tag' . $i;
					++$i;
				} while( $i < $c );
				
				$IDTags = implode(',', $IDTags);
				
				$sql = $this->db->prepare('
						SELECT t.ID, t.name, mt.IDObject, (
							SELECT COUNT(mt.ID)
							FROM memberchiptags mt
							LEFT JOIN tags t ON mt.IDTag = t.ID
							WHERE
								BINARY t.name IN (' . $IDTags . ')
							  AND
								BINARY mt.IDObject = 3
						) countMemberchip, (
							SELECT COUNT(ID)
							FROM tags
							WHERE BINARY name IN (' . $IDTags . ')
							LIMIT 0, 1
						) count
						FROM tags t
						LEFT JOIN memberchiptags mt ON mt.IDTag = t.ID
						WHERE
							BINARY t.name IN (' . $IDTags . ')
						  AND
							(
								BINARY mt.IDObject = :IDObject
							  OR
								mt.IDObject IS NULL
							)
					');
				$sql->bindValue(':IDObject', $IDObject, PDO::PARAM_INT);
				
				$i=0;
				do {
					$sql->bindValue(':tag' . $i, $tag[$i], PDO::PARAM_STR);
					++$i;
				} while( $i < $c );
				
				$sql->execute();
				
				if( !is_array( $data = $sql->fetch() ) )
					return self::ERR_DB_PROBLEM;
				
				if( $data['countMemberchip'] == $c )
					return true;
				
				
				$tagsToNotInsert = array();
				$tagsToLink = array();
				
				do {
					$tagsToNotInsert[] = $data['name'];
					if( is_null($data['IDObject']) )
						$tagsToLink[] = $data['ID'];
				} while( $data = $sql->fetch() );
				
				$tagsToInsert = array_diff( $tag, $tagsToNotInsert );
				
				if( $data['count'] < $c ) {
					// create somes
					
					$cCreate = count($tagsToInsert);
					
					$IDTagsCreate = array();
					$i=0;
					while( $i < $cCreate ) {
						$IDTagsCreate[] = ':tag' . $i;
						++$i;
					}
					
					$IDTagsCreate = implode(',', $IDTagsCreate);
					
					
					$sql = $this->db->prepare('
									INSERT INTO tags (
										name
									)
									VALUES (
										' . $IDTagsCreate . '
									)
							');
					
					$i=0;
					while( $i < $cCreate ) {
						$sql->bindValue(':tag' . $i, $tagsToInsert[$i], PDO::PARAM_STR);
						++$i;
					}
					
					$sql->execute();
					
					$sql = $this->db->prepare('
								SELECT ID, COUNT(ID) count
								FROM tags
								WHERE BINARY name IN (' . $IDTagsCreate . ')
						');
					
					$i=0;
					while( $i < $cCreate ) {
						$sql->bindValue(':tag' . $i, $tagsToInsert[$i], PDO::PARAM_STR);
						++$i;
					}
					
					$sql->execute();
					
					if( !is_array( $data = $sql->fetch() ) || $data['count'] < $c ) {
						return self::ERR_DB_PROBLEM;
					}
					
					$tagsToLinkTwo = array();
					
					do {
						$tagsToLinkTwo[] = $data['ID'];
					} while( $data = $sql->fetch() );
					
					$tagsToLink = array_merge( $tagsToLink, $tagsToLinkTwo );
				}
				
				$insertValueSql = array();
				$i = 0;
				$c = count($tagsToLink);
				do {
					$insertValueSql[] = '(
									:IDObject,
									:IDTag' . $i . '
								)';
					++$i;
				} while( $i < $c );
				
				$insertValueSql = implode(',', $insertValueSql);
				
				$sql = $this->db->prepare('
								INSERT INTO memberchiptags (
									IDObject,
									IDTag
								)
								VALUES ' . $insertValueSql .'
						');
				$sql->bindValue(':IDObject', $IDObject, PDO::PARAM_INT);
				
				$i=0;
				do {
					$sql->bindValue(':IDTag' . $i, $tagsToLink[$i]['ID'], PDO::PARAM_INT);
					++$i;
				} while( $i < $c );
				
				return $sql->execute();
			}
			return self::ERR_VALUE;
		}

		public function deleteTag($tag, $IDObject, $isID = true) {
			
			$DDos = fopen('./offline/delete.log','a');
			fseek($DDos, 0);
			fputs($DDos, 'DELETE in ' . __FILE__ . ' : "' . __METHOD__ . '( ' . var_export( $tag, true ) . ', ' . var_export( $IDObject, true ) . ', ' . var_export( $isID, true ) . ')" (l.' . __LINE__ . ') called at ' . $_SERVER['REQUEST_TIME'] . ' by ' . $_SERVER['REMOTE_ADDR'] . ' (' . gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) . ') on an ' . $_SERVER['SERVER_PROTOCOL'] . ' (' . $_SERVER['REQUEST_METHOD'] . ') request to ' . $_SERVER['REQUEST_URI'] . '.' . "\n\n");
			fclose($DDos);
			
			if( is_string($tag) || is_int($tag) ) {
				if( $isID ) {
					$sql = $this->db->prepare('
								DELETE
								FROM memberchiptags
								WHERE
									BINARY IDObject = :IDObject
								  AND
									BINARY IDTag = :tag
						');
				}
				else{
					$sql = $this->db->prepare('
								DELETE
								FROM memberchiptags
								WHERE
									BINARY IDObject = :IDObject
								  AND
									BINARY IDTag = (
													SELECT ID
													FORM tags
													WHERE BINARY name = :tag
												)
						');
				}
				$sql->bindValue(':IDObject', $IDObject, PDO::PARAM_INT);
				$sql->bindValue(':tag', $tag, PDO::PARAM_STR);
				
				return $sql->execute();
				
			}
			elseif( is_array($tag) ) {
				$c = count($tag);
				
				$tagClause = array();
				$i=0;
				do {
					if( $isID ) {
						$tagClause[] = ':tag' . $i;
					}
					else{
						$tagClause[] = '(
													SELECT ID
													FORM tags
													WHERE BINARY name = :tag' . $i . '
												)';
					}
					++$i;
				} while( $i < $c );
				
				$tagClause = implode(',', $tagClause);
				
				
				$sql = $this->db->prepare('
							DELETE
							FROM memberchiptags
							WHERE
								BINARY IDObject = :IDObject
							  AND
								BINARY IDTag IN ( ' . $tagClause . ' )
					');
				$sql->bindValue(':IDObject', $IDObject, PDO::PARAM_INT);
				
				$i = 0;
				do {
					$sql->bindValue(':tag' . $i , $tag[$i], PDO::PARAM_STR);
					++$i;
				} while( $i < $c );
				
				
				return $sql->execute();
			}
			return self::ERR_VALUE;
		}

		public function count() {
			$sql = $this->db->prepare('
							SELECT COUNT(ID) count
							FROM objects
					');
			
			$sql->execute();
			
			
			if( !is_array( $data = $sql->fetch() ) || !isset($data['count']) ) {
				return self::ERR_DB_PROBLEM;
			}
			
			return $data['count'];
		}

	}
