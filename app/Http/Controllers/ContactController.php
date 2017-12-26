<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ContactController extends Controller
{
    // public function contactMail()
    // {
    //     define('MY_EMAIL', 'aleksandr.chasovnikov@gmail.com');

    //     $receiver = MY_EMAIL;

    //     $email = trim($_POST['email']);
    //     $message = trim($_POST['message']);
    //     $text = "Email: $email \r\nMessage: $message";
    //     $title = 'Новая заявка';

    //     mail($receiver, $title, $text, "Content-type: text/plain; charset=\"utf-8\"\r\nFrom: $receiver");

    //     $success = 'Сообщение отправлено!';

    //     return view('contact')->with(['success' => $success]);
    // }

    public function contactMail(Request $request)
    {

        $a = Article::find(21)->user->id;
        dd($a);


        define('MY_EMAIL', 'aleksandr.chasovnikov@gmail.com');

        $receiver = MY_EMAIL;

        if ($request->isMethod('post')) {

            $rules = [
                'email' => 'required|email',
                'message' => 'required|max:2000|alpha_dash',
            ];

            $messages = [
              'email.required' => 'Нам надо знать ваш e-mail!',
            ];

            $this->validate($request, $rules, $messages);
        }

    }

}
