<?php

class ClientDB
{

    private $_bd;
    private $_array = array();

    public function __construct($cnx)
    {
        $this->_bd = $cnx;
    }

//A REFAIRE -->infâme
    public function updateClient($id,$champ,$valeur){
        //$query="select update_client(:id,:champ,:valeur)";
        $query= "update client set $champ='$valeur' where id_client=$id";
        try{
            $res = $this->_bd->prepare($query);
            $res->execute();
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }

    public function ajout_client($nom,$prenom,$email,$adresse,$numero){
        try{
            $query="select ajout_client(:nom,:prenom,:email,:adresse,:numero)";
            $res = $this->_bd->prepare($query);
            $res->bindValue(':nom',$nom);
            $res->bindValue(':prenom',$prenom);
            $res->bindValue(':email',$email);
            $res->bindValue(':adresse',$adresse);
            $res->bindValue(':numero',$numero);
            $res->execute();
            $data = $res->fetch();
            return $data;
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }
    public function deleteClient($email){
        print "email : ".$email;
        try{
            $query="select delete_client(:email)";
            $res = $this->_bd->prepare($query);
            $res->bindValue(':email',$email);
            $res->execute();
            $data = $res->fetch();
            return $data;
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }


    public function getClientByEmail($email){
        try{
            $query="select * from client where email = :email";
            $res = $this->_bd->prepare($query);
            $res->bindValue(':email',$email);
            $res->execute();
            $data = $res->fetch();
            return $data;
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }
    public function getClientById($id){
        try{
            $query="select * from client where id_client = :id";
            $res = $this->_bd->prepare($query);
            $res->bindValue(':id',$id);
            $res->execute();
            $data = $res->fetch();
            return $data;
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }

    public function getAllClients(){
        try{
            $query="select * from client order by nom";
            $res = $this->_bd->prepare($query);
            $res->execute();
            $data = $res->fetchAll();
            if(!empty($data))  {
                foreach($data as $d) {
                    $_array[] = new Client($d);
                }
                return $_array;
            }
            else{
                return [];
            }

            return $data;
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }
    public function getclient($login,$password)
{

    $query = "select verifier_client(:login,:password) as retour"; //retour pour 1 ou 0 retourné
    try {
        $this->_bd->beginTransaction();
        $resultset = $this->_bd->prepare($query);
        $resultset->bindValue(':login',$login);
        $resultset->bindValue(':password',$password);
        $resultset->execute();
        $retour = $resultset->fetchColumn(0);
        $this->_bd->commit();
        return $retour;
    } catch (PDOException $e) {
        $this->_bd->rollback();
        print "Echec de la requête " . $e->getMessage();
    } finally {
        if ($this->_bd->inTransaction()) {
            $this->_bd->commit();
        }
    }
}

}


