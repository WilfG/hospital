 <!-- ================================================
jQuery Library
================================================ -->
 <script src="{{asset('assets/js/jquery.min.js')}}"></script>

 <!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
 <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}}"></script>
 @if(Request::is('dashboard/*'))

 <!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
 <script src="{{asset('assets/js/plugins.js')}}"></script>

 <!-- ================================================
Bootstrap Select
================================================ -->

 <!-- ================================================
Bootstrap Toggle
================================================ -->
 <script src="{{asset('assets/js/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>

 <!-- ================================================
Bootstrap WYSIHTML5
================================================ -->
 <!-- main file -->
 <script src="{{asset('assets/js/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js')}}"></script>
 <!-- bootstrap file -->
 <script src="{{asset('assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>

 <!-- ================================================
Summernote
================================================ -->
 <script src="{{asset('assets/js/summernote/summernote.min.js')}}"></script>

 <!-- ================================================
Flot Chart
================================================ -->

 <!-- main file -->
 <script src="{{asset('assets/js/flot-chart/flot-chart.js')}}"></script>
 <!-- time.js -->
 <script src="{{asset('assets/js/flot-chart/flot-chart-time.js')}}"></script>
 <!-- stack.js -->
 <script src="{{asset('assets/js/flot-chart/flot-chart-stack.js')}}"></script>
 <!-- pie.js -->
 <script src="{{asset('assets/js/flot-chart/flot-chart-pie.js')}}"></script>
 <!-- demo codes -->
 <script src="{{asset('assets/js/flot-chart/flot-chart-plugin.js')}}"></script>


 <!-- ================================================
Chartist
================================================ -->
 <!-- main file -->
 <script src="{{asset('assets/js/chartist/chartist.js')}}"></script>
 <!-- demo codes -->
 <script src="{{asset('assets/js/chartist/chartist-plugin.js')}}"></script>
 <!-- ================================================
Easy Pie Chart
================================================ -->
 <!-- main file -->
 <script src="{{asset('assets/js/easypiechart/easypiechart.js')}}"></script>
 <!-- demo codes -->
 <script src="{{asset('assets/js/easypiechart/easypiechart-plugin.js')}}"></script>


 <!-- ================================================
Rickshaw
================================================ -->
 <!-- d3 -->
 <script src="{{asset('assets/js/rickshaw/d3.v3.js')}}"></script>
 <!-- main file -->
 <script src="{{asset('assets/js/rickshaw/rickshaw.js')}}"></script>
 <!-- demo codes -->
 <script src="{{asset('assets/js/rickshaw/rickshaw-plugin.js')}}"></script>
 <!-- ================================================
 
  ================================================
 Sweet Alert
 ================================================ -->
 <script src="{{asset('assets/js/sweet-alert/sweet-alert.min.js')}}"></script>

 <!-- ================================================
 Kode Alert
 ================================================ -->
 <script src="{{asset('assets/js/kode-alert/main.js')}}"></script>

 @endif
 <!-- Data Tables 
 ================================================ -->
 <script src="{{asset('assets/js/bootstrap-select/bootstrap-select.js')}}"></script>

 <script src="{{asset('assets/js/datatables/datatables.min.js')}}"></script>
 <!-- ================================================
jQuery UI
================================================ -->
 <script src="{{asset('assets/js/jquery-ui/jquery-ui.min.js')}}"></script>

 <!-- ================================================
Moment.js
================================================ -->
 <script src="{{asset('assets/js/moment/moment.min.js')}}"></script>

 <!-- ================================================
Full Calendar
================================================ -->
 <script src="{{asset('assets/js/full-calendar/fullcalendar.js')}}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/lang-all.js"></script>
 <!-- ================================================
Bootstrap Date Range Picker
================================================ -->
 <script src="{{asset('assets/js/date-range-picker/daterangepicker.js')}}"></script>

 <!-- ================================================
