<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <title>ใบขออนุญาตใช้รถยนต์ส่วนกลาง</title>
        <meta content="MSHTML 6.00.2900.5726" name=GENERATOR>
        <meta http-equiv=Content-Type content="text/html; charset=utf-8">
        <link type="text/css" rel="stylesheet" href="./print_php_files/styles.css" media="screen">        
        <script language=JavaScript src="./print_php_files/script.js"></script>
        <script language=JavaScript>
            // window.print();
        </script>
            
    </head>

    <body>
        <?php
        $tmp30 = 0;
        $tmp31 = 0;
        $tmp32 = 0;
        $tmp36 = 0;
        $tmp10 = 0;
        $tmpOth = 0;
        
        // Set connect db
        $db = new PDO("mysql:host=localhost; dbname=vehicle_db; charset=utf8", 'root', '1');
        $db->exec("set names utf8");
        $db->exec("COLLATE utf8_general_ci");

        $sql = "select * from changwat where chw_id IN (SELECT changwat from locations) ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);            
        foreach ($row as $ch) {
        	echo $ch['chw_id']. '-' .$ch['changwat']. '<br>';
        }

        $sql = "select * from reservations where from_date BETWEEN '2017-10-01' AND '2018-09-21'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $r) {
            $loc_list = "";
            $locations = explode(',', $r['location']);

            // foreach ($locations as $l) {
                $sql = "select l.*, c.changwat as chwname, a.amphur as ampname, t.tambon as tamname
                        from locations l 
                        left join changwat c on (l.changwat=c.chw_id)
                        left join amphur a on (l.amphur=a.id)
                        left join tambon t on (l.tambon=t.id)
                        where (l.id=:id)";
                $stmt = $db->prepare($sql);
                // $stmt->bindValue(':id', $l);
                $stmt->bindValue(':id', $locations[0]);
                $stmt->execute();
                $loc = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($loc['changwat']=='30') {
                	$tmp30 = $tmp30 + 1;
                } else if ($loc['changwat']=='31') {
                	$tmp31 = $tmp31 + 1;
                } else if ($loc['changwat']=='32') {
                	$tmp32 = $tmp32 + 1;
                } else if ($loc['changwat']=='36') {
                	$tmp36 = $tmp36 + 1;
                } else if ($loc['changwat']=='10' || $loc['changwat']=='11' || $loc['changwat']=='12' || $loc['changwat']=='13') {
                	$tmp10 = $tmp10 + 1;
                } else {
                	$tmpOth = $tmpOth + 1;
                }
            // }
        }

        echo 'นครราชสีมา = '.$tmp30. '<br>';
        echo 'บุรีรัมย์ = '.$tmp31. '<br>';
        echo 'สุรินทร์ = '.$tmp32. '<br>';
        echo 'ชัยภูมิ = '.$tmp36. '<br>';
        echo 'กทม. = '.$tmp10. '<br>';
        echo 'อื่นๆ = '.$tmpOth;
    ?>
    </body>
</html>