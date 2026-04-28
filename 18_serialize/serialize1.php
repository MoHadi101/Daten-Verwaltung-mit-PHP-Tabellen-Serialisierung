<?php 
// echo '<pre>';


// print_r($_POST);

$datei = 'dummy.txt';

$bearbeitenId = '';
$vorname = '';
$nachname = '';
$telefon = '';

// holt die daten beim lasden der Seite...
if(file_exists($datei)){
    $content = file_get_contents($datei);
    $daten = unserialize($content);
    if(!is_array($daten)){
        $daten = [];
    }
}else{
    $daten =[];
}
//Entfernen

if($_SERVER['REQUEST_METHOD' ] === 'POST' && isset ($_POST['action']) && $_POST['action'] === 'Entfernen' && isset($_POST['id'])){
    $id = $_POST['id'];
    if(isset($daten[$id])){
        unset($daten[$id]);
         file_put_contents($datei, serialize($daten)); 
    }
}
// Bearbeiten Butten CLICKEN
if($_SERVER['REQUEST_METHOD' ] === 'POST' && isset ($_POST['action']) && $_POST['action'] === 'Bearbeiten' && isset($_POST['id'])){
 $id = $_POST['id'];
 // sind die daten satz vorhanden
 if(isset($daten[$id])){
    $bearbeitenId = $id;
    $vorname = $daten[$id]['vorname'];
    $nachname = $daten[$id]['nachname'];;
    $telefon = $daten[$id]['telefon'];;
 }
}

//Update
if($_SERVER['REQUEST_METHOD' ] === 'POST' && isset ($_POST['action']) && $_POST['action'] === 'Update' && isset($_POST['id'])){
 $id = $_POST['id'];
 if(isset($daten[$id])){
    $daten[$id] = [
'vorname' => $_POST['vorname'],
'nachname' => $_POST['nachname' ],
'telefon' => $_POST['telefon' ]

];
file_put_contents($datei, serialize($daten)); 
 }
}





// echo max(array_keys($daten));
// echo '<pre>';
// print_r($daten);


//insert
if ($_SERVER['REQUEST_METHOD' ] === 'POST' && isset($_POST['action']) && $_POST['action']=== 'Insert') {
$id = empty ($daten) ? 1 : max(value: array_keys(array: $daten)) + 1;
$daten[$id] = [
'vorname' => $_POST['vorname'],
'nachname' => $_POST['nachname' ],
'telefon' => $_POST['telefon' ]

];
    // echo '<pre>';
    // print_r($daten);

  file_put_contents($datei, serialize($daten)); 
};



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daten Verwaltung</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid gray;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: white;
        }
        tr:hover {
            background-color: white;
        }
    </style>
</head>
<body>
   <table>
        <tr>
            <th>ID</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>TelefonNr</th>
            <th>Action</th>
        </tr>

  <?php if(!empty($daten)): ?>
            <?php foreach($daten as $key => $data): ?>
            <tr>
                <td><?= htmlspecialchars($key) ?></td>
                <td><?= htmlspecialchars($data['vorname']) ?></td>
                <td><?= htmlspecialchars($data['nachname']) ?></td>
                <td><?= htmlspecialchars($data['telefon']) ?></td>
                <td>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($key) ?>">
                        <input type="submit" value="Bearbeiten" name="action">
                    </form>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($key) ?>">
                        <input type="submit" value="Entfernen" name="action">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
<?php else: ?>
            <tr>
                <td colspan="4">Keine Daten vorhanden</td>
            </tr>
        <?php endif; ?>
    </table>


    <form method="post">
        <!-- <input type="text" name="id" placeholder="id"><br> -->
        <input type="text" name="vorname" placeholder="vorname" value="<?= htmlspecialchars($vorname) ?>"><br>
        <input type="text" name="nachname" placeholder="nachname" value="<?= htmlspecialchars($nachname) ?>"><br>
        <input type="text" name="telefon" placeholder="telefon" value="<?= htmlspecialchars($telefon) ?>"><br>
        <?php if($bearbeitenId !== '') {?>
        <input type="submit" value="Update" name="action" ><br>
        <?php }else{ ?>
        <input type="submit" name="action" id="" value="Insert">
        <?php } ?>

        <input type="hidden" name="id" value="<?= htmlspecialchars($bearbeitenId) ?>">

    </form>
</body>
</html>