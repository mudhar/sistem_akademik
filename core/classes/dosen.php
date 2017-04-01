<?php
// kelas dosen
class Dosen{
	private $db;
	public function __construct($database)
	{
    $this->db = $database;
  }
  // cek double nama dosen ada di table
	public function mahasiswa_exists($namadosen)
	{
    $query = $this->db->prepare("SELECT COUNT(`id`) FROM `dosen` WHERE `namadosen`= ?");
		$query->bindValue(1, $namadosen);
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

  // cek double email
	public function cek_email_exists_dosen($email)
	{	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `dosen` WHERE `email`= ?");
		$query->bindValue(1, $email);
		try{
			$query->execute();
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
  // tambah dosen
	public function add_dosen($namadosen,$alamat,$telp,$email,$noktp)
	{	$time 		= time();
		$query 	= $this->db->prepare("INSERT INTO `dosen` (`namadosen`, `alamat`, `telp`, `email`, `noktp`,`time`) VALUES (?, ?, ?, ?, ?, ?)");
		$query->bindValue(1, $namadosen);
		$query->bindValue(2, $alamat);
		$query->bindValue(3, $telp);
		$query->bindValue(4, $email);
		$query->bindValue(5, $noktp);
		$query->bindValue(6, $time);
	 	try{
			$query->execute();
	 	}catch(PDOException $e){
			die($e->getMessage());
		}
	}

  // update dosen
	public function update_dosen($iddosen,$namadosen,$alamat,$telp,$email,$noktp)
	{	$time 		= time();
	 	$query 	= $this->db->prepare("UPDATE `dosen` SET `namadosen` = ? , `alamat` = ? , `telp` = ? , `email` = ? , `noktp` = ? , `time` = ? WHERE `idmahasiswa` = ?");
		$query->bindValue(1, $namamahasiswa);
		$query->bindValue(2, $alamat);
		$query->bindValue(3, $telp);
		$query->bindValue(4, $email);
		$query->bindValue(5, $noktp);
		$query->bindValue(6, $time);
	 	try{
			$query->execute();
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	}

  // delete dosen
	public function delete_dosen($id){
		$sql="DELETE FROM `dosen` WHERE `iddosen` = ?";
		$query = $this->db->prepare($sql);
		$query->bindValue(1, $id);
		try{
			$query->execute();
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	}

  // activasi
	public function activate($email, $email_code)
	{	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `dosen` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
		$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);
		try{
			$query->execute();
			$rows = $query->fetchColumn();
			if($rows == 1){
				$query_2 = $this->db->prepare("UPDATE `dosen` SET `confirmed` = ? WHERE `email` = ?");
				$query_2->bindValue(1, 1);
				$query_2->bindValue(2, $email);
				$query_2->execute();
				return true;
			}else{
				return false;
			}
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

  // Konfirmasi
	public function email_confirmed($username)
	{	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `dosen` WHERE `username`= ? AND `confirmed` = ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, 1);
		try{
			$query->execute();
			$rows = $query->fetchColumn();
			if($rows == 1){
				return true;
			}else{
				return false;
			}
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

  // dosen data
	public function dosen_data($id)
	{	$query = $this->db->prepare("SELECT * FROM `dosen` WHERE `iddosen`= ?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
			return $query->fetch();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function get_dosen()
	{	$query = $this->db->prepare("SELECT * FROM `dosen` ORDER BY `namadosen` ASC");
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		return $query->fetchAll();
	}
}
