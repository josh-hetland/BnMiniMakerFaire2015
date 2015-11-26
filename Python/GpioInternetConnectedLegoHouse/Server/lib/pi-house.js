/**
 * Client side functionality for updating the status of the house and
 * sending requests to toggle a room in the house
 */

var PiHouse = PiHouse || {};

PiHouse.timer = null;

PiHouse.checkin = function( room ){
  if( PiHouse.timer !== null ){
      clearTimeout( PiHouse.timer );
      PiHouse.timer = null;
  }
  
  $.ajax({
      url:'/make/lib/Worker.Client.php',
      accepts:'json',
      method:'POST',
      contentType:'application/x-www-form-urlencoded; charset=UTF-8',
      data: { Room : room }
   }).done( function( data, textStatus, jqXHR  ){
        if( data.Upstairs === 0 ){
            $('#UpstairsIndicator').removeClass('on').addClass('off');
            $('#UpstairsIndicator')[0].innerText = 'off';
        }else{
            $('#UpstairsIndicator').removeClass('off').addClass('on');
            $('#UpstairsIndicator')[0].innerText = 'on';
        }
        
        if( data.Downstairs === 0 ){
            $('#DownstairsIndicator').removeClass('on').addClass('off');
            $('#DownstairsIndicator')[0].innerText = 'off';
        }else{
            $('#DownstairsIndicator').removeClass('off').addClass('on');
            $('#DownstairsIndicator')[0].innerText = 'on';
        }
        
        if( data.Outside === 0 ){
            $('#OutsideIndicator').removeClass('on').addClass('off');
            $('#OutsideIndicator')[0].innerText = 'off';
        }else{
            $('#OutsideIndicator').removeClass('off').addClass('on');
            $('#OutsideIndicator')[0].innerText = 'on';
        }
   }).always( function( ){
        if( PiHouse.timer !== null ){
          clearTimeout( PiHouse.timer );
          PiHouse.timer = null;
        }
        PiHouse.timer = setTimeout(function(){ PiHouse.checkin(); }, 500);
   });
};

$(document).ready(function( ){
    $('#UpstairsButton').click( function(){ PiHouse.checkin('upstairs'); });
    $('#DownstairsButton').click( function(){ PiHouse.checkin('downstairs'); });
    $('#OutsideButton').click( function(){ PiHouse.checkin('outside'); });
    PiHouse.checkin();
});