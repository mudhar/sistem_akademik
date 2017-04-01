<?php
class Jurusan{
	private $db;
	public function __construct($database)
	{   $this->db = $database; }
	public function jurusan_exists($jurusanid)
	{	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `jurusan` WHERE `jurusanid`= ?");
		$query->bindValue(1, $jurusanid);
		try
		{	$query->execute();
			$rows = $query->fetchColumn();
			if($rows == 1){
				return true;
			}else{
				return false;
			}
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function add_jurusan($kodejurusan,$idprodi,$namajurusan)
	{	$querystring = "INSERT INTO `jurusan` (`kodejurusan`,`idprodi`, `namajurusan`) VALUES (?, ?, ?)";
		$query 	= $this->db->prepare($querystring);
		$query->bindValue(1, $kodejurusan);
		$query->bindValue(2, $idprodi);
		$query->bindValue(3, $namajurusan);
	 	try{
			$query->execute();
	 	}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function update_jurusan ($kodejurusan,$idprodi,$namajurusan)
	{	$querystring = "UPDATE `jurusan` SET `kodejurusan` = ? , `idprodi` = ? , `namajurusan` = ? WHERE `idjurusan` = ?";
		$query 	= $this->db->prepare($querystring);
	 	$query->bindValue(1, $kodejurusan);
		$query->bindValue(2, $idprodi);
		$query->bindValue(3, $namajurusan);
		$query->bindValue(4, $idjurusan);
	 	try{
			$query->execute();
		}
		catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function delete_jurusan($id){
		$sql="DELETE FROM `jurusan` WHERE `idjurusan` = ?";
		$query = $this->db->prepare($sql);
		$query->bindValue(1, $id);
		try{
			$query->execute();
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function jurusan_data($id)
	{	$query = $this->db->prepare("SELECT * FROM `jurusan` WHERE `idjurusan`= ?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
			return $query->fetch();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function get_jurusan()
	{	$query = $this->db->prepare("SELECT * FROM `jurusan` ORDER BY `idjurusan` DESC");
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		return $query->fetchAll();
	}
	public function get_jurusan_prodi($id) //get project_data by idcustomer
	{	$query = $this->db->prepare("SELECT * FROM `jurusan` WHERE `idprodi`= ? ORDER BY `namajurusan` DESC LIMIT 1");
		$query->bindValue(1, $id);
		try{
			$query->execute();
			return $query->fetch();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
}
