app.controller('insuranceCtrl', function($scope, $http, toaster, ModalService, CONFIG) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;
    $scope._ = _;
/** ################################################################################## */
    /** FORM VALIDATION */
    $scope.formError = null;
    $scope.newInsurance = {
        docNo: '',
        docDate: '',
        vehicleId: '',
        insuranceNo: '',
        company: '',
        insuranceType: '',
        insuranceDetail: '',
        insuranceStartDate: '',
        insuranceStartTime: '',
        insuranceRenewalDate: '',
        insuranceRenewalTime:'',
        insuranceNet: '',
        insuranceStamp: '',
        insuranceVat: '',
        insuranceTotal: ''
    };

    $scope.formValidate = function (event) {
        event.preventDefault();

        $scope.newInsurance.docDate = $('#doc_date').val();
        $scope.newInsurance.insuranceStartDate = $('#insurance_start_date').val();
        $scope.newInsurance.insuranceRenewalDate = $('#insurance_renewal_date').val();
        
        var req_data = {
            doc_no: $scope.newInsurance.docNo,
            doc_date: $scope.newInsurance.docDate,
            vehicle_id: $scope.newInsurance.vehicleId,
            insurance_no: $scope.newInsurance.insuranceNo,
            insurance_company_id: $scope.newInsurance.company,
            insurance_type: $scope.newInsurance.insuranceType,
            insurance_detail: $scope.newInsurance.insuranceDetail,
            insurance_start_date: $scope.newInsurance.insuranceStartDate,
            insurance_start_time: $scope.newInsurance.insuranceStartTime,
            insurance_renewal_date: $scope.newInsurance.insuranceRenewalDate,
            insurance_renewal_time: $scope.newInsurance.insuranceRenewalTime,
            insurance_net: $scope.newInsurance.insuranceNet,
            insurance_stamp: $scope.newInsurance.insuranceStamp,
            insurance_vat: $scope.newInsurance.insuranceVat,
            insurance_total: $scope.newInsurance.insuranceTotal,
        };
        console.log(req_data);

        $http.post(baseUrl + '/insurance/validate', req_data)
        .then(function (res) {
            // console.log(res);
            $scope.formError = res.data;
            console.log($scope.formError);

            if ($scope.formError.success === 1) {
                $('#frmNewInsurance').submit();
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

        status = ($scope.formError && $scope.newInsurance[field] === '') ? true : false;

        return status;
    }

    $scope.frmAllVehicles = [];
    $scope.frmVehicle = null;
    $scope.frmVehicleDetail = '';
    $scope.popUpAllVehicle = function () {
        $http.get(baseUrl + '/ajaxvehicles')
        .then(function (res) {
            console.log(res);
            $scope.frmAllVehicles = res.data.vehicles;
            console.log($scope.frmAllVehicles);
            $('#dlgAllVehicle').modal('show');
        });
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
});
