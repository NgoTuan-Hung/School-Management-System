@component('mail::message')
# Xin chào {{$user->name}}

Chúng tôi hiểu chuyện xảy ra và muốn giúp bạn khôi phục lại mật khẩu của mình.

@component('mail::button', ['url' => url('reset/'.$user->remember_token)])
    Đặt lại mật khẩu của bạn
@endcomponent

Nếu bạn gặp bất kỳ vấn đề gì, vui lòng [liên lạc với chúng tôi](mailto:bao992001pth@gmail.com).

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
