<?php

$tblName = 'supplies';
$slug = 'sr_slug';

$error = false;

// Start Supply Request
if(isset($_POST["startSupplyRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $srTitle	 	            = filter_var($_POST['srTitle'], FILTER_SANITIZE_STRING);
    $srSlug	 	            = filter_var($_POST['srSlug'], FILTER_SANITIZE_STRING);
    $clientId    = filter_var($_POST['clientId'], FILTER_SANITIZE_STRING);
    $requestType	 	    = filter_var($_POST['requestType'], FILTER_SANITIZE_STRING);
    $supplyDate	 	    = filter_var($_POST['supplyDate'], FILTER_SANITIZE_STRING);
    $srComment	 	    = filter_var($_POST['srComment'], FILTER_SANITIZE_STRING);
    
    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($srTitle)) {
        $error = true;
        echo'Supply Request Title Is Required';
    }
    if (empty($srSlug)) {
        $error = true;
        echo'Supply Request S Is Required ';
    }
    if (empty($clientId)) {
        $error = true;
        echo'Client Is Required';
    }
    if (empty($requestType)) {
        $error = true;
        echo'Request Type Is Required';
    }
    if (empty($supplyDate)) {
        $error = true;
        echo'Supply Date Is Required';
    }
    if (empty($srComment)) {
        $error = true;
        echo'Supply Comment Is Required';
    }

    if( !$error ) {
        startSupplyRequest($srTitle, $srSlug, $clientId, $requestType, $supplyDate, $srComment, $username, $addedOn);
    }
}
// Start Supply Request function
function startSupplyRequest($srTitle, $srSlug, $clientId, $requestType, $supplyDate, $srComment, $username, $addedOn)
{
    require('../core/db.php');

    $sql = "INSERT INTO supplies (client_id, sr_title, sr_type, sr_date, sr_comment, requested_by, requested_on, sr_slug)
            VALUES ('$clientId', '$srTitle', '$requestType', '$supplyDate', '$srComment', '$username', '$addedOn', '$srSlug')";
    if ($con->query($sql) === true) {
        echo "sm";

        // Get Client Information 
        $reqClientName      = getClientNameByIds($clientId);
        $clientName         = $reqClientName['bank_name'];
        // Get Branch Information 
        // $reqBranchInfo      = getClientBranches($clientBranch);
        // $cBranch            = $reqBranchInfo['name'];
        //get consignement 
        // $reqConsLoc             = getConsignmentLocationByIds($consignmentLocation);
        // $consignmentLocation    = $reqConsLoc['name'];

        // Send Email To CPC Staff
        $to = 'e.ibeh@icms.ng';
        $subject = 'New Supply Request From:'.$clientName;
        $from = 'no-reply@icms.ng';
        
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        // Compose a simple HTML email message
        $message = '<!DOCTYPE html>
        <html
            lang="en"
            xmlns="http://www.w3.org/1999/xhtml"
            xmlns:v="urn:schemas-microsoft-com:vml"
            xmlns:o="urn:schemas-microsoft-com:office:office"
        >
            <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <meta name="x-apple-disable-message-reformatting">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta content="telephone=no" name="format-detection">
                <title></title>
                <!--[if (mso 16)]>
                <style type="text/css">
                a {text-decoration: none;}
                </style>
                <![endif]-->
                <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->

                <link href="https://fonts.googleapis.com/css?family=Didact+Gothic&display=swap" rel="stylesheet" />

                <style>
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }
            
                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }
            
                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }
            
                        /* What it does: Stops Outlook from adding extra spacing to tables. */
                        table,
                        td {
                            mso-table-lspace: 0pt !important;
                            mso-table-rspace: 0pt !important;
                        }
            
                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }
            
                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode: bicubic;
                        }
            
                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }
            
                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],  /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }
            
                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }
            
                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }
            
                        img.g-img + div {
                            display: none !important;
                        }
            
                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
            
                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u ~ div .email-container {
                                min-width: 320px !important;
                            }
                        }
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u ~ div .email-container {
                                min-width: 375px !important;
                            }
                        }
                        /* iPhone 6+, 7+, and 8+ */
                        @media only screen and (min-device-width: 414px) {
                            u ~ div .email-container {
                                min-width: 414px !important;
                            }
                        }

                        .primary {
                            background: #af0000;
                        }
            
                        .bg_white {
                            background: #ffffff;
                        }
                        .bg_light {
                            background: #fafafa;
                        }
                        .bg_black {
                            background: #000000;
                        }
                        .bg_dark-grey {
                            background: rgb(48, 47, 47);
                        }
                        .bg_red {
                            background: #af0000;
                        }
                        .bg_dark {
                            background: rgba(0, 0, 0, 0.8);
                        }
                        .email-section {
                            padding: 2.5em;
                        }
                        .btn {
                            padding: 10px 15px;
                        }
                        .btn.btn-primary {
                            border-radius: 30px;
                            background: #af0000;
                            color: #ffffff;
                        }

                        h1, h2, h3, h4, h5, h6 {
                            font-family: "Didact Gothic", sans-serif;
                            color: #363636;
                            margin-top: 0;
                            font-weight: 600;
                        }
            
                        body {
                            font-family: "Didact Gothic", sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0, 0, 0, 0.4);
                        }
            
                        a {
                            color: #f3a333;
                        }
                        .logo h1 {
                            margin: 0;
                        }
                        .logo h1 a {
                            color: #fff;
                            font-size: 20px;
                            font-weight: 700;
                            text-transform: uppercase;
                            font-family: "Didact Gothic", sans-serif;
                        }
                        .hero {
                            position: relative;
                        }
                        .hero img {
                        }
                        .hero .text {
                            color: rgba(255, 255, 255, 0.8);
                        }
                        .hero .text h2 {
                            color: #ffffff;
                            font-size: 30px;
                            margin-bottom: 0;
                        }
                        .heading-section {
                        }
                        .heading-section h2 {
                            color: #af0000;
                            font-size: 28px;
                            margin-top: 0;
                            line-height: 1.4;
                        }
                        .heading-section .subheading {
                            margin-bottom: 20px !important;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(0, 0, 0, 0.4);
                            position: relative;
                        }
                        .heading-section-white {
                            color: rgba(255, 255, 255, 0.8);
                        }
                        .heading-section-white h2 {
                            font-size: 28px;
                            line-height: 1;
                            padding-bottom: 0;
                        }
                        .heading-section-white h2 {
                            color: #ffffff;
                        }
                        .heading-section-white .subheading {
                            margin-bottom: 0;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(255, 255, 255, 0.4);
                        }
            
                        .icon {
                            text-align: center;
                        }
                        .icon img {
                        }
                        .text-services {
                            padding: 10px 10px 0;
                            text-align: center;
                        }
                        .text-services h3 {
                            font-size: 20px;
                        }
                        .text-services .meta {
                            text-transform: uppercase;
                            font-size: 14px;
                        }
                        .footer {
                            color: rgba(255, 255, 255, 0.5);
                        }
                        .footer .heading {
                            color: #ffffff;
                            font-size: 20px;
                        }
                        .footer ul {
                            margin: 0;
                            padding: 0;
                        }
                        .footer ul li {
                            list-style: none;
                            margin-bottom: 10px;
                        }
                        .footer ul li a {
                            color: rgba(255, 255, 255, 1);
                        }
            
                        @media screen and (max-width: 500px) {
                            .icon {
                                text-align: left;
                            }
            
                            .text-services {
                                padding-left: 0;
                                padding-right: 20px;
                                text-align: left;
                            }
                        }
                    </style>


            </head>';
            $message .= '<body
            width="100%"
            style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
            <center style="width: 100%; background-color: #f1f1f1;">
                <div
                    style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;"
                >
                    &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                </div>
                <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                    <!-- BEGIN BODY -->
                    <table
                        align="center"
                        role="presentation"
                        cellspacing="0"
                        cellpadding="0"
                        border="0"
                        width="100%"
                        style="margin: auto;"
                    >
                        <tr>
                            <td class="bg_red logo" style="padding: 1em 2.5em; text-align: center">
                                <h1><a href="#" style="color: white">ICMS - Cash Processing Center</a></h1>
                            </td>
                        </tr>
                        <!-- end tr -->
                        <tr>
                            <td class="bg_white">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td class="bg_white email-section">
                                            <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                                <span class="subheading">New Cash Supply Request From:</span>
                                                <h2>'.$clientName.'</h2>
                                                <p> The above-stated client just made a new cash supply request. The supply request is set to be executed on '.$supplyDate.'.
                                                Find below supply details:
                                                <ul>
                                                    <li>Request Title: <strong>'.$srTitle.'</strong></li>
                                                    <li>Client: <strong>'.$clientName.'</strong></li>
                                                    <li>Supply Typr: <strong>'.$requestType.'</strong></li>
                                                    <li>Date of Execution: <strong>'.$supplyDate.'</strong></li>
                                                    <li>Message: <strong>'.$srComment.'</strong></li>
                                                </ul>
                                                </p>
                                                <p><a href="https://cpc.icms.ng/supply-requests" class="btn btn-primary" style="color: white">View Request</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- end:tr -->
                        <!-- 1 Column Text + Button : END -->
                    </table>

                    <table
                        align="center"
                        role="presentation"
                        cellspacing="0"
                        cellpadding="0"
                        border="0"
                        width="100%"
                        style="margin: auto;"
                    >
                        <tr>
                            <td valign="middle" class="bg_dark-grey footer email-section">
                                <table>
                                    <tr>
                                        <td valign="top" width="33.333%">
                                            <table
                                                role="presentation"
                                                cellspacing="0"
                                                cellpadding="0"
                                                border="0"
                                                width="100%"
                                            >
                                                <tr>
                                                    <td style="text-align: left; padding-right: 10px;">
                                                        <p>&copy; '.date('Y').' ICMS. All Rights Reserved</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top" width="33.333%">
                                            <table
                                                role="presentation"
                                                cellspacing="0"
                                                cellpadding="0"
                                                border="0"
                                                width="100%"
                                            >
                                                <tr>
                                                    <td style="text-align: right; padding-left: 5px; padding-right: 5px;">
                                                        <p>
                                                            <a href="#" style="color: rgba(255,255,255,.4);">Unsubcribe</a>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </center>
            </body>';
        $message .= '</html>';
        
        // Sending email 004 813 9953
        if(mail($to, $subject, $message, $headers)){
            echo '';
        } else{
            echo 'Unable to send email. Please try again.';
        }

    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Update Supply Request 
