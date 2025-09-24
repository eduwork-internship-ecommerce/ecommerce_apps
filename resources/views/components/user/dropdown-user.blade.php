      <!-- Settings Dropdown user profile-->
      <div class="hidden sm:flex sm:items-center sm:ms-6">
          <x-dropdown align="right" width="48">
              <x-slot name="trigger">
                  <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[var(--deep-brown)] bg-[var(--dark-gold)] hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">


                      <div class="flex items-center gap-2">

                          <svg class="fill-current" width="24" height="24" viewBox="0 0 68 68" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M34.322 0.453857C15.8729 0.453857 0.916992 15.4098 0.916992 33.8588C0.916992 52.3079 15.8729 67.2638 34.322 67.2638C52.771 67.2638 67.727 52.3079 67.727 33.8588C67.727 24.9993 64.2075 16.5026 57.9429 10.238C51.6782 3.9733 43.1815 0.453857 34.322 0.453857ZM34.3217 10.4755C39.8564 10.4755 44.3432 14.9623 44.3432 20.497C44.3432 26.0317 39.8564 30.5185 34.3217 30.5185C28.787 30.5185 24.3002 26.0317 24.3002 20.497C24.3002 14.9623 28.787 10.4755 34.3217 10.4755ZM34.3211 57.1982C41.7206 57.1982 48.6834 53.696 53.0947 47.7553C53.7783 46.7561 53.8678 45.4653 53.3286 44.3814L52.5603 42.8113C50.8794 39.3809 47.3944 37.2044 43.5743 37.1993H25.068C21.1934 37.2035 17.6684 39.4407 16.0152 42.9449L15.3137 44.4148C14.7876 45.4898 14.8768 46.764 15.5475 47.7553C19.9589 53.696 26.9217 57.1982 34.3211 57.1982Z"></path>
                          </svg>
                          <p>{{ Auth::user()->name }}</p>
                      </div>

                      <div class="ms-1">
                          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                          </svg>
                      </div>
                  </button>
              </x-slot>

              <x-slot name="content">
                  <x-dropdown-link :href="route('profile.edit')">
                      {{ __('Profile') }}
                  </x-dropdown-link>

                  <!-- Authentication -->
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf

                      <x-dropdown-link :href="route('logout')"
                          onclick="event.preventDefault();
                                                this.closest('form').submit();">
                          {{ __('Log Out') }}
                      </x-dropdown-link>
                  </form>
              </x-slot>
          </x-dropdown>
      </div>