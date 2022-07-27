<div class="container-fluid header-container">
  <div class="row header">
    <div class="container-fluid " id="header-container">
      <div class="row">
        <!-- Header starts -->
        <nav class="navbar col-12 navbar-expand ">
          <button class="menu-btn btn btn-link btn-sm" type="button">
            <i class="material-icons">menu</i>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- large desktop market rates starts -->
            <div class="mx-auto d-none d-xl-inline">
              <div class="row mx-0">
                <div id="TRX" class="col-auto">
                  <h5 class="fs15 font-weight-normal mb-0"><span class="icon_color text-danger mx-1"><i
                        class="icon material-icons vm">arrow_drop_down</i></span> <span class="current_price">0</span>
                  </h5>
                  <p class="fs11"><span>Live</span> <span class="old_price">0</span></p>
                </div>
                <div id="USDT" class="col-auto border-left-dashed">
                  <h5 class="fs15 font-weight-normal mb-0"><span class="icon_color text-danger mx-1"><i
                        class="icon material-icons vm">arrow_drop_down</i></span> <span class="current_price">0</span>
                  </h5>
                  <p class="fs11"><span>Live</span> <span class="old_price">0</span></p>
                </div>
              </div>
            </div>
            <!-- large desktop market rates ends -->

            <!-- icons dropwdowns starts -->
            <ul class="navbar-nav ml-auto">
              <!-- flag dropdown-->

              <!-- profile dropdown-->
              <li class="nav-item dropdown ml-0 ml-sm-4">
                <a class="nav-link dropdown-toggle profile-link" href="#" id="navbarDropdown6" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <figure class="rounded avatar avatar-30">
                    <img src="{{ Avatar::create(Auth::user()->name)->setShape('square')->toBase64() }}"
                      alt="{{ Auth::user()->name }}">
                  </figure>
                  <div class="username-text ml-2 mr-2 d-none d-lg-inline-block">
                    <h6 class="username"><span>{{ trans('command.welcome') }},</span> {{ auth()->user()->name }}</h6>
                  </div>
                  <figure class="rounded avatar avatar-30 d-none d-md-inline-block">
                    <i class="material-icons">expand_more</i>
                  </figure>
                </a>
                <div class="dropdown-menu dropdown-menu-right w-300 pt-0 overflow-hidden"
                  aria-labelledby="navbarDropdown6">
                  <div class="position-relative text-center rounded py-5">
                    <div class="background">
                      <img src="{{ asset('admin/img/background-part.png') }}" alt="">
                    </div>
                  </div>
                  <div class="text-center mb-3 top-60 z-2">
                    <figure class="avatar avatar-120 mx-auto shadow">
                      <img src="{{ Avatar::create(Auth::user()->name)->setShape('square')->toBase64() }}"
                        alt="{{ Auth::user()->name }}">
                    </figure>
                  </div>
                  <h5 class="text-center mb-0">{{ Auth::user()->name }}</h5>
                  <p class="text-center">{{ Auth::user()->email }}</p>
                  <p class="text-center text-secondary fs13">{{ Auth::user()->username }}</p>
                  @role(['admin', 'user'])
                  <a class="dropdown-item border-top" href="{{ route('profile.edit', auth()->user()->username) }}">
                    <div class="row">
                      <div class="col-auto align-self-center">
                        <i class="material-icons text-success">account_box</i>
                      </div>
                      <div class="col pl-0">
                        <p class="mb-0">{{ trans('command.header.profile_description') }}</p>
                        <p class="small text-mute text-trucated">{{ trans('command.header.my_profile') }}</p>
                      </div>
                      <div class="col-auto align-self-center text-right pl-0">
                        <i class="material-icons text-mute small">chevron_right</i>
                      </div>
                    </div>
                  </a>
                  <a class="dropdown-item border-top" href="{{ route('tron.create') }}">
                    <div class="row">
                      <div class="col-auto align-self-center">
                        <i class="material-icons text-info">account_balance_wallet</i>
                      </div>
                      <div class="col pl-0">
                        <p class="mb-0">{{ trans('command.header.my_wallet') }}</p>
                        <p class="small text-mute text-trucated">{{ trans('command.header.wallet_description') }}</p>
                      </div>
                      <div class="col-auto align-self-center text-right pl-0">
                        <i class="material-icons text-mute small">chevron_right</i>
                      </div>
                    </div>
                  </a>
                  @endrole
                  <a class="dropdown-item border-top logout" href="#">
                    <div class="row">
                      <div class="col-auto align-self-center">
                        <i class="material-icons text-danger">exit_to_app</i>
                      </div>
                      <div class="col pl-0">
                        <p class="mb-0 text-danger">{{ trans('command.header.logout') }}</p>
                      </div>
                      <div class="col-auto align-self-center text-right pl-0">
                        <i class="material-icons text-mute small text-danger">chevron_right</i>
                      </div>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <!-- icons dropwdowns starts -->
          </div>
        </nav>
        <!-- Header ends -->
      </div>
    </div>
  </div>
</div>