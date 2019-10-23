app.controller('fuelCtrl', function($scope, $http, toaster, ModalService, CONFIG) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;
/** ################################################################################## */
    $scope._ = _;

    /** FORM VALIDATION */
    $scope.formError = null;
    $scope.newFuel = {
        department: '1',
        vehicle: '',
        fuelType: '',
        billNo: '',
        billDate: '',
        volume: '',
        unitPrice: '',
        total: '',
        jobDesc: '',
    };

    $scope.jobDescText = {
        ambulance   : 'รับ-ส่งผู้ป่วย/Refer ผู้ป่วย',
        gardener    : 'ภาคสนาม',
        general     : 'รับ-ส่งเอกสารและเจ้าหน้าที่',
        director    : 'รับ-ส่งผู้อำนวยการ',
        lab         : 'ไปส่ง LAB, เบิกเบือด และราชการอื่นๆ ที่ รพ.มหาราช',
        supply      : 'รับ-ส่งเซตหัตถการ งานจ่ายกลาง',
        laundry     : 'รับ-ส่งผ้าผู้ป่วย งานซักฟอก',
        electric    : 'เติมเครื่องปั่นไฟฟ้าสำรอง งานช่างซ่อมบำรุง'
    }

    $scope.loadEditData = function () {
        $scope.newFuel.department = $("#department:checked").val()
        $scope.newFuel.vehicle = $("#vehicle").val()
        $scope.newFuel.fuelType = $("#fuel_type").val()
        $scope.newFuel.billNo = $("#bill_no").val()
        $scope.newFuel.billDate = $("#bill_date").val()
        $scope.newFuel.volume = $("#volume").val()
        $scope.newFuel.unitPrice = $("#unit_price").val()
        $scope.newFuel.total = $("#total").val()
        $scope.newFuel.jobDesc = $("#job_desc").val()
    }

    $scope.formValidate = function (event) {
        event.preventDefault();

        $scope.newFuel.billDate = $('#bill_date').val();
        
        var req_data = {
            department: $scope.newFuel.department,
            vehicle_id: $scope.newFuel.vehicle,
            fuel_type: $scope.newFuel.fuelType,
            bill_no: $scope.newFuel.billNo,
            bill_date: $scope.newFuel.billDate,
            volume: $scope.newFuel.volume,
            unit_price: $scope.newFuel.unitPrice,
            total: $scope.newFuel.total,
            job_desc: $scope.newFuel.jobDesc,
        };
        console.log(req_data);

        $http.post(baseUrl + '/fuel/validate', req_data)
        .then(function (res) {
            // console.log(res);
            $scope.formError = res.data;
            console.log($scope.formError);

            if ($scope.formError.success === 1) {
                let formId = $(event.target).closest("form").attr("id")
                $("#"+formId).submit();
            } else {
                toaster.pop('error', "", "คุณกรอกข้อมูลไม่ครบ !!!");
            }
        })
        .catch(function (res) {
            console.log(res);
        });
    }

    $scope.checkValidate = function (field) {
        var status = false;

        status = ($scope.formError && $scope.newFuel[field] === '') ? true : false;

        return status;
    }

    // $scope.frmAllVehicles = [];
    // $scope.frmVehicle = null;
    // $scope.frmVehicleDetail = '';
    // $scope.popUpAllVehicle = function () {
    //     $http.get(baseUrl + '/ajaxvehicles')
    //     .then(function (res) {
    //         console.log(res);
    //         $scope.frmAllVehicles = res.data.vehicles;
    //         console.log($scope.frmAllVehicles);
    //         $('#dlgAllVehicle').modal('show');
    //     });
    // }

    $scope.setJobDescWithVehicle = function () {
        console.log($scope.newFuel.vehicle)

        if ($scope.newFuel.vehicle == '1' || $scope.newFuel.vehicle == '6' || $scope.newFuel.vehicle == '7' || $scope.newFuel.vehicle == '13') {
            $("#job_desc").val($scope.jobDescText.ambulance)
            $scope.newFuel.jobDesc = $scope.jobDescText.ambulance
        } else if ($scope.newFuel.vehicle == '2') {
            $("#job_desc").val($scope.jobDescText.director)
            $scope.newFuel.jobDesc = $scope.jobDescText.director
        } else if ($scope.newFuel.vehicle == '9' || $scope.newFuel.vehicle == '90') {
            $("#job_desc").val($scope.jobDescText.gardener)
            $scope.newFuel.jobDesc = $scope.jobDescText.gardener
        } else if ($scope.newFuel.vehicle == '12') {
            $("#job_desc").val($scope.jobDescText.supply)
            $scope.newFuel.jobDesc = $scope.jobDescText.supply
        } else if ($scope.newFuel.vehicle == '15') {
            $("#job_desc").val($scope.jobDescText.laundry)
            $scope.newFuel.jobDesc = $scope.jobDescText.laundry
        } else if ($scope.newFuel.vehicle == '91') {
            $("#job_desc").val($scope.jobDescText.electric)
            $scope.newFuel.jobDesc = $scope.jobDescText.electric
        } else {
            $("#job_desc").val($scope.jobDescText.general)
            $scope.newFuel.jobDesc = $scope.jobDescText.general
        }
    }

    $scope.calculateTotal = function () {
        console.log(event.target)
        _total =(parseFloat($("#volume").val()) * parseFloat($(event.target).val())).toFixed(2)
        console.log(_total)
        $("#total").val(_total)
        $scope.newFuel.total = _total
    }

    $scope.frmSetVehicle = function (vehicle) {
        $('#vehicle_id').val(vehicle.vehicle_id);       
        console.log($('#vehicle_id').val());

        $scope.frmVehicle = vehicle;
        $scope.frmVehicleDetail = vehicle.cate.vehicle_cate_name;
        $scope.frmVehicleDetail += ' ประเภท ' + vehicle.type.vehicle_type_name;
        $scope.frmVehicleDetail += ' ' + vehicle.manufacturer.manufacturer_name;
        $scope.frmVehicleDetail += ' ' + vehicle.model;
        $scope.frmVehicleDetail += ' ทะเบียน ' + vehicle.reg_no + vehicle.changwat.short;
        
        $('#dlgAllVehicle').modal('hide');
    }

    $scope.paginate = function (event, url) {
        if ($(event.target).closest('li').hasClass('disabled')) {
            event.preventDefault();
        } else {
            $http.get(url).then(function (res) {
                console.log(res);
                $scope.frmAllVehicles = res.data.vehicles;
                // console.log($scope.frmAllVehicles);
            });
        }
    }
/** ################################################################################## */
    /** CRUD ACTION */
    $scope.delete = function (event, id) {
        console.log(event);     
        event.preventDefault();

        if (confirm('คุณต้องการลบข้อมูล ID ' + id +' ใช่หรือไม่?')) {
            document.getElementById(id + '-delete-form').submit();
        }
    }

    $scope.cancel = function (event, id) {
        console.log(event);     
        event.preventDefault();

        if (confirm('คุณต้องการยกเลิกข้อมูล ID ' + id +' ใช่หรือไม่?')) {
            document.getElementById(id + '-cancel-form').submit();
        }
    }

    $scope.recover = function (event, id) {
        console.log(event);     
        event.preventDefault();

        if (confirm('คุณต้องการนำข้อมูล ID ' + id +' กลับมาใหม่ใช่หรือไม่?')) {
            document.getElementById(id + '-recover-form').submit();
        }
    }
/** ################################################################################## */
});
