<?php
class Mahasiswa{
	private $db;
	public function __construct($database)
	{
    $this->db = $database;
  }
  // cek double nama mahasiswa ada di table
	public function mahasiswa_exists($namamahasiswa)
	{
    $query = $this->db->prepare("SELECT COUNT(`id`) FROM `mahasiswa` WHERE `namamahasiswa`= ?");
		$query->bindValue(1, $namamahasiswa);
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
	public function email_exists($email)
	{	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `mahasiswa` WHERE `email`= ?");
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
  // tambah mahasiswa
	public function add_mahasiswa($namamahasiswa,$alamat,$telp,$email,$noktp)
	{	$time 		= time();
		$query 	= $this->db->prepare("INSERT INTO `mahasiswa` (`namamahasiswa`, `alamat`, `telp`, `email`, `noktp`,`time`) VALUES (?, ?, ?, ?, ?, ?)");
		$query->bindValue(1, $namamahasiswa);
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

  // update mahasiswa
	public function update_mahasiswa($idmahasiswa,$namamahasiswa,$alamat,$telp,$email,$noktp)
	{	$time 		= time();
	 	$query 	= $this->db->prepare("UPDATE `mahasiswa` SET `namamahasiswa` = ? , `alamat` = ? , `telp` = ? , `email` = ? , `noktp` = ? , `time` = ? WHERE `idmahasiswa` = ?");
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

  // delete mahasiswa
	public function delete($id){
		$sql="DELETE FROM `mahasiswa` WHERE `idmahasiswa` = ?";
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
	{	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `mahasiswa` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
		$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);
		try{
			$query->execute();
			$rows = $query->fetchColumn();
			if($rows == 1){
				$query_2 = $this->db->prepare("UPDATE `mahasiswa` SET `confirmed` = ? WHERE `email` = ?");
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
	{	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `mahasiswa` WHERE `username`= ? AND `confirmed` = ?");
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

  // login
	public function login_mahasiswa($username, $password)
	{	$query = $this->db->prepare("SELECT `email`, `idprodi` FROM `mahasiswa` WHERE `email` = ?");
		$query->bindValue(1, $username);
		try{
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password'];
			$id   				= $data['id'];
			if($stored_password === sha1($password)){
				return $id;
			}else{
				return false;
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

  // mahasiswa data
	public function mahasiswa_data($id)
	{	$query = $this->db->prepare("SELECT * FROM `mahasiswa` WHERE `idmahasiswa`= ?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
			return $query->fetch();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function get_mahasiswa()
	{	$query = $this->db->prepare("SELECT * FROM `mahasiswa` ORDER BY `namamahasiswa` ASC");
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		return $query->fetchAll();
	}
}
