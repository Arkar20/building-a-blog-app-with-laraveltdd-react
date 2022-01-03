                @foreach ($threads as $thread)
                    <div class="card-header d-flex justify-content-between">
                        <a href={{$thread->path()}} >
                          {{$thread->title}} 
                        </a>
                       <a href="{{'/profile/'.$thread->user->name}}">{{$thread->user->name}}</a>
                        @if(auth()->check() && $thread->hasNewUpdates())
                            <span class="bg-danger p-1 text-white ">New</span>  
                        @endif
                    </div>
                    <div class="card-body">
                        {{$thread->desc}}
                    </div>
                    <div class="card-footer">
                        <p>
                            {{$thread->created_at->diffForHumans()}}
                        </p>
                        <p>
                            {{$thread->comments_count}} comments
                        </p>
                    </div>
                    @endforeach
            