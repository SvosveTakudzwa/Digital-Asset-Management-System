<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;

class Validate
{
    public $dbConnect = false;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'root';
    private $db = 'assets_management';

    public function __construct()
    {
        if (!$this->dbConnect) {
            $conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

            if ($conn->error) {
                die('Error in mysql connection :' . $conn->connect_error);
            } else {
                $this->dbConnect = $conn;
            }
        }
    }

    public function getAllData($sqlquery)
    {
        $result = mysqli_query($this->dbConnect, $sqlquery);
        if (!$result) {
            die('Error in mysql' . mysqli_error($this->dbConnect));
        } else {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function getOneRow($sqlquery)
    {
        $result = mysqli_query($this->dbConnect, $sqlquery);
        if (!$result) {
            die('Error in mysql' . mysqli_error($this->dbConnect));
        } else {
            return $result->fetch_assoc();
        }
    }

    public function registerUsers($username, $email, $pass, $dob, $id_number, $phone_number, $address): void
    {
        $is_verified = 1;
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sqlquery = "INSERT INTO portal_users (username, email, password, dob, id_number, phone_number, address , is_verified) VALUES(?, ?, ? , ? , ? ,? ,? , ?)";
        $stmt = mysqli_prepare($this->dbConnect, $sqlquery);
        $stmt->bind_param("sssssssi", $username, $email, $pass, $dob, $id_number, $phone_number, $address, $is_verified);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $id = $stmt->insert_id;
            $_SESSION['user_id'] = $id;
            header('Location: index.php');
        } else {
            echo  "Error";
        }
    }

    public function verification($id): void
    {
        $sql = "UPDATE portal_users SET is_verified = 1 WHERE id = ?";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $sql = 'SELECT * FROM portal_users WHERE id = ?';
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION['user_id'] = $row['id'];
                    header('Location: index.php');
                }
            }
        }
    }

    public function login($email,  $password)
    {
        $_SESSION['status'] = false;
        $stmt = $this->dbConnect->prepare('SELECT * FROM portal_users WHERE is_verified = 1 AND email = ? or username = ? ');
        $stmt->bind_param('ss', $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if (!password_verify($password, $data['password'])) {
                return  $_SESSION['status'] = false;
            } else {
                $_SESSION['status'] = true;
                $_SESSION['user_id'] = $data['id'];
                if (($this->insertActivity($data['id'], 'login')) == 'Inserted') {
                    header('Location: index.php');
                    $_SESSION['status'] = true;
                }
            }
        }
    }

    public function insertActivity($id, $activity)
    {
        $session_id = uniqid('HIT', true);
        $sql = 'INSERT INTO user_session (user_id, session_id, activity) VALUES (?, ? , ?)';
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bind_param("iss", $id, $session_id, $activity);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return 'Inserted';
        } else {
            return 'Error';
        }
    }

    public function checkAsset($deviceName, $deviceModel, $serialNumber)
    {
        $sql = "SELECT * FROM assets WHERE item_description = ? AND model = ? AND serial_number = ?";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bind_param("sss", $deviceName, $deviceModel, $serialNumber);
        $stmt->execute();

        if (($stmt->num_rows) > 0) {
            $assets_info =  $this->getOneRow($sql);
            $assets_id = $assets_info['assets_id'];

            $sql = "UPDATE assets SET missing = 'Yes' WHERE assets_id = " . $assets_id . "";
            if ($this->dbConnect->query($sql)) {
                return 'Missing';
            }
        } else {
            return 'This is a new Asset';
        }
    }

    public function registerAsset($userID, $regNumber, $deviceName, $deviceModel, $serialNumber, $signature)
    {

        if ($this->checkAsset($deviceName, $deviceModel, $serialNumber) == 'Missing') {
            return 'Missing';
        } else {
            $date = date('Y-m-d');
            $regNumber = trim(strtoupper($regNumber));
            $stmt = $this->dbConnect->prepare('INSERT INTO assets (student_id, user_id, item_description, model, serial_number, date_created, signature) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('sisssss', $regNumber, $userID, $deviceName, $deviceModel, $serialNumber, $date, $signature);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $id =  $stmt->insert_id;
                $url = 'http://localhost/Digital-Asset-Management-System/card.php?aid=' . $id . '';

                $qr_id = uniqid();
                $qr_image = $qr_id . ".jpg";

                $qr_path = 'qrcodes/' . $qr_id . '.jpg';

                $qr_link = 'http://localhost/Digital-Asset-Management-System/verify.php?qrcode=' . $qr_id . '.jpg';

                QRcode::png($url, $qr_path);

                $query = mysqli_query($this->dbConnect, "UPDATE assets set qr_code='$qr_image' WHERE assets_id = $id");
                if ($query) {
                    $message =  $this->message($regNumber, $qr_link);
                    $email = $regNumber . "@hit.ac.zw";
                    if (($this->sendEmail($email, $message)) == 'mail send') {
                        return "Mail Send";
                    }
                    $stmt->close();
                } else {
                    return 'Error saving asset';
                }
            }
        }
    }
    public function message($username, $id)
    {

        date_default_timezone_set('Africa/Harare');
        $date = date_create();
        date_add($date, date_interval_create_from_date_string('1 hour')); // Set expiration time to 1 hour from now
        $expiration_time = date_format($date, 'Y-m-d H:i:s'); // Format expiration time as string
        $link_url = $id . '&expires=' . urlencode($expiration_time); // Add expiration time to link URL

        $output = '<img><br>
    <h3>Dear ' . $username . '</h3>
    <p>Please find attached your digital asset card. Click the link below to download:</p>
    <a href="' . $link_url . '">Download here!</a>
    <hr>
    <p>Email sent at ' . date('d-m-Y H:i') . '</p>
    <h4>Thank you,</h4>
    <h4>From HIT ACMS Admin.</h4>';

        return $output;
    }


    public function sendEmail($email, $msg)
    {
        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = ""; // use smtp.example.com
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->isHTML(true);
        $mail->Username   = ''; //SMTP username
        $mail->Password   = '';
        $mail->setFrom('', "Asset QR Code");
        $mail->addAddress($email, '');
        $mail->Subject = 'ATTACHED IS YOUR DIGITAL ASSET QR CODE';
        $mail->Body = $msg;
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );
        if ($mail->send()) {
            return 'mail send';
        } else {
            return 'mail error';
        }
    }
    public function editAsset($userID, $regNumber, $deviceName, $deviceModel, $serialNumber, $assets_id, $missing)
    {

        $regNumber = trim($regNumber);
        $stmt = $this->dbConnect->prepare('UPDATE assets SET student_id = ?,  user_id = ?, item_description = ?, model = ?, serial_number = ? , missing = ? WHERE assets_id = ?');
        $stmt->bind_param('sissssi', $regNumber, $userID, $deviceName, $deviceModel, $serialNumber, $missing, $assets_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return 'Success';
            $stmt->close();
        } else {
            return 'Error';
        }
    }

    public function deleteAsset($id)
    {

        if (($this->storeDeletedAssets($id)) == 'Saved') {
            $sql = "DELETE FROM assets WHERE assets_id = ?";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return "Deleted";
            } else {
                return 'Error';
            }
        }
    }


    private function storeDeletedAssets($id)
    {
        $sql =  "SELECT * FROM assets WHERE assets_id = $id";
        $result = $this->dbConnect->query($sql);
        if ($result->num_rows > 0) {
            $deleted_asset = $result->fetch_assoc();
            $student_id = $deleted_asset['student_id'];
            $item_name = $deleted_asset['item_description'];
            $user_id = $deleted_asset['user_id'];
            $serial_number =  $deleted_asset['serial_number'];
            $sql = 'INSERT INTO deleted_assets (asset_id, asset_name , reg_number, user_id, serial_number)  VALUES ("' . $id . '", "' . $item_name . '","' . $student_id . '","' . $user_id . '","' . $serial_number . '")';
            if ($this->dbConnect->query($sql)) {
                return 'Saved';
            } else {
                return 'Error';
            }
        } else {
            return 'Error';
        }
    }

    public function getNumRows($sql)
    {
        $result = mysqli_query($this->dbConnect, $sql);
        return $result->num_rows;
    }
}