if(isset($_POST["updateSupplyRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $srTitle	 	            = filter_var($_POST['srTitle'], FILTER_SANITIZE_STRING);
    $srSlug	 	            = filter_var($_POST['srSlug'], FILTER_SANITIZE_STRING);
    $clientId    = filter_var($_POST['clientId'], FILTER_SANITIZE_STRING);
    $requestType	 	    = filter_var($_POST['requestType'], FILTER_SANITIZE_STRING);
    $supplyDate	 	    = filter_var($_POST['supplyDate'], FILTER_SANITIZE_STRING);
    $srComment	 	    = filter_var($_POST['srComment'], FILTER_SANITIZE_STRING);
    $srId	 	    = filter_var($_POST['srId'], FILTER_SANITIZE_STRING);
    
    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($srTitle)) {
        $error = true;
        echo'Supply Request Title Is Required';
    }
    if (empty($srSlug)) {
        $error = true;
        echo'Supply Request S Is Required ';
    }
    if (empty($clientId)) {
        $error = true;
        echo'Client Is Required';
    }
    if (empty($requestType)) {
        $error = true;
        echo'Request Type Is Required';
    }
    if (empty($supplyDate)) {
        $error = true;
        echo'Supply Date Is Required';
    }
    if (empty($srComment)) {
        $error = true;
        echo'Supply Comment Is Required';
    }

    if( !$error ) {
        updateSupplyRequest($srId, $srTitle, $srSlug, $clientId, $requestType, $supplyDate, $srComment, $username, $addedOn);
    }
}

// Update Supply Request function
function updateSupplyRequest($srId, $srTitle, $srSlug, $clientId, $requestType, $supplyDate, $srComment, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "UPDATE supplies SET 
    client_id = '$clientId', 
    sr_title = '$srTitle', 
    sr_type = '$requestType', 
    sr_date = '$supplyDate', 
    sr_comment = '$srComment', 
    requested_by = '$username', 
    requested_on = '$addedOn', 
    sr_slug = '$srSlug'
    WHERE id = '$srId' ";
    if ($con->query($sql) === true) {
        echo "sm";

        // Get Client Information 
        $reqClientName      = getClientNameByIds($clientId);
        $clientName         = $reqClientName['bank_name'];
        // Get Branch Information 
        // $reqBranchInfo      = getClientBranches($clientBranch);
        // $cBranch            = $reqBranchInfo['name'];
        //get consignement 
        // $reqConsLoc             = getConsignmentLocationByIds($consignmentLocation);
        // $consignmentLocation    = $reqConsLoc['name'];

        // Send Email To CPC Staff
        $to = 'e.ibeh@icms.ng';
        $subject = 'Update On Supply Request From:'.$clientName;
        $from = 'no-reply@icms.ng';
        
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        // Compose a simple HTML email message
        $message = '<!DOCTYPE html>
        <html
            lang="en"
            xmlns="http://www.w3.org/1999/xhtml"
            xmlns:v="urn:schemas-microsoft-com:vml"
            xmlns:o="urn:schemas-microsoft-com:office:office"
        >
            <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <meta name="x-apple-disable-message-reformatting">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta content="telephone=no" name="format-detection">
                <title></title>
                <!--[if (mso 16)]>
                <style type="text/css">
                a {text-decoration: none;}
                </style>
                <![endif]-->
                <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->

                <link href="https://fonts.googleapis.com/css?family=Didact+Gothic&display=swap" rel="stylesheet" />

                <style>
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }
            
                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }
            
                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }
            
                        /* What it does: Stops Outlook from adding extra spacing to tables. */
                        table,
                        td {
                            mso-table-lspace: 0pt !important;
                            mso-table-rspace: 0pt !important;
                        }
            
                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }
            
                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode: bicubic;
                        }
            
                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }
            
                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],  /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }
            
                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }
            
                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }
            
                        img.g-img + div {
                            display: none !important;
                        }
            
                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
            
                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u ~ div .email-container {
                                min-width: 320px !important;
                            }
                        }
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u ~ div .email-container {
                                min-width: 375px !important;
                            }
                        }
                        /* iPhone 6+, 7+, and 8+ */
                        @media only screen and (min-device-width: 414px) {
                            u ~ div .email-container {
                                min-width: 414px !important;
                            }
                        }

                        .primary {
                            background: #af0000;
                        }
            
                        .bg_white {
                            background: #ffffff;
                        }
                        .bg_light {
                            background: #fafafa;
                        }
                        .bg_black {
                            background: #000000;
                        }
                        .bg_dark-grey {
                            background: rgb(48, 47, 47);
                        }
                        .bg_red {
                            background: #af0000;
                        }
                        .bg_dark {
                            background: rgba(0, 0, 0, 0.8);
                        }
                        .email-section {
                            padding: 2.5em;
                        }
                        .btn {
                            padding: 10px 15px;
                        }
                        .btn.btn-primary {
                            border-radius: 30px;
                            background: #af0000;
                            color: #ffffff;
                        }

                        h1, h2, h3, h4, h5, h6 {
                            font-family: "Didact Gothic", sans-serif;
                            color: #363636;
                            margin-top: 0;
                            font-weight: 600;
                        }
            
                        body {
                            font-family: "Didact Gothic", sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0, 0, 0, 0.4);
                        }
            
                        a {
                            color: #f3a333;
                        }
                        .logo h1 {
                            margin: 0;
                        }
                        .logo h1 a {
                            color: #fff;
                            font-size: 20px;
                            font-weight: 700;
                            text-transform: uppercase;
                            font-family: "Didact Gothic", sans-serif;
                        }
                        .hero {
                            position: relative;
                        }
                        .hero img {
                        }
                        .hero .text {
                            color: rgba(255, 255, 255, 0.8);
                        }
                        .hero .text h2 {
                            color: #ffffff;
                            font-size: 30px;
                            margin-bottom: 0;
                        }
                        .heading-section {
                        }
                        .heading-section h2 {
                            color: #af0000;
                            font-size: 28px;
                            margin-top: 0;
                            line-height: 1.4;
                        }
                        .heading-section .subheading {
                            margin-bottom: 20px !important;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(0, 0, 0, 0.4);
                            position: relative;
                        }
                        .heading-section-white {
                            color: rgba(255, 255, 255, 0.8);
                        }
                        .heading-section-white h2 {
                            font-size: 28px;
                            line-height: 1;
                            padding-bottom: 0;
                        }
                        .heading-section-white h2 {
                            color: #ffffff;
                        }
                        .heading-section-white .subheading {
                            margin-bottom: 0;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(255, 255, 255, 0.4);
                        }
            
                        .icon {
                            text-align: center;
                        }
                        .icon img {
                        }
                        .text-services {
                            padding: 10px 10px 0;
                            text-align: center;
                        }
                        .text-services h3 {
                            font-size: 20px;
                        }
                        .text-services .meta {
                            text-transform: uppercase;
                            font-size: 14px;
                        }
                        .footer {
                            color: rgba(255, 255, 255, 0.5);
                        }
                        .footer .heading {
                            color: #ffffff;
                            font-size: 20px;
                        }
                        .footer ul {
                            margin: 0;
                            padding: 0;
                        }
                        .footer ul li {
                            list-style: none;
                            margin-bottom: 10px;
                        }
                        .footer ul li a {
                            color: rgba(255, 255, 255, 1);
                        }
            
                        @media screen and (max-width: 500px) {
                            .icon {
                                text-align: left;
                            }
            
                            .text-services {
                                padding-left: 0;
                                padding-right: 20px;
                                text-align: left;
                            }
                        }
                    </style>


            </head>';
            $message .= '<body
            width="100%"
            style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
            <center style="width: 100%; background-color: #f1f1f1;">
                <div
                    style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;"
                >
                    &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                </div>
                <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                    <!-- BEGIN BODY -->
                    <table
                        align="center"
                        role="presentation"
                        cellspacing="0"
                        cellpadding="0"
                        border="0"
                        width="100%"
                        style="margin: auto;"
                    >
                        <tr>
                            <td class="bg_red logo" style="padding: 1em 2.5em; text-align: center">
                                <h1><a href="#" style="color: white">ICMS - Cash Processing Center</a></h1>
                            </td>
                        </tr>
                        <!-- end tr -->
                        <tr>
                            <td class="bg_white">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td class="bg_white email-section">
                                            <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                                <span class="subheading">Updated Supply Request From:</span>
                                                <h2>'.$clientName.'</h2>
                                                <p> The above-stated client just made updated cash supply request. The updated supply request is set to be executed on '.$supplyDate.'.
                                                Find below supply details:
                                                <ul>
                                                    <li>Request Title: <strong>'.$srTitle.'</strong></li>
                                                    <li>Client: <strong>'.$clientName.'</strong></li>
                                                    <li>Supply Typr: <strong>'.$requestType.'</strong></li>
                                                    <li>Date of Execution: <strong>'.$supplyDate.'</strong></li>
                                                    <li>Message: <strong>'.$srComment.'</strong></li>
                                                </ul>
                                                </p>
                                                <p><a href="https://cpc.icms.ng/supply-requests" class="btn btn-primary" style="color: white">View Request</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- end:tr -->
                        <!-- 1 Column Text + Button : END -->
                    </table>

                    <table
                        align="center"
                        role="presentation"
                        cellspacing="0"
                        cellpadding="0"
                        border="0"
                        width="100%"
                        style="margin: auto;"
                    >
                        <tr>
                            <td valign="middle" class="bg_dark-grey footer email-section">
                                <table>
                                    <tr>
                                        <td valign="top" width="33.333%">
                                            <table
                                                role="presentation"
                                                cellspacing="0"
                                                cellpadding="0"
                                                border="0"
                                                width="100%"
                                            >
                                                <tr>
                                                    <td style="text-align: left; padding-right: 10px;">
                                                        <p>&copy; '.date('Y').' ICMS. All Rights Reserved</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top" width="33.333%">
                                            <table
                                                role="presentation"
                                                cellspacing="0"
                                                cellpadding="0"
                                                border="0"
                                                width="100%"
                                            >
                                                <tr>
                                                    <td style="text-align: right; padding-left: 5px; padding-right: 5px;">
                                                        <p>
                                                            <a href="#" style="color: rgba(255,255,255,.4);">Unsubcribe</a>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </center>
            </body>';
        $message .= '</html>';
        
        // Sending email 004 813 9953
        if(mail($to, $subject, $message, $headers)){
            echo '';
        } else{
            echo 'Unable to send email. Please try again.';
        }

    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Save Branch Supply Request
