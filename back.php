<?php
    date_default_timezone_set('PRC');
    $hour = date('H',time());
    $day = date('Y-m-d',time());
    class Validate_SQLWrite{
        public $hour;
        public function chek(){
            $hour = date('H',time());
            $db_conn = new mysqli('localhost', '', '', '');
            $sql = "SELECT dedo , morning, afternoon FROM ";
            mysqli_select_db( $db_conn, '' );
            $retval = mysqli_query($db_conn,$sql);
            $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
            echo $row['afternoon'];
            #echo ($hour<12 && $row['morning'] = 1);
            if($hour<12){
                if($row['morning'] == 1){
                    return 0;
                }
                else if($row['morning'] == 0){
                    return 1;
                }
            }
            else{
                if($row['afternoon'] == 1){
                    return 0;
                }
                else if($row['afternoon'] == 0){
                    return 1;
                }
            }
        }
    }

    if($hour<12){
        $morning = 1;
        $afternoon = 0;
        $db_conn = new mysqli('localhost', '', '', '');
        $sql = "insert into  values ('{$day}',$morning,$afternoon)";
        $result = $db_conn->query($sql);
    }
    else{
        #$morning = 0;
        #$afternoon = 1;
        $db_conn = new mysqli('localhost', '', '', '');
        #$sqlaf = "insert into  values ('{$day}',$morning,$afternoon)";
        $sqlaf = "UPDATE `` SET `afternoon`= 1 WHERE `dedo` = '".$day."'";
        $result = $db_conn->query($sqlaf);
    }
    ?>