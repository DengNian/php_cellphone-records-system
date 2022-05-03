<?php
require_once('abstractDAO.php');
require_once('./model/iphone.php');

class iphoneDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getIphone($iPhoneId){
        $query = 'SELECT * FROM iphones WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $iPhoneId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $iphone = new iphone($temp['id'],$temp['name'], $temp['releaseDate'], $temp['price'], $temp['image']);
            $result->free();
            return $iphone;
        }
        $result->free();
        return false;
    }


    public function getIphones(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM iphones');
        $iphones = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new employee object, and add it to the array.
                $iphone = new iphone($row['id'], $row['name'], $row['releaseDate'], $row['price'], $row['image']);
                $iphones[] = $iphone;
            }
            $result->free();
            return $iphones;
        }
        $result->free();
        return false;
    }   
    
    public function addIphone($iphone){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO iphones (name, releaseDate, price, image) VALUES (?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $iphone->getName();
			        $releaseDate = $iphone->getReleaseDate();
			        $price = $iphone->getPrice();
					$image = $iphone->getImage();
			        $stmt->bind_param('ssis', $name, $releaseDate, $price, $image);    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $iphone->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }  
	
    public function updateIphone($iphone){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE iphones SET name=?, releaseDate=?, price=?, image=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $iphone->getId();
                    $name = $iphone->getName();
			        $releaseDate = $iphone->getReleaseDate();
			        $price = $iphone->getPrice();
					$image = $iphone->getImage();
                  
			        $stmt->bind_param('ssssi', 
				        $name,
				        $releaseDate,
				        $price,
						$image,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $iphone->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteIphone($iphoneId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM iphones WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $iphoneId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>

