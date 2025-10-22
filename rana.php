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


===================================



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