app.controller('maintainedCtrl', function($scope, $http, toaster, ModalService, CONFIG) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;
/** ################################################################################## */
	$scope._ = _;
	
	$scope.selectedVehicle = '';
	$scope.date = [];
	$scope.tiresList = [];
	$scope.leakList = [];
	$scope.radiatorList = [];
	$scope.oilList = [];
	$scope.brakeClutchList = [];
	$scope.batteryList = [];
	$scope.windshieldList = [];
	$scope.fuelList = [];
	$scope.gaugesList = [];
	$scope.lightsList = [];
	$scope.oxygenList = [];
	$scope.sirenList = [];
	$scope.radioList = [];
	$scope.damageList = [];
	$scope.isWashedList = [];

	$scope.renderTable = function () {
		$scope.date = [];
		$scope.tiresList = [];
		$scope.leakList = [];
		$scope.radiatorList = [];
		$scope.oilList = [];
		$scope.brakeClutchList = [];
		$scope.batteryList = [];
		$scope.windshieldList = [];
		$scope.fuelList = [];
		$scope.gaugesList = [];
		$scope.lightsList = [];
		$scope.oxygenList = [];
		$scope.sirenList = [];
		$scope.radioList = [];
		$scope.damageList = [];
		$scope.isWashedList = [];

        console.log($scope.selectedVehicle);

		$http.get(baseUrl + '/maintained/ajaxchecklist/' + $('#check_date').val() + '/' + $scope.selectedVehicle)
	    .then(function (res) {
	        let checkList = res.data.dailycheck;
        	console.log(checkList);

        	angular.forEach (checkList, function (list) {
			    let arrCheckDate = list.check_date.split('-');
			    let checkdate = parseInt(arrCheckDate[2]);

			    $scope.date.push(checkdate);

			    $scope.tiresList.push({
					date: checkdate,
					state: list.tires,
					text: list.tires_text
				});

				$scope.leakList.push({
					date: list.check_date,
					state: list.leak,
					text: list.leak_text
				});

				$scope.radiatorList.push({
					date: list.check_date,
					state: list.radiator,
					text: list.radiator_text
				});

				$scope.oilList.push({
					date: list.check_date,
					state: list.oil,
					text: list.oil_text
				});

					$scope.brakeClutchList.push({
						date: list.check_date,
						state: list.brake_clutch,
						text: list.brake_clutch_text
					});

					$scope.batteryList.push({
						date: list.check_date,
						state: list.battery,
						text: list.battery_text
					});

					$scope.windshieldList.push({
						date: list.check_date,
						state: list.windshield,
						text: list.windshield_text
					});

					$scope.fuelList.push({
						date: list.check_date,
						state: list.fuel,
						text: list.fuel_text
					});

					$scope.gaugesList.push({
						date: list.check_date,
						state: list.gauges,
						text: list.gauges_text
					});

					$scope.lightsList.push({
						date: list.check_date,
						state: list.lights,
						text: list.lights_text
					});

					$scope.oxygenList.push({
						date: list.check_date,
						state: list.oxygen,
						text: list.oxygen_text
					});

					$scope.sirenList.push({
						date: list.check_date,
						state: list.siren,
						text: list.siren_text
					});

					$scope.radioList.push({
						date: list.check_date,
						state: list.radio,
						text: list.radio_text
					});

					$scope.damageList.push({
						date: list.check_date,
						state: list.damage,
						text: list.damage_text
					});

					$scope.isWashedList.push({
						date: list.check_date,
						state: list.is_washed
					});
			})
        });
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

    $scope.checkListPopup = function (list) {
    	console.log(list);
	    var popup = document.getElementById("myPopup");
	    if (list.text != null) {
	    	popup.textContent = list.text;
	    	popup.classList.toggle("show");
	    }
    }
})
// .directive('toggle', function(){
//   return {
//     restrict: 'A',
//     link: function(scope, element, attrs){
//       if (attrs.toggle=="tooltip"){
//         $(element).tooltip();
//       }
//       if (attrs.toggle=="popover"){
//         $(element).popover();
//       }
//     }
//   };
// });