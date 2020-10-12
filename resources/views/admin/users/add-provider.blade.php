@extends(admin_layout_vw().'.index')

@section('css')

    <link href="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet"
          type="text/css"/>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('/')}}/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{url('/')}}/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->

    <style>
        .pac-container {
            z-index: 9999999;
            display: block;
        }
    </style>
@endsection
@section('content')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user-plus font-green-haze"></i>
                <span class="caption-subject font-green-haze bold uppercase">{{$title ?? ''}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            {!! Form::open(['method'=>'post','class'=>'form-horizontal','files'=>true,'id'=>'formAdd']) !!}
            <input type="hidden" name="type" id="type" value="service_provider">
            <div class="form-body">
                <h3 class="form-section">البيانات الاساسية</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label class="control-label col-md-3">الصورة الشخصية</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                         style="width: 200px; height: 150px;">
                                        <img src="{{url('assets/apps/img/unknown.png')}}"
                                             alt=""/>

                                    </div>
                                    <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اختيار </span>
                                                                <span class="fileinput-exists"> تغير </span>
                                                                <input type="file" name="photo"
                                                                       id="photo"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists"
                                           data-dismiss="fileinput">
                                            افراغ </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">الاسم كامل:</label>
                            <div class="col-md-9">
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="اضف الاسم كامل...">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">رقم الهاتف:</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-icon">
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               placeholder="اضف رقم الهاتف..."></div>
                                    <span class="input-group-addon">
                                                            <input type="text" name="country_code" id="country_code"
                                                                   class="form-control input-xsmall"
                                                                   placeholder="+966">
                                                        </span>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">البريد الالكتروني:</label>
                                <div class="col-md-9">
                                    <input type="text" name="email" id="email" class="form-control"
                                           placeholder="اضف البريد الالكتروني...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الجنس:</label>
                                <div class="col-md-9">
                                    <select class="form-control select" name="gender"
                                            id="gender">
                                        <option value="male">ذكر</option>
                                        <option value="female">انثى</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">المدينة:</label>
                                <div class="col-md-9">
                                    <select class="form-control select" name="city_id"
                                            id="city_id">
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الحالة:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><input type="checkbox"
                                                                          class="make-switch"
                                                                          data-on-text="&nbsp;مفعّل&nbsp;"
                                                                          data-off-text="&nbsp;معطّل&nbsp;"
                                                                          name="is_active"
                                                                          checked
                                                                          data-on-color="success"
                                                                          data-size="mini" data-off-color="warning"></p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">كلمة المرور:</label>
                                <div class="col-md-9">
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="اضف كلمة المرور...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">تأكيد كلمة المرور:</label>
                                <div class="col-md-9">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control"
                                           placeholder="اضف تأكيد كلمة المرور...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <h3 class="form-section">البيانات الفرعية</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">نوع مزود الخدمة:</label>
                                <div class="col-md-9">

                                    <select class="form-control select" name="service_provider_type_id"
                                            id="service_provider_type_id">
                                        @foreach($service_provider_types as $service_provider_type)
                                            <option
                                                value="{{$service_provider_type->id}}">{{$service_provider_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">العنوان:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <div class="input-icon">
                                            <input type="text" name="address" id="address" class="form-control"
                                                   placeholder="اضف العنوان..."></div>
                                        <span class="input-group-btn">
                                                            <button id="genpassword" class="btn btn-success"
                                                                    type="button" onclick="openMap()">
                                                                <i class="fa fa-map-marker"></i> الخريطة</button>
                                                        </span>
                                    </div>


                                    <input type="hidden" name="latitude" id="latitude" class="form-control">
                                    <input type="hidden" name="longitude" id="longitude" class="form-control">


                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">رقم البطاقة الشخصية:</label>
                                <div class="col-md-9">
                                    <input type="text" name="idno" id="idno" class="form-control"
                                           placeholder="اضف رقم البطاقة الشخصية...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">صورة البطاقة التعريفية:</label>
                                <div class="col-md-9">
                                    <input type="file" name="idno_file" id="idno_file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الهواية:</label>
                                <div class="col-md-9">
                                    <input type="text" name="skill" id="skill" class="form-control"
                                           placeholder="اضف الهواية...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">مرفق الهواية:</label>
                                <div class="col-md-9">
                                    <input type="file" name="skill_file" id="skill_file" class="form-control">

                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">حالة الرخصة:</label>
                                <div class="col-md-9">

                                    <select class="form-control select" name="license_type"
                                            id="license_type">
                                        <option value="licensed">مرخص</option>
                                        <option value="unlicensed">غير مرخص</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">ملف الرخصة:</label>
                                <div class="col-md-9">

                                    <input type="file" name="licensed_file" id="licensed_file" class="form-control">

                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">نبذه:</label>
                                <div class="col-md-9">
                                    <textarea name="bio" id="bio" rows="5" placeholder="اضف نبذه..."
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-circle green btn-md save"><i
                                    class="fa fa-user-plus"></i>
                                اضافة جديدة
                            </button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <!-- END FORM-->
            </div>
        </div>


        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLongTitle"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalLongTitle"> تحديد العنوان</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input id="autocomplete" class="form-control"
                               placeholder="تحديد العنوان " type="text"/>

                        <div id="map" style="height: 300px; width:100%; margin-top: 10px"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">اغلاق
                        </button>
                        <button type="button" class="btn btn-primary"
                                onclick="AddPlace()">تحديد العنوان
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @endsection
        @section('js')

            <script src="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
                    type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            =    <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <script src="{{url('/')}}/assets/pages/scripts/form-samples.min.js" type="text/javascript"></script>

            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <!-- END PAGE LEVEL SCRIPTS -->
            <script src="{{url('/')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
            <script src="{{url('/')}}/assets/js/providers.js" type="text/javascript"></script>

            <script src="https://cdn.klokantech.com/maptilerlayer/v1/index.js"></script>

            <script>
    $(document).ready(function () {
    });

    function AddPlace() {
        $('#address').val($('#autocomplete').val());
        $('#exampleModalLong').modal('hide');
    }

    var address = '';

    function geocodeLatLng(location, first) {

        geocoder.geocode({'location': location}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {

                    address = results[0].formatted_address;
                    if (first == '1') {
                        $('#autocomplete').val(address);
                        $('#address').val(address);
                    } else {
                        $('#autocompleteEnd').val(address);
                    }


                } else {
                    // window.alert('No Address');
                }
            } else {
                // window.alert('Geocoder failed due to: ' + status);
            }
        });
    }


    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }


    markersFrist = [];
    marker = [];
    nowto = 0;
    var map, places, infoWindow;
    markers = [];
    var autocomplete;
    var autocompleteEnd;
    var countryRestrict = {'country': 'tr'};
    var MARKER_PATH = 'https://developers.google.com/maps/documentation/javascript/images/marker_green';
    var hostnameRegexp = new RegExp('^https?://.+?/');


    function getPositionErrorMessage(code) {
        // console.log('error place code' + code);
    }

    function initMap() {

        // الرياض
        var lat = 24.7255553;
        var lng = 47.1027145;

        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        geocoder = new google.maps.Geocoder;
        map = new google.maps.Map(document.getElementById('map'), {

            center: {lat: lat, lng: lng},
            mapTypeControl: true,
            panControl: true,
            zoomControl: true,
            streetViewControl: false,
            zoom: 10
        });

        directionsDisplay.setMap(map);
        mapMaxZoom = 13;
        geoloccontrol = new klokantech.GeolocationControl(map, mapMaxZoom);
        infoWindow = new google.maps.InfoWindow({
            content: document.getElementById('info-content')
        });

        map.addListener('click', function (event) {

            placeMarker(map, event.latLng);

        });

        // Create the autocomplete object and associate it with the UI input control.
        // Restrict the search to the default country, and to place type "cities".
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */ (
                document.getElementById('autocomplete'))
        );

        places = new google.maps.places.PlacesService(map);
        autocomplete.addListener('place_changed', onPlaceChanged);
    }


    function deleteMarkers() {
        clearMarkers();
        marker = [];
    }

    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }


    function clearMarkers() {
        setMapOnAll(null);
    }


    function placeMarker(map, location) {

        deleteMarkers();
        var marker = new google.maps.Marker({
            position: location,
            map: map,

        });

        markers.push(marker);


        setLongLatmyFunction(location);
        var infowindow = new google.maps.InfoWindow({
            content: address
        });

        infowindow.open(map, marker);
        geocodeLatLng(location, '1');


    }

    function setLongLatmyFunction(marker) {

        $('#latitude').val(marker.lat());
        $('#longitude').val(marker.lng());

    }

    function onPlaceChanged() {

        var place = autocomplete.getPlace();
        if (place.geometry) {
            map.panTo(place.geometry.location);
            map.setZoom(15);
            search();
        } else {
            document.getElementById('autocomplete').placeholder = 'Enter a city';
        }
    }

    // Search for hotels in the selected city, within the viewport of the map.
    function search() {


        var mark = [];
        var search = {
            bounds: map.getBounds(),
            types: ['lodging']
        };

        places.nearbySearch(search, function (results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                //clearResults();
                deleteMarkers();
                // Create a marker for each hotel found, and
                // assign a letter of the alphabetic to each marker icon.
                for (var i = 0; i < results.length; i++) {
                    var markerLetter = String.fromCharCode('A'.charCodeAt(0) + (i % 26));
                    var markerIcon = 'http://www.coffeecreamthemes.com/themes/taxigrabber/html/images/map-marker.png';
                    // Use marker animation to drop the icons incrementally on the map.
                    mark[i] = new google.maps.Marker({
                        position: results[i].geometry.location,
                        animation: google.maps.Animation.DROP,
                        icon: markerIcon
                    });


                }

                $('#latitude').val(mark[0].position.lat());
                $('#longitude').val(mark[0].position.lng());

                var marker = new google.maps.Marker({
                    position: mark[0].position,
                    map: map,

                });

                markers.push(marker);


                // If the user clicks a hotel marker, show the details of that hotel
                // in an info window.
                mark[i].placeResult = results[i];
                google.maps.event.addListener(mark[i], 'click', showInfoWindow);
                setTimeout(dropMarker(i), i * 100);
                addResult(results[i], i);


            }

        });
    }

    // Set the country restriction based on user input.
    // Also center and zoom the map on the given country.
    function setAutocompleteCountry() {
        var country = document.getElementById('country').value;
        if (country == 'all') {
            autocomplete.setComponentRestrictions({'country': []});
            map.setCenter({lat: 15, lng: 0});
            map.setZoom(2);
        } else {
            autocomplete.setComponentRestrictions({'country': country});
            map.setCenter(countries[country].center);
            map.setZoom(countries[country].zoom);
        }
        // clearResults();
        clearMarkers();
    }

    function dropMarker(i) {
        return function () {
            markers[i].setMap(map);
        };
    }

    function addResult(result, i) {
        var results = document.getElementById('results');
        var markerLetter = String.fromCharCode('A'.charCodeAt(0) + (i % 26));
        var markerIcon = MARKER_PATH + markerLetter + '.png';

        var tr = document.createElement('tr');
        tr.style.backgroundColor = (i % 2 === 0 ? '#F0F0F0' : '#FFFFFF');
        tr.onclick = function () {
            google.maps.event.trigger(markers[i], 'click');
        };

        var iconTd = document.createElement('td');
        var nameTd = document.createElement('td');
        var icon = document.createElement('img');
        icon.src = markerIcon;
        icon.setAttribute('class', 'placeIcon');
        icon.setAttribute('className', 'placeIcon');
        var name = document.createTextNode(result.name);
        iconTd.appendChild(icon);
        nameTd.appendChild(name);
        tr.appendChild(iconTd);
        tr.appendChild(nameTd);
        results.appendChild(tr);
    }


    // Get the place details for a hotel. Show the information in an info window,
    // anchored on the marker for the hotel that the user selected.
    function showInfoWindow() {
        var marker = this;

        places.getDetails({placeId: marker.placeResult.place_id},
            function (place, status) {
                if (status !== google.maps.places.PlacesServiceStatus.OK) {
                    return;
                }
                infoWindow.open(map, marker);

            });
    }

    function openMap() {

        $('#exampleModalLong').modal('show');
    }
    </script>

            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDviHB7G4RWAgQNwvjaVXLhC1j5DNTSPFE&libraries=places&callback=initMap"
                async defer></script>
@stop
