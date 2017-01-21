<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactAdmin;
use Illuminate\Http\Request;

use Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('public.contact');
    }

    public function send(ContactFormRequest $request)
    {
        $email = $request->get('email');
        $name = $request->get('name');
        $subject = $request->get('subject');
        $the_message = $request->get('the_message');
        $the_mail = new ContactAdmin($name, $email, $subject, $the_message);
        Mail::to('stef.kariotidis.dev@gmail.com')->send($the_mail);
        return redirect(route('contact'))->with('status', 'Your message has been sent');
    }
}
