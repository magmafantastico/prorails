<?php

/**
 * Magma ProRails Model v0.3.0 (http://getvilla.org/)
 * Copyright 2014-2015 Magma Fantastico
 * Licensed under MIT (https://github.com/noibe/villa/blob/master/LICENSE)
 */

class Thing
{

	public $_id;

	private $queryName;
	private $queryLimit = 10;
	private $queryValue;

	/**
	 * Constrói string sql para utilizar na query do push
	 * @return string
	 */
	private function buildInsertQuery()
	{
		$a = new ReflectionObject($this);                           // get reflection of object
		$b = $a->getProperties(ReflectionProperty::IS_PUBLIC);      // get all public properties
		$o = (array)$this;                                          // parse array to get value with key

		if (count($b) > 1) {

			$ok = array();      // object key
			$ov = array();      // object value

			for ($i = count($b); $i--;)
				if ($b[$i]->name != '_id') {
					array_push($ok, $b[$i]->name);
					array_push($ov, '"' . $o[$b[$i]->name] . '"');
				}

			$n = ' ' . lcfirst(get_class($this)) . ' ';     // table name
			$k = '(';                                       // key content
			$v = '(';                                       // value content

			for ($i = count($ok); $i--;) {
				$s = ',';
				if ($i < 1) $s = ') ';
				$k .= $ok[$i] . $s;
				$v .= $ov[$i] . $s;
			}

		} else {
			return 'INSERT INTO ' . lcfirst(get_class($this)) . ' () VALUES ()';
		}

		return 'INSERT INTO' . $n . $k . 'VALUES ' . $v;
	}

	/**
	 * Constrói string sql para utilizar na query do pull
	 * @return bool|string
	 */
	public function buildSelectQuery()
	{
		$qn = $this->getQueryName();        // query name (column name)
		$ql = $this->getQueryLimit();       // query limit
		$qv = $this->getQueryValue();       // query value

		$n = ' ' . lcfirst(get_class($this));       // table name
		$k = '*';                                   // key content

		$sql = 'SELECT ' . $k . ' FROM' . $n;       // select init
		$order = ' ORDER BY _id DESC';              // order by
		$qls = ' LIMIT ' . $ql;                     // set limit

		// test if limit is 0
		if ($ql < 1)
			$qls = '';

		if (!empty($qn)) {
			$cl = ' WHERE ';        // WHERE clause

			// test if value exists to build the WHERE LIKE clause
			if (!empty($qv))
				$cl .= $qn . ' LIKE "%' . $qv . '%"';
			else $cl = '';

			// concat full query
			return $sql . $cl . $order . $qls;
		}

		return $sql . $order . $qls;
	}

	/**
	 * Constrói string sql para utilizar na query do push
	 * @return string
	 */
	private function buildUpdateQuery()
	{
		$a = new ReflectionObject($this);                           // get reflection of object
		$b = $a->getProperties(ReflectionProperty::IS_PUBLIC);      // get all public properties
		$o = (array)$this;                                          // parse array to get value with key

		$ok = array();      // object key
		$ov = array();      // object value

		for ($i = count($b); $i--;)
			if ($b[$i]->name != '_id') {
				array_push($ok, $b[$i]->name);
				array_push($ov, '"' . $o[$b[$i]->name] . '"');
			}

		$n = ' ' . lcfirst(get_class($this)) . ' ';     // table name
		$s = ' ';                                       // set content
		$d = ', ';                                      // divider content

		for ($i = count($ok); $i--;) {
			if ($i < 1) $d = ' ';
			$s .= $ok[$i] . ' = ' . $ov[$i] . $d;
		}

		$w = '_id = ' . $this->getId();

		return 'UPDATE' . $n . 'SET' . $s . 'WHERE ' . $w;

	}

	/**
	 * Executa push utilizando a conexão e a string construída
	 * @param mysqli $c
	 */
	public function push($c)
	{
		if ($this->getId()) $q = $this->buildUpdateQuery();
		else $q = $this->buildInsertQuery();

		if ($q)
			if ($c->query($q))
				$this->setId($c->insert_id);
			else echo $c->error;
	}

	/**
	 * Executa pull utilizando a conexão e a string construída
	 * @param mysqli $c
	 * @return bool|mysqli_result
	 */
	public function pull($c)
	{
		$q = $this->buildSelectQuery();
		if ($q)
			if ($r = $c->query($q))
				return $r;
		return false;
	}

	/**
	 * @param array $a
	 */
	public function fill($a)
	{
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->_id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getQueryName()
	{
		return $this->queryName;
	}

	/**
	 * @param mixed $queryName
	 */
	public function setQueryName($queryName)
	{
		$this->queryName = $queryName;
	}

	/**
	 * @return int
	 */
	public function getQueryLimit()
	{
		return $this->queryLimit;
	}

	/**
	 * @param int $queryLimit
	 */
	public function setQueryLimit($queryLimit)
	{
		$this->queryLimit = $queryLimit;
	}

	/**
	 * @return mixed
	 */
	public function getQueryValue()
	{
		return $this->queryValue;
	}

	/**
	 * @param mixed $queryValue
	 */
	public function setQueryValue($queryValue)
	{
		$this->queryValue = $queryValue;
	}

	/**
	 * @return string
	 */
	public function toJSON()
	{
		return json_encode($this);
	}

}