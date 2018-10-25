<?php
//includes/classes/Album.php

    class Album {

        private $con;
        private $id;
        private $title;
        private $artistId;
        private $genre;
        private $artworkpath;

        public function __construct($con, $id) {
            //this refers to the instance of this class; same as for Artist
            $this->con = $con;
            $this->id = $id;

            // a single query to fetch all data from album database
            $query    = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
            $album    = mysqli_fetch_array($query);

            //assigns to local variables
            $this->title = $album['title'];
            $this->artistId = $album['artist'];
            $this->genre = $album['genre'];
            $this->artworkpath = $album['artworkpath'];

        }

        public function getTitle(){            
            return $this->title;
        }
        public function getArtist(){            
            return new Artist ($this->con, $this->artistId);        //returns a new object
        }
        public function getGenre(){            
            return $this->genre;
        }
        public function getArtWorkPath(){            
            return $this->artworkpath;
        }

        public function getNumberOfSongs(){
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id'");
            return mysqli_num_rows($query);
            //this is another option: but it dint work
            //$query = mysqli_query($this->con, "SELECT COUNT(id) FROM songs WHERE album='$this->id'");
            //return $query;
        }

        public function getSongIds(){
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");
            $array = array(); //initialise a new array
            while($rows = mysqli_fetch_array($query)){
                array_push($array, $rows['id']);
            }
            return $array;
        }
    }

?>