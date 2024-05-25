<?php

class TicketDB extends Ticket
{
    private $_db;
    private $_attributs = array();

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function ajout_ticket($client,$seance,$quantite){
        try{
            $query="select ajout_ticket(:client,:seance,:quantite) as retour";
            $res = $this->_bd->prepare($query);
            $res->bindValue(':client',intval($client));
            $res->bindValue(':seance',intval($seance));
            $res->bindValue(':quantite',intval($quantite));
            $res->execute();
            $data = $res->fetch();
            return $data;
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }

    public function getTicketByClient($id_client)
    {
        $query = "select * from ticket where id_client = :id_client order by id_ticket asc";
        try {
            $resultset = $this->_db->prepare($query);
            $resultset->bindValue(':id_client', $id_client);
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

}
