<?php
declare(strict_types=1);
include_once('./idatabase.php');

class DB implements idatabase{
	
        public $database = null;
        public $servername; // 127.0.0.1
        public $dbname; // aufgabe4
	public $username; // root
	public $passwort; // 

        
	public function __construct(string $dbservername,string $dbname,string $dbusername,string $dbpassword){
         
            $this->servername = $dbservername;
            $this->dbname = $dbname;
            $this->username = $dbusername;
            $this->password = $dbpassword;
	}
	
	public function open(){
            try{
				$DNS = "mysql:host=$this->servername;dbname=$this->dbname";
				$this->database = new PDO($DNS, $this->username, $this->password);
				$this->database -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->database -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
				echo ('Connection successful ');
            }catch(PDOException $exeption){
                echo('Connection failed '.$exeption -> getMessage());			
            }
	}
	
	public function insert(string $article_name,float $price_euro,int $amount){
            try{
				$sql = "INSERT INTO shopping_list (article_name,price_euro,amount) VALUES(?,?,?)";
				$statement = $this->database-> prepare($sql);
				$statement->bindParam(1,$article_name, PDO::PARAM_STR);
				$statement->bindParam(2,$price_euro, PDO::PARAM_STR);
				$statement->bindParam(3,$amount, PDO::PARAM_INT);
				$statement->execute();
				$this->database->lastInsertId();
		echo ('Insert successful ');
                
            }catch(PDOException $exeption){
                echo('Insert failed '.$exeption->getMessage());			
            }
	}
	
	public function query(string $name,string $string){
            try{
				$query = "SELECT * FROM shopping_list WHERE $name='$string'";
				$statement = $this->database->prepare($query);
				$statement->execute();
					
				while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
							print_r($row);
						
				}
            }catch(PDOException $exeption){
                echo ('Select statement failed '.$exeption->getMessage());			
            }
	}
	
	public function delete(string $name,string $string){
            try{
		$delete = "DELETE FROM shopping_list WHERE $name='$string'";
		$stmt = $this->database->prepare($delete);
		$stmt -> execute();
		echo(' Deletion succesful ');
                
            }catch(PDOException $exeption){
		echo('Deletion failed '.$exeption->getMessage());			
            }
	}
	
	public function close(){
            try{
                $this->database = null;
		echo('Database closed ');
                
            }catch(PDOException $exeption){
		echo('Closing database failed '.$exeption->getMessage());			
	}
    }
} 