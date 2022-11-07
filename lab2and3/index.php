<?php
class Station
{
    public $id;
    public $address;
    public $owner;
    public $resources;
    public $price;

    public function __construct($id, $array)
    {
        $this->id = $id;
        $this->address = $array["address"];
        $this->owner = $array["owner"];
        $this->resources = $array["resources"];
        $this->price = $array["price"];
    }

    static function validationStations($array)
    {
        if (
            empty($array["address"]) ||
            empty($array["owner"]) ||
            $array["resources"] <= 0 ||
            $array["price"] < 0 ||
            !isset($array)
        ) {
            return false;
        }
        return true;
    }
}


class StationsList
{
    public $Stations;

    public function StationsData()
    {
        return $this->Stations = [
            new Station(1, [
                "address" => "London",
                "owner" => "BP",
                "resources" => 10570,
                "price" => 3.10,
            ]),
            new Station(2, [
                "address" => "Birmingham",
                "owner" => "OKKO",
                "resources" => 4000,
                "price" => 2.50,
            ])
        ];
    }

    public function getStationById($id)
    {
        foreach ($this->Stations as $petrolStation)
        {
            if($petrolStation->id == $id)
            {
                return $petrolStation;
            }
        }
        return null;
    }

    public function showTable()
    {
        echo "<table>";
        echo "<tr>
                <th>Id</th>
                <th>Address</th>
                <th>Owner</th>
                <th>Resources</th>
                <th>Price</th>
               </tr>";
        foreach ($this->Stations as $station) {
            echo "<tr>";
            foreach ($station as $item)
            {
                echo "<td>$item</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function addStation($station)
    {
        $this->Stations[] = $station;
    }

    public function editStation($array)
    {
        $petrolStation = $this->getStationById($array['id']);
        if(!empty($array))
        {
            $petrolStation->id = $array['id'];
            $petrolStation->address = $array['address'];
            $petrolStation->owner = $array['owner'];
            $petrolStation->resources = $array['resources'];
            $petrolStation->price = $array['price'];
            $this->Stations[$array['id']] = $petrolStation;
        }
    }

    public function saveStations()
    {
        $file = fopen("file.txt", "w");
        fwrite($file, serialize($this->Stations));
        fclose($file);
        $_POST = null;
    }

    public function loadStations()
    {
        $file = fopen("file.txt", "r");
        $text = "";
        while(!feof($file)){
            $part = fread($file, 1);
            $text .= $part;
        }
        $this->Stations = unserialize($text);
        fclose($file);
        $_POST = null;
    }
}

session_start();

if (empty($_SESSION)) {
    $_SESSION['Stations'] = new StationsList();
    $_SESSION['Stations']->StationsData();
}

$_SESSION['Stations']->showTable();

if ($_POST['action'] == "save") {
    $_SESSION['Stations']->saveStations();
} elseif ($_POST['action'] == "load") {
    $_SESSION['Stations']->loadStations();
} elseif ($_POST['action'] == 'add') {
    if (Station:: validationStations($_POST)) {
        $counter = count($_SESSION['Stations']->petrolStations);
        $_SESSION['Stations']->addStation(new Station($counter, $_POST));
    }
    $_POST = null;
} elseif ($_POST['action'] == 'edit') {
    if (Station:: validationStations($_POST)) {
        $_SESSION['Stations']->editStation($_POST);
    }
    $_POST = null;
}

?>

<button onclick="ShowAddForm()"> ADD</button>
<button onclick="ShowEditForm()"> EDIT</button>

<br>
<form method="post">
    <input type="hidden" name="action" value="save">
    <input type="submit" value="Save">
</form>
<br>
<form method="post">
    <input type="hidden" name="action" value="load">
    <input type="submit" value="Load">
</form>
<br>
<form action='<?= $_SERVER['PHP_SELF'] ?>' method='post' id='addForm'>
    ADD <br>
    <label> id:
        <input type='number' name='id'>
    </label><br>
    <label> address:
        <input type='text' name='address'>
    </label><br>
    <label> owner:
        <input type='text' name='owner'>
    </label><br>
    <label> resources:
        <input type='text' name='resources'>
    </label><br>
    <label> price:
        <input type='text' name='price'>
    </label><br>
    <input type='hidden' name='action' value='add'>
    <input type='submit'>
</form>

<br>

<form action='<?= $_SERVER['PHP_SELF'] ?>' method='post' id='editForm'>
    EDIT <br>
    <label> id:
        <input type='number' name='id'>
    </label><br>
    <label> address:
        <input type='text' name='address'>
    </label><br>
    <label> owner:
        <input type='text' name='owner'>
    </label><br>
    <label> resources:
        <input type='text' name='resources'>
    </label><br>
    <label> price:
        <input type='text' name='price'>
    </label><br>
    <input type='hidden' name='action' value='edit'>
    <input type='submit'>
</form>

<style>
    #addForm {
        display: none;
    }

    #editForm {
        display: none;
    }

    table, th, td {
        border: 1px solid;
        text-align: center;
    }

    th {
        width: 100px;
    }

    td {
        height: 50px;
        s
    }
</style>

<script>
    function ShowAddForm() {
        document.querySelector('#addForm').style.display = 'inline';
    }

    function ShowEditForm() {
        document.querySelector('#editForm').style.display = 'inline';
    }
</script>