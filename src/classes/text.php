

<?php




    require_once '../classes/cours.php';

    class textContent extends cours{

        private $content;
        public function __construct($id_cour,$titre,$desc,$img, $id_user,$id_category,$content)
        {
            parent::__construct($id_cour,$titre,$desc,$img,$id_user,$id_category);
            $this->content = $content;
        }

        public function addTextCour(){
            return parent::addCours(null,$this->titre,$this->desc,$this->content,$this->img,$this->id_user,$this->id_category,'text',Database::getInstance()->getConnect());
        }
        
    }





?>