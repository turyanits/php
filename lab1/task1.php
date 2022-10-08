<?php

$array = [
        [
            'id'=> '1',
            'address'=>'Nottingham',
            'owner'=>'Shell',
            'resources'=>'4.400 L',
            'price'=>'2.40$'
        ],

        [
            'id'=> '2',
            'address'=>'Birmingham',
            'owner'=>'BP',
            'resources'=>'21.000 L',
            'price'=>'2.20$'
        ],

        [
            'id'=> '3',
            'address'=>'London',
            'owner'=>'Shell',
            'resources'=>'2.200 l',
            'price'=>'2.25$',
        ],

        [
            'id'=> '4',
            'address'=>'Manchester',
            'owner'=>'Tesco',
            'resources'=>'8.000 l',
            'price'=>'2.31$'
        ],

        [
            'id'=> '5',
            'address'=>'Edinburgh',
            'owner'=>'Jet',
            'resources'=>'3.300 l',
            'price'=>'2.34$'
        ],

        [
            'id'=> '6',
            'address'=>'Liverpool',
            'owner'=>'Texaco',
            'resources'=>'45.000 l',
            'price'=>'2.24$',
        ]
      ];

function CreateNewStation($array, $id)
{
    return [
        'id' => $id,
        'address' => $array['address'],
        'owner' => $array['owner'],
        'resources' => $array['resources'],
        'price' => $array['price'],
    ];
}

function validationStations($array)
{
    return !(
        empty($array['address']) ||
        empty($array['owner']) ||
        empty($array['resources']) ||
        empty($array['price']) ||
        $array['resources'] <= 0 ||
        $array['price'] <= 0 ||
        !isset($array)
    );
}

function filterByOwnerResources($arr, $owner, $resources)
{
    return array_filter($arr,
        function ($value) use ($owner, $resources) {
            return ($value["owner"] == $owner and $value["resources"] > $resources);
        });
}

function displayTableStations($array, $caption)
{
    $table = '<table>';
    $table .= "<caption> $caption </caption>";
    $table .= '<tr> <th>id</th> <th>address</th> <th>owner</th> <th>resources</th> <th>price</th> </tr>';

    if (is_array($array) || is_object($array)) {

        foreach ($array as $item) {
            $table .= "<tr>" .
                "<td>$item[id]</td><td>$item[address]</td><td>$item[owner]</td>" .
                "<td>$item[resources]</td><td>$item[price]</td>" .
                "</tr>";
        }
    }
    else // If $myList was not an array, then this block is executed.
        {
            echo "Unfortunately, an error occured.";
        }

    $table .= '</table>';
    echo $table;
}

session_start();

// setting default values
if (empty($_SESSION)) {
    $_SESSION['Stations'] = $array;
}

// adding station
if ($_POST['action'] == 'add') {
    if (validationStations($_POST)) {
        $nextStationId = count($_SESSION['Stations']) + 1;
        $_SESSION['Stations'][] = CreateNewStation($_POST, $nextStationId);
    }
}

// editing station
if ($_POST['action'] == 'edit') {
    if (validationStations($_POST)) {
        $idToEdit = $_POST['id'];
        foreach ($_SESSION['Stations'] as $key => $value) {
            if ($value['id'] == $idToEdit) {
                $_SESSION['Stations'][$key] = CreateNewStation($_POST, $idToEdit);
                break;
            }
        }
    }
}

// filtering stations
if ($_POST['action'] == 'filter') {
    displayTableStations(
        filterByOwnerResources($_SESSION['Stations'], $_POST['owner'], $_POST['resources']), 'Filter results'
    );
}

// display all stations
displayTableStations($_SESSION['Stations'], 'Petrol stations');
?>
<br>

<button onclick="ShowAddForm()"> ADD</button>
<button onclick="ShowEditForm()"> EDIT</button>
<button onclick="ShowFilterForm()"> FILTER</button>

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

<br>

<form action='<?= $_SERVER['PHP_SELF'] ?>' method='post' id='filterForm'>
    Filter <br>
    <label> owner:
        <input type='text' name='owner'>
    </label><br>
    <label> resources:
        <input type='number' name='resources'>
    </label><br>
    <input type='hidden' name='action' value='filter'>
    <input type='submit'>
</form>


<style>
    #addForm {
        display: none;
    }

    #editForm {
        display: none;
    }

    #filterForm {
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

    function ShowFilterForm() {
        document.querySelector('#filterForm').style.display = 'inline';
    }
</script>