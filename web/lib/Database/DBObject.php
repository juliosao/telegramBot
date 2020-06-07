<?php

namespace Database;

use Exception;
use Exceptions\NotFoundException;
use Exceptions\DatabaseException;

/**
 * \fn DBObject
 * \brief Clase generica para objetos guarDice en bases de datos
 */
abstract class DBObject
{		
	public function __construct($db)
	{
		$this->$db=$db;
	}

	public static function select($db,$filters=array(),$ctorArgs=[])
	{
		$where=array();
		foreach($filters as $key => $unused)
		{
			$where[]=$key.'= :'.$key;
		}

		array_unshift($ctorArgs,$db);
		if(count($where)==0)
			return $db->query(static::selectQry(), $filters,static::class,$ctorArgs);
		else
			return $db->query(static::selectQry().' WHERE '.implode(' AND ',$where), $filters,static::class,[$db]);
	}

	public function __toString()
	{
		return static::class.':'.json_encode($this);
	}

	public function update()
	{		
		return $this->db->execute(static::updateQry(),get_object_vars($this));
	}

	public function insert()
	{
		$ret = $this->db->execute(static::insertQry(),get_object_vars($this));
		if($ret==1)
			return $this->db->getInsertId();
		else
			throw new DatabaseException("Cannot insert ".static::class);
	}

	public function replace()
	{
		$ret = $this->db->execute(static::replaceQry(),get_object_vars($this));		
		if($ret==0)
			throw new DatabaseException("Cannot replace ".static::class);	
		return $ret;
	}

	public function delete()
	{		
		return $this->db->execute(static::deleteQry(),get_object_vars($this));
	}

	public static function get($db,$ctorArgs=[])
	{
		$params = func_get_args();
		array_shift($params);

		array_unshift($ctorArgs,$db);
		$res = $db->query(static::getQry(), $params, static::class, $ctorArgs);
		if(count($res)==0)
		{
			throw new NotFoundException(static::class);
		}
		return $res[0];
	}

	static function onNotFound($args)
	{
		throw new NotFoundException(static::class);
	}

	abstract static function getQry();
	abstract static function selectQry();
	abstract static function insertQry();
	abstract static function replaceQry();
	abstract static function updateQry();
	abstract static function deleteQry();
}

