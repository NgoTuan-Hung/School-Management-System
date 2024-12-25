@extends('layouts._trainers_app')
@section('content')
<main class="main">
  <!-- Page Title -->
  <div class="page-title" data-aos="fade">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8">
            <h1>Trainers</h1>
            <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
          </div>
        </div>
      </div>
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="{{ url('school/home') }}">Home</a></li>
          <li class="current">Trainers</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!-- Trainers Section -->
  <section id="trainers" class="section trainers">

    <div class="container">

      <div class="row gy-5">
        @foreach ($getRecord as $teacher)
        <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
          <div class="member-img">
            <img src="{{url('upload/profile/'.$teacher->	profile_pic)}}" class="img-fluid" alt="">
            <div class="social">
              <a href="#"><i class="bi bi-twitter-x"></i></a>
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info text-center">
            <h4>{{$teacher->name}} {{$teacher->last_name}}</h4>
            <span>{{$teacher->qualification}}</span>
            <p>{{$teacher->work_experience}}</p>
          </div>
        </div><!-- End Team Member -->

        @endforeach
      </div>

    </div>

  </section><!-- /Trainers Section -->

</main>
@endsection

