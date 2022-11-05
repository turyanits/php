<?php
session_start();
$array = [
    [
        'id'=> '1',
        'subject'=>'PHP',
        'vykladach'=>'Andrashko. U. V.',
        'balls'=>'100'
    ],

    [
        'id'=> '2',
        'subject'=>'Web-programming',
        'vykladach'=>'Andrashko. U. V.',
        'balls'=>'100',
    ],

    [
        'id'=> '3',
        'subject'=>'Software architecture',
        'vykladach'=>'Andrashko. U. V.',
        'balls'=>'100',
    ],

    [
        'id'=> '4',
        'subject'=>'C#',
        'vykladach'=>'Andrashko. U. V.',
        'balls'=>'100',
    ],

    [
        'id'=> '5',
        'subject'=>'Math',
        'vykladach'=>'Andrashko. U. V.',
        'balls'=>'100',
    ]
];

function CreateNewSubject($array, $id)
{
    return [
        'id' => $id,
        'subject' => $array['subject'],
        'vykladach' => $array['vykladach'],
        'balls' => $array['balls'],
    ];
}

function validationSubjects($array)
{
    return !(
        empty($array['subject']) ||
        empty($array['vykladach']) ||
        empty($array['balls']) ||
        $array['balls'] <= 0 ||
        !isset($array)
    );
}

function displayTableSubjects($array, $caption)
{
    $table = '<table>';
    $table .= "<caption> $caption </caption>";
    $table .= '<tr> <th>id</th> <th>subject</th> <th>vykladach</th> <th>balls</th> </tr>';

    if (is_array($array) || is_object($array)) {

        foreach ($array as $item) {
            $table .= "<tr>" .
                "<td>$item[id]</td><td>$item[subject]</td><td>$item[vykladach]</td>" .
                "<td>$item[balls]</td>" .
                "</tr>";
        }
    }
    else // If $ was not an array, then this block is executed.
    {
        echo "Unfortunately, an error occured.";
    }

    $table .= '</table>';
    echo $table;
}

// setting default values
if (empty($_SESSION)) {
    $_SESSION['Subjects'] = $array;
}

// adding station
if ($_POST['action'] == 'add') {
    if (validationSubjects($_POST)) {
        $nextSubjectId = count($_SESSION['Subjects']) + 1;
        $_SESSION['Subjects'][] = CreateNewSubject($_POST, $nextSubjectId);
    }
}

// editing station
if ($_POST['action'] == 'edit') {
    if (validationSubjects($_POST)) {
        $idToEdit = $_POST['id'];
        foreach ($_SESSION['Subjects'] as $key => $value) {
            if ($value['id'] == $idToEdit) {
                $_SESSION['Subjects'][$key] = CreateNewSubject($_POST, $idToEdit);
                break;
            }
        }
    }
}

// display all stations
displayTableSubjects($_SESSION['Subjects'], 'Subjects');
session_unset();
?>
    <br>

    <button onclick="ShowAddForm()"> ADD</button>
    <button onclick="ShowEditForm()"> EDIT</button>
    <br>

    <form action='<?= $_SERVER['PHP_SELF'] ?>' method='post' id='addForm'>
        ADD <br>
        <label> id:
            <input type='number' name='id'>
        </label><br>
        <label> subject:
            <input type='text' name='subject'>
        </label><br>
        <label> vykladach:
            <input type='text' name='vykladach'>
        </label><br>
        <label> balls:
            <input type='number' name='balls'>
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
        <label> subject:
            <input type='text' name='subject'>
        </label><br>
        <label> vykladach:
            <input type='text' name='vykladach'>
        </label><br>
        <label> balls:
            <input type='text' name='balls'>
        </label><br>
        <input type='hidden' name='action' value='edit'>
        <input type='submit'>
    </form>

    <br>

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
<?php
