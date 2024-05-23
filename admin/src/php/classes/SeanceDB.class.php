<?php

class SeanceDB extends Seance
{
    private $_db;
    private $_attributs = array();

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getAllSeances()
    {

        $query = "select * from seance order by date asc , heure asc";
        try {

            $resultset = $this->_db->prepare($query);
            $resultset->execute();
            $data = $resultset->fetchAll();

            if (count($data) > 0) {

                foreach ($data as $d) {

                    $this->_attributs[] = new Seance($d);
                }

            }
            if (count($this->_attributs) != 0) {


                return $this->_attributs;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            print "Echec de la requête :  " . $e->getMessage();
        }

    }

    public function getSeanceByFilm($id_film)
    {
        $query = "select * from seance where id_film = :id_film order by date asc, heure asc";
        try {
            $resultset = $this->_db->prepare($query);
            $resultset->bindValue(':id_film', $id_film);
            $resultset->execute();
            $data = $resultset->fetchAll();
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $this->_attributs[] = new Seance($d);
                }
            }
            if ($this->_attributs != null) {
                return $this->_attributs;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            print "Echec de la requête " . $e->getMessage();
        }
    }
    public function getSeanceById($id_seance)
    {
        $query = "select * from seance where id_seance = :id_seance";
        try {
            $resultset = $this->_db->prepare($query);
            $resultset->bindValue(':id_seance', $id_seance);
            $resultset->execute();
            $data = $resultset->fetch();
            if (!empty($data)) {
                return new Seance($data);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            print "Echec de la requête " . $e->getMessage();
        }
    }

}