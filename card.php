<?php
require 'vendor/dompdf/autoload.inc.php';
require './config/Validate.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET['aid'])) {
    $validate = new Validate();
    $aid = $_GET['aid'];

    $sql = 'SELECT * FROM assets AS ast INNER JOIN students as stu ON ast.student_id = stu.student_id INNER JOIN portal_users AS pu ON ast.user_id = pu.id WHERE ast.assets_id = ' . $aid . '';
    $assets = $validate->getOneRow($sql);



    define("DOMPDF_UNICODE_ENABLED", true);
    define("DOMPDF_ENABLE_REMOTE", true);

    $context = stream_context_create([
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'user_agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
        ],
        'ssl' => [
            'verify_peer' => FALSE,
            'verify_peer_name' => FALSE,
            'allow_self_signed' => TRUE
        ]
    ]);
    $dompdf = new Dompdf(array('enable_remote' => true));
    $dompdf->setHttpContext($context);
    $options = new Options();
    $options->setIsRemoteEnabled(true);
    $options->setIsHtml5ParserEnabled(true);
    $options->set(array('isRemoteEnabled' => true));
    $html = '
<head>

    <style>
    /*Beginning of whole doc styling*/
    body{
      font-size: 20px;
    }
    
    /*Beginning of form styling*/
    
    .form{
        width: 800px;
        margin: auto;
     }
 
    .float-child {
        width: 45%;
        float: left;
        padding: 0 10px;
    }
    
    p {
        border-bottom: 2px solid #FFA500;
        font-size: 18px;
        margin-bottom: -16px;
      }
    
    .float-child img{
        padding-top: 45px;
        margin-bottom: -19px;
        margin-left: 115px;
    }

    .right-branch{
        padding-top: -50px; 
    }

    h1{
        margin-left: 65px;
        padding-top: 61px;
        text-transform: uppercase;
        font-size: 35px;
    }
    h4{
        margin-top: 20px;
        font-size: 14px;
    }
    h5{
        margin-bottom: -12px;
    }
    h6 {
        color: red;
        font-size: 16px;
        text-align: right;
        margin-top: 20px;
    }
    </style>

</head>

<body>

    <div class="form">
        <div class="float-child">
            <div class="logo">

                <img src="img/HITfavicon.jpg" alt="Harare Institute of Technology Logo" width="180" height="95">
            </div>
            <div class="right-branch">
                <h5>Card Holder\'s Name</h5>
                <p>' . $assets['student_username'] . '</p>
                <h5>Mobile Number</h5>
                <p>' . $assets['student_phone'] . '</p>
                <h5>Serial Number</h5>
                <p>' . $assets['serial_number'] . '</p> 
                <h5>Date:</h5>
                <p>' . $assets['date_created'] . '</p>
                <h5>Security signature:</h5>
                <br>
                <img src="signatures/'.$assets['guard_signature'].'" width="200">
                <h4 text-align="center">For Terms and Conditions see reverse</h4>
                </div>
            </div>

        <div class="float-container">
            <div class="float-child">
                <h1 class="case">asset card</h1>
                <h5>Student Registration Number</h5>
                <p>' . $assets['student_id'] . '</p>
                <h5>Item description</h5>
                <p>' . $assets['item_description'] . '</p>
                <h5>Model</h5>
                <p>' . $assets['model'] . '</p>
                <h5>Guard Name:</h5>
                <p>'.$assets['username'].'</p>
                <h5>Official Signature:</h5>
                <br>
                <img src="signatures/'.$assets['signature'].'" width="200">
                <h6>No: ASSET' . (1000 + $assets['assets_id']) . '</h6>
            </div>
        </div>
    </div>

</body>

</html>';

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();


    // Output the generated PDF to Browser
    $dompdf->stream('Asset Card', array('Attachment' => 0));
} else {
    echo "OOOPSSS";
}