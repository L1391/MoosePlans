<?php
include_once("conn.php");

$weekend_id = 1; //$_POST['wknd_id'];

$get_pref = $db->query("SELECT users.id, p.meal_on_first, p.meal_on_second, p.meal_on_third FROM
                        users INNER JOIN teach_pref as p ON users.id = p.teach_id
                        WHERE p.wknd_id='$weekend_id' GROUP BY p.teach_id")->fetchAll();

$pref_matrix = [];
$teach_order = [];
foreach ($get_pref as $p) {
    $teach_pref_row = [10,10,10,10,10,10];
    $teach_pref_row[$p['meal_on_first']] = 1;
    $teach_pref_row[$p['meal_on_second']] = 2;
    $teach_pref_row[$p['meal_on_third']] = 3;

    array_push($pref_matrix,($teach_pref_row));
    array_push($teach_order,($p['id']));
}

//print original preferences
foreach($pref_matrix as $index=>$row) {
    echo "teacher " . $teach_order[$index] . " ";
    foreach($row as $cell) {
        echo $cell . ",";
    }
    echo "<br>";
}

$taken_columns = [];
$nonnovel_rows = [];
$original_rows = [];

foreach($pref_matrix as $index=>$teach) {
    $pref = array_search(1, $teach);
    if (in_array($pref, $taken_columns)) {
        array_push($nonnovel_rows,($index));
    } else {
        array_push($taken_columns,($pref));
        array_push($original_rows,($index));
    }
}


$not_taken_columns = [];
for ($i = 0; $i < 6; $i++) {
    if (!in_array($i, $taken_columns)){
        array_push($not_taken_columns,($i));
    }
}

//organize the matrix
$organized_matrix = [];
$new_teach_order = [];
foreach($pref_matrix as $index=>$teach){
    if (in_array($index, $original_rows)) {
        array_push($organized_matrix,($pref_matrix[$index]));
        array_push($new_teach_order,($teach_order[$index]));
    }
} 
foreach($pref_matrix as $index=>$teach){
    if (in_array($index, $nonnovel_rows)) {
        array_push($organized_matrix,($pref_matrix[$index]));
        array_push($new_teach_order,($teach_order[$index]));
    }
} 

$assignments = [];
$already_assigned= [];
foreach($original_rows as $index=>$row) {
    array_push($assignments,([$new_teach_order[$index], array_search(1, $organized_matrix[$index])]));
}

if (sizeof($taken_columns) < 6) {
    foreach ($nonnovel_rows as $index=>$n) {
        if (!in_array(array_search(2, $organized_matrix[$index + sizeof($original_rows)]),$taken_columns)) {
            array_push($assignments,([$new_teach_order[$index + sizeof($original_rows)], array_search(2, $organized_matrix[$index+ sizeof($original_rows)])]));
            array_push($already_assigned,($index+ sizeof($original_rows)));
            array_push($taken_columns,(array_search(2, $organized_matrix[$index+ sizeof($original_rows)])));
        }
    }
}
if (sizeof($taken_columns) < 6) {
    foreach ($nonnovel_rows as $index=>$n) {
        if (!in_array(array_search(3, $organized_matrix[$index + sizeof($original_rows)]),$taken_columns) && !in_array($index + sizeof($original_rows), $already_assigned)) {
            array_push($assignments,([$new_teach_order[$index + sizeof($original_rows)], array_search(3, $organized_matrix[$index+ sizeof($original_rows)])]));
            array_push($already_assigned,($index+ sizeof($original_rows)));
            array_push($taken_columns,(array_search(3, $organized_matrix[$index+ sizeof($original_rows)])));
            //echo $index . "  " . array_search(3, $organized_matrix[$index+ sizeof($original_rows)]);
        }
    }
}


if (sizeof($taken_columns) < 6) {
    $unassigned_meals = [];
    for ($i = 0; $i < 6; $i++) {
        if (!in_array($i, $taken_columns)) {
            array_push($unassigned_meals,($i));
            echo $i . " meal unassigned <br>";
        }
    }
}

// print results
foreach ($assignments as $a) {
     echo "Teacher " . $a[0] . " :"; //teacher id
     echo $a[1] . "<br>"; // meal shift
}


?>