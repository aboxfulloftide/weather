<?php
include_once("../core/connection.php");
//$stations = 'USW00014822,USC00200230';
$stations = 'USC00209110,US1MIWY0047,USW00014822,USC00200230';
#https://www.ncei.noaa.gov/support/access-data-service-api-user-documentation

$dataTypes = '&dataTypes=stations_id,wDate,DASF,MDSF,PRCP,SNOW,SNWD,TMAX,TMIN,TOBS,TAVG,WT01,WT02,WT03,WT04,WT05,WT06,WT07,WT08,WT09,WT10,WT11,WT12,WT13,WT14,WT15,WT16,WT17,WT18,WT19,WT20,WT21,WT22,AWND,PGTM,WSFM,WESF,WESD,TSUN,WSF1,WSF2,WSF5,WDF1,WDF2,WDF5,ACMH,WDFG,ACSH,WSFG,PSUN,WDFM';
//The date that you want to start at.
$start = '2020-02-12';

//The date that you want to stop at.
$end = '2020-02-28';

//We set our counter to the start date.
$currentDate = strtotime($start);

//While the current timestamp is smaller or equal to
//the timestamp of the end date.
while($currentDate <= strtotime($end)){
    $start_display = date("Y-m-d", $currentDate);
    $currentDate = strtotime("+6 day", $currentDate);
    $end_display = date("Y-m-d", $currentDate);
    echo $start_display . " " . $end_display . "\n";
    $json = file_get_contents("https://www.ncei.noaa.gov/access/services/data/v1?dataset=daily-summaries&stations=$stations&startDate=$start_display&endDate=$end_display&format=json&units=standard$dataTypes");
    $obj = json_decode($json);
    //var_dump($obj);

    foreach ($obj as $k => $v) {
        $mysql_c    = "(";
        $mysql_d    = "('";
        foreach ($v as $sub_k => $sub_v) {
            $mysql_c    .= "$sub_k,";
            $mysql_d    .= "$sub_v','";
            //echo $sub_k. ' : '. $sub_v . "\n";
        }
        $mysql_c = substr($mysql_c,0,-1);
        $mysql_d = substr($mysql_d,0,-2);
        $mysql_c    .= ")";
        $mysql_d    .= ") on Duplicate Key update wDate = VALUES(wDate)";
        $col_replace_old    = ['DATE','STATION'];
        $col_replace_new    = ['wDate','stations_id'];
        $data_replace_old    = ['USC00200230','USW00014822','USC00209110','US1MIWY0047'];
        $data_replace_new    = ['1','2','3','4'];
        $mysql_c = str_replace($col_replace_old,$col_replace_new,$mysql_c);
        $mysql_d = str_replace($data_replace_old,$data_replace_new,$mysql_d);
        $query   = "Insert INTO weather.daily_summaries $mysql_c VALUES $mysql_d";
        $db->query($query);
        //echo $query . "\n";
        //echo $mysql_c . "\n" . $mysql_d . "\n";

    }
}










