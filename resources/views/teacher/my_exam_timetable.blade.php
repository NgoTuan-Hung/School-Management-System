@extends('layouts.master')

@section('content')
    @include('message')
    @foreach($examSchedule as $examDetails)
        <div class="exam-list">
            <h3>Exam: {{ $examDetails['exam_name'] }}</h3>
            @foreach($examDetails['subjects'] as $subject)
                <div class="exam-info">
                    <p><strong>Subject:</strong> {{ $subject['subject_name'] }}</p>
                    <p><strong>Date:</strong> {{ date('l, d-m-Y', strtotime($subject['exam_date'])) }}</p>
                    <p><strong>Room:</strong> {{ $subject['room'] }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection

<div class="page-wrapper">
    <section class="content-section">
        <div class="content-box">
            @foreach($schedule as $examData)
                <div class="exam-card">
                    <h3>{{ $examData['exam_title'] }}</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Room Number</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($examData['exams'] as $examInfo)
                                <tr>
                                    <td>{{ $examInfo['subject'] }}</td>
                                    <td>{{ $examInfo['room'] }}</td>
                                    <td>{{ $examInfo['marks'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </section>

    <section class="exam-header">
        <div class="container">
            <h1>Exam Schedule</h1>
        </div>
    </section>

    <section class="exam-details">
        @foreach($schedule as $record)
            <div class="exam-card">
                <h2>Course: <span>{{ $record['course_name'] }}</span></h2>
                @foreach($record['exams'] as $exam)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Exam Name</th>
                                <th>Exam Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $exam['exam_name'] }}</td>
                                <td>{{ date('d-m-Y', strtotime($exam['exam_date'])) }}</td>
                                <td>{{ date('g:i A', strtotime($exam['exam_time'])) }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            </div>
        @endforeach
    </section>
</div>

<section class="exam-footer">
    <footer>
        <div class="exam-info">
            @foreach($examData as $exam)
                <h3>Exam Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Passing Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exam['subjects'] as $subject)
                            <tr>
                                <td>{{ $subject['subject_name'] }}</td>
                                <td>{{ date('g:i A', strtotime($subject['start_time'])) }}</td>
                                <td>{{ date('g:i A', strtotime($subject['end_time'])) }}</td>
                                <td>{{ $subject['passing_marks'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </footer>
</section>

<div class="exam-schedule">
    @foreach($examDetails['subjects'] as $examSubject)
        <table class="table">
            <tr>
                <th>Exam Time</th>
                <th>Subject</th>
                <th>Location</th>
            </tr>
            <tr>
                <td>{{ date('g:i A', strtotime($examSubject['exam_time'])) }}</td>
                <td>{{ $examSubject['subject_name'] }}</td>
                <td>{{ $examSubject['room_number'] }}</td>
            </tr>
        </table>
    @endforeach
</div>

<div class="exam-schedule">
    @foreach($examDetails['subjects'] as $examSubject)
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Room Number</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $examSubject['subject_name'] }}</td>
                    <td>{{ $examSubject['room'] }}</td>
                    <td>{{ $examSubject['marks'] }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach
</div>

    <section class="exam-footer">
        <footer>
        </footer>
    </section>

@endsection
