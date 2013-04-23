/* VIEWCHANGER */
$(document).ready(function(){
  $('.view').hide(); //Hide all views
  $('#view-step1').show();
  $('#btnTakePicture').click(function(){
      $('.taken-image').show();
      $('#textballoon').hide();
  })
  initCamera();
  
  initTags();
});

/* NAVIGATION (PHOTO-MODULE) */
function goToStep(dest){
  $('.view').slideUp();
  $("#view-step" + dest).slideDown();
  pre = dest - 1;
  $(".step" + pre).removeClass('active').addClass('done');
  $(".step" + dest).addClass('active');
  if(dest === 2){
    initWheel();
  }
  if(dest === 3){
    initMap();
    getLocation();
  }
}

/* CAM */
function initCamera(){
  $("#imageContainer").hide();
  $('#btnTakePicture').show();
  $('#showAfterStep1').hide();
  $('#base64_photo').val('');
  $("#webcam").scriptcam({
    showMicrophoneErrors:false,
    path: '../assets/third_party/scriptcam/',
    onError:onError,
    cornerRadius:0,
    onPictureAsBase64:base64_tofield_and_image,
    width: 640,
    height: 480
  });
}
function takePicture(){
  $('#base64_photo').val($.scriptcam.getFrameAsBase64());
  $('#image').attr("src","data:image/png;base64,"+$.scriptcam.getFrameAsBase64());
  $('.image-preview').css('background-image', "url(data:image/png;base64,"+$.scriptcam.getFrameAsBase64()+')');
  $('.image-preview').css('opacity', '1');
  $('#webcam').hide();
  $('#imageContainer').show();
  $('#btnTakePicture').hide();
  $('#showAfterStep1').show();
};
function base64_tofield_and_image(b64) {
  $('#base64_photo').val(b64);
  $('#image').attr("src","data:image/png;base64,"+b64);
};
function onError(errorId,errorMsg) {
  alert(errorMsg);
} 

/* ATMOSPHERE */
var dragging;
var selected_mood = 1;
function initWheel(){
    var target = $('#atmosphere-wheel');
    var offset_top = $(target).offset().top;
    var offset_left = $(target).offset().left;
    var offset_x = offset_left + 387;
    var offset_y = offset_top - 387;
    var angle = 0;
    var startAngle;
    var slices = 12;
    var sliceAngle = 360 / slices;
    target.mousedown(function(e) {
        var mouse_x = e.pageX;
        var mouse_y = e.pageY;
        var radians = Math.atan2(mouse_x - offset_x, mouse_y - offset_y);
        dragging = true
        startAngle = ((radians * (180 / Math.PI) * -1) + 90) - angle;
    })
    $(document).mouseup(function() {
        dragging = false;
        var slice = (angle + (sliceAngle/2)) / sliceAngle;
        if(slice < 0){
            slice = 12 + slice;
        }else if(slice > 12){
            slice = 12 - slice;
        }
        
        // Move circle in perfect position
        angle = (Math.floor(slice) * (360 / slices));
        target.css('-moz-transform', 'rotate(' + angle + 'deg)');
        target.css('-moz-transform-origin', '50% 50%');
        target.css('-webkit-transform', 'rotate(' + angle + 'deg)');
        target.css('-webkit-transform-origin', '50%, 50%');
        target.css('-o-transform', 'rotate(' + angle + 'deg)');
        target.css('-o-transform-origin', '50% 50%');
        target.css('-ms-transform', 'rotate(' + angle + 'deg)');
        target.css('-ms-transform-origin', '50% 50%');
        
        selected_mood = Math.floor(slice) + 1;
        if(selected_mood === 0){
          selected_mood = 12;
        }
        $('.sphere img').attr('src', 'assets/images/template/atmospheres/' + selected_mood + '.png');
        var sphere_txt;
        if(selected_mood === 1){
          sphere_txt = 'Actief';
        }else if(selected_mood === 2){
          sphere_txt = 'Blij';
        }else if(selected_mood === 3){
          sphere_txt = 'Boos';
        }else if(selected_mood === 4){
          sphere_txt = 'Dromerig';
        }else if(selected_mood === 5){
          sphere_txt = 'Party';
        }else if(selected_mood === 6){
          sphere_txt = 'Geirriteerd';
        }else if(selected_mood === 7){
          sphere_txt = 'Gek';
        }else if(selected_mood === 8){
          sphere_txt = 'Opgewonden';
        }else if(selected_mood === 9){
          sphere_txt = 'Romantisch';
        }else if(selected_mood === 10){
          sphere_txt = 'Rustig';
        }else if(selected_mood === 11){
          sphere_txt = 'Verdrietig';
        }else if(selected_mood === 12){
          sphere_txt = 'Verveeld';
        }
        $('.sphere p').html(sphere_txt);
    });
    $(document).mousemove(function(e) {
        if (dragging) {
            var mouse_x = e.pageX;
            var mouse_y = e.pageY;
            var radians = Math.atan2(mouse_x - offset_x, mouse_y - offset_y);
            var degree = (radians * (180 / Math.PI) * -1) + 90;
            angle = degree - startAngle;
            if(angle < 0){
                angle = 360 + angle;   
            }else if(angle > 360){
                angle = 360 - angle;
            }
            target.css('-moz-transform', 'rotate(' + angle + 'deg)');
            target.css('-moz-transform-origin', '50% 50%');
            target.css('-webkit-transform', 'rotate(' + angle + 'deg)');
            target.css('-webkit-transform-origin', '50%, 50%');
            target.css('-o-transform', 'rotate(' + angle + 'deg)');
            target.css('-o-transform-origin', '50% 50%');
            target.css('-ms-transform', 'rotate(' + angle + 'deg)');
            target.css('-ms-transform-origin', '50% 50%');
        }
    })
};

