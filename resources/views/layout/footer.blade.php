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
 <script src="{{asset('assets/js/bootstrap-select/bootstrap-select.js')}}"></script>

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
Data Tables
================================================ -->
 <script src="{{asset('assets/js/datatables/datatables.min.js')}}"></script>

 <!-- ================================================
Sweet Alert
================================================ -->
 <script src="{{asset('assets/js/sweet-alert/sweet-alert.min.js')}}"></script>

 <!-- ================================================
Kode Alert
================================================ -->
 <script src="{{asset('assets/js/kode-alert/main.js')}}"></script>

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

 <!-- ================================================
Bootstrap Date Range Picker
================================================ -->
 <script src="{{asset('assets/js/date-range-picker/daterangepicker.js')}}"></script>
 @endif

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
     content_langs: [
      { title: 'English', code: 'en' },
      { title: 'Spanish', code: 'es' },
      { title: 'French', code: 'fr' },
      { title: 'German', code: 'de' },
      { title: 'Portuguese', code: 'pt' },
      { title: 'Chinese', code: 'zh' }
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
         // data: {
         //    id:itemId
         // },
         success: function(response) {
           // Handle the response\
           alert(response)
           var blob = new Blob([response]); // Adjust type according to your file type
           var url = window.URL.createObjectURL(blob);
           var a = document.createElement('a');
           a.href = url;
           a.download = response; // Adjust filename as needed
           document.body.appendChild(a);
           a.click();
           window.URL.revokeObjectURL(url);

         },
         error: function(xhr, status, error) {
           // Handle errors
           console.error(xhr.responseText);
         }
       });
     })
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
 @endif
 <script src="{{asset('assets/js/plugins.js')}}"></script>
 <!-- Sidebar Graph - END -->