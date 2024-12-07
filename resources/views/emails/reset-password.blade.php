<div  style="padding: 1rem; margin: 1rem; width: 100%; ">
  <div style="max-width: 500px; margin: 0 auto; text-align: center; padding: 1rem; border-radius: 1rem; background-color: #fffabb;  ">
    <img src="{{ $message->embed( public_path('assets/images/logo.png') ) }}" alt="logo image" style="width: 80px ; height: 80px; margin: 1rem auto; display: block; ">
    <h1 style="font-size: 1.5rem; margin: 1rem 0; font-weight: bold;">Reset Your Password</h1>
    <p style="font-size: 1rem; margin: 1rem 0;">Please click the link below to reset your password:</p>
    <a href="{{ $url ?? '#' }}" style="font-size: 1rem; margin: 1rem 0; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; background-color: #000; color: #fff;">Reset My Password</a>
    <p style="font-size: 1rem; margin: 1rem 0;">If you did not request this request, please ignore this email.</p>
    <p style="font-size: 1rem; margin: 1rem 0;">If the link is not working please copy this url and paste it in your browser: <a href="{{ $url ?? '#' }}" target="_blank" style="color: blue; ">{{ $url ?? '########'  }}</a></p>
    <p style="font-size: 1rem; margin: 1rem 0;">Thank you!</p>
  </div>
</div>