/* MAPS */
var map;
var markersArray = [];
var location_id;
var locationsNearby = false;
function initMap(){
  var myOptions = {
    zoom: 15,
    center: new google.maps.LatLng(51.04758721, 3.73072105),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("map_canvas"),  myOptions);
}
function getLocation(){
  if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(showPosition,errorCallback_highAccuracy,{maximumAge:0, timeout:10000, enableHighAccuracy: true});
  }else{
    alert("Geolocation is not supported by this browser.");
  }
}
function errorCallback_highAccuracy(){
  alert('Kon de locatie niet nauwkeurig bepalen!');
}
function showPosition(position){
  map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
  var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);            
  var marker = new google.maps.Marker({
        position: myLatlng, 
        map: map, 
        title: 'U bent hier'
  });
  markersArray.push(marker);
  getLocationsNearby(position.coords.latitude, position.coords.longitude);
}
function getLocationsNearby(lat, lng){
  if(locationsNearby === false){
    $.ajax({
      dataType: "json",
      url: 'http://tagmosphere.be/photo/getLocationsNearby/' + lat + '/' + lng,
      success: function(data){
        var html;
        $.each(data, function(i, item) {
          html += '<tr><td class="label">';
          html += item.name + '</td>';
          html += '<td>' + Math.round(item.distance*100)/100 + 'km</td>';
          html += '<td><a href="#" onclick="goToStep(4); setLocationId(' + item.id + ', \'' + item.name + '\')"><img src="../assets/images/template/location-pick.png" alt="Location select" /></a>';
          html += '</td></tr>';
        });
        $('#locations_nearby').append(html);
      }
    });
    locationsNearby = true;
  }
}
function setLocationId(id, name){
  location_id = id;
  $(".location-preview").html('<p><strong>Locatie: </strong><br />' + name + '</p>');
}

/* TAGS */
var count_tags = 0;
var front_tag_id = 0;
function initTags(){
  $('#addTagForm').submit(function(){
    $('#location_next_step').show();
    count_tags++;
    front_tag_id++;
    $("#tags-list").append('<li class="f_tag_' + front_tag_id + '"><span>' + $("#newTagField").val() +  '</span><a href="#" onclick="removeTag(' + front_tag_id + '); return false;"><img src="../assets/images/template/verwijder.png" alt="Verwijder tag" /></a></li>');
    $(".tags-small ul").append('<li class="f_tag_' + front_tag_id + '"><span>' + $("#newTagField").val() + '</span> •</li>');
    $("#newTagField").val('');
    return false;
  });
  
  // Autocomplete
  $('#newTagField').autocomplete({
    serviceUrl: 'photo/autocompleteTags'
  });
}
function removeTag(front_tag_id){
  count_tags--;
  if(count_tags === 0){
    $('#location_next_step').hide();
  }
  $('.f_tag_' + front_tag_id).remove();
}
function getAllTags(){
  var tags = [];
  $("#tags-list li").each(function(){
    tmp_tag = $(this).find('span').html();
    tags.push(tmp_tag);
  });
  return tags;
}

/* PUBLISH */
function publish(){
  $.ajax({
    type: "POST",
    url: "photo",
    dataType: "json",
    data: {photo: $('#base64_photo').val(), atmosphere: selected_mood, location_id: location_id,tags: getAllTags()},
    success: function(data){
      if(data.success){
        window.location = "wall";
      }else{
        alert('Er is wat misgelopen, probeer opnieuw!');
        window.location = "photo";
      }              
    }
  });
}