<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Book (Role: {{$this->book->role ?? 'Author'}})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            @if ($this->book->id ?? false)
            <div class="card">
                <div class="card-header">
                    Collaborators
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <label for="">Email</label>
                            <input wire:model='collaboratorEmail' type="text" class="form-control"
                                placeholder="email address">
                            @error("collaboratorEmail")
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-8">
                            <button wire:target='addCollaborator' wire:loading.attr='disabled'
                                class="btn btn-primary mt-4" wire:click='addCollaborator'><i class="fa fa-spinner spin"
                                    wire:target='addCollaborator' wire:loading></i> Add Collaborator</button>
                        </div>
                        <div class="col-12">
                            @foreach ($collaborators as $item)
                            <div style="min-width:500px" class="border inline-block p-2 mt-3 mb-3">{{$item->name}} <i
                                    wire:click='removeCollaborator({{$item->id}})'
                                    class="float-end fa fa-trash text-danger"></i></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    Basic Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="title">Title</label>
                            <input wire:model='name' type="text" name="title" class="form-control">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="intro">Intro</label>
                            <textarea wire:model='intro' name="intro" id="" cols="30" rows="5"
                                class="form-control"></textarea>
                            @error('intro')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-end col-12 mt-3">
                            @if ($this->book->id ?? false)
                            <button class="btn btn-primary" wire:click='updateBasicInformation'
                                wire:loading.attr='disabled' wire:target='updateBasicInformation'><i
                                    class="fa fa-spinner fa-spin" wire:target='updateBasicInformation' wire:loading></i>
                                Update</button>
                            @else
                            <button class="btn btn-primary" wire:click='createBook' wire:loading.attr='disabled'
                                wire:target='createBook'><i class="fa fa-spinner fa-spin" wire:target='createBook'
                                    wire:loading></i>
                                Create</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if ($addSectionVisible)
            <div class="card">
                <div class="card-header">
                    Create New Section
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="sectionTitle">Title</label>
                            <input wire:model='sectionTitle' type="text" name="sectionTitle" class="form-control">
                            @error('sectionTitle')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="sectionContent">Content</label>
                            <textarea wire:model='sectionContent' name="sectionContent" id="" cols="30" rows="5"
                                class="form-control"></textarea>
                            @error('sectionContent')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @if ($book->role == 'author')
                        <div class="col-12">
                            <label for="sectionContent">Parent Section</label>
                            <select wire:model='parentSection' class="form-control">
                                <option value="">None</option>
                                @foreach ($allSections as $item)
                                <option value="{{$item['id']}}">{{$item['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="text-end col-12 mt-3">
                            @if (!$sectionId)
                            <button class="btn btn-primary" wire:click='createSection' wire:loading.attr='disabled'
                                wire:target='createSection'><i class="fa fa-spinner fa-spin" wire:target='createSection'
                                    wire:loading></i>
                                Create</button>
                            @else
                            <button class="btn btn-primary" wire:click='updateSection' wire:loading.attr='disabled'
                                wire:target='updateSection'><i class="fa fa-spinner fa-spin" wire:target='updateSection'
                                    wire:loading></i>
                                Update</button>
                            @endif
                            <button class="btn btn-info" wire:click='$set("addSectionVisible", false)'
                                wire:loading.attr='disabled'>
                                Cancle</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (($this->book->id ?? false) && !$addSectionVisible)
            <div class="card">
                <div class="card-header">
                    Sections
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if (!$addSectionVisible && $book->role == 'author')
                            <button class="btn btn-primary" wire:click='$set("addSectionVisible", true)'>Create Section</button>
                            @endif
                            @php
                            function displayTree($item, $padding = 0){
                            foreach($item['children'] as $key => $child){
                            @endphp
                            <div style="padding-left: {{$padding}}px">
                                <h2>{{$child['title']}} <i class="fa fa-edit" wire:click='editSection("{{$child['id']}}", "{{$child['title']}}", "{{$child['content']}}", "{{$child['parent_section_id']}}")'></i></h2>
                                <p>{{$child['content']}}</p>
                            </div>
                            @php
                            if(count($child['children'])){
                            $padding += 50;
                            displayTree($child, $padding);
                            $padding -= 50;
        
                            }
                            }
                            }
                            @endphp
                            @foreach($sections as $key => $item)
                            <h2>{{$item['title']}}<i class="fa fa-edit" wire:click='editSection("{{$item['id']}}", "{{$item['title']}}", "{{$item['content']}}", "{{$item['parent_section_id']}}")'></i></h2>
                            <p>{{$item['content']}}</p>
                            @php
                            displayTree($item, 50)
                            @endphp
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>