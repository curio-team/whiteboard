@extends('layouts.app')

@section('content')
    <div class="board">
        @if(count($announcements) || Gate::allows('admin'))
            <div class="category announcements">
                <div class="title">
                    <h2>Announcements</h2>
                    @if(Gate::allows('admin'))
                        <a class="btn btn-primary" href="{{ route('announcements.create') }}">Nieuw</a>
                    @endif
                </div>
                <ul>
                    @foreach($announcements as $announcement)
                        <li>
                            <strong>{{ $announcement->title }}</strong><?php echo $announcement->body ? ': ' . $announcement->body : ''; ?>
                            @if(Gate::allows('admin'))
                                <a class="pull-right glyphicon glyphicon-remove" href="{{ route('announcements.delete', $announcement->id) }}"></a>
                            @endif
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
                    @if(Gate::allows('admin'))
                        <div class="admin-buttons">
                            <a class="btn btn-warning" href="{{ route('categories.clear', $category->id) }}">Leegmaken</a>
                            <a class="btn btn-danger" href="{{ route('categories.toggle', $category->id) }}">Uitschakelen</a>
                        </div>
                    @endif
                    <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#descriptionModal">Voeg mij toe</a>
                </div>
            </div>
            <ul id="category-{{ $category->id }}">
                @foreach($category->users as $user)
                    <li id="category-{{ $category->id }}-user-{{ $user->id }}">
                        <span class="time">
                            {{ $user->pivot->updated_at->format('d/m H:i') }}
                        </span>
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
        </div>
        @endforeach
    </div>

    <div class="modal fade in" id="descriptionModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Beschrijf kort je vraag</h5>
                </div>
                <div class="modal-body">
                    <textarea name="modalInput" id="modalInput" cols="75" rows="10" placeholder="Beschrijving"></textarea>
                    <input type="hidden" id="user" value="{{ Auth::user()->id }}">
                    <input type="hidden" id="category" value="{{ $category->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSubmit">Voeg mij toe</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#btnSubmit').click( function() {
            var user = $('#user').val();
            var category = $('#category').val();
            var description = $('#modalInput').val();

            window.location.href = '/signup/user/'+ user +'/category/'+ category +'/description/' + description;
        });
    </script>
@endsection

