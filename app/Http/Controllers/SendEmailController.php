<?php

namespace App\Http\Controllers;
use Mail;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendEmailController extends Controller
{
    public function index()
    {
        $content = [
            'name' => 'Ini Nama Pengirim',
            'subject' => 'Ini subject email',
            'body' => 'Ini isi email',
        ];

        FacadesMail::to('anaisdiyanto@gmail.com')->send(new SendEmail($content));
        return "Email berhasil dikirim!";
    }
}
