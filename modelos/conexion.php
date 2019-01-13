<?php

class Conexion{
	static public function conectar(){
		$link = new PDO("mysql:host=127.0.0.1;dbname=g&g", "root", "");
		$link->exec("set names utf8");
		return $link;
	}
}
/*
class Conexion{
	static public function conectar(){
		$link = new PDO("mysql:host=localhost;dbname=bd_x", "root", "");
		$link->exec("set names utf8");
		return $link;
	}
}*/