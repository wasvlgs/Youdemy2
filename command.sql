CREATE DATABASE youdemy


CREATE TABLE categorie (
  id_categorie int(11) NOT NULL,
  name varchar(255) DEFAULT NULL
)

CREATE TABLE cours (
  id_cours int(11) NOT NULL,
  titre varchar(550) DEFAULT NULL,
  description text DEFAULT NULL,
  content longtext DEFAULT NULL,
  video varchar(500) DEFAULT NULL,
  id_approved tinyint(1) DEFAULT NULL,
  id_user int(11) DEFAULT NULL,
  id_categorie int(11) DEFAULT NULL
)


CREATE TABLE role (
  id_role int(11) NOT NULL,
  name varchar(255) DEFAULT NULL
)


CREATE TABLE tags (
  id_tag int(11) NOT NULL,
  name varchar(255) DEFAULT NULL
)


CREATE TABLE users (
  id_user int(11) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  prenom varchar(255) DEFAULT NULL,
  email varchar(550) DEFAULT NULL,
  password varchar(100) DEFAULT NULL,
  role int(11) DEFAULT NULL,
  statut enum('active','block','pending') DEFAULT NULL
)




CREATE TABLE cours(id_cours int AUTO_INCREMENT PRIMARY KEY NOT null,
                   titre varchar(550),
                   description text,
                   content longtext,
                   video varchar(500),
                   id_approved boolean,
                   id_user int,
                   id_categorie int,
                   FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
                   FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie) ON DELETE CASCADE ON UPDATE CASCADE)


CREATE TABLE tags_cours(id_tag int NOT null,
id_cours int NOT null,
 FOREIGN KEY (id_tag) REFERENCES tags(id_tag) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_cours) REFERENCES cours(id_cours) ON DELETE CASCADE ON UPDATE CASCADE)


CREATE TABLE mycours(id_cours int NOT null, id_user int NOT null, FOREIGN KEY (id_cours) REFERENCES cours(id_cours) ON DELETE CASCADE ON UPDATE CASCADE,
 FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE);


 SELECT titre,COUNT(cours.id_cours) AS joinCount FROM cours INNER JOIN mycours ON cours.id_cours = mycours.id_cours WHERE cours.id_user = 20 GROUP BY cours.id_cours ORDER BY joinCount DESC LIMIT 1;