<script>
const data = [
    <?php
    $sqlsearch = "SELECT `item` FROM `inventory` WHERE `type` = 'ingredient';";
    $resultsearch = mysqli_query($conn, $sqlsearch);

    $items = [];
    while ($row = mysqli_fetch_assoc($resultsearch)) {
        $items[] = '"' . ucfirst($row['item']) . '"';
    }
    echo implode(", ", $items);
    ?>
];
</script>
