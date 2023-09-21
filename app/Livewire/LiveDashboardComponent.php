<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveDashboardComponent extends Component
{
    public $books;

    public function mount()
    {
        $this->books = Book::whereJsonContains('collaborators', Auth::id())
        ->orWhere('user_id', Auth::id())->get();
    }

    public function render()
    {
        return view('dashboard');
    }
}
