<?php
$error = false;
// Check If Seal Numbers Exists
if(isset($_POST["verifySealNUmber"])){

    require_once('../core/general-functions.php');

    $sealNumbers = $_POST['sealNumbers'];

    if (empty($sealNumbers)) {
        $error = true;
        echo'Seal Number(s) Required';
    }

    if( !$error ) {
        foreach($sealNumbers as $sealNumber){
            require('../core/db.php');
            // Check if seal number
            $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations WHERE seal_number = '$sealNumber' ";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                echo '';
            } else {
                echo 'Choose a Valid And Registered Seal Number';
            }
        }
    }
}

// Verify If Seal Number Exists
if(isset($_POST["verifyOneSealNUmber"])){

    require_once('../core/general-functions.php');

    $sealNumber = $_POST['sealNumber'];

    if (empty($sealNumber)) {
        $error = true;
        echo'Seal Number Required';
    }

    if( !$error ) {
        require('../core/db.php');
        // Check if seal number exists
        $sql = "SELECT DISTINCT seal_number FROM sealings";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $snum = $row['seal_number'];
                $pieces = explode("-", $snum);
                $existingSealNumber = $pieces[1];
                if ( $existingSealNumber == $sealNumber ) {
                    echo 'Seal Number Already Exists';
                }
            }
        }
    }
}

// Verify If Seal Number Exists Evac Req
if(isset($_POST["verifyEvacReqSealNUmber"])){

    require_once('../core/general-functions.php');

    $sealNumber = $_POST['sealNumber'];

    if (empty($sealNumber)) {
        $error = true;
        echo'Seal Number Required';
    }

    if( !$error ) {
        require('../core/db.php');
        // Check if seal number exists
        $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $snum = $row['seal_number'];
                $pieces = explode("-", $snum);
                $existingSealNumber = $pieces[1];
                if ( $existingSealNumber == $sealNumber ) {
                    echo 'Seal Number Already Exists';
                }
            }
        }
    }
}

// Verify If Seal Number Exists Sealing
if(isset($_POST["verifySealingSealNUmber"])){

    require_once('../core/general-functions.php');

    $sealNumber = $_POST['sealNumber'];

    if (empty($sealNumber)) {
        $error = true;
        echo'Seal Number Required';
    }

    if( !$error ) {
        require('../core/db.php');
        // Check if seal number exists
        $sql = "SELECT DISTINCT seal_number FROM sealings";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $snum = $row['seal_number'];
                $pieces = explode("-", $snum);
                $existingSealNumber = $pieces[1];
                if ( $existingSealNumber == $sealNumber ) {
                    echo 'Seal Number Already Exists';
                }
            }
        }
    }
}

// Verify If Seal Number Exists Sealing
if(isset($_POST["verifySealingcurrentSealNumber"])){

    require_once('../core/general-functions.php');

    $currentSealNumber = $_POST['currentSealNumber'];

    if (empty($currentSealNumber)) {
        $error = true;
        echo'Seal Number Required';
    }

    if( !$error ) {
        require('../core/db.php');
        // Check if seal number exists
        $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $snum = $row['seal_number'];
                $pieces = explode("-", $snum);
                $existingcurrentSealNumber = $pieces[1];
                if ( $existingcurrentSealNumber == $currentSealNumber ) {
                    echo 'Seal Number Valid';
                } else {
                    echo 'Seal Number Invalid';
                }
            }
        }
    }
}

// Verify If Seal Number Exists Sealing
if(isset($_POST["verifySealingcurrentSealNumbers"])){

    require_once('../core/general-functions.php');

    $currentSealNumber = $_POST['currentSealNumber'];

    if (empty($currentSealNumber)) {
        $error = true;
        echo'Seal Number Required';
    }

    if( !$error ) {
        require('../core/db.php');
        // Check if seal number exists In CP Table
        $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $snum = $row['seal_number'];
                $pieces = explode("-", $snum);
                $existingcurrentSealNumber = $pieces[1];
                if ( $existingcurrentSealNumber == $currentSealNumber ) {
                    echo 'Seal Number Invalid';
                } else {
                    echo '';
                }
            }
        }
        // Check if seal number exists In S Table
        $sql = "SELECT DISTINCT seal_number FROM sealings LIMIT 1";
        $result = $con->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $snum = $row['seal_number'];
                $pieces = explode("-", $snum);
                $existingcurrentSealNumber = $pieces[1];
                if ( $existingcurrentSealNumber == $currentSealNumber ) {
                    echo 'Seal Number Invalid';
                } else {
                    echo '';
                }
            }
        }
    }
}