Below codes are only for index widgets
================================================ -->
 <!-- Today Sales -->

 <script src="{{asset('/Multiselect/dist/js/multiselect.min.js')}}">
 </script>
 <script src="https://cdn.tiny.cloud/1/pvrso85as4f19qriph0r4qxnlezbnzx7x6ih1m8qdee7a8kl/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
 <script>
   tinymce.init({
     selector: 'textarea',
     plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
     content_langs: [{
         title: 'English',
         code: 'en'
       },
       {
         title: 'Spanish',
         code: 'es'
       },
       {
         title: 'French',
         code: 'fr'
       },
       {
         title: 'German',
         code: 'de'
       },
       {
         title: 'Portuguese',
         code: 'pt'
       },
       {
         title: 'Chinese',
         code: 'zh'
       }
     ]
   });
 </script>

 <script type="text/javascript">
   $(document).ready(function() {
     $('#multiselect').multiselect();

     $('#material').hide();
     $('#material').parent().hide();
     $('#item_type').change(function() {
       //  alert()
       if ($(this).val() == 'product') {
         $('#material').val('').hide();
         $('#material').parent().hide();
         $('#drug').show();
         $('#drug').parent().show();
       } else {
         $('#drug').val('').hide();
         $('#drug').parent().hide();

         $('#material').show();
         $('#material').parent().show();
       }

     });

     $('.downloadBtn').click(function() {
       var itemId = $(this).data('line-id');
       $.ajax({
         type: 'GET',
         url: "/facturation_gestion_financiere/demande_de_depense/download/" + itemId, // Laravel route

         success: function(response) {
           //  alert(response)
           var a = document.createElement('a');
           a.href = response;
           a.download = response;
           a.click();

         },
         error: function(xhr, status, error) {
           console.error(xhr.responseText);
         }
       });
     })

     $('#searchticket').on('keyup', function() {
       $value = $(this).val();
       $.ajax({
         type: 'get',
         url: "{{URL::to('/gestion_ticket/searchticket')}}",
         data: {
           'searchticket': $value
         },
         success: function(data) {
           // console.log(data)
           $('#tickets_results').html(data);
         },
         error: function(data) {
           $('#tickets_results').html('<h3>Pas de tickets trouvés</h3>');

         }
       });
     })


     /* initialize the external events
     -----------------------------------------------------------------*/
     $('#external-events .fc-event').each(function() {

       // store data so the calendar knows to render an event upon drop
       $(this).data('event', {
         title: $.trim($(this).text()), // use the element's text as the event title
         stick: true // maintain when user navigates (see docs on the renderEvent method)
       });

       // make the event draggable using jQuery UI
       $(this).draggable({
         zIndex: 999,
         revert: true, // will cause the event to go back to its
         revertDuration: 0 //  original position after the drag
       });

     });


     /* initialize the calendar
     -----------------------------------------------------------------*/
     $('#calendar').fullCalendar({
       header: {
         left: 'prev,next today',
         center: 'title',
         right: 'month,basicWeek,basicDay',
         //  buttonText: {
         //    today: 'Aujourd\'ui',
         //    day: 'Jour',
         //    week: 'Semaine',
         //    month: 'Mois'
         //  }
       },
       defaultDate: new Date(),
       editable: true,
       droppable: true, // this allows things to be dropped onto the calendar
       eventLimit: true, // allow "more" link when too many events
       lang: 'fr',
       events: {
         url: "{{url('api/appointments')}}",
         type: "GET"
       },
       //  eventRender: function(info) {
       //    var firstname = info.event.extendedProps.firstname;
       //    var lastname = info.event.extendedProps.lastname;

       //    info.el.querySelector('.fc-title').innerHTML += ' (' + firstname + " " + lastname + ')';
       //  },

       eventClick: function(info) {
         alert('Description: Vous avez Rendez-vous avec ' + info.event.firstname + " " + info.event.lastname);
         // You can customize how you want to display the additional data here
       }
     });
     $('.datatb').DataTable({
       "language": {
         "sUrl": "custom_fr.txt"
       }
     });

     //Categorie de depense
     function categoryList() {
       $.ajax({
         method: "GET",
         url: "{{URL::to('/api/categoryExpList')}}",
         success: function(rsp) {
           console.log(rsp)
           $('#categorie').html(rsp);
           //  $('#myModal').close();
         },
         error: function(err) {
           console.log(err)
         }
       })
     };
     categoryList();
     $('#formCategExpPlus').submit(function(e) {
       e.preventDefault();
       var label_categorie = $('#label_categorie').val();
       $.ajax({
         method: "POST",
         url: "{{URL::to('/api/categoryExp')}}",
         data: {
           label_categorie: label_categorie
           //  _token: '{{csrf_token()}}'

         },
         success: function(rsp) {
           window.location.reload();
           //  $('#categorie').html(rsp);
           //  $('#myModal').close();
         },
         error: function(err) {
           console.log(err)
         }
       })
     });


   });

   $('#country-dd').on('change', function() {
     var idCountry = this.value;
     $("#state-dd").html('');
     $.ajax({
       url: "{{url('api/fetch-states')}}",
       type: "POST",
       data: {
         country_id: idCountry,
         _token: '{{csrf_token()}}'
       },
       dataType: 'json',
       success: function(result) {
         $('#state-dd').html('<option value="">Select State</option>');
         $.each(result.states, function(key, value) {
           $("#state-dd").append('<option value="' + value
             .id + '">' + value.name + '</option>');
         });
         $('#city-dd').html('<option value="">Select City</option>');
       }
     });
   });
   $('#state-dd').on('change', function() {
     var idState = this.value;
     $("#city-dd").html('');
     $.ajax({
       url: "{{url('api/fetch-cities')}}",
       type: "POST",
       data: {
         state_id: idState,
         _token: '{{csrf_token()}}'
       },
       dataType: 'json',
       success: function(res) {
         $('#city-dd').html('<option value="">Select City</option>');
         $.each(res.cities, function(key, value) {
           $("#city-dd").append('<option value="' + value
             .id + '">' + value.name + '</option>');
         });
       }
     });

   });
 </script>
 @if(Request::is('dashboard/*'))

 <script>
   var seriesData = [
     [],
     [],
     []
   ];
   var random = new Rickshaw.Fixtures.RandomData(20);

   for (var i = 0; i < 110; i++) {
     random.addData(seriesData);
   }

   // instantiate our graph!

   var graph = new Rickshaw.Graph({
     element: document.getElementById("todaysales"),
     renderer: 'bar',
     series: [{
       color: "#33577B",
       data: seriesData[0],
       name: 'Photodune'
     }, {
       color: "#77BBFF",
       data: seriesData[1],
       name: 'Themeforest'
     }, {
       color: "#C1E0FF",
       data: seriesData[2],
       name: 'Codecanyon'
     }]
   });

   graph.render();

   var hoverDetail = new Rickshaw.Graph.HoverDetail({
     graph: graph,
     formatter: function(series, x, y) {
       var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
       var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
       var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
       return content;
     }
   });
 </script>

 <!-- Today Activity -->
 <script>
   // set up our data series with 50 random data points

   var seriesData = [
     [],
     [],
     []
   ];
   var random = new Rickshaw.Fixtures.RandomData(20);

   for (var i = 0; i < 50; i++) {
     random.addData(seriesData);
   }

   // instantiate our graph!

   var graph = new Rickshaw.Graph({
     element: document.getElementById("todayactivity"),
     renderer: 'area',
     series: [{
       color: "#9A80B9",
       data: seriesData[0],
       name: 'London'
     }, {
       color: "#CDC0DC",
       data: seriesData[1],
       name: 'Tokyo'
     }]
   });

   graph.render();

   var hoverDetail = new Rickshaw.Graph.HoverDetail({
     graph: graph,
     formatter: function(series, x, y) {
       var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
       var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
       var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
       return content;
     }
   });
 </script>

 <script type="text/javascript">
   $.ajaxSetup({
     headers: {
       'csrftoken': '{{ csrf_token() }}'
     }
   });
 </script>
 @endif
 <script src="{{asset('assets/js/plugins.js')}}"></script>
 <!-- Sidebar Graph - END -->