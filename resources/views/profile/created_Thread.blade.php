   <slot>
          <h5 class="card-title">You Created This Thread "{{$activity->activity->title}}" at {{$activity->created_at->diffForHumans()}}</h5>
            {{-- <p class="card-text">{{$activity->activity_type}}</p> --}}
            <a href="{{$activity->activity->path()}}" class="btn btn-primary">View Detail</a>
    </slot>