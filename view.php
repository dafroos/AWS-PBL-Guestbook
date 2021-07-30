<?php 
session_start();
include "database/db.php";
$eventid = $_SESSION['eventid'];
$userid = $_GET['userid'];
if($eventid == NULL)
{
    header("location: ./../login.php");
}

else
{ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Guestbook</title>
</head>
<body>

    <form action="controller/doLogout.php" method="POST">
        <div class="signoutbutton">
            <input type="submit" value="Sign Out" class="btn">
        </div>
    </form>

    <div class="body">
        <div class="heading">
            <h2>GUESTBOOK</h2>
            <h4>Event ID: <?=$eventid?></h4>
        </div>
        <br>
        <div class="form">
            <form action="controller/addGuest.php?userid=<?=$userid?>"  method="POST">
                <div class="form-content">
                    <label for="name" class="label-heading">Name</label>
                    <br>
                    <input type="text" name="name" class="form-text">
                </div>
                <br>
                <div class="form-content">
                    <label for="Message" class="label-heading">Message</label>
                    <br>
                    <input type="text" name="message" class="form-text">
                </div>
                <br>
                <input type="submit" value="Submit" class="btn" id="submitbtn">
            </form>
        </div>
        <br>
        <div class="results">
            <h3>Messages</h3>
            <br>
            <table>
            
                <tr>
                    <th id="time">Time</th>
                    <th id="name">Name</th>
                    <th id="message">Message</th>
                </tr>

                <?php
                $guestID = 0;
                while(true){
                    $guestID += 1;
                    $sql = "SELECT * FROM $eventid where guestID=?";
                    $select = $conn->prepare($sql);
                    $select->bind_param('i', $guestID);
                    $select->execute();
                    $guest = $select->get_result();
                ?>      
                <?php foreach($guest as $g){

                    ?>
                <tr>
                    <td class="td-spacing"><?=$g['date']?></td>
                    <td class="td-spacing"><?=$g['name']?></td>
                    <td class="td-spacing"><?=$g['message']?></td>
                </tr>

                <?php } ?> 
            <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php 
}
?>