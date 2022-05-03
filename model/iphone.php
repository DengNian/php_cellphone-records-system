<?php
	class iphone{		

		private $id;
		private $name;
		private $releaseDate;
		private $price;
		private $image;
				
		function __construct($id, $name, $releaseDate, $price, $image){
			$this->setId($id);
			$this->setName($name);
			$this->setReleaseDate($releaseDate);
			$this->setPrice($price);
			$this->setImage($image);
			}		
		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getName(){
			return $this->name;
		}
		
		public function setReleaseDate($releaseDate){
			$this->releaseDate = $releaseDate;
		}
		
		public function getReleaseDate(){
			return $this->releaseDate;
		}
		
		public function setPrice($price){
			$this->price = $price;
		}
		
		public function getPrice(){
			return $this->price;
		}

		public function setImage($image){
			$this->image = $image;
		}
		
		public function getImage(){
			return $this->image;
		}





	}
?>