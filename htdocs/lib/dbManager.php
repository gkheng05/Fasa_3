<?php
session_start();

/**
 * redirects webpage to specific path
 * 
 * @param string $path path to redirect to eg. login.php, daftarPeserta.php, folder/file
 */
function redirect(string $path){
    header("Location: $path", true, 302);
}

class dbManager
{
    /**
     * @var string $dbHost database hostname or ip address
     */
    private string $dbHost;

    /**
     * @var string $dbHost database username
     */
    private string $username;

    /**
     * @var string $dbHost database password
     */
    private string $password;

    /**
     * @var string $dbHost database name
     */
    private string $dbName;

    /**
     * @var mysqli $dbHost database session object
     */
    private mysqli $dbConn;

    public function __construct($dbHost, $username, $password, $dbName)
    {
        $this->dbHost = $dbHost;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    /**
     * initialize class, need to be called everytime
     * 
     * @return bool true if success or else false
     */
    public function init()
    {
        //init database session
        $this->dbConn = new mysqli($this->dbHost, $this->username, $this->password, $this->dbName);

        if ($this->dbConn->connect_error) {
            return false;
        }
        //query to create ADMIN table
        $createAdmin = "CREATE TABLE IF NOT EXISTS `ADMIN` ( 
                `idAdmin` INT NOT NULL AUTO_INCREMENT ,
                `namaAdmin` VARCHAR(256) NOT NULL , 
                `kataLaluanAdmin` VARCHAR(64) NOT NULL ,
                PRIMARY KEY (`idAdmin`), 
                UNIQUE (`namaAdmin`)) 
                ENGINE = InnoDB;";

        //query to create PESERTA table with foreign key restrain
        /* 
        $createPeserta = "CREATE TABLE IF NOT EXISTS `PESERTA` ( 
            `idPeserta` INT NOT NULL AUTO_INCREMENT ,
            `namaPeserta` VARCHAR(256) NOT NULL , 
            `kataLaluanPeserta` VARCHAR(64) NOT NULL ,
            `alamatPeserta` VARCHAR(200) NOT NULL ,
            `idMarkah` INT NULL DEFAULT NULL ,
            PRIMARY KEY (`idPeserta`), 
            UNIQUE (`namaPeserta`) ,
            FOREIGN KEY (`idMarkah`) REFERENCES MARKAH(`idMarkah`) ON DELETE CASCADE
            ) ENGINE = InnoDB;";
        */
        
        //query to create PESERTA table
        $createPeserta = "CREATE TABLE IF NOT EXISTS `PESERTA` ( 
            `idPeserta` INT NOT NULL AUTO_INCREMENT ,
            `namaPeserta` VARCHAR(256) NOT NULL , 
            `kataLaluanPeserta` VARCHAR(64) NOT NULL ,
            `alamatPeserta` VARCHAR(200) NOT NULL ,
            `idMarkah` INT NULL DEFAULT NULL ,
            PRIMARY KEY (`idPeserta`), 
            UNIQUE (`namaPeserta`)
            ) ENGINE = InnoDB;";

