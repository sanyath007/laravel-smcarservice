app.controller('reserveCtrl', function($scope, $http, toaster, ModalService, CONFIG) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;
/** ################################################################################## */
    $scope.locationQuery = [];
    $scope.locations = [];
    $scope.locationIds = '';
    $scope.locationItemSelected = null;
    $scope.locationAutocomplete = $('.list-group');

    //################## autocomplete ##################
    $scope.queryLocation = function (event) {
        var output = [];
        var keyword = ($(event.target).val() == '') ? '' : $(event.target).val();
        // console.log(keyword);

        $scope.hidePopupLocation = false;

        if((event.keyCode < 40 || event.keyCode == 8) && keyword == '') {
            $scope.hidePopupLocation = true;
            $scope.locationItemSelected = 0;
            return;
        } else if ($scope.hidePopupLocation === false && event.keyCode === 38) {
            $scope.locationItemSelected = $scope.locationItemSelected - 1;
            $scope.setLocationItemSelected();
        } else if ($scope.hidePopupLocation === false && event.keyCode === 40) {
            $scope.locationItemSelected = $scope.locationItemSelected + 1;
            $scope.setLocationItemSelected();
        } else {
            $http.get(baseUrl + '/location/ajaxquery/' + keyword)
            .then(function (data) {
                // console.log(data);
                $scope.locationQuery = data.data;
                // console.log(this.locationQuery);

                //ใส่ข้อมูลจากากร filter ในตัวแปรสำหรับแสดงผลใน autocomplete
                $scope.filterLocation = $scope.locationQuery;
                // $scope.cursorControl(e);
            });
        }        
    }

    $scope.setLocationItemSelected = function () {
        if ($scope.locationItemSelected === null) {
            $scope.hidePopupLocation = true;
            return;
        }

        if ($scope.locationItemSelected < 0) {
            $scope.locationItemSelected = 0;
        }

        if ($scope.locationItemSelected >= $scope.locationAutocomplete.find('.list-group-item').length) {
            $scope.locationItemSelected = $scope.locationAutocomplete.find('.list-group-item').length - 1
        }

        // console.log($scope.locationAutocomplete.find('.list-group-item').length);
        // console.log($scope.locationItemSelected);
        var prevlistItem = $('.list-group-item, .active');
        var nextListItem = $('.list-group-item')[$scope.locationItemSelected];
        $(prevlistItem).removeClass('active');
        $(nextListItem).addClass('active');
    }

    $scope.enterToAddLocation = function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();

            if ($scope.hidePopupLocation === false) {
                var location = $scope.locationQuery[$scope.locationItemSelected];
                console.log(location);

                if (location != null) {
                    $scope.addLocation(location);
                }

                $(event.target).val('');
                $scope.hidePopupLocation = true;
                $scope.locationItemSelected = null;
            }
        }
    }
    //################## autocomplete ##################

    $scope.addLocation = function(location) {
        let index = $scope.locations.findIndex(l => {
            console.log(l.id + '==' + location.id);
            return l.id==location.id;
        });
        console.log('index :' + index);

        if (index < 0) {
            $scope.locations.push({
                id: location.id,
                name: location.name
            });
        } else {
            toaster.pop('warning', "", "คุณเลือกสถานที่ซ้ำ !!!");
        }

        $scope.createLocationIdList();

        //clear input value
        $('#location').val('');
        //ซ่อน autocomplete
        $scope.hidePopupLocation = true;
    }

    $scope.createLocationIdList = function() {
        var index = 1;
        $scope.locationIds = '';
        angular.forEach($scope.locations, function(location) {
            console.log(index + '==' + $scope.locations.length);
            if (index < $scope.locations.length) {
                $scope.locationIds += location.id + ',';
            } else {
                $scope.locationIds += location.id;
            }

            index++;
        });

        console.log($scope.locationIds);

        $('#locationId').val($scope.locationIds);
    }

    $scope.removeLocation = function (location) {
        // console.log(location);
        let index = $scope.locations.indexOf(location);
        $scope.locations.splice(index, 1);
        console.log($scope.locations);

        $scope.createLocationIdList();
    }

