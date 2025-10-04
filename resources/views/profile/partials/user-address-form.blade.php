<section>
    <header>
        <h2 class="text-gray-900">
            {{ __('Alamat Pengguna') }}
        </h2>
        <p class="mt-1 text-gray-600">
            {{ __('Tambahkan atau perbarui alamat pengiriman Anda untuk memudahkan proses checkout.') }}
        </p>
    </header>

    {{-- Div untuk menampilkan alamat yang sudah tersimpan --}}
    <div class="mt-6 p-6 bg-[var(--light-cream)] rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Alamat Tersimpan') }}</h3>

        {{-- Hapus blok @php dummy data --}}

        @if (isset($addresses) && $addresses->count() > 0)
        @foreach ($addresses as $address)
        {{-- Pastikan Anda memiliki properti 'id' pada objek $address untuk delete --}}
        <div class="mb-4 p-4 border border-gray-300 rounded-md bg-white flex justify-between items-start">
            <div>
                <p class="text-gray-900 font-semibold mb-1">
                    {{ $address->recipient_name ?? 'Nama Penerima' }}
                    @if ($address->is_default)
                    <span class="ms-2 inline-block px-2 py-0.5 text-xs font-semibold text-white bg-amber-600 rounded-full">{{ __('Utama') }}</span>
                    @endif
                </p>
                <p class="text-gray-700"><strong>{{ __('Telepon:') }}</strong> {{ $address->phone ?? '-' }}</p>
                <p class="text-gray-700"><strong>{{ __('Alamat:') }}</strong> {{ $address->address_line }}</p>
                <p class="text-gray-700">{{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }} ({{ $address->country }})</p>
            </div>

            <div class="flex flex-col space-y-2">
                {{-- Tombol Hapus - Memicu Modal --}}
                <x-danger-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-address-deletion-{{ $address->id }}')">
                    {{ __('Hapus') }}
                </x-danger-button>
                {{-- Tombol Edit (Opsional, jika Anda ingin menambahkannya) --}}
                {{-- <x-secondary-button>{{ __('Edit') }}</x-secondary-button> --}}
            </div>
        </div>

        {{-- MODAL KONFIRMASI PENGHAPUSAN --}}
        <x-modal name="confirm-address-deletion-{{ $address->id }}" :show="$errors->addressDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.address.destroy', $address) }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Apakah Anda yakin ingin menghapus alamat ini?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Penghapusan alamat ini bersifat permanen. Pastikan ini bukan alamat utama Anda.') }}
                </p>

                <div class="mt-6">
                    <p class="text-sm text-gray-700 italic">{{ $address->address_line }}</p>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Hapus Alamat') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
        @endforeach
        @else
        <p class="text-gray-500 italic">{{ __('Anda belum menyimpan alamat apapun.') }}</p>
        @endif
    </div>
    <form method="post" action="{{ route('profile.address.store') }}" class="p-6 space-y-6">
        @csrf

        {{-- Field Nama Penerima --}}
        <div>
            <x-input-label for="recipient_name" :value="__('Nama Penerima')" />
            {{-- Kita gunakan old('recipient_name') untuk mempertahankan input setelah validasi gagal --}}
            <x-text-input id="recipient_name" name="recipient_name" type="text" class="mt-1 block w-full" :value="old('recipient_name')" required />
            <x-input-error class="mt-2" :messages="$errors->get('recipient_name')" />
        </div>

        {{-- Field Label --}}
        <div>
            <x-input-label for="label" :value="__('Label Alamat (Contoh: Rumah, Kantor)')" />
            <x-text-input id="label" name="label" type="text" class="mt-1 block w-full" :value="old('label')" required />
            <x-input-error class="mt-2" :messages="$errors->get('label')" />
        </div>
        {{-- Field Nomor Telepon --}}
        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon Penerima')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>
        {{-- Field Alamat Lengkap --}}
        <div>
            <x-input-label for="address_line" :value="__('Alamat Lengkap (Jalan, Nomor Rumah, RT/RW)')" />
            <x-text-input id="address_line" name="address_line" type="text" class="mt-1 block w-full" :value="old('address_line')" required />
            <x-input-error class="mt-2" :messages="$errors->get('address_line')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <x-input-label for="city" :value="__('Kota')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" required />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
            <div>
                <x-input-label for="province" :value="__('Provinsi')" />
                <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" :value="old('province')" required />
                <x-input-error class="mt-2" :messages="$errors->get('province')" />
            </div>
            <div>
                <x-input-label for="postal_code" :value="__('Kode Pos')" />
                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code')" required />
                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
            </div>
        </div>

        <div>
            <x-input-label for="country" :value="__('Negara')" />
            <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country')" required />
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <div class="flex items-center mt-4">
            {{-- Gunakan 'checked' jika old('is_default') ada atau is_default diset dari controller (misal: saat edit) --}}
            <input type="checkbox" id="is_default" name="is_default" value="1"
                class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500"
                {{ old('is_default') ? 'checked' : '' }}>
            <label for="is_default" class="ms-2 text-sm text-gray-600">{{ __('Jadikan Alamat Utama') }}</label>
            <x-input-error class="ms-2" :messages="$errors->get('is_default')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Alamat') }}</x-primary-button>
        </div>
    </form>
</section>