        //query to create HAKIM table
        $createHakim = "CREATE TABLE IF NOT EXISTS `HAKIM` ( 
            `idHakim` INT NOT NULL AUTO_INCREMENT ,
            `namaHakim` VARCHAR(256) NOT NULL , 
            `kataLaluanHakim` VARCHAR(64) NOT NULL ,
            PRIMARY KEY (`idHakim`), 
            UNIQUE (`namaHakim`)) 
            ENGINE = InnoDB;";
        
        //query to create MARKAH table
        $createMarkah = "CREATE TABLE IF NOT EXISTS `MARKAH` ( 
            `idMarkah` INT NOT NULL AUTO_INCREMENT ,
            `markahBhgA` INT NOT NULL , 
            `markahBhgB` INT NOT NULL ,
            `markahBhgC` INT NOT NULL ,
            `jumlahMarkah` INT AS (markahBhgA + markahBhgB + markahBhgC) VIRTUAL NOT NULL ,
            PRIMARY KEY (`idMarkah`) ,
            ) ENGINE = InnoDB;";
        
        //query to create PEMENANG table (useless)
        $createPemenang = "CREATE TABLE IF NOT EXISTS `PEMENANG` ( 
            `idPemenang` INT NOT NULL AUTO_INCREMENT ,
            `jumlahMarkah` INT NOT NULL , 
            `tempatPeserta` INT NULL DEFAULT NULL ,
            PRIMARY KEY (`idPemenang`) ,
            ) ENGINE = InnoDB;";

        /**
         * create table query doesnt needed to be run if tables are already created
         */
        /*

        $this->dbConn->query($createAdmin); #these both first
        $this->dbConn->query($createHakim);

        $this->dbConn->query($createMarkah); #then this

        $this->dbConn->query($createPeserta); #this last
        
        $this->dbConn->query($createPemenang);

        */

        return true;
    }
    /**
     * get a full list of peserta, it will be a nested array
     * 
     * @return array 
     */
    public function getAllTempatPeserta(){
        $queryStr = "SELECT PESERTA.namaPeserta, MARKAH.markahBhgA, MARKAH.markahBhgB, MARKAH.markahBhgC, MARKAH.jumlahMarkah FROM PESERTA 
                    JOIN MARKAH ON PESERTA.idMarkah = MARKAH.idMarkah 
                    ORDER BY MARKAH.jumlahMarkah DESC";

        $result = $this->dbConn->query($queryStr);
        while($res = $result->fetch_array()){
            $ret[] = $res;
        }
        return $ret;
    }

    /**
     * get a full list of peserta, filter by namaPeserta
     * 
     * @return array 
     */
    public function getTempatPesertaByName(string $namaPeserta){
        $queryStr = "SELECT PESERTA.namaPeserta, MARKAH.markahBhgA, MARKAH.markahBhgB, MARKAH.markahBhgC, MARKAH.jumlahMarkah FROM PESERTA 
                    JOIN MARKAH ON PESERTA.idMarkah = MARKAH.idMarkah 
                    WHERE PESERTA.namaPeserta LIKE '$namaPeserta%'
                    ORDER BY MARKAH.jumlahMarkah DESC";

        $result = $this->dbConn->query($queryStr);
        $ret = array();
        if($result)
            while($res = $result->fetch_array()){
                $ret[] = $res;
            }
        return $ret;
    }
    
    /**
     * get markah peserta if current session is peserta
     * 
     * @return array 
     */
    public function getMarkahPeserta(){
        $queryStr = "SELECT markahBhgA, markahBhgB, markahBhgC, jumlahMarkah FROM MARKAH WHERE idMarkah = '{$_SESSION["idPeserta"]}'";
        $result = $this->dbConn->query($queryStr);
        return $result->fetch_array();
    }

    /**
     * get current user name
     * 
     * @return string 
     */
    public function getNamaPengguna(){
        return $_SESSION["nama"];
    }

    /**
     * get all users
     * 
     * @return array
     */
    public function getAllUsers(){
        $queryStr = "SELECT namaPeserta as nama, 1 as idPeranan FROM `PESERTA` 
                    UNION SELECT namaHakim as nama, 2 as idPeranan FROM `HAKIM` 
                    UNION SELECT namaAdmin as nama, 6 as idPeranan FROM `ADMIN`";
        $result = $this->dbConn->query($queryStr);
        $ret = [];
        if($result)
            while($res = $result->fetch_array()){
                $ret[] = $res;
            }
        return $ret;
    }

    /**
     * search by username or role groups
     * 
     * @param int $role 0 = all roles, 1 = peserta, 2 = hakim, 6 = admin
     * @return array
     */
    public function searchBy(string $username, int $role = 0){
        $queryStr = "SELECT * FROM
                    (SELECT namaPeserta as nama, 1 as idPeranan FROM `PESERTA` 
                    UNION SELECT namaHakim as nama, 2 as idPeranan FROM `HAKIM` 
                    UNION SELECT namaAdmin as nama, 6 as idPeranan FROM `ADMIN`) AS A
                    WHERE nama LIKE '$username%' AND ($role = 0 OR idPeranan = $role)";
        $result = $this->dbConn->query($queryStr);
        $ret = [];
        if($result)
            while($res = $result->fetch_array()){
                $ret[] = $res;
            }
        return $ret;
    }

    /**
     * login as Peserta / Hakim / Admin
     * 
     * @return bool true if loggin successful or else false
     */
    public function getLoginCred(string $username, string $password){
        $this->hashPassword($password);
        if(!$this->checkValidString(func_get_args()))
            return false;

        //check if is Peserta
        if(($query = $this->dbConn->query("SELECT * FROM `PESERTA` WHERE namaPeserta = '$username' AND kataLaluanPeserta = '$password'"))->num_rows >= 1)
        {
            $data = $query->fetch_array();
            $_SESSION["role"] = 0x001;
            $_SESSION["idPeserta"] = $data["idPeserta"];
            $_SESSION["nama"] = $data["namaPeserta"];
            return true;
        }
        //check if is Hakim
        else if(($query = $this->dbConn->query("SELECT * FROM `HAKIM` WHERE namaHakim = '$username' AND kataLaluanHakim = '$password'"))->num_rows >= 1)
        {
            $data = $query->fetch_array();
            $_SESSION["role"] = 0x010;
            $_SESSION["nama"] = $data["namaHakim"];
            return true;
        }
        //check if is Admin
        else if(($query = $this->dbConn->query("SELECT * FROM `ADMIN` WHERE namaAdmin = '$username' AND kataLaluanAdmin = '$password'"))->num_rows >= 1)
        {
            $data = $query->fetch_array();
            $_SESSION["role"] = 0x110;
            $_SESSION["nama"] = $data["namaAdmin"];
            return true;
        }
        
        return false;
    }

    /**
     * check if current session is Admin
     * 
     * @return bool
     */
    public function isAdmin(){
        return (bool)($_SESSION["role"] & 0x100);
    }

    /**
     * check if current session is Hakim
     * 
     * @return bool
     */
    public function isHakim(){
        return (bool)($_SESSION["role"] & 0x010);
    }

    /**
     * check if current session is Peserta
     * 
     * @return bool
     */
    public function isPeserta(){
        return (bool)($_SESSION["role"] & 0x001);
    }

    /**
     * check if session logged in as Peserta / Hakim / Admin
     * 
     * @return bool
     */
    public function checkLoggedIn(){
        if($this->isPeserta() || $this->isHakim() || $this->isAdmin())
        {
            return true;
        }
        redirect("login.php");
        return false;
    }

    /**
     * create peserta role user
     * 
     * @param string $namaPeserta peserta username
     * @param string $kataLaluanPeserta peserta password
     * @param string $alamatPeserta [Optional]
     */
    public function createPeserta(string $namaPeserta, string $kataLaluanPeserta, string $alamatPeserta = ""){
        if(!$this->checkValidString(func_get_args()))
            return false;
        $this->hashPassword($kataLaluanPeserta);
        $queryStr = "INSERT INTO `PESERTA`(`namaPeserta`, `kataLaluanPeserta`, `alamatPeserta`) VALUES ('$namaPeserta', '$kataLaluanPeserta', '$alamatPeserta')";
        //echo $queryStr;
        return ($this->dbConn->query($queryStr)) ? true : false;
    }

    /**
     * create hakim role user
     * 
     * @param string $namaHakim hakim username
     * @param string $kataLaluanHakim hakim password
     */
    public function createHakim(string $namaHakim, string $kataLaluanHakim){
        if(!$this->checkValidString(func_get_args()))
            return false;
        $this->hashPassword($kataLaluanHakim);
        $queryStr="INSERT INTO `HAKIM`(`namaHakim`, `kataLaluanHakim`) VALUES ('$namaHakim', '$kataLaluanHakim')";
        return ($this->dbConn->query($queryStr)) ? true : false;
    }

    /**
     * create admin role user
     * 
     * @param string $namaAdmin admin username
     * @param string $kataLaluanAdmin admin password
     */
    public function createAdmin(string $namaAdmin, string $kataLaluanAdmin){
        if(!$this->checkValidString(func_get_args()))
            return false;
        $this->hashPassword($kataLaluanAdmin);
        $queryStr="INSERT INTO `ADMIN`(`namaAdmin`, `kataLaluanAdmin`) VALUES ('$namaAdmin', '$kataLaluanAdmin')";
        return ($this->dbConn->query($queryStr)) ? true : false;
    }

    /**
     * change markah by namaPeserta
     * 
     * @return bool
     */
    public function editMarkah(string $namaPeserta, int $markahBhgA, int $markahBhgB, int $markahBhgC){
        //echo ("test");
        if(!$this->checkValidString(func_get_args()))
            return false;
        
        if($this->dbConn->query("SELECT * FROM `PESERTA` WHERE namaPeserta = '$namaPeserta'")->num_rows == 0)
            return false;
        
        if($markahBhgA > 20 || $markahBhgB > 30 || $markahBhgC > 50)
            return false;

        #$queryInsert = "INSERT INTO MARKAH(markahBhgA, markahBhgB, markahBhgC) VALUES (int $markahBhgA, int $markahBhgB, int $markahBhgC)  "
        $idMarkah = $this->dbConn->query("SELECT idMarkah FROM `PESERTA` WHERE namaPeserta = '$namaPeserta'")->fetch_array()[0];
        //echo var_dump($idMarkah);
        if($idMarkah){
            $queryUpdate = "UPDATE `MARKAH` SET `markahBhgA` = '$markahBhgA' , `markahBhgB` = '$markahBhgB' , `markahBhgC` = '$markahBhgC' WHERE `MARKAH`.`idMarkah` = $idMarkah";
            return ($this->dbConn->query($queryUpdate)) ? true : false;
        }else{
            $queryInsert = "INSERT INTO `MARKAH` (`markahBhgA`, `markahBhgB`, `markahBhgC`) VALUES ('$markahBhgA', '$markahBhgB', '$markahBhgC');";
            $res = $this->dbConn->query($queryInsert);
            //echo var_dump($res);
            if($res != TRUE)
                return false;
            $queryUpdate = "UPDATE `PESERTA` SET idMarkah = LAST_INSERT_ID() WHERE namaPeserta = '$namaPeserta'";
            return ($this->dbConn->query($queryUpdate)) ? true : false;
        }
    }

    /**
     * delete user by username, defaults to delete peserta
     * 
     * @param int $role user role group
     * @return bool
     */
    public function deletePengguna(string $username ,?int $role = 0x001){
        switch($role)
        {
            case 1:
                return ($this->dbConn->query("DELETE FROM `PESERTA` WHERE namaPeserta = '$username'")) ? true : false;
            case 2:
                return ($this->dbConn->query("DELETE FROM `HAKIM` WHERE namaHakim = '$username'")) ? true : false;
            case 6:
                return ($this->dbConn->query("DELETE FROM `ADMIN` WHERE namaAdmin = '$username'")) ? true : false;
        }
    }

    /**
     * check if string is a valid query string, for security purposes
     * 
     * @param array $allString array of string args
     */
    private function checkValidString(array $allString){
        foreach($allString as $str){
            $checkedStr = $this->dbConn->real_escape_string($str);
            if($str != $checkedStr)
                return false;
        }
        return true;
    }

    /**
     * keep hashed password on database for security purpose
     * 
     * @param string &$password reference to password, will change the variable directly
     */
    private function hashPassword(string &$password){
        $newPass = $password;
        $password = hash("sha256", $newPass);
    }
}

$dbManager = new dbManager("sql106.epizy.com", "epiz_30527667", "3GR5M3fnYnFp6Sx", "epiz_30527667_test");

