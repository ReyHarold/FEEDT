<nav>
<menu>
	<menuitem>
        <a id ="dropTitle">Select Item to Produce</a>
        <menu>
<?php
$sql3 = "SELECT DISTINCT `feed` FROM `inventory`;";
$result3 = mysqli_query($conn, $sql3);

while ($row3 = mysqli_fetch_assoc($result3)) {
    echo "<menuitem>";
    echo "<a>" . htmlspecialchars(ucfirst($row3["feed"])) . "</a>";
    echo "<menu>";
    
    // Corrected SQL query for $sql4
    $sql4 = "SELECT `item`, `feed`, `itemID` FROM `inventory` WHERE `feed` = '" . mysqli_real_escape_string($conn, $row3["feed"]) . "' AND `type` = 'finish';";
    $result4 = mysqli_query($conn, $sql4);

    while ($row4 = mysqli_fetch_assoc($result4)) {
        echo "<menuitem><a onclick='setDrop(\"".$row4['item']."\",\"production\",\"".$row4['feed']."\")'>" . htmlspecialchars(ucfirst($row4['item'])) . "</a></menuitem>";
    }

    echo "</menu>";
    echo "</menuitem>";
}
?>
</menu>
</nav>