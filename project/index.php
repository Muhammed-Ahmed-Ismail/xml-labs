<?php
/*session_start();
ini_set('error_reporting', E_ALL);
ini_set( 'display_errors', 1 );*/
require_once "vendor/autoload.php";
$xmlManupilator = new ContactsXmlManipulator();
$max = $xmlManupilator->getRecordesCount();
if (isset($_GET["no"])) {
    if ($_GET["no"] > $max) {
        $current = $max;
    } elseif ($_GET["no"] < 1) {
        $current = 1;
    } else {
        $current = $_GET["no"];
    }
} else {
    $current = 1;
}
$next = ($current + 1 <= $max) ? $current + 1 : $current;
$prev = ($current - 1 != 0) ? $current - 1 : $current;
$empDto = $xmlManupilator->readEmployeeRecordByPosition($current);
$name = $empDto->getName();
$phone = $empDto->getPhone();
$address = $empDto->getAddress();
$email = $empDto->getEmail();

if (!empty($_GET)) {
    $insertedName = $_GET["name"];
    $insertedPhone = $_GET["phone"];
    $insertedAddress = $_GET["address"];
    $insertedEmail = $_GET["email"];
    if (isset($_GET["insert"])) {
        $xmlManupilator->createEmployeeRecord($insertedName, $insertedPhone, $insertedAddress, $insertedEmail);
        $current = $xmlManupilator->getRecordesCount();
        $empDto = $xmlManupilator->readEmployeeRecordByPosition($current);

    } elseif (isset($_GET["update"])) {
        $xmlManupilator->updateEmployeeRecord($current, $insertedName, $insertedPhone, $insertedAddress, $insertedEmail);
        $empDto = $xmlManupilator->readEmployeeRecordByPosition($current);
    } elseif (isset($_GET["delete"])) {
        $xmlManupilator->deleteEmployeeRecord($current);
        $current =($current-1>0)? $current - 1 : 1;
        echo $current;
        $empDto = $xmlManupilator->readEmployeeRecordByPosition($current);
    } elseif (isset($_GET["search"])) {
        $empDto = $xmlManupilator->readEmployeeRecordByName($_GET["name"]);
        $current = $empDto->getPosition();
    }
    $name = $empDto->getName();
    $phone = $empDto->getPhone();
    $address = $empDto->getAddress();
    $email = $empDto->getEmail();
}
?>
<html lang="en">
<header>
    <link rel="stylesheet" href="Static/css/style.css">
</header>
<body class="flex">
<div class="form-container flex flex-column">
    <form action="index.php" method="get" class=" flex flex-column" id="xml-form">
        <table>
            <tr>
                <td>
                    <label>#NO</label>
                </td>
                <td>
                    <input type="text" readonly name="no" value="<?= $current?>"><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Name</label>
                </td>
                <td>
                    <input type="text" name="name" value="<?= $name ?>" required><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Phone</label>
                </td>
                <td>
                    <input type="text" name="phone" value="<?= $phone ?>" required><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Address</label>
                </td>
                <td>
                    <input type="text" name="address" value="<?= $address ?>" required><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Email</label>
                </td>
                <td>
                    <input type="text" name="email" value="<?= $email ?>" required><br/>
                </td>
            </tr>
        </table>
        <div class="flex flex-row">
            <input type="submit" name="insert" value="Insert">
            <input type="submit" name="delete" value="delete">
            <input type="submit" name="update" value="update">
            <input type="submit" name="search" value="search">
        </div>
        <div class="flex flex-row">
            <a href="index.php?no=<?= $prev ?>">prev</a>
            <a href="index.php?no=<?= $next ?>">next</a>
        </div>
    </form>
</div>
</body>
</html>
