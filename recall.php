<?php
    date_default_timezone_set('PRC');
    $hour = date('H',time());
    $day = date('Y-m-d',time());
    if($hour<12){
        $morning = 0;
        $afternoon = 0;
        $db_conn = new mysqli('localhost', '', '', '');
        $sql = "UPDATE `data_tbl` SET `morning`= 0 WHERE `dedo` = '".$day."'";
        $result = $db_conn->query($sql);
    }
    else{
        $morning = 1;
        $afternoon = 0;
        $db_conn = new mysqli('localhost', '', '', '');
        $sqlaf = "UPDATE `data_tbl` SET `afternoon`= 0 WHERE `dedo` = '".$day."'";
        #UPDATE `data_tbl` SET `afternoon`= 0 WHERE `dedo` = '2022-2-12';
        $result = $db_conn->query($sqlaf);
    }
    $db_conn = new mysqli('localhost', '', '', '');
    $sql = "SELECT dedo , morning, afternoon FROM ";
    mysqli_select_db( $db_conn, '' );
    $retval = mysqli_query( $db_conn, $sql );
    echo '<table border="1"><tr><td>日期</td><td>上午</td><td>下午</td></tr>';
    while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
    {
        echo "<tr><td> {$row['dedo']}</td> ".
            "<td>{$row['morning']} </td> ".
            "<td>{$row['afternoon']} </td> ".
            "</tr>";
}
    echo '</table>';
?>