<?php
//includes/classes/Artist.php

class Artist {

    private $con;
    private $id;

    public function __construct($con, $id) {
        //this refers to the instance of this class
        $this->con = $con;
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
    //classes help to reduce repeating queries to the database; this reduces risk;
    public function getName(){
        $artistQuery    = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
        $artist         = mysqli_fetch_array($artistQuery);
        return $artist['name'];
    }

    public function getSongIds(){
        $query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays DESC");
        $array = array(); //initialise a new array
        while($rows = mysqli_fetch_array($query)){
            array_push($array, $rows['id']);
        }
        return $array;
    } 
}

          

?>