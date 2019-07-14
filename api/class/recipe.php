<?php
class RECIPE
{
    private $con;
    private $table_name = "recipes";

    public $title;
    public $id;
    public $ingredients;
    public $steps;
    public $timings;
    public $image;  // base64 hash for image

    public $error;

    public function __construct($db)
    {
        $this->con = $db;
    }

    private function encodeIngredients()
    {
        $this->ingredients = json_encode($this->ingredients);
    }

    private function decodeIngredients($assoc = false)
    {
        $this->ingredients = json_decode($this->ingredients, $assoc);
    }

    private function encodeTimings()
    {
        $this->timings = json_encode($this->timings);
    }

    private function decodeTimings($assoc = false)
    {
        $this->timings = json_decode($this->timings, $assoc);
    }

    private function sanetize()
    {
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->id = htmlspecialchars(strip_tags($this->id));
    }

    public function create()
    {
        try {
            if (!isset($this->title)) {
                throw new Exception('No Title set');
            }
            if (!isset($this->ingredients)) {
                throw new Exception('No ingredients set');
            }
            if (!isset($this->steps)) {
                throw new Exception('No steps set.');
            }
            if (!isset($this->timings)) {
                $this->timings = array('prep' => '60', 'cook' => '40');
            }
            if (!isset($this->image)) {
                $this->image = 'iVBORw0KGgoAAAANSUhEUgAAAlEAAAGqAgMAAABWr/kKAAAADFBMVEXu7ez////39/by8fD/1M1rAAACrUlEQVR42uzcMU8TYRzH8T+9jUSYOvACGHBi0UST6ltw8F+0IYEFJMSEN2Cib+IZYGJh8EiAuZh4b6K7C1MXEuOgQ/Xa0gTt9bEu9/yE72dm+OV7cPSuvRoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQNvg/Nr0SK7K3dsfTEzLSxuFaRmteiO2Kuv50LZJ0VzV8pGOSVn1Ma2Tw4qPrZuS4GPHpqQnucrd97vuvmlClt29sG/ur0yI5qrF0anqgdiqJclVZastswXNVUFu1Qu9VUtlK9XfK61V2SD3G+1TmVcN2eBjuWd3d2e46qtJyPIdv+3ok6X3I/ifjtJfVFSs2k+9KrvyCu1/O4j3Y1UjeLVzS6hxqLjqxGdJeAwf+QxJ78889pk6yVZlPZ9t2xJpSK5qeUTHEml6jCWyIrnqYR5j87knqwDgf7HiMdeWxprkqqbkqvgRvLA0ViVbaa6S+xt8lpeCx+RDtU7LRqsO/7rq9MJqtOYTBycuc6XzxCfeC60KfuNlseBRx1abZZ/Ysyx4zKbVYHpVQ2bVok+8i98CqeHNiqpVbyVX0YpWd72V/dZK5Xxl4XYrlf84FuZu9cXq05q31ZbVqBUmrZRW2c9u/6wboq1Oyx/5XFidnpej+iHa6qx/dnlZWO2a41Zid7ab41Y6V15ztFq3OdGKVrSi1RRa0YpWtKpAK1rRilZTaEUrWtGqAq1oRStaTaEVrWhFqwq0ohWt7lqrPWsEvVYbxYLaE1Wyq/zgRHBVW2/Vqke8tkTWZD7rq7+qpfNpIvlVjaD4ZLHmKruSfI5+0Wfas2SeSq6y7z5Dp7Ak4qvaKVdlg7ySzvcCAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAL/ag0MCAAAAAEH/X7vBDgAAAEva1kKwuiuFHwAAAABJRU5ErkJggg==';
            }
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }

        $this->encodeIngredients();
        $this->encodeTimings();

        $this->serialize();

        $query = "INSERT INTO " . $this->table_name . "
                    SET
                    title = :title,
                    ingredients = :ingredients,
                    steps = :steps,
                    timings = :timings,
                    image = :image";

        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":ingredients", $this->ingredients);
        $stmt->bindParam(":steps", $this->steps);
        $stmt->bindParam(":timings", $this->timings);
        $stmt->bindParam(":image", $this->image);

        if ($stmt->execute()) {
            return true;
        } else {
            $this->error = $stmt->errorInfo();
            return false;
        }
    }

    public function update()
    {
        try {
            if (!isset($this->id)) {
                throw new Exception('No id set');
            }
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }

        $this->encodeIngredients();
        $this->encodeTimings();

        $this->sanetize();

        $query = "UPDATE " . $this->table_name . " SET";

        if (isset($this->title)) {
            $query .= "title = :title";
        }
        if (isset($this->ingredients)) {
            $query .= "ingredients = :ingredients";
        }
        if (isset($this->steps)) {
            $query .= "steps = :steps";
        }
        if (isset($this->timings)) {
            $query .= "timings = :timings";
        }
        if (isset($this->image)) {
            $query .= "image = :image";
        }

        $query .= "WHERE id = :id";
        $stmt = $this->con->prepare($query);

        if (issset($this->title)) {
            $stmt->bindParam(":title", $this->title);
        }
        if (isset($this->ingredients)) {
            $stmt->bindParam(":ingredients", $this->ingredients);
        }
        if (isset($this->steps)) {
            $stmt->bindParam(":steps", $this->steps);
        }
        if (isset($this->timings)) {
            $stmt->bindParam(":timings", $this->timings);
        }
        if (isset($this->image)) {
            $stmt->bindParam(":image", $this->image);
        }

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            $this->error = $stmt->errorInfo();
            return false;
        }
    }


    public function show()
    {
        try {
            if (!isset($this->id)) {
                throw new Exception('No id set');
            }
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }


        $query = "SELECT * FROM " . $this->table_name . "
            WHERE 
            id = ?
            LIMIT 0, 1";
        $stmt = $this->con->prepare($query);

        $this->sanetize();

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->title = $row["title"];
            $this->image = $row["image"];
            $this->ingredients = $row["ingredients"];
            $this->decodeIngredients(true);
            $this->timings = $row["timings"];
            $this->decodeTimings(true);
            $this->steps = $row["steps"];

            return true;
        } else {
            $this->error = $stmt->errorInfo();
            return false;
        }
    }

    public function list($amount = 20, $min = 0)
    {
        $max = $min + $amount;
        $query = "SELECT id, title FROM " . $this->table_name . " WHERE id > :min AND id < :max  ORDER BY id DESC";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":min", $min);
        $stmt->bindParam(":max", $max);

        $recipies = array();

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $temp = array("id" => $row['id'], "title" => $row["title"]);
                array_push($recipies, $temp);
            }
            return $recipies;
        } else {
            $this->error = $stmt->errorInfo();
            return false;
        }
    }


    public function search()
    {
        $this->sanetize();
        $searchstring = "*";
        $searchstring .= $this->title;
        $searchstring .= "*";

        $query = "SELECT title, id FROM " . $this->table_name . " WHERE MATCH(title) AGAINST(? IN BOOLEAN MODE)";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $searchstring);

        $recipies = array();

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $temp = array("id" => $row['id'], "title" => $row["title"]);
                array_push($recipies, $temp);
            }
            return $recipies;
        } else {
            $this->error = $stmt->errorInfo();
            return false;
        }
    }
}
