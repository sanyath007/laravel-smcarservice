<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <title>ใสรุปรายงานการใช้น้ำมันเชื้อเพลิง</title>
        <meta content="MSHTML 6.00.2900.5726" name="GENERATOR">
        <meta http-equiv=Content-Type content="text/html; charset=utf-8">
        <link type="text/css" rel="stylesheet" href="./print_php_files/styles.css" media="screen">
        <style type="text/css" media="print">
            body {
                -webkit-print-color-adjust: exact;
            }
            @page { 
                size: 8.5in 11in; margin: 1cm 
            }
            .page {
                margin: 0px; 
                margin-bottom: 20px;
                /*border: 1px solid #000;*/
                /*height: 100%;*/
                page-break-after: always;
            }
            .datatable {
                border-collapse: collapse; 
                border: 1px solid black;
                font-family:"TH SarabunPSK";
                font-size:16pt;
            }
            .thaitext {
                font-size: 15pt; 
                color: #000000; 
                font-family: "TH SarabunPSK";
            }
            .thaitext-sm {
                font-size: 12pt; 
                color: #000000; 
                font-family: "TH SarabunPSK";
            }
        </style>           
        <script language=JavaScript src="./print_php_files/script.js"></script>
        <script language=JavaScript>
            // window.print();
        </script>
            
    </head>

    <body>
        <?php
            // Read db config
            require './config.php';
            
            // Set the PDO error mode to exception
            $sql = "select 
                    DATE_FORMAT(vf.bill_date,'%d') AS date,
                    DATE_FORMAT(vf.bill_date,'%m') AS month,
                    DATE_FORMAT(vf.bill_date,'%Y')+543 AS year, 
                    vf.id, vf.department, vf.vehicle_id, vf.fuel_type_id, vf.bill_no, vf.bill_date,  
                    vf.volume, vf.unit_price, vf.total, vf.job_desc, vf.remark, v.reg_no
                    FROM vehicle_fuel vf LEFT JOIN vehicles v ON (vf.vehicle_id=v.vehicle_id)
                    WHERE (vf.bill_date BETWEEN '" .$_GET['_month']. "-16' AND '" .$_GET['_month']. "-31') 
                    AND (vf.status NOT IN ('2','3'))
                    ORDER BY vf.bill_date, vf.bill_no";

            $stmt = $db->prepare($sql);
            // $stmt->bindValue(':id', $_GET['id']);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
               echo $e->getMessage();
            }

            $vehicle_type = [
                '1' => 'รถกระบะ', 
                '2' => 'รถตู้ 12 ที่นั่ง', 
                '3' => 'รถพยาบาล'
            ];
            
            $_month = explode('-', $_GET['_month']);
            $lastDayInMonth = date("t", strtotime($_GET['_month'].'-1'));
        ?>
        <div class="page" align="center">
            <div class="page-layout">
                <div style="padding: 0 5 0 5px;">

                    <!--<table width="100%">
                        <tr>
                            <td width="527"></td>
                            <td>
                                <p align="right" class="formnumber">QF-ICT-45 <br> updated 20/10/2559</p>
                            </td>
                        </tr>
                    </table>-->

                    <table width="100%" border="0" class="thaitext">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <b class="p20"><center>สรุปรายงานการใช้น้ำมันเชื้อเพลิง   รอบวันที่ 16-<?=$lastDayInMonth?> <?=thaimonth($_month[1]). ' ' .(((int)$_month[0]) + 543); ?>
                                    <br>งานยานพาหนะ  กลุ่มงานบริหารทั่วไป  โรงพยาบาลเทพรัตน์นครราชสีมา</center></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /HEADER -->
                
                <div style="padding: 0 5 5 5px;"><!-- DETAIL -->
                    <table width="100%">
                        <tr>
                            <td>
                                
                                <table border="1" width="100%" class="datatable">
                                    <tr>
                                        <th style="width: 4%; text-align: center;">ลำดับ</th>
                                        <th style="width: 14%; text-align: center;">วันที่</th>
                                        <th style="width: 10%; text-align: center;">ทะเบียนรถ</th>
                                        <th style="width: 12%; text-align: center;">เลขบิล</th>
                                        <th style="width: 10%; text-align: center;">จำนวนลิตร</th>
                                        <th style="width: 10%; text-align: center;">ราคา/ลิตร</th>
                                        <th style="width: 12%; text-align: center;">ราคารวม</th>
                                        <th style="text-align: center;">งานที่ปฏิบัติ</th>
                                        <!-- <th>หมายเหตุ</th> -->
                                    </tr>
                                    <?php 
                                        $cx = 0;
                                        $tmpVolume = 0;
                                        $tmpUnitPrice = 0;
                                        $tmpTotal = 0;
                                        $fuels = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($fuels as $fuel) :
                                            if ($fuel['department'] == 1) :
                                                $tmpVolume += (float)$fuel['volume'];
                                                $tmpUnitPrice += (float)$fuel['unit_price'];
                                                $tmpTotal += (float)$fuel['total'];
                                    ?>
                                            <tr>
                                                <td style="text-align: center;"><?=++$cx ?></td>
                                                <td style="text-align: center;"><?=$fuel['bill_date'] ?></td>
                                                <td style="text-align: center;">
                                                    <span <?=(($fuel['vehicle_id']=='90' || $fuel['vehicle_id']=='91') ? 'class="thaitext-sm"' : '');?>>
                                                        <?=$fuel['reg_no'] ?>
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?=$fuel['bill_no'] ?>
                                                </td>
                                                <td style="text-align: center;"><?=$fuel['volume'] ?></td>
                                                <td style="text-align: center;"><?=$fuel['unit_price'] ?></td>
                                                <td style="text-align: center;"><?=number_format($fuel['total'],2) ?></td>
                                                <td style="padding: 2px;"><?=$fuel['job_desc'] ?></td>
                                            </tr>

                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <tr>
                                        <td style="text-align: center;" colspan="4">รวม</td>
                                        <td style="text-align: center;"><?=number_format($tmpVolume,2) ?></td>
                                        <td style="text-align: center;"><?=number_format($tmpUnitPrice,2) ?></td>
                                        <td style="text-align: center;"><?=number_format($tmpTotal,2) ?></td>
                                        <td style="background-color: #848484 !important;" colspan="2"></td>
                                    </tr>

                                </table>
                                         
                            </td>
                        </tr>               
                    </table><br>

                    <?=(($cx > 19 && $cx < 25) ? '<hr style="page-break-after: always;">' : '') ?>

                    <table width="100%" border="0" class="thaitext">
                        <tbody>
                            <tr>
                                <td width="50%" style="vertical-align: top;">
                                    <p style="margin: 5 0 0 15px; padding: 0px; font-weight: bold;">
                                        พนักงานขับรถยนต์
                                    </p>
                                    <p style="margin: 5 0 0 15px; padding: 0px;">
                                        ลงชื่อ............................  ลงชื่อ............................
                                    </p>
                                    <p style="margin: 5 0 0 15px; padding: 0px;">
                                        ลงชื่อ............................  ลงชื่อ............................
                                    </p>
                                    <p style="margin: 5 0 0 15px; padding: 0px;">
                                        ลงชื่อ............................  ลงชื่อ............................
                                    </p>
                                    <p style="margin: 5 0 0 15px; padding: 0px;">
                                        ลงชื่อ............................  ลงชื่อ............................
                                    </p>                                               
                                </td>
                                <td width="50%" style="vertical-align: top;">
                                    <p style="margin: 5 0 0 15px; padding: 0px; font-weight: bold;">
                                        &nbsp;
                                    </p>
                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................ผู้จัดทำ
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        (&nbsp;&nbsp;&nbsp;นางวิภา&nbsp;&nbsp;พยอมใหม่&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 100px; padding: 0px;">
                                        เจ้าพนักงานธุรการ
                                    </p>

                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................ผู้ตรวจสอบ
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        (&nbsp;&nbsp;&nbsp;นายสัญญา&nbsp;&nbsp;ธรรมวงษ์&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        นักจัดการงานทั่วไปปฏิบัติการ
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table><br>                    
                
                </div><!-- /DETAIL -->

            </div> <!-- end page-layout -->
        </div>  <!-- end page -->

        <!-- วัดบูรพ์ -->
        <div class="page" align="center">
            <div class="page-layout">
                <div style="padding: 0 5 0 5px;">

<!--                    <table width="100%">
                        <tr>
                            <td width="527"></td>
                            <td>
                                <p align="right" class="formnumber">QF-ICT-45 <br> updated 20/10/2559</p>
                            </td>
                        </tr>
                    </table>-->

                    <table width="100%" border="0" class="thaitext">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <b class="p20"><center>สรุปรายงานการใช้น้ำมันเชื้อเพลิง   รอบวันที่ 16-<?=$lastDayInMonth?> <?=thaimonth($_month[1]). ' ' .(((int)$_month[0]) + 543); ?>
                                    <br>ศูนย์สุขภาพชุมชนเมือง 3 วัดบูรพ์  โรงพยาบาลเทพรัตน์นครราชสีมา</center></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /HEADER -->
                
                <div style="padding: 0 5 5 5px;"><!-- DETAIL -->
                    <table width="100%">
                        <tr>
                            <td>
                                
                                <table border="1" width="100%" class="datatable">
                                    <tr>
                                        <th style="width: 4%; text-align: center;">ลำดับ</th>
                                        <th style="width: 14%; text-align: center;">วันที่</th>
                                        <th style="width: 10%; text-align: center;">ทะเบียนรถ</th>
                                        <th style="width: 12%; text-align: center;">เลขบิล</th>
                                        <th style="width: 10%; text-align: center;">จำนวนลิตร</th>
                                        <th style="width: 10%; text-align: center;">ราคา/ลิตร</th>
                                        <th style="width: 12%; text-align: center;">ราคารวม</th>
                                        <th style="text-align: center;">งานที่ปฏิบัติ</th>
                                        <!-- <th>หมายเหตุ</th> -->
                                    </tr>
                                    <?php 
                                        $cx = 0;
                                        $tmpVolume = 0;
                                        $tmpUnitPrice = 0;
                                        $tmpTotal = 0;
                                        foreach ($fuels as $fuel) :
                                            if ($fuel['department'] == 2) :
                                                $tmpVolume += (float)$fuel['volume'];
                                                $tmpUnitPrice += (float)$fuel['unit_price'];
                                                $tmpTotal += (float)$fuel['total'];
                                    ?>
                                                <tr>
                                                    <td style="text-align: center;"><?=++$cx ?></td>
                                                    <td style="text-align: center;"><?=$fuel['bill_date'] ?></td>
                                                    <td style="text-align: center;">
                                                        <?=$fuel['reg_no'] ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?=$fuel['bill_no'] ?>
                                                    </td>
                                                    <td style="text-align: center;"><?=$fuel['volume'] ?></td>
                                                    <td style="text-align: center;"><?=$fuel['unit_price'] ?></td>
                                                    <td style="text-align: center;"><?=number_format($fuel['total'],2) ?></td>
                                                    <td style="padding: 2px;"><?=$fuel['job_desc'] ?></td>
                                                </tr>

                                            <?php endif ?>
                                    <?php endforeach; ?>

                                    <tr>
                                        <td style="text-align: center;" colspan="4">รวม</td>
                                        <td style="text-align: center;"><?=number_format($tmpVolume,2) ?></td>
                                        <td style="text-align: center;"><?=number_format($tmpUnitPrice,2) ?></td>
                                        <td style="text-align: center;"><?=number_format($tmpTotal,2) ?></td>
                                        <td style="background-color: #848484 !important;" colspan="2"></td>
                                    </tr>

                                </table>
                                         
                            </td>
                        </tr>               
                    </table><br>

                    <table width="100%" border="0" class="thaitext">
                        <tbody>
                            <tr>
                                <td width="50%" style="vertical-align: top;">
                                    <p style="margin: 5 0 0 15px; padding: 0px; font-weight: bold;">
                                        พนักงานขับรถยนต์
                                    </p>
                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................
                                    </p>
                                    <p style="margin: -3 2 2 -35px; padding: 0px; text-align: center;">
                                        (&nbsp;&nbsp;&nbsp;นายสมควร&nbsp;&nbsp;ปวงกลาง&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 105px; padding: 0px;">
                                        พนักงานขับรถยนต์
                                    </p>                                          
                                </td>
                                <td width="50%" style="vertical-align: top;">
                                    <p style="margin: 5 0 0 15px; padding: 0px; font-weight: bold;">
                                        &nbsp;
                                    </p>
                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................ผู้จัดทำ
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        (&nbsp;&nbsp;&nbsp;นางวิภา&nbsp;&nbsp;พยอมใหม่&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 100px; padding: 0px;">
                                        เจ้าพนักงานธุรการ
                                    </p>

                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................ผู้ตรวจสอบ
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        (&nbsp;&nbsp;&nbsp;นายสัญญา&nbsp;&nbsp;ธรรมวงษ์&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        นักจัดการงานทั่วไปปฏิบัติการ
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>                    
                
                </div><!-- /DETAIL -->

            </div> <!-- end page-layout -->
        </div>  <!-- end page -->

        <!-- ราชภัฎ -->
        <div class="page" align="center">
            <div class="page-layout">
                <div style="padding: 0 5 0 5px;">

                    <!--<table width="100%">
                        <tr>
                            <td width="527"></td>
                            <td>
                                <p align="right" class="formnumber">QF-ICT-45 <br> updated 20/10/2559</p>
                            </td>
                        </tr>
                    </table>-->

                    <table width="100%" border="0" class="thaitext">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <b class="p20"><center>สรุปรายงานการใช้น้ำมันเชื้อเพลิง   รอบวันที่ 16-<?=$lastDayInMonth?> <?=thaimonth($_month[1]). ' ' .(((int)$_month[0]) + 543); ?>
                                    <br>ศูนย์สุขภาพชุมชนเมือง 9 ราชภัฎ  โรงพยาบาลเทพรัตน์นครราชสีมา</center></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /HEADER -->
                
                <div style="padding: 0 5 5 5px;"><!-- DETAIL -->
                    <table width="100%">
                        <tr>
                            <td>
                                
                                <table border="1" width="100%" class="datatable">
                                    <tr>
                                        <th style="width: 4%; text-align: center;">ลำดับ</th>
                                        <th style="width: 14%; text-align: center;">วันที่</th>
                                        <th style="width: 10%; text-align: center;">ทะเบียนรถ</th>
                                        <th style="width: 12%; text-align: center;">เลขบิล</th>
                                        <th style="width: 10%; text-align: center;">จำนวนลิตร</th>
                                        <th style="width: 10%; text-align: center;">ราคา/ลิตร</th>
                                        <th style="width: 12%; text-align: center;">ราคารวม</th>
                                        <th style="text-align: center;">งานที่ปฏิบัติ</th>
                                        <!-- <th>หมายเหตุ</th> -->
                                    </tr>
                                    <?php 
                                        $cx = 0;
                                        $tmpVolume = 0;
                                        $tmpUnitPrice = 0;
                                        $tmpTotal = 0;
                                        foreach ($fuels as $fuel) :
                                            if ($fuel['department'] == 3) :
                                                $tmpVolume += (float)$fuel['volume'];
                                                $tmpUnitPrice += (float)$fuel['unit_price'];
                                                $tmpTotal += (float)$fuel['total'];
                                    ?>
                                                <tr>
                                                    <td style="text-align: center;"><?=++$cx ?></td>
                                                    <td style="text-align: center;"><?=$fuel['bill_date'] ?></td>
                                                    <td style="text-align: center;">
                                                        <?=$fuel['reg_no'] ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?=$fuel['bill_no'] ?>
                                                    </td>
                                                    <td style="text-align: center;"><?=$fuel['volume'] ?></td>
                                                    <td style="text-align: center;"><?=$fuel['unit_price'] ?></td>
                                                    <td style="text-align: center;"><?=number_format($fuel['total'],2) ?></td>
                                                    <td style="padding: 2px;"><?=$fuel['job_desc'] ?></td>
                                                </tr>

                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <tr>
                                        <td style="text-align: center;" colspan="4">รวม</td>
                                        <td style="text-align: center;"><?=number_format($tmpVolume,2) ?></td>
                                        <td style="text-align: center;"><?=number_format($tmpUnitPrice,2) ?></td>
                                        <td style="text-align: center;"><?=number_format($tmpTotal,2) ?></td>
                                        <td style="background-color: #848484 !important;" colspan="2"></td>
                                    </tr>

                                </table>
                                         
                            </td>
                        </tr>               
                    </table><br>

                    <table width="100%" border="0" class="thaitext">
                        <tbody>
                            <tr>
                                <td width="50%" style="vertical-align: top;">
                                    <p style="margin: 5 0 0 15px; padding: 0px; font-weight: bold;">
                                        พนักงานขับรถยนต์
                                    </p>
                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................
                                    </p>
                                    <p style="margin: -3 2 2 -35px; padding: 0px; text-align: center;">
                                        (&nbsp;&nbsp;&nbsp;นางสิรินทร&nbsp;&nbsp;พิเศษพงษา&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 50px; padding: 0px;">
                                        เจ้าพนักงานทันตสาธารณสุขชำนาญงาน
                                    </p>                                           
                                </td>
                                <td width="50%" style="vertical-align: top;">
                                    <p style="margin: 5 0 0 15px; padding: 0px; font-weight: bold;">
                                        &nbsp;
                                    </p>
                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................ผู้จัดทำ
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        (&nbsp;&nbsp;&nbsp;นางวิภา&nbsp;&nbsp;พยอมใหม่&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 100px; padding: 0px;">
                                        เจ้าพนักงานธุรการ
                                    </p><br>

                                    <p style="margin: 5 0 0 40px; padding: 0px;">
                                        ลงชื่อ.....................................................ผู้ตรวจสอบ
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        (&nbsp;&nbsp;&nbsp;นายสัญญา&nbsp;&nbsp;ธรรมวงษ์&nbsp;&nbsp;&nbsp;)
                                    </p>
                                    <p style="margin: -3 2 2 80px; padding: 0px;">
                                        นักจัดการงานทั่วไปปฏิบัติการ
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>                   
                
                </div><!-- /DETAIL -->

            </div> <!-- end page-layout -->
        </div>  <!-- end page -->

    </body>
</html>