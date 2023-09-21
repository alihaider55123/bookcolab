<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class LiveHomeComponent extends Component
{
    public $books;

    public function mount(){
        $this->books = Book::with('auther')->get();
    }
    
    public function render()
    {
        return view('livewire.live-home-component')->layout('layouts.client');
    }
}
