<?php



    class categorie{

        private $id_categorie;
        private $name;


        public function __construct($id = null,$name = null)
        {
            $this->id_categorie = $id;
            $this->name = $name;
        }


        public static function getCategories($conn){
            $getData = $conn->prepare("SELECT categorie.id_categorie,name,COUNT(cours.id_cours) as total FROM categorie LEFT JOIN cours ON categorie.id_categorie = cours.id_categorie GROUP BY categorie.id_categorie");
            if($getData->execute()){
                return $getData;
            }else{
                return null;
            }
        }
        public function addCategorie($id,$name,$conn){

            $this->id_categorie = $id;
            $this->name = $name;

            $addCategorie = $conn->prepare("INSERT INTO categorie(id_categorie,name) VALUES(:getID,:name)");
            $addCategorie->bindParam(":getID",$this->id_categorie);
            $addCategorie->bindParam(":name",$this->name);
            if($addCategorie->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function editCategorie($id,$name,$conn){

            $this->id_categorie = $id;
            $this->name = $name;
            $editCategorie = $conn->prepare("UPDATE categorie SET name = :name WHERE id_categorie = :getID");
            $editCategorie->bindParam(":name",$this->name);
            $editCategorie->bindParam(":getID",$this->id_categorie);
            if($editCategorie->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function removeCategorie($id,$conn){

            $this->id_categorie = $id;
            $removeCategorie = $conn->prepare("DELETE FROM categorie WHERE id_categorie = :getID");
            $removeCategorie->bindParam(":getID",$this->id_categorie);
            if($removeCategorie->execute()){
                return true;
            }else{
                return false;
            }
        }


    }