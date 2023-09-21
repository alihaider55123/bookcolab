<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveEditBookComponent extends Component
{
    public $collaborators;
    public $name;
    public $intro;
    public $sections = [];
    public $book;
    public $collaboratorEmail;
    public $addSectionVisible = false;
    public $sectionTitle;
    public $sectionId;
    public $sectionContent;
    public $parentSection = null;
    public $allSections;

    protected $rules = [
        'name' => 'required',
        'intro' => 'required',
        'sections.*.title' => 'required',
        'sections.*.content' => 'required'
    ];

    public function addCollaborator()
    {
        $this->validate([
            'collaboratorEmail' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $this->collaboratorEmail)->first();

        $collaborators = $this->book->collaborators ?? []   ;
        if(in_array($user->id, $collaborators)){
            $this->addError('collaboratorEmail', 'Collaborator already exists');
            return;
        }
        $collaborators[] = $user->id;
        $this->book->collaborators = $collaborators;
        $this->book->update();
        $this->refreshRecord();
    }

    public function removeCollaborator($id){
        $collaborators = $this->book->collaborators;
        if (($key = array_search($id, $collaborators)) !== false) {
            unset($collaborators[$key]);
            $this->book->collaborators = $collaborators;
            $this->book->update();
        }

        $this->refreshRecord();
    }

    private function refreshRecord(){
        $this->book = Book::find($this->book->id);
        $this->collaborators = $this->book->current_collaborators;
        $this->sections = $this->book->sections->where('parent_section_id', null)->toArray();
        $this->allSections = Section::where('book_id', $this->book->id)->get()->toArray();
    }

    public function createBook(){
        $this->validate([
            'name' => 'required',
            'intro' => 'required',
        ]);

        $this->book = Book::forceCreate([
            'name' => $this->name,
            'intro' => $this->intro,
            'user_id' => Auth::id(),
        ]);

        $this->refreshRecord();
    }

    public function mount()
    {
        $this->book = Book::find(request()->book);
        if($this->book){
            if($this->book->role != 'author' && $this->book->role != 'colab'){
                abort('404');
            }
            $this->collaborators = $this->book->current_collaborators;
            $this->name = $this->book->name;
            $this->intro = $this->book->intro;
            $this->sections = $this->book->sections->where('parent_section_id', null)->toArray();
            $this->allSections = Section::where('book_id', $this->book->id)->get()->toArray();
        }

    }

    public function editSection($id, $title, $conent, $parentId){
        $this->addSectionVisible = true;
        $this->sectionId = $id;
        $this->sectionTitle = $title;
        $this->sectionContent = $conent;
        $this->parentSection = $parentId;
    }

    public function createSection(){
        $this->validate([
            'sectionTitle' => 'required',
            'sectionContent' => 'required',
        ]);
        if($this->book->role == 'author'){
            Section::forceCreate([
                'title' => $this->sectionTitle,
                'content' => $this->sectionContent,
                'book_id' => $this->book->id,
                'parent_section_id' => $this->parentSection
            ]);
        }
        $this->refreshRecord();
        $this->clearSectionEditForm();
    }

    public function updateBasicInformation()
    {
        $this->validate([
            'name' => 'required',
            'intro' => 'required',
        ]);
        $this->book->name = $this->name;
        $this->book->intro = $this->intro;
        $this->book->update();
    }

    public function updateSection()
    {
        Section::find($this->sectionId)->update([
            'title' => $this->sectionTitle,
            'content' => $this->sectionContent,
            'parent_section_id' => $this->parentSection == "" ? null : $this->parentSection,
        ]);        
        $this->clearSectionEditForm();
        $this->refreshRecord();
    }

    private function clearSectionEditForm(){
        $this->sectionTitle = null;
        $this->sectionContent = null;
        $this->parentSection = null;
        $this->sectionId = null;
        $this->addSectionVisible = false;
    }

    public function render()
    {
        return view('livewire.live-edit-book-component');
    }
}
