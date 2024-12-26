@extends('layouts._home_app')
@section('content')

<body class="index-page">
<main class="main"> 

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      @foreach ($getContent as $content )
      <img src="{{$content->getProfileDirect()}}" alt="" data-aos="fade-in">
      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100">{{$content->title}}</h2>
        <p data-aos="fade-up" data-aos-delay="200">{{$content->small_title}}</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="{{url('school/crouse')}}" class="btn-get-started">Get Started</a>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="{{$content->getProfileDirectUs()}}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>About Us</h3>
            {!! $content->about_us !!}
            <p class="fst-italic">
            </p>
            <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->
        
      @endforeach

      
    <!-- Counts Section -->
    <section id="counts" class="section counts light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end={{$getTotalStudent}} data-purecounter-duration="1" class="purecounter"></span>
              <p>Students</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end={{$getTotalCrouse}} data-purecounter-duration="1" class="purecounter"></span>
              <p>Class</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end={{$getTotalTeacher}} data-purecounter-duration="1" class="purecounter"></span>
              <p>Trainers</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Counts Section -->

    <!-- Courses Section -->
    <section id="courses" class="courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
          <h2>Courses</h2>
          <p>Popular Courses</p>
      </div><!-- End Section Title -->
  
      <div class="container">
          <div class="row">
              @foreach($getClass as $class)
                  <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                      <div class="course-item">
                          <img src="{{$class->getClassProfileDirect()}}" class="img-fluid" alt="...">
                          <div class="course-content">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                  <!-- Hiển thị tên lớp học -->
                                  <p class="category">{{ $class->name }}</p>
                                  <p class="price">${{$class->amount}}</p>
                              </div>
  
                              <p class="description">Et architecto provident deleniti facere repellat nobis iste. Id facere quia quae dolores dolorem tempore.</p>
                              <div class="trainer d-flex justify-content-between align-items-center">
                                  <div class="trainer-profile d-flex align-items-center">
                                      <img src="{{ $class->getTeacherProfileDirect() }}" class="img-fluid" alt="">
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
                  </div>
              @endforeach
          </div>
      </div>
  </section>
  

    <!-- Trainers Index Section -->
    <section id="trainers-index" class="section trainers-index">

      <div class="container">

        <div class="row">
          @foreach ($teachers as $teacher )
          <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <<img src="{{ $teacher->getProfileDirect() }}" class="img-fluid" alt="">
              <div class="member-content">
                <h4>{{$teacher->name}}</h4>
                <span>{{$teacher->qualification}}</span>
                <p>
                  {{$teacher-> note}}
                </p>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->
            
          @endforeach
         

        </div>

      </div>

    </section><!-- /Trainers Index Section -->

  </main>

  @endsection
