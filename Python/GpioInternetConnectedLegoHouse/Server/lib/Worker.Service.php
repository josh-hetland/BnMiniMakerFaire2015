<?php
/**
 * Update the status of the house in the server and get the next task on the queue
 */
$Upstairs = 0;
if( isset( $_POST['Upstairs' ] ) ){
    $Upstairs = (int)$_POST['Upstairs'];
}
$Downstairs = 0;
if( isset( $_POST['Downstairs'] ) ){
    $Downstairs = (int)$_POST['Downstairs'];
}
$Outside = 0;
if( isset( $_POST['Outside'] ) ){
    $Outside = (int)$_POST['Outside'];
}

$Task = array('Room' => null);

do{
    $Db = new PDO("mysql:host=localhost;port=44221;dbname=BnMake",'BnMake','BnMake');
    if( ! $Db ){
        break;
    }
    
    // update the current status of our rooms
    $CurrentState = $Db->prepare("UPDATE `Status` SET `Upstairs`=:Upstairs, `Downstairs`=:Downstairs, `Outside`=:Outside WHERE `Id`=1");
    $CurrentState->bindParam(':Upstairs',     $Upstairs,      PDO::PARAM_INT);
    $CurrentState->bindParam(':Downstairs',   $Downstairs,    PDO::PARAM_INT);
    $CurrentState->bindParam(':Outside',      $Outside,       PDO::PARAM_INT);
    $CurrentState->execute();
    
    // get the next task on the list
    $Result = $Db->query("SELECT `Id`, `Button` FROM `Requests` WHERE `Processed` = 0 ORDER BY `Timestamp` ASC LIMIT 1");
    if( ! $Result ){
        break;
    }
    $Row = $Result->fetch( PDO::FETCH_ASSOC );
    if( ! $Row ){
        break;
    }
    $Task['Room'] = $Row['Button'];
    
    // mark that we have taken the request to process it
    $Db->query("UPDATE `Requests` SET `Processed` = 1 WHERE `Id` = {$Row['Id']}");
}while( False );

header('Cache-Control: no-cache');
header('Content-Type: application/json');
print( json_encode( $Task ) );