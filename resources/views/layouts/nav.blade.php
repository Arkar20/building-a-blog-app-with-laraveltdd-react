 <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    React+Laravel TDD
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        @if(auth()->check())
                         <li class="nav-item">
                                    <a class="nav-link" href="/threads/create">+Create Thread</a>
                        </li>
                        @endif
                       <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    All Threads
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                                <a class="dropdown-item" href="/threads">All Threads</a>
                                                @if(auth()->check())
                                                    <a class="dropdown-item" href="/threads?by={{auth()->user()->name}}">My Threads</a>
                                                @endif
                                                    <a class="dropdown-item" href="/threads?popular=1">Popular Threads</a>
                                                    <a class="dropdown-item" href="/threads?uncomment=1">Threads Without Comments</a>

                                </div>
                            </li>
                        
                        <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Channels
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                      @foreach (Cache::get('channels') as $channel)
                                                <a class="dropdown-item" href="{{'/threads/'.$channel->name}}">{{$channel->name}}</a>
                                          @endforeach
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile',auth()->user()->name) }}">
                                            Profile
                                        </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Notifications</button>

                                    {{-- //* start of notification modal --}}

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Notifications</h5></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- start of list  --}}
                                                      <div class="list-group">
                                                          @forelse (auth()->user()->notifications as $noti)
                                                          <form action="{{route('noti.mark',$noti->id)}}" method="POST">
                                                              @csrf
                                                              @method('DELETE')
                                                            <button class="list-group-item list-group-item-action" aria-current="true">
                                                                <div class="d-flex w-100 justify-content-between">
                                                                    <h5 class="mb-1">List group item heading</h5>
                                                                    <small>3 days ago</small>
                                                                </div>
                                                                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                                                                    <small>And some small print.</small>
                                                            </button>
                                                            </form>
                                                            @empty 
                                                            <p>No NOtifications</p>
                                                          @endforelse 
                                                           
                                                         </div>
                                                    {{-- end of list  --}}
                                                </div>
                                               
                                                </div>
                                            </div>
                                            </div>
                                    {{-- //* end  of notification modal --}}
                                    
                                </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>