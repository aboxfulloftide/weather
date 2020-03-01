<?php


$steps  = [];
$steps[]  = 'current_weather.php';
$steps[]  = 'forecast_weather.php';
foreach($steps as $stepID => $stepName){
    echo "running " . $stepName . "\n";
    include_once "steps/$stepName";
}

        /*
        $mysql_c = "(";
        $mysql_d = "('";
        foreach ($v as $sub_k => $sub_v) {
            $mysql_c .= "$sub_k,";
            $mysql_d .= "$sub_v','";
            //echo $sub_k. ' : '. $sub_v . "\n";
        }
        $mysql_c = substr($mysql_c, 0, -1);
        $mysql_d = substr($mysql_d, 0, -2);
        $mysql_c .= ")";
        $mysql_d .= ") on Duplicate Key update wDate = VALUES(wDate)";
        $col_replace_old = ['DATE', 'STATION'];
        $col_replace_new = ['wDate', 'stations_id'];
        $data_replace_old = ['USC00200230', 'USW00014822', 'USC00209110', 'US1MIWY0047'];
        $data_replace_new = ['1', '2', '3', '4'];
        $mysql_c = str_replace($col_replace_old, $col_replace_new, $mysql_c);
        $mysql_d = str_replace($data_replace_old, $data_replace_new, $mysql_d);
        $query = "Insert INTO weather.daily_summaries $mysql_c VALUES $mysql_d";
        $db->query($query);
        //echo $query . "\n";
        //echo $mysql_c . "\n" . $mysql_d . "\n";
*/












