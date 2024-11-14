<?php

namespace App\Http\Controllers;
use Mail;
use App\Mail\SendEmail;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendEmailController extends Controller
{
    public function index()
    {
        return view('emails.kirim-email');
        // $content = [
        //     'name' => 'Ini Nama Pengirim',
        //     'subject' => 'Ini subject email',
        //     'body' => 'Ini isi email',
        // ];

        // FacadesMail::to('erin611579@gmail.com')->send(new SendEmail($content));
        // return "Email berhasil dikirim!";
    }

    public function store(Request $request)
    {
        $data = $request->all();
        dispatch(new SendEmailJob($data));

        return redirect()->route('kirim-email')->with('success', 'Email berhasil dikirim');
    }
}
