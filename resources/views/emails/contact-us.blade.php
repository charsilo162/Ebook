<!-- resources/views/emails/contact-us.blade.php -->

<h2>New Contact Message</h2>

<p><strong>Name:</strong> {{ $name }}</p>
<p><strong>Email:</strong> {{ $email }}</p>

<p><strong>Message:</strong></p>
<p>{{ $contactMessage }}</p>

<hr>

<p>Sent from {{ config('app.name') }}</p>