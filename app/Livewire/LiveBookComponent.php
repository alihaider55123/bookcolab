<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class LiveBookComponent extends Component
{
    public $book;

    protected $rules = [
        'book.name' => 'required',
        'book.sections' => 'nullable',
    ];

    public function mount(Book $book){
        $this->book = $book->load(['sections' => function($sections){
            $sections->where('parent_section_id', null);
        }]);
    }

    public function render()
    {
        return view('livewire.live-book-component')->layout('layouts.client');
    }
}
