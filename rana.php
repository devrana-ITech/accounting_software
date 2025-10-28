<?php
$val = $_settings->userdata('year_id'); // বর্তমান বছর
$journal_type = 'dv';

// Step 1: main voucher number বের করা
$qry_year = $conn->query("SELECT max(FLOOR(voucher_number)) as vn FROM `journal_entries` WHERE year_id = '$val' AND journal_type = '$journal_type'");
$v1 = 1;
if($qry_year->num_rows > 0){
    $res1 = $qry_year->fetch_assoc();
    if(!empty($res1['vn'])){
        $v1 = $res1['vn'] + 1; // নতুন main voucher
    }
}

// Step 2: ওই voucher-এর মধ্যে সর্বশেষ sub number বের করা
$qry_sub = $conn->query("SELECT max(voucher_number) as sub_vn FROM `journal_entries` WHERE year_id = '$val' AND journal_type = '$journal_type' AND FLOOR(voucher_number) = '$v1'");
if($qry_sub->num_rows > 0){
    $res2 = $qry_sub->fetch_assoc();
    if(!empty($res2['sub_vn'])){
        $voucher_number = $res2['sub_vn'] + 0.1; // পরের decimal voucher
    } else {
        $voucher_number = $v1 + 0.1; // প্রথম sub voucher
    }
} else {
    $voucher_number = $v1 + 0.1;
}
?>

===================================

<?php

$val = $_settings->userdata('year_id'); 
$journal_type = 'dv';

