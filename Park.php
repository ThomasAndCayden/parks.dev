<?php

class Park
{

    ///////////////////////////////////
    // Static Methods and Properties //
    ///////////////////////////////////

    public static $connection = null;
    
    public static function dbConnect() {
        if (!is_null(self::$connection)) {
            return;
        }
        self::$connection = require 'db_connection.php';
    }

    public static function count() {

        self::dbConnect();
        $connection = self::$connection;

        $parkTotal = count(self::all()); 
        
        return $parkTotal;

    }

    public static function all() {

        self::dbConnect();
        $connection = self::$connection;

        $select = "SELECT * FROM national_parks";
        $parks = $connection->prepare($select);

        $parks->execute();
        $arrayOfParks = [];

        foreach ($parks as $park) {
            $nationalPark = new Park();
            $nationalPark->name = $park['name'];
            $nationalPark->location = $park['location'];
            $nationalPark->dateEstablished = $park['date_established'];
            $nationalPark->areaInAcres = $park['area_in_acres'];
            $nationalPark->description = $park['description'];

            $arrayOfParks[] = $nationalPark;
        }

        // Returns an array of Park objects
        return $arrayOfParks;
    }

    public static function paginate($page, $limit = 4) {
        
        self::dbConnect();
        $connection = self::$connection;

        // Calculate the limit and offset needed based on the passed values
        $offset = ($page - 1) * $limit;

        // Calculated limit and offset
        $select = "SELECT * FROM national_parks LIMIT :limit OFFSET :offset";
        $statement = $connection->prepare($select);
        $statement->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        
        $result = $statement->execute();

        // Returns an array of the found Park objects
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    /////////////////////////////////////
    // Instance Methods and Properties //
    /////////////////////////////////////

    public $id;
    public $name;
    public $location;
    public $dateEstablished;
    public $areaInAcres;
    public $description;

    public function insert() {
 
        self::dbConnect();

        $insert = "INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES(:name, :location, :date_established, :area_in_acres, :description)"; 
        $statement = self::$connection->prepare($insert);

        $statement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $statement->bindValue(':location', $this->location, PDO::PARAM_STR);
        $statement->bindValue(':date_established', $this->dateEstablished, PDO::PARAM_STR);
        $statement->bindValue(':area_in_acres', $this->areaInAcres, PDO::PARAM_INT);
        $statement->bindValue(':description', $this->description, PDO::PARAM_STR);

        $statement->execute();
        $this->id = self::$connection->lastInsertId();
    }
}
