<section>
    <header>
        <h2 class="text-gray-900">
            {{ __('Alamat Pengguna') }}
        </h2>
        <p class="mt-1 text-gray-600">
            {{ __('Tambahkan atau perbarui alamat pengiriman Anda untuk memudahkan proses checkout.') }}
        </p>
    </header>

    {{-- Div untuk menampilkan alamat yang sudah tersimpan (menggunakan dummy data) --}}
    <div class="mt-6 p-6 bg-[var(--dark-brown)] rounded-lg shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Alamat Tersimpan') }}</h3>

        @php
            // Dummy data untuk simulasi alamat pengguna
            $addresses = [
                (object)[
                    'address_line' => 'Jl. Merdeka No. 123, Kel. Suka Maju',
                    'city' => 'Jakarta',
                    'province' => 'DKI Jakarta',
                    'postal_code' => '10110',
                    'country' => 'Indonesia',
                    'is_default' => true,
                ],
                (object)[
                    'address_line' => 'Jl. Pahlawan No. 45, RT 05 RW 02',
                    'city' => 'Bandung',
                    'province' => 'Jawa Barat',
                    'postal_code' => '40115',
                    'country' => 'Indonesia',
                    'is_default' => false,
                ],
            ];
        @endphp

        @if (count($addresses) > 0)
            @foreach ($addresses as $address)
                <div class="mb-4 p-4 border border-gray-300 rounded-md bg-white">
                    <p class="text-gray-700"><strong>{{ __('Alamat Lengkap:') }}</strong> {{ $address->address_line }}</p>
                    <p class="text-gray-700"><strong>{{ __('Kota:') }}</strong> {{ $address->city }}</p>
                    <p class="text-gray-700"><strong>{{ __('Provinsi:') }}</strong> {{ $address->province }}</p>
                    <p class="text-gray-700"><strong>{{ __('Kode Pos:') }}</strong> {{ $address->postal_code }}</p>
                    <p class="text-gray-700"><strong>{{ __('Negara:') }}</strong> {{ $address->country }}</p>
                    @if ($address->is_default)
                        <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold text-white bg-amber-500 rounded-full">{{ __('Alamat Utama') }}</span>
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-gray-500 italic">{{ __('Anda belum menyimpan alamat apapun.') }}</p>
        @endif
    </div>
    
    <form method="post" action="#" class="p-6 space-y-6">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <div>
            <x-input-label for="address_line" :value="__('Alamat Lengkap')" />
            <x-text-input id="address_line" name="address_line" type="text" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('address_line')" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <x-input-label for="city" :value="__('Kota')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
            <div>
                <x-input-label for="province" :value="__('Provinsi')" />
                <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('province')" />
            </div>
            <div>
                <x-input-label for="postal_code" :value="__('Kode Pos')" />
                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
            </div>
        </div>
        <div>
            <x-input-label for="country" :value="__('Negara')" />
            <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>
        <div class="flex items-center mt-4">
            <input type="checkbox" id="is_default" name="is_default" class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500">
            <label for="is_default" class="ms-2 text-sm text-gray-600">{{ __('Jadikan Alamat Utama') }}</label>
            <x-input-error class="ms-2" :messages="$errors->get('is_default')" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Alamat') }}</x-primary-button>
        </div>
    </form>
</section>