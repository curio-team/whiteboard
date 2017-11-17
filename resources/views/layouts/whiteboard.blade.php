@extends('layouts.app')

@section('content')
    <div class="board">
        
        @if(count($announcements))
            <div class="category announcements">
                <div class="title">
                    <h2>Announcements</h2>
                </div>
                <ul>
                    @foreach($announcements as $announcement)
                        <li>
                            <strong>{{ $announcement->title }}</strong><?php echo $announcement->body ? ': ' . $announcement->body : ''; ?>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @foreach($categories as $category)
        <div class="category">
            <div class="title">
                <h2>{{$category->name}}</h2>
                <div>
                    <a class="btn btn-primary" href="/signup/user/{{ Auth::user()->id }}/category/{{ $category->id }}">Voeg mij toe</a>
                </div>
            </div>
            @if(!count($category->users))
                <p>Dit whiteboard is leeg</p>
            @else
                <ul>
                    @foreach($category->users as $user)
                        <li>
                            {{$user->name}}
                            @if(!empty($user->pivot->description))
                                ({{$user->pivot->description}})
                            @endif
                            @if(Gate::allows('edit-own', $user))
                                <a class="pull-right glyphicon glyphicon-remove" href="/signoff/user/{{ $user->id }}/category/{{ $category->id }}"></a>
                            @endif
                        </li>                        
                    @endforeach
                </ul>
            @endif
        </div>
        @endforeach
    </div>
@endsection