// Step 1️⃣: সর্বশেষ main (integer) voucher বের করা
$qry_year = $conn->query("
    SELECT MAX(FLOOR(voucher_number)) AS vn 
    FROM journal_entries 
    WHERE year_id = '$val' 
    AND journal_type = '$journal_type'
");

$v1 = 1; // default main voucher
if ($qry_year->num_rows > 0) {
    $res1 = $qry_year->fetch_assoc();
    if (!empty($res1['vn'])) {
        $v1 = $res1['vn']; // এখানেই main voucher fix থাকবে
    }
}

// Step 2️⃣: ঐ main voucher ($v1) এর অধীনে সর্বশেষ sub voucher বের করা
$qry_sub = $conn->query("
    SELECT MAX(voucher_number) AS sub_vn 
    FROM journal_entries 
    WHERE year_id = '$val' 
    AND journal_type = '$journal_type' 
    AND FLOOR(voucher_number) = '$v1'
");

if ($qry_sub->num_rows > 0) {
    $res2 = $qry_sub->fetch_assoc();

    if (!empty($res2['sub_vn'])) {
        // আগের sub voucher থেকে 0.1 বাড়াও
        $voucher_number = number_format($res2['sub_vn'] + 0.1, 1);
    } else {
        // ঐ main voucher এর প্রথম sub voucher
        $voucher_number = number_format($v1 + 0.1, 1);
    }
} else {
    // নতুন main voucher এর প্রথম sub voucher
    $voucher_number = number_format($v1 + 0.1, 1);
}

// Step 3️⃣: চেক করো — যদি পূর্বের main voucher এর অধীনে সব শেষ হয়ে যায়,
// তখনই নতুন main voucher তৈরি হবে
// উদাহরণ: যদি তুমি manually signal দাও নতুন voucher শুরু করার
if (isset($_POST['new_main']) && $_POST['new_main'] == 1) {
    $v1 = $v1 + 1; // নতুন main voucher
    $voucher_number = number_format($v1 + 0.1, 1);
}



$v_num = $conn->query("SELECT max(voucher_number) as vn FROM `journal_entries` where year_id = '$val' and journal_type = 'jv'");
if($v_num->num_rows > 0){
        $res1 = $v_num->fetch_array();
        foreach($res1 as $key1 => $value1){
            $$key1 = $value1;
		$value1 = $value1 + 1;
        }
    }

?>


<?php
// safe cast
$val = (int) $_settings->userdata('year_id');
$journal_type = 'dv';

// 1) current highest integer (main) voucher er floor value ber koro
$qry_year = $conn->query("
    SELECT MAX(FLOOR(voucher_number)) AS max_main
    FROM journal_entries
    WHERE year_id = '$val'
      AND journal_type = '$journal_type'
");

$max_main = 0;
if ($qry_year && $qry_year->num_rows > 0) {
    $res1 = $qry_year->fetch_assoc();
    if ($res1['max_main'] !== null && $res1['max_main'] !== '') {
        $max_main = (int) $res1['max_main'];
    }
}

// next main voucher number (what would be the next integer voucher)
$next_main = $max_main + 1;

// 2) check: has the integer main voucher ($next_main) already been created?
//    - if NOT created yet -> first submit should create the integer main ($next_main)
//    - if already exists -> we must create a sub (e.g. $next_main.1, $next_main.2, ...)
$qry_main_exists = $conn->query("
    SELECT COUNT(*) AS cnt
    FROM journal_entries
    WHERE year_id = '$val'
      AND journal_type = '$journal_type'
      AND voucher_number = '$next_main'
");

$main_exists = false;
if ($qry_main_exists && $qry_main_exists->num_rows > 0) {
    $row = $qry_main_exists->fetch_assoc();
    $main_exists = ((int)$row['cnt'] > 0);
}

if (! $main_exists) {
    // no integer main voucher yet -> create the integer main voucher
    $voucher_number = (string) $next_main; // e.g. "174"
} else {
    // main exists -> create next sub voucher for that main
    $qry_sub = $conn->query("
        SELECT MAX(voucher_number) AS max_sub
        FROM journal_entries
        WHERE year_id = '$val'
          AND journal_type = '$journal_type'
          AND FLOOR(voucher_number) = '$next_main'
    ");

    $next_sub = $next_main + 0.1; // default first sub: 174.1
    if ($qry_sub && $qry_sub->num_rows > 0) {
        $res2 = $qry_sub->fetch_assoc();
        if ($res2['max_sub'] !== null && $res2['max_sub'] !== '') {
            // add 0.1 to the current max sub
            // use float arithmetic then format with one decimal
            $next_sub = (float)$res2['max_sub'] + 0.1;
        }
    }

    // ensure one decimal place and dot as decimal separator
    $voucher_number = number_format($next_sub, 1, '.', ''); // e.g. "174.2"
}
?>



<?php 

$val = $_settings->userdata('year_id'); // বর্তমান বছর
$journal_type = 'dv';

// Step 1: সর্বশেষ main voucher number বের করা (integer অংশ)
$qry_year = $conn->query("
    SELECT MAX(FLOOR(voucher_number)) AS main_vn
    FROM journal_entries
    WHERE year_id = '$val'
    AND journal_type = '$journal_type'
");

if($qry_year->num_rows > 0){
    $res1 = $qry_year->fetch_assoc();
    if(!empty($res1['main_vn'])){
        $v1 = $res1['main_vn'] + 1; // database থেকে সর্বশেষ main voucher
    } 
}

// Step 2: main voucher এর অধীনে সর্বশেষ sub voucher বের করা
$qry_sub = $conn->query("
    SELECT MAX(voucher_number) AS sub_vn
    FROM journal_entries
    WHERE year_id = '$val'
    AND journal_type = '$journal_type'
    AND FLOOR(voucher_number) = '$v1'
");

if($qry_sub->num_rows > 0){
    $res2 = $qry_sub->fetch_assoc();
    if(!empty($res2['sub_vn'])){
        // previous sub voucher থেকে 0.1 increment
        $voucher_number = number_format($res2['sub_vn'] + 0.1, 1);
    } else {
        // প্রথম sub voucher
        $voucher_number = number_format($v1 + 0.1, 1);
    }
} else {
    $voucher_number = number_format($v1 + 0.1, 1);
}

// $voucher_number এখন auto-generated: 150.1, 150.2, 150.3 ...
echo $voucher_number;


?>