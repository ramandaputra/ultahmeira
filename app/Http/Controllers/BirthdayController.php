<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\Auth;

class BirthdayController extends Controller
{
    // 1. Menampilkan halaman quiz
    public function showQuiz() 
    {
        return view('birthday.quiz');
    }

    // 2. Menyimpan jawaban quiz ke database
    public function storeQuiz(Request $request) 
    {
        QuizAnswer::create([
            'user_id' => Auth::id(),
            'color' => $request->color,
            'musician' => $request->musician,
            'outfit' => $request->outfit,
            'snack' => $request->snack,
            'place' => $request->place,
        ]);

        // Setelah simpan, beralih ke halaman slideshow
        return redirect()->route('birthday.slideshow');
    } // <-- Pastikan kurung penutup ini ada!

    // 3. Menampilkan halaman slideshow
    public function showSlideshow() 
    {
        return view('birthday.slideshow');
    }

    // 4. Menampilkan halaman kue
    public function showCake() 
    {
        return view('birthday.cake');
    }
}