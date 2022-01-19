<?php
session_start();

/**
 * redirects webpage to specific path
 * 
 * @param string $path path to redirect to eg. login.php, daftarPeserta.php, folder/file
 */
function redirect(string $path)
{
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
            `jumlahMarkah` INT AS (markahBhgA + markahBhgB + markahBhgC) VIRTUAL ,
            PRIMARY KEY (`idMarkah`)
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


        //$this->dbConn->query($createAdmin); #these both first
        //$this->dbConn->query($createHakim);

        //$this->dbConn->query($createMarkah); #then this

        //$this->dbConn->query($createPeserta); #this last

        //$this->dbConn->query($createPemenang);



        return true;
    }
    /**
     * get a full list of peserta, it will be a nested array
     * 
     * @return array 
     */
    public function getAllTempatPeserta()
    {
        $queryStr = "SELECT * FROM allPeserta";

        return $this->queryResultToArray($this->dbConn->query($queryStr));
    }

    /**
     * get a full list of peserta, filter by namaPeserta
     * 
     * @return array 
     */
    public function getTempatPesertaByName(string $namaPeserta)
    {
        $queryStr = "SELECT * FROM allPeserta WHERE nama LIKE '$namaPeserta%'";

        return $this->queryResultToArray($this->dbConn->query($queryStr));
    }

    /**
     * get markah peserta if current session is peserta
     * 
     * @return array 
     */
    public function getMarkahPeserta()
    {
        $queryStr = "SELECT markahBhgA, markahBhgB, markahBhgC, jumlahMarkah 
                    FROM MARKAH WHERE idMarkah = '{$_SESSION["id"]}'";
        $result = $this->dbConn->query($queryStr);
        return $result->fetch_array();
    }


    public function getMarkahPurata(){
        if($result = $this->dbConn->query("SELECT avg(markahBhgA) / 20 * 100 as a, avg(markahBhgB) / 30 * 100 as b, avg(markahBhgC) / 50 * 100 as c, avg(jumlahMarkah) FROM markah"))
            return $result->fetch_array();
        return false;
    }

    /**
     * get current user name
     * 
     * @return string 
     */
    public function getNamaPengguna()
    {
        return $_SESSION["nama"] ?? "";
    }

    /**
     * get all users
     * 
     * @return array
     */
    public function getAllUsers()
    {
        $queryStr = "SELECT * FROM `allPengguna`";
        /*
        $queryStr = "SELECT namaPeserta as nama, 1 as idPeranan FROM `PESERTA` 
                    UNION SELECT namaHakim as nama, 2 as idPeranan FROM `HAKIM` 
                    UNION SELECT namaAdmin as nama, 6 as idPeranan FROM `ADMIN`";*/

        return $this->queryResultToArray($this->dbConn->query($queryStr));
    }

    /**
     * search by username or role groups
     * 
     * @param int $role 0 = all roles, 1 = peserta, 2 = hakim, 6 = admin
     * @return array
     */
    public function searchBy(string $username = "", int $role = 0)
    {
        $queryStr = "SELECT * FROM `allPengguna` WHERE nama LIKE '$username%' AND ($role = 0 OR peranan = $role)";

        return $this->queryResultToArray($this->dbConn->query($queryStr));
    }

    /**
     * login as Peserta / Hakim / Admin
     * 
     * @return bool true if loggin successful or else false
     */
    public function getLoginCred(string $emel, string $kataLaluan)
    {
        $this->hashPassword($kataLaluan);
        if (!$this->checkValidString(func_get_args()))
            return false;

        //check if is Peserta
        $queryStr = "SELECT idPengguna, perananPengguna, allPengguna.nama AS nama FROM `PENGGUNA`
                    JOIN `allPengguna`
                    ON pengguna.idPengguna = allPengguna.id
                    WHERE pengguna.emelPengguna = '$emel' AND pengguna.kataLaluanPengguna = '$kataLaluan'";

        if (($query = $this->dbConn->query($queryStr))->num_rows >= 1) {
            $data = $query->fetch_array();
            $_SESSION["role"] = $data["perananPengguna"];
            $_SESSION["id"] = $data["idPengguna"];
            $_SESSION["nama"] = $data["nama"];
            return true;
        }/*
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
        */
        return false;
    }

    public function getPeranan(int $idPeranan)
    {
        switch ($idPeranan) {
            case 0b001:
                return "PESERTA";
            case 0b010:
                return "HAKIM";
            case 0b110:
                return "ADMIN";
        }
    }

    public function importMarkah(string $fileName)
    {
        $file = fopen($fileName, "r");
        while (($data = fgetcsv($file, 0)) !== false) {
            if (!empty($data[0]) && !empty($data[1]))
                $result[] = $data;
        }
        fclose($file);
        if (!isset($result) || $result[0] != array("id", "nama", "bahagian A", "bahagian B", "bahagian C") || count($result) <= 1) 
            return false;
        
        array_shift($result);

        foreach ($result as $res)
            $allMarkah[] = "(" . $res[0] . ", " . $res[2] . ", " . $res[3] . ", " . $res[4] . ")";
        $flatten = implode(", ", $allMarkah);
        $queryStr = "INSERT INTO `markah`(`idMarkah`, `markahBhgA`, `markahBhgB`, `markahBhgC`) VALUES $flatten 
                    ON DUPLICATE KEY UPDATE `markahBhgA`=VALUES(markahBhgA), `markahBhgB`=VALUES(markahBhgB), `markahBhgC`=VALUES(markahBhgC);";

        try {
            $this->dbConn->query($queryStr);
        } catch (Exception $e) {
            echo var_dump($e);
            return false;
        }
        return true;
    }

    public function exportMarkah()
    {
        //$file = fopen("php://temp","rw+");
        $file = fopen("php://output", "rw+");
        fputcsv($file, array("id", "nama", "bahagian A", "bahagian B", "bahagian C"));
        $allRes = $this->getAllTempatPeserta();
        foreach ($allRes as $res)
            fputcsv($file, array($res["id"], $res["nama"], $res["a"], $res["b"], $res["c"]));

        fclose($file);
        /*
        $len = ftell($file);
        rewind($file);
        $csv = fread($file, $len);
        fclose($file);
        return $csv;
        */
    }

    public function exportPeserta()
    {
        $result = $this->searchBy("", 1);
        $file = fopen("php://output", "rw+");
        fputcsv($file, array("nama", "emel", "kata laluan", "telefon", "noic", "alamat"));
        foreach ($result as $res)
            fputcsv($file, array($res["nama"], $res["emel"], "", $res["telefonPeserta"], $res["noicPeserta"], $res["alamatPeserta"]));

        fclose($file);
    }

    public function exportHakimAtauAdmin(bool $isAdmin)
    {
        $result = $this->searchBy("", ($isAdmin) ? 6 : 2);
        $file = fopen("php://output", "rw+");
        fputcsv($file, array("nama", "emel", "kata laluan"));
        foreach ($result as $res)
            fputcsv($file, array($res["nama"], $res["emel"], ""));

        fclose($file);
    }

    public function importByCSV(string $fileName, int $peranan)
    {
        $file = fopen($fileName, "r");
        while (($data = fgetcsv($file, 0)) !== false) {
            if (!empty($data[0]) && !empty($data[1]) && !empty($data[2]))
                $result[] = $data;
        }
        fclose($file);

        if ($peranan !== 1 && $peranan !== 2 && $peranan !== 6)
            return false;

        if (!isset($result) || $result[0] != array("nama", "emel", "kata laluan") || count($result) <= 1)
            return false;

        array_shift($result);

        try {

            $this->dbConn->begin_transaction();
            $this->dbConn->query("DELETE FROM `PENGGUNA` WHERE perananPengguna = $peranan");

            foreach ($result as $res) {
                $passwd = $res[2];
                $this->hashPassword($passwd);
                $allPengguna[] = "('" . $res[1] . "', '" . $passwd . "', " . $peranan . ")";
            }

            $flatAP = implode(", ", $allPengguna);
            $this->dbConn->query("INSERT INTO `PENGGUNA`(`emelPengguna`,`kataLaluanPengguna`,`perananPengguna`) VALUES $flatAP");

            $minID = $this->dbConn->query("SELECT MAX(`idPengguna`) FROM `Pengguna`")->fetch_array()[0] - count($result);
            if ($peranan == 1) {
                foreach ($result as $res) {
                    $minID++;
                    $allPeserta[] = "(" . $minID . " ,'" . $res[0] . "' ,'" . $res[3] . "' ,'" . $res[4] . "' ,'" . $res[5] . "')";
                    $allIDMarkah[] = "($minID)";
                }

                $this->dbConn->query("INSERT INTO `markah`(`idMarkah`) VALUES " . implode(", ", $allIDMarkah));

                $flatten = implode(", ", $allPeserta);
                $queryStr = "INSERT INTO `peserta`(`idPeserta`, `namaPeserta`, `telefonPeserta`, `noicPeserta`, `alamatPeserta`) VALUES $flatten";
            } else if ($peranan == 2 || $peranan == 6) {
                foreach ($result as $res) {
                    $minID++;
                    $allPeserta[] = "(" . $minID . " ,'" . $res[0] . "')";
                }

                $flatten = implode(", ", $allPeserta);
                $queryStr = (($peranan == 2) ? "INSERT INTO `HAKIM`(`idHakim`, `namaHakim`) VALUES " : "INSERT INTO `ADMIN`(`idAdmin`, `namaAdmin`) VALUES ") . $flatten;
            }

            $this->dbConn->query($queryStr);
            $this->dbConn->commit();
        } catch (Exception $e) {
            $this->dbConn->rollback();
            return false;
        }
        return true;
    }

    /**
     * check if current session is Admin
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return (($_SESSION["role"] ?? 0) & 0b100) !== 0;
    }

    /**
     * check if current session is Hakim
     * 
     * @return bool
     */
    public function isHakim()
    {
        return (($_SESSION["role"] ?? 0) & 0b010) !== 0;
    }

    /**
     * check if current session is Peserta
     * 
     * @return bool
     */
    public function isPeserta()
    {
        return (($_SESSION["role"] ?? 0) & 0b001) !== 0;
    }

    /**
     * check if session logged in as Peserta / Hakim / Admin
     * 
     * @return bool
     */
    public function checkLoggedIn()
    {
        if ($this->isPeserta() || $this->isHakim() || $this->isAdmin()) {
            return true;
        }
        redirect("login.php");
        return false;
    }

    public function createPengguna(int $peranan, string $emel, string $kataLaluan)
    {
        if (!$this->checkValidString(func_get_args()))
            return false;

        $this->hashPassword($kataLaluan);
        $queryStr = "INSERT INTO `PENGGUNA` (`emelPengguna`, `kataLaluanPengguna`, `perananPengguna`) VALUES ('$emel', '$kataLaluan', $peranan);";
        if (!$this->dbConn->query($queryStr))
            return false;

        return $this->dbConn->insert_id;
    }

    /**
     * create peserta role user
     * 
     * @param string $namaPeserta peserta username
     * @param string $kataLaluanPeserta peserta password
     * @param string $alamatPeserta [Optional]
     */
    public function createPeserta(string $emel, string $kataLaluan, string $namaPeserta, string $alamatPeserta, string $noicPeserta, string $telefonPeserta)
    {
        if (!$this->checkValidString(func_get_args()))
            return false;

        $id = $this->createPengguna(1, $emel, $kataLaluan);
        $pesertaQuery = "INSERT INTO `PESERTA`(`idPeserta`, `namaPeserta`, `telefonPeserta`, `noicPeserta`, `alamatPeserta`) VALUES ($id, '$namaPeserta', '$telefonPeserta', '$noicPeserta', '$alamatPeserta')";
        $markahQuery = "INSERT INTO `MARKAH`(`idMarkah`) VALUES ($id)";

        //echo $queryStr;
        return ($this->dbConn->query($pesertaQuery) && $this->dbConn->query($markahQuery)) ? true : false;
    }

    /**
     * create hakim role user
     * 
     * @param string $namaHakim hakim username
     * @param string $kataLaluanHakim hakim password
     */
    public function createHakim(string $emel, string $kataLaluan, string $namaHakim)
    {
        if (!$this->checkValidString(func_get_args()))
            return false;
        $id = $this->createPengguna(2, $emel, $kataLaluan);
        $queryStr = "INSERT INTO `HAKIM`(`idHakim`, `namaHakim`) VALUES ($id, '$namaHakim')";
        return ($this->dbConn->query($queryStr)) ? true : false;
    }

    /**
     * create admin role user
     * 
     * @param string $namaAdmin admin username
     * @param string $kataLaluanAdmin admin password
     */
    public function createAdmin(string $emel, string $kataLaluan, string $namaAdmin)
    {
        if (!$this->checkValidString(func_get_args()))
            return false;
        $id = $this->createPengguna(6, $emel, $kataLaluan);
        $queryStr = "INSERT INTO `ADMIN`(`idAdmin`, `namaAdmin`) VALUES ($id, '$namaAdmin')";
        return ($this->dbConn->query($queryStr)) ? true : false;
    }

    /**
     * change markah by id
     * 
     * @return bool
     */
    public function editMarkah(int $id, int $markahBhgA, int $markahBhgB, int $markahBhgC)
    {
        //echo ("test");
        //if(!$this->checkValidString(func_get_args()))
        //    return false;

        if ($this->dbConn->query("SELECT * FROM `MARKAH` WHERE idMarkah = $id")->num_rows == 0)
            return false;

        if ($markahBhgA > 20 || $markahBhgB > 30 || $markahBhgC > 50)
            return false;

        $queryUpdate = "UPDATE `MARKAH` SET `markahBhgA` = $markahBhgA , `markahBhgB` = $markahBhgB , `markahBhgC` = $markahBhgC WHERE `MARKAH`.`idMarkah` = $id";
        return ($this->dbConn->query($queryUpdate)) ? true : false;
        #$queryInsert = "INSERT INTO MARKAH(markahBhgA, markahBhgB, markahBhgC) VALUES (int $markahBhgA, int $markahBhgB, int $markahBhgC)  "
        /*$idMarkah = $this->dbConn->query("SELECT idMarkah FROM `PESERTA` WHERE namaPeserta = '$namaPeserta'")->fetch_array()[0];
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
        }*/
    }

    public function editPengguna(int $id, string $emel, string $kataLaluan = null)
    {
        if (!$this->checkValidString(func_get_args()))
            return false;

        $editKataLaluan = "";
        if ($kataLaluan != null) {
            $this->hashPassword($kataLaluan);
            $editKataLaluan = ", `kataLaluanPengguna` = '$kataLaluan'";
        }
        $queryStr = "UPDATE `PENGGUNA` SET `emelPengguna` = '$emel'$editKataLaluan WHERE `PENGGUNA`.`idPengguna` = $id";

        return $this->dbConn->query($queryStr);
    }

    public function editHakim(int $id, string $nama)
    {

        if (!$this->checkValidString(func_get_args()))
            return false;

        $queryStr = "UPDATE `HAKIM` SET `namaHakim` = '$nama' WHERE `HAKIM`.`idHakim` = $id";

        return $this->dbConn->query($queryStr);
    }

    public function editAdmin(int $id, string $nama)
    {
        if (!$this->checkValidString(func_get_args()))
            return false;

        $queryStr = "UPDATE `ADMIN` SET `namaAdmin` = '$nama' WHERE `ADMIN`.`idAdmin` = $id";

        return $this->dbConn->query($queryStr);
    }

    public function editPeserta(int $id, string $nama, string $alamat, string $noic, string $telefon)
    {
        if (!$this->checkValidString(func_get_args()))
            return false;

        $queryStr = "UPDATE `PESERTA` SET `namaPeserta` = '$nama', `telefonPeserta` = '$telefon', `noicPeserta` = '$noic', `alamatPeserta` = '$alamat'
                     WHERE `PESERTA`.`idPeserta` = $id";

        return $this->dbConn->query($queryStr);
    }

    /**
     * delete user by id
     * 
     * @return bool
     */
    public function deletePengguna(int $id)
    {
        return ($this->dbConn->query("DELETE FROM `PENGGUNA` WHERE idPengguna = $id")) ? true : false;
    }

    /**
     * check if string is a valid query string, for security purposes
     * 
     * @param array $allString array of string args
     */
    private function checkValidString(array $allString)
    {
        foreach ($allString as $str) {
            if (is_null($str))
                return false;

            $checkedStr = $this->dbConn->real_escape_string($str);
            if ($str != $checkedStr)
                return false;
        }
        return true;
    }

    /**
     * keep hashed password on database for security purpose
     * 
     * @param string &$password reference to password, will change the variable directly
     */
    private function hashPassword(string &$password)
    {
        $newPass = $password;
        $password = hash("sha256", $newPass);
    }

    private function queryResultToArray(mysqli_result $result)
    {
        $ret = [];
        //echo var_dump($result);
        if ($result)
            while ($res = $result->fetch_array()) {
                $ret[] = $res;
            }
        return $ret;
    }
}

$dbManager = new dbManager("127.0.0.1", "admin", "4C4zjH_12)[/_zz_", "webapp");