if(isset($_POST["saveBranchRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $srId	 	            = filter_var($_POST['srId'], FILTER_SANITIZE_STRING);
    $srClient	 	            = filter_var($_POST['srClient'], FILTER_SANITIZE_STRING);
    $clientBranch	 	            = filter_var($_POST['clientBranch'], FILTER_SANITIZE_STRING);
    $currency    = filter_var($_POST['currency'], FILTER_SANITIZE_STRING);
    $denomination	 	    = filter_var($_POST['denomination'], FILTER_SANITIZE_STRING);
    $cashCategory	 	    = filter_var($_POST['cashCategory'], FILTER_SANITIZE_STRING);
    $amount	 	    = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
    
    // Basic Validation 
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($srId)) {
        $error = true;
        echo'Supply Request UID Is Required';
    }
    if (empty($srClient)) {
        $error = true;
        echo'Client UID Is Required';
    }
    if (empty($clientBranch)) {
        $error = true;
        echo'Branch Is Required ';
    }
    if (empty($currency)) {
        $error = true;
        echo'Currency Is Required';
    }
    if (empty($denomination)) {
        $error = true;
        echo'Denomination Is Required';
    }
    if (empty($cashCategory)) {
        $error = true;
        echo'Cash Category Is Required';
    }
    if (empty($amount)) {
        $error = true;
        echo'Amount Is Required';
    }

    if( !$error ) {
        saveBranchRequest($srId, $srClient, $clientBranch, $currency, $denomination, $cashCategory, $amount, $username, $addedOn);
    }
}
// Save Branch Supply Request function
function saveBranchRequest($srId, $srClient, $clientBranch, $currency, $denomination, $cashCategory, $amount, $username, $addedOn)
{
    require('../core/db.php');

    $sql = "INSERT INTO supplybranches (supply_id, client, branch, currency, denomination, cash_category, amount, requested_by, requested_on)
            VALUES ('$srId', '$srClient', '$clientBranch', '$currency', '$denomination', '$cashCategory', '$amount', '$username', '$addedOn')";
    if ($con->query($sql) === true) {
        echo "sm";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Delete Branch Supply Request
if(isset($_POST["deleteBranchRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $bId	 	            = filter_var($_POST['bId'], FILTER_SANITIZE_STRING);
    
    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($bId)) {
        $error = true;
        echo'Branch Request UID Is Required';
    }

    if( !$error ) {
        deleteBranchRequest($bId);
    }
}
// Delete Branch Supply Request function
function deleteBranchRequest($bId)
{
    require('../core/db.php');
    $sql = "UPDATE supplybranches SET 
    is_deleted = 'YES'
    WHERE id = '$bId' ";
    if ($con->query($sql) === true) {
        echo "sm";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Conclude Supply Request
if(isset($_POST["doneCloseSupplyRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $supplyId	 	            = filter_var($_POST['supplyId'], FILTER_SANITIZE_STRING);
    
    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($supplyId)) {
        $error = true;
        echo'Branch Request UID Is Required';
    }

    if( !$error ) {
        doneCloseSupplyRequest($supplyId);
    }
}
// Conclude Supply Request function
function doneCloseSupplyRequest($supplyId)
{
    require('../core/db.php');
    $sql = "UPDATE supplies SET 
    bp_done = 'YES'
    WHERE id = '$supplyId' ";
    if ($con->query($sql) === true) {
        echo "sm";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Verify Supply Request
if(isset($_POST["verifyThisRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $supplyId	 	            = filter_var($_POST['supplyId'], FILTER_SANITIZE_STRING);
    $verComment	 	            = filter_var($_POST['verComment'], FILTER_SANITIZE_STRING);
    
    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($supplyId)) {
        $error = true;
        echo'Supply Request UID Is Required';
    }

    if( !$error ) {
        verifyThisRequest($supplyId, $username, $addedOn, $verComment);
    }
}
// Verify Supply Request function
function verifyThisRequest($supplyId, $username, $addedOn, $verComment)
{
    require('../core/db.php');
    $srStatus = 'Verified, Awaiting Approval';
    $sql = "UPDATE supplies SET 
    sr_status = '$srStatus',
    sr_verified = 'YES',
    verified_by = '$username',
    verified_on = '$addedOn',
    verified_comment = '$verComment'
    WHERE id = '$supplyId' ";
    if ($con->query($sql) === true) {
        echo "sm";
        // Update Branch Request
        $sql = "UPDATE supplybranches SET 
        srb_status = '$srStatus'
        WHERE supply_id = '$supplyId' ";
        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }

    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Approve Supply Request
if(isset($_POST["approveThisRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $supplyId	 	            = filter_var($_POST['supplyId'], FILTER_SANITIZE_STRING);
    $appComment	 	            = filter_var($_POST['appComment'], FILTER_SANITIZE_STRING);
    
    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($supplyId)) {
        $error = true;
        echo'Supply Request UID Is Required';
    }

    if( !$error ) {
        approveThisRequest($supplyId, $username, $addedOn, $appComment);
    }
}
// Approve Supply Request function
function approveThisRequest($supplyId, $username, $addedOn, $appComment)
{
    require('../core/db.php');
    $srStatus = 'Approved, Awaiting Dispatch';
    $sql = "UPDATE supplies SET 
    sr_status = '$srStatus',
    sr_approved = 'YES',
    approved_by = '$username',
    approved_on = '$addedOn',
    approved_comment = '$appComment'
    WHERE id = '$supplyId' ";
    if ($con->query($sql) === true) {
        echo "sm";
        // Update Branch Request
        $sql = "UPDATE supplybranches SET 
        srb_status = '$srStatus'
        WHERE supply_id = '$supplyId' ";
        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Dispatch Supply Request
if(isset($_POST["dispatchThisRequest"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $srbranchId	 	            = filter_var($_POST['srbranchId'], FILTER_SANITIZE_STRING);
    $cmo	 	            = filter_var($_POST['cmo'], FILTER_SANITIZE_STRING);
    $vehicle	 	            = filter_var($_POST['vehicle'], FILTER_SANITIZE_STRING);
    
    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($srbranchId)) {
        $error = true;
        echo'Supply Request UID Is Required';
    }
    if (empty($cmo)) {
        $error = true;
        echo'CMO Is Required';
    }
    if (empty($vehicle)) {
        $error = true;
        echo'Vehicle Is Required';
    }

    if( !$error ) {
        dispatchThisRequest($srbranchId, $username, $addedOn, $cmo, $vehicle);
    }
}
// Dispatch Supply Request function
function dispatchThisRequest($srbranchId, $username, $addedOn, $cmo, $vehicle)
{
    require('../core/db.php');
    $srStatus = 'Dispatched';
    $sql = "UPDATE supplybranches SET 
    is_dispatched = 'YES',
    is_dispatchedOn = '$addedOn',
    is_dispatchedBy = '$username',
    cit_officer = '$cmo',
    cit_vehicle = '$vehicle',
    srb_status = '$srStatus'
    WHERE id = '$srbranchId' ";
    if ($con->query($sql) === true) {
        echo "sm";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Split Supply Request
if(isset($_POST["packThisBag"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $srUID	 	            = filter_var($_POST['srUID'], FILTER_SANITIZE_STRING);
    $genSealNumber	 	    = filter_var($_POST['gencurrentSealNumber'], FILTER_SANITIZE_STRING);

    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($srUID)) {
        $error = true;
        echo'Supply Request UID Is Required';
    }
    if (empty($genSealNumber)) {
        $error = true;
        echo'Seal Number Is Required';
    }

    if( !$error ) {
        packThisBag($srUID, $genSealNumber, $username, $addedOn);
    }
}
// Split Supply Request function
function packThisBag($srUID, $genSealNumber, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "UPDATE supplybranches SET 
    seal_number = '$genSealNumber',
    is_packed = 'YES',
    packed_by = '$username',
    packed_on = '$addedOn'
    WHERE id = '$srUID' ";
    if ($con->query($sql) === true) {
        echo "sm";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}




// Get Client Name By ID
function getClientNameByIds($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM banks WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getClientBranches($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM bank_branches WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getConsignmentLocationById
function getConsignmentLocationByIds($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM consignmentlocations WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
