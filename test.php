<!DOCTYPE html>
<html>

<head>
    <title>PHP Signature Pad Example</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./assets/jquery.signature.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./assets/jquery.signature.css">
    <script src="./assets/jquery.ui.touch-punch.min.js"></script>
    <style>
        .kbw-signature {
            width: 400px;
            height: 200px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="col-md-12">
        <label class="" for="">Signature:</label>
        <br />
        <div id="sig"></div>
        <br />
        <button id="clear">Clear Signature</button>
        <textarea id="signature64" name="signed" style="display: none"></textarea>
    </div>

    <br />
    <input type="submit" value="submit" id="submit" class="btn btn-success" name="submit">

    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });

        $('#sig').draggable()
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>
</body>

</html>