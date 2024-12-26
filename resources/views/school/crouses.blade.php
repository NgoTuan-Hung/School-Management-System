@extends('layouts._home_app')
@section('content')

<body class="courses-page">
  <main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Courses</h1>
              <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Courses</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Courses Section -->
    <section id="courses" class="courses section">

      <div class="container">

        <div class="row">

          @foreach ($getClass as $class)
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="course-item">
              <img src="{{$class->getClassProfileDirect()}}" class="img-fluid" alt="...">
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <p class="category">HAST</p>
                  <p class="price">${{$class->amount}}</p>
                </div>

                <h3><a href="{{url('school/details/'.$class->id)}}">{{$class->name}}</a></h3>
                <p class="description">Et architecto provident deleniti facere repellat nobis iste. Id facere quia quae dolores dolorem tempore.</p>
                <div class="trainer d-flex justify-content-between align-items-center">
                  <div class="trainer-profile d-flex align-items-center">
                    <img src="assets/img/trainers/trainer-1-2.jpg" class="img-fluid" alt="">
                    <a href="" class="trainer-link">{{$class->teacher_name}}</a>
                  </div>
                  <div class="trainer-rank d-flex align-items-center">
                    <i class="bi bi-person user-icon"></i>&nbsp;50
                    &nbsp;&nbsp;
                    <i class="bi bi-heart heart-icon"></i>&nbsp;65
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- End Course Item-->
              
          @endforeach

          

          
    </section><!-- /Courses Section -->

  </main>

  @endsection