/** ################################################################################## */
    $scope.persons = [];
    $scope.passengerList = [];
    $scope.personItemSelected = null;

    //################## autocomplete ##################
    $scope.queryPersons = function(event) {
        var output = [];
        var keyword = ($(event.target).val() == '') ? '' : $(event.target).val();
        $scope.hidethis = false;

         if((event.keyCode < 40 || event.keyCode == 8) && keyword == '') {
            $scope.personItemSelected = 0;
            $scope.hidethis = true;
            return;
        } else if ($scope.hidethis === false && event.keyCode === 38) {
            $scope.personItemSelected = $scope.personItemSelected - 1;
            $scope.setPersonItemSelected();
        } else if ($scope.hidethis === false && event.keyCode === 40) {
            $scope.personItemSelected = $scope.personItemSelected + 1;
            $scope.setPersonItemSelected();
        } else {
            console.log('keyword = ' + keyword);
            $http.get(baseUrl + '/ajaxperson/' + keyword)
            .then(function (data) {
                // console.log(data);
                $scope.persons = data.data;
                // console.log(this.persons);
            });
        }
    }

    $scope.setPersonItemSelected = function () {
        if ($scope.personItemSelected === null) {
            $scope.hidethis = true;
            return;
        }

        if ($scope.personItemSelected < 0) {
            $scope.personItemSelected = 0;
        }

        if ($scope.personItemSelected >= $scope.locationAutocomplete.find('.list-group-item').length) {
            $scope.personItemSelected = $scope.locationAutocomplete.find('.list-group-item').length - 1
        }

        // console.log($scope.locationAutocomplete.find('.list-group-item').length);
        // console.log($scope.personItemSelected);
        var prevlistItem = $('.list-group-item, .active');
        var nextListItem = $('.list-group-item')[$scope.personItemSelected];
        $(prevlistItem).removeClass('active');
        $(nextListItem).addClass('active');
    }

    $scope.enterToAddPassengers = function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();

            if ($scope.hidethis === false) {
                var person = $scope.persons[$scope.personItemSelected];
                console.log(person);

                if (location != null) {
                    $scope.addPassenger(person);
                }

                $(event.target).val('');
                $scope.hidethis = true;
                $scope.personItemSelected = null;
            }
        }
    }

    $scope.addPassenger = function(person) {
        console.log(person);
        if (person) {
            $scope.passengerList.push(person);
            //ซ่อน autocomplete
            $scope.hidethis = true;
            //เคลียร์ค่าใน text searchProduct
            $('#searchPassenger').val('');            
            //นับจำนวนผู้ร่วมเดินทาง
            $scope.countAllPassengers();
            console.log($('#passengers').val());
        }
    }

    // ลบรายการ
    $scope.removePassngerList = function(list) {
        let index = $scope.passengerList.indexOf(list);
        $scope.passengerList.splice(index, 1);
        //นับจำนวนผู้ร่วมเดินทาง
        $scope.countAllPassengers();
        console.log($('#passengers').val());
    }

    $scope.countAllPassengers = function () {
        var passengers = "";
        var count = 0;
        angular.forEach($scope.passengerList, function(passenger) {
            if(count != $scope.passengerList.length - 1){
                passengers += passenger.id + ",";
            } else {
                passengers += passenger.id
            }

            count++;
        });

        $('#passengers').val(passengers);
        $('#passengerNum').val(count);
    } 
/** ################################################################################## */
    $scope.changwats = [];
    $scope.selectedChangwat = '';
    $scope.amphurs = [];
    $scope.selectedAmphur = '';
    $scope.tambons = [];
    $scope.selectedTambon = '';

    $scope.addNewLocation = function (event) {
        var data = {
            name: $('#locationName').val(),
            type: '',
            address: $('#locationAddress').val(),
            road: $('#locationRoad').val(),
            changwat: $scope.selectedChangwat,
            amphur: $scope.selectedAmphur,
            tambon: $scope.selectedTambon,
            postcode: $('#locationPostcode').val()
        }

        console.log(data);       
        $http.post(baseUrl + '/location/ajaxadd', data)
        .then(function (data) {
            console.log(data);
            if (data.status === 200) {
                toaster.pop('success', "", data.data.msg);
            } else {
                toaster.pop('warning', "", data.data.msg);
            }

            $('#dlgNewLocationForm').modal('hide');

            //clear ค่า
            $('#locationName').val('');
            $('#locationAddress').val('');
            $('#locationRoad').val('');
            $('#locationPostcode').val('');
            $scope.selectedChangwat = '';
            $scope.selectedAmphur = '';
            $scope.selectedTambon = '';
        });
    }

    $scope.showNewLocationForm = function (event) {        
        $http.get(baseUrl + '/location/ajaxchangwat')
        .then(function (data) {
            $scope.changwats = data.data;
            console.log($scope.changwats);

            $('#dlgNewLocationForm').modal('show')
        });
    }

    $scope.getAmphur = function (event, changwat) {
        console.log(changwat);
        $http.get(baseUrl + '/location/ajaxamphur/' + changwat)
        .then(function (data) {
            $scope.amphurs = data.data;
            console.log($scope.amphurs);
        });
    }

    $scope.getTambon = function (event, amphur) {
        console.log(amphur);
        $http.get(baseUrl + '/location/ajaxtambon/' + amphur)
        .then(function (data) {
            $scope.tambons = data.data;
            console.log($scope.tambons);
        });
    }
