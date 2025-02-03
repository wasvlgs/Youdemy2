

<?php




    require_once '../classes/cours.php';

    class videoContent extends cours{

        private $content;
        public function __construct($id_cour,$titre,$desc,$img, $id_user,$id_category,$content)
        {
            parent::__construct($id_cour,$titre,$desc,$img,$id_user,$id_category);
            $this->content = $content;
        }

        public function addVideoCour(){
            return parent::addCours(null,$this->titre,$this->desc,$this->content,$this->img,$this->id_user,$this->id_category,'video',Database::getInstance()->getConnect());
        }
    }





?>