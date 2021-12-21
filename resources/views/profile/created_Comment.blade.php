   <slot>
         <h5 class="card-title">You replied to  "{{$activity->activity->title}}" at {{$activity->created_at->diffForHumans()}}
              to the thread "{{$activity->activity->thread->title}}"
            </h5>
            {{-- <p class="card-text">{{$activity->activity_type}}</p> --}}
            <a href="{{$activity->activity->thread->path()}}" class="btn btn-primary">View Detail</a>
    </slot>