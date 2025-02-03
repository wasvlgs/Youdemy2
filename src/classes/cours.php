
<?php

    class cours{

        protected $id_cours;
        protected $titre;
        protected $desc;
        protected $id_category;
        protected $id_user;
        protected $img;


        public function __construct($id_cour = null,$titre = null,$desc = null, $img = null, $id_user = null,$id_category = null)
        {
            $this->id_cours = $id_cour;
            $this->titre = $titre;
            $this->desc = $desc;
            $this->id_category = $id_category;
            $this->id_user = $id_user;
            $this->img = $img;
        }


        public static function getCours($conn,$offSet = 0,$getCategorie = '',$search = ''){
            $getAllData = $conn->prepare("SELECT * FROM cours INNER JOIN users ON cours.id_user = users.id_user INNER JOIN categorie ON cours.id_categorie = categorie.id_categorie WHERE id_approved = '1'");
            if(!empty($search)){
                $getSearch = '%' . $search . '%';
                $getData = $conn->prepare("SELECT * FROM cours INNER JOIN users ON cours.id_user = users.id_user INNER JOIN categorie ON cours.id_categorie = categorie.id_categorie WHERE id_approved = '1' AND (titre LIKE :search OR description LIKE :search) LIMIT 6 offset :offset");
                $getData->bindParam(":search",$getSearch);
            }elseif(!empty($getCategorie)){
                $getData = $conn->prepare("SELECT * FROM cours INNER JOIN users ON cours.id_user = users.id_user INNER JOIN categorie ON cours.id_categorie = categorie.id_categorie WHERE id_approved = '1' AND cours.id_categorie = :categorie LIMIT 6 offset :offset");
                $getData->bindParam(":categorie",$getCategorie,PDO::PARAM_INT);
            }else{
                $getData = $conn->prepare("SELECT * FROM cours INNER JOIN users ON cours.id_user = users.id_user INNER JOIN categorie ON cours.id_categorie = categorie.id_categorie WHERE id_approved = '1' LIMIT 6 offset :offset");
            }
            
            $getData->bindParam(":offset",$offSet,PDO::PARAM_INT);
            
            
            if($getData->execute() && $getAllData->execute()){
                return [
                    "data"=> $getData,
                    "pages" => ceil($getAllData->rowCount()/6),
                ];
            }else{
                return null;
            }
        }

        public function getSingleCour($getID,$conn){
            $this->id_cours = $getID;
            $getCour = $conn->prepare("SELECT * FROM cours INNER JOIN users ON cours.id_user = users.id_user WHERE id_cours = :getID");
            $getCour->bindParam(":getID",$this->id_cours);
            if($getCour->execute() && $getCour->rowCount() === 1){
                return $getCour->fetch(PDO::FETCH_ASSOC);
            }else{
                return null;
            }
        }
        public function mycours($getID,$conn){
            $this->id_cours = $getID;
            $getMyCours = $conn->prepare("SELECT * FROM mycours INNER JOIN cours ON mycours.id_cours = cours.id_cours 
             INNER JOIN categorie ON cours.id_categorie = categorie.id_categorie 
             INNER JOIN users ON users.id_user = cours.id_user
            WHERE mycours.id_user = :getID");
            $getMyCours->bindParam(":getID",$this->id_cours);
            if($getMyCours->execute()){
                return $getMyCours;
            }else{
                return null;
            }
        }

        public function checkMyCour($user,$cours,$conn){
            $this->id_cours = $cours;
            $this->id_user = $user;
            $getCount = $conn->prepare("SELECT * FROM mycours WHERE id_cours = :cours AND id_user = :user");
            $getCount->bindParam(":cours",$this->id_cours);
            $getCount->bindParam(":user",$this->id_user);
            if($getCount->execute()){
                return $getCount->rowCount();
            }else{
                return null;
            }
        }

        public function joinCour($user,$cours,$conn){
            $this->id_user = $user;
            $this->id_cours = $cours;
            $join = $conn->prepare("INSERT INTO mycours(id_cours,id_user,date_join) VALUES(:cours,:user,CURRENT_TIME)");
            $join->bindParam(":cours",$cours);
            $join->bindParam(":user",$user);
            if($join->execute()){
                header('Location: student/mescours.php');
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }

        public function myCoursCount($getID,$conn){

            $this->id_user = $getID;
            $getCount = $conn->prepare("SELECT count(*) as total FROM cours WHERE id_user = :getID");
            $getCount->bindParam(":getID",$this->id_user);
            if($getCount->execute()){
                $getRow = $getCount->fetch(PDO::FETCH_ASSOC);
                return $getRow['total'];
            }else{
                return null;
            }
        }

        public function myStudentCount($getID,$conn){

            $myStudentCount = $conn->prepare("SELECT COUNT(DISTINCT users.id_user) AS total FROM users INNER JOIN mycours ON users.id_user = mycours.id_user INNER JOIN cours ON cours.id_cours = mycours.id_cours WHERE cours.id_user = :getID");
            $myStudentCount->bindParam(":getID",$getID);
            if($myStudentCount->execute() && $myStudentCount->rowCount() > 0){
                $getRow = $myStudentCount->fetch(PDO::FETCH_ASSOC);
                return $getRow['total'];
            }else{
                return null;
            }
        }

        public function getBestCours($getID,$conn){
            $getCours = $conn->prepare("SELECT titre,COUNT(cours.id_cours) AS joinCount FROM cours INNER JOIN mycours ON cours.id_cours = mycours.id_cours WHERE cours.id_user = :getID GROUP BY cours.id_cours ORDER BY joinCount DESC LIMIT 1");
            $getCours->bindParam(":getID",$getID);
            if($getCours->execute()){
                return $getCours->fetch(PDO::FETCH_ASSOC);
            }else{
                return null;
            }
        }

        public function recentActivities($getID,$conn){
            $this->id_user = $getID;
            $getActivities = $conn->prepare("SELECT nom,prenom,titre,date_join FROM users INNER JOIN mycours ON users.id_user = mycours.id_user INNER JOIN cours ON mycours.id_cours = cours.id_cours WHERE cours.id_user = :getID ORDER BY date_join DESC LIMIT 3");
            $getActivities->bindParam(":getID",$getID);
            if($getActivities->execute()){
                return $getActivities;
            }else{
                return null;
            }
        }

        public function getAllMyStudents($getID,$conn,$filter){
            $this->id_user = $getID;
            if($filter){
                $getUsers = $conn->prepare("SELECT nom,prenom,email,titre FROM users INNER JOIN mycours ON users.id_user = mycours.id_user INNER JOIN cours ON cours.id_cours = mycours.id_cours WHERE cours.id_user = :getID AND cours.id_cours = :cour");
                $getUsers->bindParam(":cour",$filter);
            }else{
                $getUsers = $conn->prepare("SELECT nom,prenom,email,titre FROM users INNER JOIN mycours ON users.id_user = mycours.id_user INNER JOIN cours ON cours.id_cours = mycours.id_cours WHERE cours.id_user = :getID");
            }
            
            $getUsers->bindParam(":getID",$getID);
            if($getUsers->execute()){
                return $getUsers;
            }else{
                return null;
            }
        }

        public function getMyTitleCourses($getID,$conn){
            $this->id_user = $getID;
            $getTitles = $conn->prepare("SELECT id_cours,titre FROM cours WHERE id_user = :getID");
            $getTitles->bindParam(":getID",$getID);
            if($getTitles->execute()){
                return $getTitles;
            }else{
                return null;
            }
        }

        protected function addCours($id,$titre,$desc,$content,$img,$user,$categorie,$type,$conn){

            $this->id_cours = $id;
            $this->titre = $titre;
            $this->desc = $desc;
            $this->id_user = $user;
            $this->id_category = $categorie;

            $addCours = $conn->prepare("INSERT INTO cours(id_cours,titre,description,content,id_approved,id_user,id_categorie,imgSrc,date_create,typeContent) 
            VALUES(:id,:titre,:desc,:content,0,:id_user,:id_categorie,:imgSrc,CURRENT_DATE,:type)");
            $addCours->bindParam(":id",$this->id_cours);
            $addCours->bindParam(":titre",$this->titre);
            $addCours->bindParam(":desc",$this->desc);
            $addCours->bindParam(":content",$content);
            $addCours->bindParam(":id_user",$this->id_user);
            $addCours->bindParam(":id_categorie",$this->id_category);
            $addCours->bindParam(":imgSrc",$img);
            $addCours->bindParam(":type",$type);
            if($addCours->execute()){
                return $conn->lastInsertId();
            }else{
                return false;
            }
            
        }

        public function teacherCours($getID,$conn){
            $this->id_cours = $getID;
            $getCours = $conn->prepare("SELECT * FROM cours WHERE id_user = :getID");
            $getCours->bindParam(":getID",$getID);
            if($getCours->execute()){
                return $getCours;
            }else{
                return null;
            }
        }

        public function editCour($titre,$desc,$getID,$teacher,$conn){
            $this->titre = $titre;
            $this->desc = $desc;
            $this->id_cours = $getID;
            $this->id_user = $teacher;

            $editCours = $conn->prepare("UPDATE cours SET titre = :titre, description = :desc, id_approved = '0' WHERE id_cours = :getID AND id_user = :user");
            $editCours->bindParam(":titre",$this->titre);
            $editCours->bindParam(":desc",$this->desc);
            $editCours->bindParam(":getID",$this->id_cours);
            $editCours->bindParam(":user",$this->id_user);
            if($editCours->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function removeCour($cour,$user,$conn){

            $this->id_cours = $cour;
            $this->id_user = $user;
            $removeCours = $conn->prepare("DELETE FROM cours WHERE id_cours = :cours AND id_user = :user");
            $removeCours->bindParam(":cours",$this->id_cours);
            $removeCours->bindParam(":user",$this->id_user);
            if($removeCours->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function afficherCours($getID,$typeContent,$conn){
            $this->id_cours = $getID;
            $getContent = $conn->prepare("SELECT content FROM cours WHERE id_cours = :getID");
            $getContent->bindParam(":getID",$getID);
            if($getContent->execute()){
                $content = $getContent->fetch(PDO::FETCH_ASSOC);
                if($typeContent === "text"){
                    echo '<section class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Text Content</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-600 leading-relaxed mb-6">
                                '.$content.'
                            </p>
                            
                        </div>
                    </section>';
                }elseif($typeContent === "video"){
                    echo '<section class="bg-white rounded-2xl shadow-xl p-8 mb-8 overflow-hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Video Content</h2>
                        <div class="aspect-video bg-gray-900 rounded-xl overflow-hidden relative group">
                            <video controls class="w-full h-full object-cover">
                                <source src="../../public/videos/'.$content.'" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/30 transition-all cursor-pointer">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all">
                                    <i class="fas fa-play text-indigo-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </section>';
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }

        public static function getAllCoursCount($conn){
            $getCount = $conn->prepare("SELECT count(id_cours) as total FROM cours");
            if($getCount->execute()){
                return $getCount->fetch(PDO::FETCH_ASSOC);
            }else{
                return null;
            }
        }

        public static function bestCours($conn){
            $getCours = $conn->prepare("SELECT cours.id_cours,titre,COUNT(cours.id_cours) AS total FROM cours INNER JOIN mycours ON mycours.id_cours = cours.id_cours GROUP BY cours.id_cours ORDER BY total DESC LIMIT 1");
            if($getCours->execute()){
                return $getCours->fetch(PDO::FETCH_ASSOC);
            }else{
                return null;
            }
        }

        public static function getAllPendingCourses($conn){

            $getCourses = $conn->prepare("SELECT * FROM cours INNER JOIN users ON cours.id_user = users.id_user INNER JOIN categorie ON categorie.id_categorie = cours.id_categorie WHERE id_approved = 0");
            if($getCourses->execute()){
                return $getCourses;
            }else{
                return null;
            }
        }

        public function accepteCourse($id,$conn){

            $this->id_cours = $id;
            $accept = $conn->prepare("UPDATE cours SET id_approved = 1 WHERE id_cours = :getID");
            $accept->bindParam(":getID",$this->id_cours);
            if($accept->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function rejectCourse($id,$conn){

            $this->id_cours = $id;
            $accept = $conn->prepare("DELETE FROM cours WHERE id_cours = :getID");
            $accept->bindParam(":getID",$this->id_cours);
            if($accept->execute()){
                return true;
            }else{
                return false;
            }
        }

        public static function bestThreeCours($conn){
            $getCours = $conn->prepare("SELECT *,COUNT(mycours.id_cours) AS total FROM cours LEFT JOIN mycours ON mycours.id_cours = cours.id_cours INNER JOIN categorie ON cours.id_categorie = categorie.id_categorie GROUP BY cours.id_cours ORDER BY total DESC LIMIT 3");
            if($getCours->execute()){
                return $getCours;
            }else{
                return null;
            }
        }

        public static function allCoursCount($conn){
            $getCoursCount = $conn->prepare("SELECT count(*) as total FROM cours WHERE id_approved = '1'");
            if($getCoursCount->execute()){
                return $getCoursCount->fetch(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }
        public static function allCoursPendingCount($conn){
            $getCoursCount = $conn->prepare("SELECT count(*) as total FROM cours WHERE id_approved = '0'");
            if($getCoursCount->execute()){
                return $getCoursCount->fetch(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }
    }








