

        // Get Client Information 
        $reqClientName      = getClientNameByIds($bankId);
        $clientName         = $reqClientName['bank_name'];
        // Get Branch Information 
        $reqBranchInfo      = getClientBranches($clientBranch);
        $cBranch            = $reqBranchInfo['name'];
        //get consignement 
        $reqConsLoc             = getConsignmentLocationByIds($consignmentLocation);
        $consignmentLocation    = $reqConsLoc['name'];

        // Send Email To CPC Staff
        $to = 'e.ibeh@icms.ng';
        $subject = 'Updated Evacuation Request From:'.$clientName;
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
                                                <span class="subheading">Updated Evacuation Request From:</span>
                                                <h2>'.$clientName.'</h2>
                                                <p> The above-stated client has updated their request for cash evacuation. The evacuation is set to be carried out on '.$dateOfExecutione.'.
                                                Find below evacuation details:
                                                <ul>
                                                    <li>Request Title: <strong>'.$erName.'</strong></li>
                                                    <li>Client: <strong>'.$clientName.'</strong></li>
                                                    <li>Branch: <strong>'.$cBranch.'</strong></li>
                                                    <li>Date of Execution: <strong>'.$dateOfExecutione.'</strong></li>
                                                    <li>Destination Location: <strong>'.$consignmentLocation.'</strong></li>
                                                </ul>
                                                </p>
                                                <p><a href="https://cpc.icms.ng/evacuation-requests" class="btn btn-primary" style="color: white">View Request</a></p>
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