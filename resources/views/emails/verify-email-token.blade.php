<div  style="padding: 1rem; margin: 1rem; width: 100%; ">
  <div style="max-width: 500px; margin: 0 auto; text-align: center; padding: 1rem; border-radius: 1rem; background-color: #fffabb;  ">
    <img src="{{ $message->embed( public_path('assets/images/logo.png') ) }}" alt="logo image" style="width: 80px ; height: 80px; margin: 1rem auto; display: block; ">
    <h1 style="font-size: 1.5rem; margin: 1rem 0; font-weight: bold;">Verify your email address</h1>
    <p style="font-size: 1rem; margin: 1rem 0;">Please click the link below to verify your email address:</p>
    <a href="{{ $url ?? '#' }}" style="font-size: 1rem; margin: 1rem 0; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; background-color: #000; color: #fff;">Verify my email address</a>
    <p style="font-size: 1rem; margin: 1rem 0;">If you did not request this verification, please ignore this email.</p>
    <p style="font-size: 1rem; margin: 1rem 0;">If the link is not working please copy this token and paste it in the input field: <b style="color: blue; ">{{ $token ?? '################' }}</b></p>
    <p style="font-size: 1rem; margin: 1rem 0;">Thank you!</p>
  </div>
</div>