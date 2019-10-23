<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <title>ใบขออนุญาตใช้รถยนต์ส่วนกลาง</title>
        <meta content="MSHTML 6.00.2900.5726" name=GENERATOR>
        <meta http-equiv=Content-Type content="text/html; charset=utf-8">
        <link href="print_php_files/styles.css" type=text/css rel=stylesheet>
        
        <style type=text/css>
            body {
                PADDING-RIGHT: 0px; 
                PADDING-LEFT: 0px; 
                PADDING-BOTTOM: 0px; 
                MARGIN: 0px; 
                PADDING-TOP: 0px;
                background-color: #ffffff;
                height: 842px;
            }
            a:link {
                COLOR: #0000ff; 
                TEXT-DECORATION: none
            }
            a:visited {
                COLOR: #005ca2; 
                TEXT-DECORATION: none
            }
            a:active {
                COLOR: #0099ff; 
                TEXT-DECORATION: underline
            }
            a:hover {
                COLOR: #0099ff; 
                TEXT-DECORATION: underline
            }

            @media Print {
                div.page {
                    MARGIN: 0px; 
                    HEIGHT: 100%
                }
            }
            .UnderLine {
                FONT-WEIGHT: normal;
                MARGIN: 1px;
                COLOR: #0000ff;
                BORDER-TOP-STYLE: none;
                BORDER-BOTTOM: black 1px dotted;
                FONT-FAMILY: "TH SarabunPSK";
                BORDER-RIGHT-STYLE: none;
                BORDER-LEFT-STYLE: none;
                HEIGHT: 18px;
                TEXT-ALIGN: center
            }
            .UnderLineLeft {
                FONT-WEIGHT: normal; 
                MARGIN: 1px; 
                COLOR: #0000ff; 
                BORDER-TOP-STYLE: none; 
                BORDER-BOTTOM: black 1px dashed; 
                FONT-FAMILY: "TH SarabunPSK"; 
                BORDER-RIGHT-STYLE: none; 
                BORDER-LEFT-STYLE: none; 
                HEIGHT: 18px; 
                TEXT-ALIGN: left
            }
            .formthaitext {
                FONT-WEIGHT: bold; 
                FONT-SIZE: 15px; 
                COLOR: #000000; 
                FONT-FAMILY: "TH SarabunPSK";
            }
            .textform {
                FONT-SIZE: 11px; 
                COLOR: #000000; 
                FONT-FAMILY: Verdana
            }
            .thaitext {
                FONT-SIZE: 13px; 
                COLOR: #000000; 
                FONT-FAMILY: "TH SarabunPSK";
            }
            .thaitext_small {
                FONT-SIZE: 10px; 
                COLOR: #000000; 
                FONT-FAMILY: "TH SarabunPSK";
            }
            .headthaitext {
                FONT-SIZE: 15px; 
                COLOR: #000000; 
                FONT-FAMILY: "TH SarabunPSK";
            }
            .CordiaUPC {
                FONT-SIZE: 12px; 
                COLOR: #000000; 
                FONT-FAMILY: "TH SarabunPSK";
            }
            .buntuekkorkuam {
                font-size: 29pt; 
                color: #000000; 
                font-family: "TH SarabunPSK"; 
                font-weight:bold;  
                margin-left: -100px;
            }
            .txt-content {
                font-size: 16pt; 
                color: #000000; 
                font-family: "TH SarabunPSK";
            }
            .trh1 {
                height: 30px;
            }
            .trh0 {
                height: 5px;
            }
            p {
                font-size: 16pt; 
                color: #000000; 
                font-family: "TH SarabunPSK"; 
                font-weight: normal;
            }
            .p16 {
                font-size: 16pt; 
                color: #000000; 
                font-family: "TH SarabunPSK"; 
                font-weight: bold;
            }
            .p18 {
                font-size: 18pt; 
                color: #000000; 
                font-family: "TH SarabunPSK"; 
                font-weight: bold;
            }
            .p20 {
                font-size: 20pt; 
                color: #000000; 
                font-family: "TH SarabunPSK"; 
                font-weight: bold;
            }
            .formnumber {
                font-size: 11pt; 
                color: #000000; 
                font-family: "TH SarabunPSK"; 
                font-weight: bold;
                text-align: center;
                border: 1px solid #000000;
                padding: 0 5 0 5px;
            }
            .indent {
                margin-left: 94px;
            }
            .indent2 {
                margin-left: 30px;
            }
            .hasborder { border:1px solid #F00;  }
            .table {
                border: 1px solid #000000;
                border-collapse: collapse;
            }

            p.MsoNormal, li.MsoNormal, div.MsoNormal,span.MsoNormal {
                border-bottom: 1px dashed #000000;
                margin-top:0cm;
                margin-right:0cm;
                margin-bottom:10.0pt;
                margin-left:0cm;
                line-height:115%;
                font-size:16pt;
                font-family:"TH SarabunPSK";
            }
            .UnderlineTagp {
                border-bottom: 1px dashed #000000; 
                padding: 0px; 
                margin:0px;
                height: 20px
            }
        </style>
        
        <script language=JavaScript src="print_php_files/script.js"></script>
        <script language=JavaScript>
            // window.print();
        </script>
            
    </head>

    <body>
        <?php
        $vehicle_type = [
            '1' => 'รถกระบะ', 
            '2' => 'รถตู้ 12 ที่นั่ง', 
            '3' => 'รถพยาบาล'
        ];
        
        // Set connect db
        $db = new PDO("mysql:host=localhost; dbname=vehicle_db; charset=utf8", 'root', '1');
        $db->exec("set names utf8");
        $db->exec("COLLATE utf8_general_ci");
        
        // Set the PDO error mode to exception
        $sql = "select 
        DATE_FORMAT(r.reserve_date,'%d') AS date,
        DATE_FORMAT(r.reserve_date,'%m') AS month,
        DATE_FORMAT(r.reserve_date,'%Y')+543 AS year,
        DATE_FORMAT(r.from_date,'%d') AS sdate,
        DATE_FORMAT(r.from_date,'%m') AS smonth,
        DATE_FORMAT(r.from_date,'%Y')+543 AS syear,
        DATE_FORMAT(r.to_date,'%d') AS edate,
        DATE_FORMAT(r.to_date,'%m') AS emonth,
        DATE_FORMAT(r.to_date,'%Y')+543 AS eyear,
	DATE_FORMAT(r.from_time,'%H:%i') AS start_time, 
	DATE_FORMAT(r.to_time,'%H:%i') AS end_time, 
        r.id, r.activity_type, r.activity, r.location, r.passengers, 
        r.transport, r.startpoint, r.vehicle_type, r.remark,
        CONCAT(t.prefix_name, p.person_firstname, '  ', p.person_lastname) as person_name, 
        pos.position_name, ac.ac_name, p.person_tel, p.person_email, d.depart_name
        #, w.ward_name
        from reservations r
	left outer join db_ksh.personal p ON (r.user_id=p.person_id)
        left outer join db_ksh.prefix t ON (p.person_prefix = t.prefix_id)
        #left outer join db_ksh.ward w ON (w.ward_id = p.office_id)
        left outer join db_ksh.depart d ON (r.department = d.depart_id)
        left outer join db_ksh.position pos ON (p.position_id = pos.position_id)
        left outer join db_ksh.academic ac ON (p.ac_id = ac.ac_id)
        where r.id=:id ";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        try {
            $stmt->execute();
           // var_dump($stmt);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
           // var_dump($row);            
            $sdate = (int)$row['sdate'];
            $smonth = $row['smonth'];
            $syear = $row['syear'];            
            $start_time = $row['start_time'];

            $edate = (int)$row['edate'];
            $emonth = $row['emonth'];
            $eyear = $row['eyear'];        
            $end_time = $row['end_time'];
            
            $count = 0;
            $loc_list = "";
            $loc_tam = "";
            $loc_amp = "";
            $loc_chw = "";
            $locations = explode(',', $row['location']);
            foreach ($locations as $l) {
                $sql = "select l.*, c.changwat as chwname, a.amphur as ampname, t.tambon as tamname
                        from locations l 
                        left join changwat c on (l.changwat=c.chw_id)
                        left join amphur a on (l.amphur=a.id)
                        left join tambon t on (l.tambon=t.id)
                        where (l.id=:id)";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $l);
                $stmt->execute();
                // var_dump($stmt);

                $loc = $stmt->fetch(PDO::FETCH_ASSOC);
                // var_dump($l);      
                // var_dump($loc);      

                if (count($locations) > 1) {
                    if ($count <= 5) {
                        $loc_list .= $loc['name']. ', ';
                    } else if ($count == 6) {
                        $loc_list .= '...';
                    }
                } else {
                    $loc_list = $loc['name'];
                }

                // ใช้ที่อยู่ของสถานที่หลัก
                if ($count == 0) {
                    $loc_tam = $loc['tamname'];
                    $loc_amp = $loc['ampname'];
                    $loc_chw = $loc['chwname'];
                }

                $count++;
            }

            $sql = "select p.*, r.reserve_id, r.status, t.prefix_name, pos.position_name, ac.ac_name, w.ward_name
                        from reserve_passengers r 
                        left outer join db_ksh.personal p ON (r.person_id=p.person_id)
                        left outer join db_ksh.prefix t ON (p.person_prefix = t.prefix_id)
                        left outer join db_ksh.ward w ON (w.ward_id = p.office_id)
                        #left outer join db_ksh.depart d ON (r.department = d.depart_id)
                        left outer join db_ksh.position pos ON (p.position_id = pos.position_id)
                        left outer join db_ksh.academic ac ON (p.ac_id = ac.ac_id)
                        where (r.reserve_id=:id) and (r.status <> '1')";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $row['id']);
            $stmt->execute();
            $passengers = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            $passenger_num = ($stmt->rowCount() > 0) ? $stmt->rowCount() : '-';
            // var_dump($stmt);
            // var_dump($row);
            // var_dump($passengers);
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
        ?>
        <div class="page" align="center">
            <div style="width: 660px; margin-left: 65px; margin-right: 15px; margin-top: 0px; padding: 5px;">
                <div style="padding: 0 5 0 5px;">

<!--                    <table width="100%">
                        <tr>
                            <td width="527"></td>
                            <td>
                                <p align="right" class="formnumber">QF-ICT-45 <br> updated 20/10/2559</p>
                            </td>
                        </tr>
                    </table>-->
                    
                    <div style="float: right;">
                        <p style="float: left; padding: 0px; margin:0px;">
                            เลขที่..<?php echo $row['id'] ?>..
                        </p>                           
                    </div>

                    <table width="100%">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <b class="p20"><center>ใบขอใช้รถยนต์ส่วนกลาง
                                    <br>โรงพยาบาลเทพรัตน์นครราชสีมา</center></b>
                                </td>
                            </tr>
                            
                            <tr class="trh1">
                                <td colspan="2">
                                    <p style="margin: -10 0 0 470px; padding: 2px;">
                                        วันที่
                                        <?php echo (int)$row['date']; ?>  <?php echo thaimonth($row['month']); ?>  <?php echo $row['syear']; ?>
                                    </p>
                                </td>
                            </tr>
                            
                            <tr class="trh1">
                                <td colspan="2">
                                    <p>
                                        <b class="p18">เรียน</b>&nbsp;&nbsp;ผู้อำนวยการโรงพยาบาลเทพรัตน์นครราชสีมา
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /HEADER -->
                
                <div style="padding: 0 5 5 5px;"><!-- DETAIL -->
                    <table width="100%">
                        <tr>
                            <td>
                                <div class="indent">
                                    <p style="float: left; padding: 0px; margin:0px;">
                                        ข้าพเจ้า
                                    </p>
                                    <p class="UnderlineTagp" style="width: 250px; margin-left: 45px; ">
                                        &nbsp;&nbsp;
                                        <?php echo $row['person_name']; ?>
                                    </p>

                                    <p style="float: left; padding: 0px; margin: -21 0 0 255px;">
                                        ตำแหน่ง
                                    </p>
                                    <p class="UnderlineTagp" style="width: 215px; float: left; padding: 0px; margin:-25 0 0 346px;">
                                        &nbsp;&nbsp;
                                        <?php echo $row['position_name'].$row['ac_name']; ?>
                                    </p>
                                </div>		 
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div style="margin: 2px">
                                    <p style="float: left; padding: 0px; margin: 0px;">
                                        กลุ่มงาน/งาน
                                    </p>
                                    <p class="UnderlineTagp" style="width: 285px; margin-left: 78px;">
                                        &nbsp;&nbsp;
                                        <?php echo $row['depart_name']; ?>
                                    </p>
                                    <p style="float: left; padding: 0px; margin: -21 0 0 290px;">
                                        พร้อมด้วยเจ้าหน้าที่จำนวน
                                    </p>
                                    <p class="UnderlineTagp" style="width: 80px; float: left; padding: 0px; margin:-24 0 0 515px; text-align: center;">
                                        <?php echo $passenger_num; ?>
                                    </p>
                                    <p style="float: left; padding: 0; margin:-24 0 0 597px;">
                                        คน&nbsp;&nbsp;ดังนี้
                                    </p>
                                </div>
                            </td>
                        </tr>
                       <?php $cx = 0; ?>
                       <?php foreach ($passengers as $passenger) : ?>
                            <?php if ($cx < 5) : ?>
                            <tr>
                                <td>
                                    <div style="margin: 2px">                                    
                                        <p style="float: left; padding: 0px; margin: 0px; margin-left: 50px;"><?=($cx += 1); ?>. </p>
                                        <p class="UnderlineTagp" style="width: 295px; margin-left: 65px;">
                                            &nbsp;
                                            <?= $passenger['prefix_name'].$passenger['person_firstname']. '   ' .$passenger['person_lastname']?>
                                        </p>

                                        <p style="float: left; padding: 0px; margin:-21 0 0 305px;">ตำแหน่ง</p>
                                        <p class="UnderlineTagp" style="width: 237px; float: left; padding: 0px; margin:-21 0 0 3px;">
                                            &nbsp;<?= $passenger['position_name'].$passenger['ac_name']; ?>
                                        </p>                                    
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <tr>
                            <td>  
                                <div style="margin: 2px">                              
                                    <p style="float: left; margin:0px; padding: 0px;">
                                        ขออนุญาตใช้รถยนต์ราชการไป (ชื่อสถานที่)
                                    </p>
                                    <p class="UnderlineTagp" style="width: 410px; margin-left: 245px;margin-bottom: 20px;">
                                        <?php echo $loc_list; ?>
                                    </p>
                                </div>
                            </td>
                        </tr>     
                        
                        <tr>
                            <td>
                                <div style="margin: 2px">
                                    <p style="float: left; padding: 0px; margin:0px;">ตำบล</p>
                                    <p class="UnderlineTagp" style="width: 160px; margin-left: 35px;">
                                        &nbsp;&nbsp;
                                        <?php echo $loc_tam; ?>
                                    </p>

                                    <p style="float: left; padding: 0px; margin:-21 0 0 165px;">อำเภอ</p>
                                    <p class="UnderlineTagp" style="width: 160px; float: left; padding: 0px; margin:-21 0 0 3px;">
                                        &nbsp;&nbsp;<?php echo $loc_amp; ?>
                                    </p>
                                    
                                    <p style="float: left; padding: 0px; margin:-21 0 0 167px;">จังหวัด</p>
                                    <p class="UnderlineTagp" style="width: 210px; float: left; padding: 0px; margin:-24 0 0 443px;">
                                        &nbsp;&nbsp;<?= $loc_chw; ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div style="margin: 2px">                          
                                    <p style="float: left; margin:0px; padding: 0px;">
                                        เพื่อออกปฏิบัติราชการ (กิจกรรม)
                                    </p>
                                    <p class="UnderlineTagp" style="width: 465px; margin-left: 190px;margin-bottom: 20px;">
                                        &nbsp;&nbsp;<?php echo $row['activity']; ?>
                                    </p>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div style="margin: 2px">     
                                    <p style="float: left; padding: 0px; margin:0px;">
                                        โดยออกเดินทาง วันที่
                                    </p>
                                    
                                    <p class="UnderlineTagp" style="width: 345px; margin-left: 120px; text-align: center;">
                                        <?php echo $sdate; ?>&nbsp;&nbsp;<?php echo thaimonth($smonth); ?> <?php echo $syear; ?>
                                    </p>
                                    
                                    <p style="float: left; padding: 0px; margin:-21 0 0 350px;">เวลา</p>
                                    <p class="UnderlineTagp" style="width: 160px; float: left; padding: 0px; margin:-24 0 0 495px; text-align: center;">
                                        <?php echo $start_time; ?> น.
                                    </p>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div style="margin: 2px">     
                                    <p style="float: left; padding: 0px; margin:0px;">
                                        กลับถึงโรงพยาบาล วันที่
                                    </p>
                                    
                                    <p class="UnderlineTagp" style="width: 330px; margin-left: 138px; text-align: center;">
                                        <?php echo $edate; ?>&nbsp;&nbsp;<?php echo thaimonth($emonth); ?> <?php echo $eyear; ?>
                                    </p>
                                    
                                    <p style="float: left; padding: 0px; margin:-21 0 0 335px;">เวลา</p>
                                    <p class="UnderlineTagp" style="width: 160px; float: left; padding: 0px; margin:-24 0 0 495px; text-align: center;">
                                        <?php echo $end_time; ?> น.
                                    </p>
                                </div>
                            </td>
                        </tr>                
                        
                        <tr>
                            <td>
                                <p class="indent" style="margin-top: 5px; padding: 2px;">
                                    จึงเรียนมาเพื่อโปรดพิจารณาอนุญาต
                                </p>
                            </td>
                        </tr>
                    </table>

                    <table width="100%" border="0">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <p style="margin: 5 0 0 15px; padding: 2px;">
                                        ลงชื่อ.....................................................ผู้ขออนุญาต
                                    </p>
                                    <p style="margin: -3 2 2 -40px; padding: 0px; text-align: center;">
                                        (&nbsp;&nbsp;&nbsp;<?php echo $row['person_name']; ?>&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    
                                    <p style="float: left; padding: 0px; margin: -5 2 2 15px;">ตำแหน่ง</p>
                                    <p class="UnderlineTagp" style="width: 200px; margin: -5 0 0 65px;">
                                        &nbsp;&nbsp;&nbsp;<?php echo $row['position_name'].$row['ac_name']; ?>
                                    </p>
                                    
                                </td>
                                <td width="50%">
                                    <p style="margin: 5 0 0 15px; padding: 0px;">
                                        ลงชื่อ.....................................................หัวหน้ากลุ่มงาน
                                    </p>
                                    <p style="margin: -3 2 2 -40px; padding: 0px; text-align: center;">
                                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 15px; padding: 0px;">
                                        ตำแหน่ง....................................................
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table><br>
                    
                    <p style="margin: -5 2 2 15px; font-style: italic;">
                        <?php if ($row['remark']) : ?>
                            <b>หมายเหตุ : </b><?php echo $row['remark']; ?>
                        <?php endif; ?>
                        <?php if ($row['startpoint']) : ?>
                            / จุดรับ <?php echo $row['startpoint']; ?>
                        <?php endif; ?>
                        <?php if ($row['vehicle_type']) : ?>
                            / ใช้รถ <?php echo $vehicle_type[$row['vehicle_type']]; ?>
                        <?php endif; ?>
                    </p>
                    
                    <hr style="margin-top: 0; padding-top: 0">

                    <table width="100%" border="0">
                        <tbody>
                            <tr>
                                <td colspan="2" style="padding-top: 5px;">
                                    <p style="margin: -5 2 8 15px; font-weight: bold;">
                                        ความเห็นของผู้ควบคุมการใช้รถ
                                    </p>
                                    <p style="margin: -5 0 8 15px;">
                                        (&nbsp;&nbsp;&nbsp;&nbsp;) เห็นควรอนุญาตให้ใช้รถยนต์ราชการ หมายเลขทะเบียน................................เลขไมล์ที่รถ.............................
                                    </p>
                                    <p style="margin: -5 2 8 15px;">
                                        โดยให้ นาย...................................................................................เป็นพนักงานขับรถยนต์
                                    </p>
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" align="left">
                                    <p style="margin: 5 0 5 60px; padding: 0px;">
                                        ลงชื่อ.....................................................ผู้ควบคุมการใช้รถ
                                    </p>
                                    <p style="margin: -3 0 5 90px; padding: 0px;">
                                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 0 5 60px; padding: 0px;">
                                        ตำแหน่ง....................................................
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <hr>

                    <table width="100%" border="0">
                        <tbody>
                            <tr>                                
                                <td width="50%" style="padding-top: 5px;" align="center">
                                    <p style="margin: 5 0 0 15px; padding: 2px;">
                                        <b style="text-decoration: underline;">คำสั่ง</b>
                                    </p>                                    
                                </td>
                            </tr>

                            <tr>                                
                                <td width="50%" style="padding-top: 15px;" align="center">
                                    <p style="margin: -5 2 2 15px;">
                                        <span style='font-family:"Wingdings 2"'>&pound</span> 
                                        อนุญาต&nbsp;&nbsp;&nbsp;
                                        <span style='font-family:"Wingdings 2"'>&pound</span> 
                                        ไม่อนุญาต&nbsp;&nbsp;&nbsp;
                                    </p>
                                </td>
                            </tr>
                            
                            <tr>
                                <td align="center">
                                    <p style="margin: 5 0 0 0px; padding: 2px;">
                                        .....................................................................
                                    </p>
                                    <p style="margin: -3 2 2 0px; padding: 0px;">
                                        .....................................................................
                                    </p>
                                    <p style="margin: -3 2 2 0px; padding: 0px;">
                                        .....................................................................
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /DETAIL -->

            </div> <!-- end page -->
        </div>	<!-- end page -->
        <?php
        function thainumDigit($num) {
            return str_replace(
                    array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), 
                    array("๐", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙"), 
                    $num
            );
        }

        function thaimonth($monthparam) {
            switch ($monthparam) {
                case 1:
                    $month = 'มกราคม';
                    return $month;
                    break;
                case 2:
                    $month = 'กุมภาพันธ์';
                    return $month;
                    break;
                case 3:
                    $month = 'มีนาคม';
                    return $month;
                    break;
                case 4:
                    $month = 'เมษายน';
                    return $month;
                    break;
                case 5:
                    $month = 'พฤษภาคม';
                    return $month;
                    break;
                case 6:
                    $month = 'มิถุนายน';
                    return $month;
                    break;
                case 7:
                    $month = 'กรกฎาคม';
                    return $month;
                    break;
                case 8:
                    $month = 'สิงหาคม';
                    return $month;
                    break;
                case 9:
                    $month = 'กันยายน';
                    return $month;
                    break;
                case 10:
                    $month = 'ตุลาคม';
                    return $month;
                    break;
                case 11:
                    $month = 'พฤศจิกายน';
                    return $month;
                    break;
                case 12:
                    $month = 'ธันวาคม';
                    return $month;
                    break;
            }
        }
        ?>

    </body>
</html>