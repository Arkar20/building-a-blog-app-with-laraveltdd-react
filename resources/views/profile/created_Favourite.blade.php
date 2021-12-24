   <slot>

   {{-- {{dd($activity->activity)}} --}}
          <h5 class="card-title">You Favourited This Comment <q> {{$activity->activity->favouriteable->title}} </q> </h5>

             <a href="{{$activity->activity->favouriteable->thread->path()}}" class="btn btn-primary">View Detail</a>
    </slot>