/** ################################################################################## */
    $scope.wards = [];
    $scope.getWard = function (event, department) {
        console.log(event);
        $http.get(baseUrl + '/reserve/ajaxward/' + department)
        .then(function (res) {
            $scope.wards = res.data;
            console.log($scope.wards);
        });
    }
/** ################################################################################## */
	/** FORM VALIDATION */
    $scope.formError = null;
    $scope.newReserve = {
        activity_type: '',
        activity: '',
        location: '',
        department: '',
        // ward: '',
        transport: '',
        startpoint: '',
    };

    $scope.formValidate = function (event) {
        event.preventDefault();

        var req_data = {
            activity_type: $scope.newReserve.activity_type,
            activity: $scope.newReserve.activity,
            location: $('#location').val(),
            department: $scope.newReserve.department,
            // ward: $scope.newReserve.ward,
            transport: $scope.newReserve.transport,
            // startpoint: $scope.newReserve.startpoint,
        };
        console.log(req_data);

        $http.post(baseUrl + '/reserve/validate', req_data)
        .then(function (res) {
            // console.log(res);
            $scope.formError = res.data;
            console.log($scope.formError);

            if ($scope.formError.success === 1) {
                $('#frmNewReserve').submit();
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
        if (field == 'activity_type_text') {
            status = ($scope.formError && $scope.newReserve.activity_type === '99' && $scope.newReserve.activity_type_text === '') ? true : false;
        } else if (field == 'location') {
            status = ($scope.formError && $('#location').val() === '') ? true : false;
        } else {
            status = ($scope.formError && $scope.newReserve[field] === '') ? true : false;
        }

        return status;
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
	/** EDIT ACTION */
	$scope.loadReservationData = function (id) {
		$http.get(baseUrl + '/reserve/ajaxedit/' + id)
        .then(function (res) {
            console.log(res);
			
			$scope.wards = res.data[1];
            $scope.newReserve = {
		        activity_type: res.data[0].activity_type,
		        activity_type_text: res.data[0].activity_type_text,
		        activity: res.data[0].activity,
		        locationId: res.data[0].location,
		        department: res.data[0].department,
		        ward: res.data[0].ward,
		        transport: res.data[0].transport,
		        startpoint: res.data[0].startpoint,
		    };		    
		    console.log($scope.newReserve);
		    console.log($scope.wards);

            /*ดึงข้อมูล passenger มาแสดงรายการ passenger*/
			$http.get(baseUrl + '/ajaxpassenger/' + id + '/1')
	        .then(function (res) {
	            // console.log(res.data);
	            $scope.passengerList = res.data[1];
	        }); 

            /*ดึงข้อมูล location มาแสดงรายการ location*/
            var l = res.data[0].location.split(',');
	        // console.log(l);
	        angular.forEach(l, function(l) {
		        // console.log(l);
	            $http.get(baseUrl + '/location/ajaxlocation/' + l)
		        .then(function (res) {
		            // console.log(res);
		            $scope.locations.push({
		                id: res.data.id,
		                name: res.data.name
		            });
		        });	            
	        });

		    $('#locationId').val(res.data[0].location);
        })
        .catch(function (res) {
            console.log(res);
        });
	}
/** ################################################################################## */
    $scope.selectedTextToActivity = function (e) {
        console.log($("#activity_type").val());
        console.log($("#activity_type option:selected").text());

        if ($("#activity_type").val() == '7' || $("#activity_type").val() == '8') {
            
        }
    }
/** ################################################################################## */
    $scope.reservation = {};
    $scope.strLocation = '';
    $scope.activityType = [];
    $scope.transport = [];
    $scope.showDetail = function (id) {
        console.log(id);
        $scope.strLocation = '';
        $http.get(baseUrl + '/reserve/ajaxdetail/' + id)
        .then(function (res) {
            console.log(res);
            $scope.reservation = res.data.reservation;
            $scope.activityType = res.data.activityType;
            $scope.transport = res.data.transport;
            
            let arrLocations = $scope.reservation.location.split(',');
            angular.forEach(arrLocations, function(l) {
                $http.get(baseUrl + '/location/ajaxlocation/' + l)
                .then(function (res) {
                    console.log(res);
                    $scope.strLocation += res.data.name + ', ';
                });
            });

            console.log($scope.strLocation);
            $('#dlgReservations').modal('show')
        });        
    }
/** ################################################################################## */
});