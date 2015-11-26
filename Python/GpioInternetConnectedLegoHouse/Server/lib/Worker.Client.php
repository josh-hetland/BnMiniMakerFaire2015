<?php
/**
 * Get the current state of the house and if a task is included
 * put it on the queue to be processed
 */
$Room = null;
if( isset( $_POST['Room' ] ) ){
    $Room = strtolower( $_POST['Room'] );
}

$Status = array('Online' => false, 'Upstairs' => 0, 'Downstairs' => 0, 'Outside' => 0, 'RequestSet' => false);
$Status['Debug'] = array();
do{
    $Db = new PDO("mysql:host=localhost;port=44221;dbname=BnMake",'BnMake','BnMake');
    if( ! $Db ){
        $Status['Debug'][] = "no database connection";
        break;
    }
    
    // Get the current status of the lights
    $Result = $Db->query("SELECT `Upstairs`, `Downstairs`, `Outside`, UNIX_TIMESTAMP(`Timestamp`) AS `Timestamp` FROM `Status` ORDER BY `Timestamp` DESC LIMIT 1");
    if( ! $Result ){
        $Status['Debug'][] = "status query failed";
        break;
    }
    $Row = $Result->fetch( PDO::FETCH_ASSOC );
    if( ! $Row ){
        $Status['Debug'][] = "no results from query";
        break;
    }
    $Status['Online']       = ( $Row['Timestamp']  < (time() - 60) )? false : true;
    $Status['Upstairs']     = (int)$Row['Upstairs'];
    $Status['Downstairs']   = (int)$Row['Downstairs'];
    $Status['Outside']      = (int)$Row['Outside'];
    
    if( ! is_null( $Room ) ){
        $Status['Debug'][] = "room value present";
        $RequestTask = $Db->prepare("INSERT INTO `Requests` SET `Button`=:Button");
        $RequestTask->bindValue(':Button', $Room);
        if( $RequestTask->execute() ){
            $Status['RequestSet'] = true;
        }else{
            $Status['Debug'][] = "failed to save record";
        }
    }
}while( False );

header('Cache-Control: no-cache');
header('Content-Type: application/json');
print( json_encode( $Status ) );