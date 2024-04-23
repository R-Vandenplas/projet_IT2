<?php class FilmDB extends Film
{
    private $_db;
    private $_attributs = array();

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getAllFilms()
    {

        $query = "select * from film";
        try {

            $resultset = $this->_db->prepare($query);
            $resultset->execute();
            $data = $resultset->fetchAll();

            if (count($data) > 0) {


                foreach ($data as $d) {

                    $this->_attributs[] = new Film($d);
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

    public function getFilmById($id_film)
    {
        print "id_film : " . $id_film;
        $query = "select * from film where id_film = :id_film";
        try {
            $resultset = $this->_db->prepare($query);
            $resultset->bindValue(':id_film', $id_film);
            $resultset->execute();
            $data = $resultset->fetch();
            if (count($data) > 0) {
                $this->_attributs[] = new Film($data);
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
}
