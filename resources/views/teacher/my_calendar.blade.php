@extends('layouts.app')

@section('style')

<style type="text/css">
  .fc-daygrid-event {
    white-space: normal;
  }
  .fc-daygrid-event2 {  
    background-color: red;
  }
</style>  

@endsection

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Calendar</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
              <div id="calendar"></div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@latest"></script>  
  <script src="/js/calendar.js"></script>  
  
  <script>
    $(document).ready(function() {
      $('#calendar').fullCalendar({
        events: '/get-events',
        editable: true,
        droppable: true,
      }); 
    });
  </script>

@endsection

@section('footer') 
  <footer>
    <p>&copy; 2024 My Calendar App</p>
  </footer>  
