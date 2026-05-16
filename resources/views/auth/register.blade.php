<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Location Selection -->
        <div class="mt-4" x-data="{
            selectedState: '{{ old('state_id') }}',
            selectedCity: '{{ old('city_id') }}',
            selectedLocality: '{{ old('locality_id') }}',
            selectedSociety: '{{ old('society_id') }}',
            houseNo: '{{ old('house_no') }}',
            cities: [],
            localities: [],
            societies: [],
            loadCities() {
                this.cities = [];
                this.localities = [];
                this.societies = [];
                if (!this.selectedState) return;
                fetch('/api/states/' + this.selectedState + '/cities')
                    .then(r => r.json())
                    .then(data => {
                        this.cities = data;
                        if(this.selectedCity && !data.find(c => c.id == this.selectedCity)) {
                            this.selectedCity = '';
                        }
                    });
            },
            loadLocalities() {
                this.localities = [];
                this.societies = [];
                if (!this.selectedCity) return;
                fetch('/api/cities/' + this.selectedCity + '/localities')
                    .then(r => r.json())
                    .then(data => {
                        this.localities = data;
                        if(this.selectedLocality && !data.find(l => l.id == this.selectedLocality)) {
                            this.selectedLocality = '';
                        }
                    });
            },
            loadSocieties() {
                this.societies = [];
                if (!this.selectedLocality) return;
                fetch('/api/localities/' + this.selectedLocality + '/societies')
                    .then(r => r.json())
                    .then(data => {
                        this.societies = data;
                        if(this.selectedSociety && !data.find(s => s.id == this.selectedSociety)) {
                            this.selectedSociety = '';
                        }
                    });
            },
            get previewAddress() {
                let parts = [];
                if (this.houseNo) parts.push(this.houseNo);
                let soc = this.societies.find(s => s.id == this.selectedSociety);
                let loc = this.localities.find(l => l.id == this.selectedLocality);
                let cit = this.cities.find(c => c.id == this.selectedCity);
                if (soc) parts.push(soc.name);
                if (loc) parts.push(loc.name);
                if (cit) parts.push(cit.name);
                // State name is hardcoded to Punjab here if we don't pass the states array, but let's just append something generic if not loaded
                let stateSelect = document.querySelector('select[name=\'state_id\']');
                if (stateSelect && stateSelect.options[stateSelect.selectedIndex]) {
                    let stateName = stateSelect.options[stateSelect.selectedIndex].text;
                    if(stateName && stateName !== '— Select State —') {
                        parts.push(stateName);
                    }
                }
                if (soc && soc.pincode) 
                    parts[parts.length-1] += ' - ' + soc.pincode;
                return parts.join(', ') || 'Fill in the fields above...';
            },
            init() {
                if(this.selectedState) this.loadCities();
                if(this.selectedCity) this.loadLocalities();
                if(this.selectedLocality) this.loadSocieties();
            }
        }" x-init="init()">
            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Your Location</h3>

            <!-- State -->
            <div class="mb-4">
                <x-input-label for="state_id" :value="__('State')" />
                <select name="state_id" id="state_id" x-model="selectedState" @change="selectedCity=''; selectedLocality=''; selectedSociety=''; loadCities()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    <option value="">— Select State —</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('state_id')" class="mt-2" />
            </div>

            <!-- City -->
            <div class="mb-4" x-show="selectedState" x-transition x-cloak>
                <x-input-label for="city_id" :value="__('City')" />
                <select name="city_id" id="city_id" x-model="selectedCity" @change="selectedLocality=''; selectedSociety=''; loadLocalities()" :disabled="cities.length === 0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    <option value="">— Select City —</option>
                    <template x-for="city in cities" :key="city.id">
                        <option :value="city.id" x-text="city.name"></option>
                    </template>
                </select>
                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
            </div>

            <!-- Locality -->
            <div class="mb-4" x-show="selectedCity" x-transition x-cloak>
                <x-input-label for="locality_id" :value="__('Locality / Area')" />
                <p class="text-xs text-gray-500 mb-1">The main area or sector of the city</p>
                <select name="locality_id" id="locality_id" x-model="selectedLocality" @change="selectedSociety=''; loadSocieties()" :disabled="localities.length === 0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    <option value="">— Select Locality —</option>
                    <template x-for="loc in localities" :key="loc.id">
                        <option :value="loc.id" x-text="loc.name"></option>
                    </template>
                </select>
                <x-input-error :messages="$errors->get('locality_id')" class="mt-2" />
            </div>

            <!-- Society -->
            <div class="mb-4" x-show="selectedLocality" x-transition x-cloak>
                <x-input-label for="society_id" :value="__('Society / Colony')" />
                <p class="text-xs text-gray-500 mb-1">Your specific residential society, colony, block or phase</p>
                <select name="society_id" id="society_id" x-model="selectedSociety" :disabled="societies.length === 0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    <option value="">— Select Society —</option>
                    <template x-for="soc in societies" :key="soc.id">
                        <option :value="soc.id">
                            <span x-text="soc.name"></span>
                            <template x-if="soc.landmark"><span> &middot; <span x-text="soc.landmark"></span></span></template>
                        </option>
                    </template>
                </select>
                <x-input-error :messages="$errors->get('society_id')" class="mt-2" />
                
                <div class="mt-2" x-show="selectedSociety">
                    <template x-if="societies.find(s => s.id == selectedSociety)">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize"
                            :class="{
                                'bg-olive text-white': societies.find(s => s.id == selectedSociety).type === 'colony',
                                'bg-blue-100 text-blue-800': societies.find(s => s.id == selectedSociety).type === 'block',
                                'bg-amber text-white': societies.find(s => s.id == selectedSociety).type === 'phase',
                                'bg-teal-100 text-teal-800': societies.find(s => s.id == selectedSociety).type === 'sector',
                                'bg-purple-100 text-purple-800': societies.find(s => s.id == selectedSociety).type === 'enclave',
                                'bg-gray-100 text-gray-800': ['colony','block','phase','sector','enclave'].indexOf(societies.find(s => s.id == selectedSociety).type) === -1
                            }"
                            x-text="societies.find(s => s.id == selectedSociety).type || 'other'">
                        </span>
                    </template>
                </div>
            </div>

            <!-- House No -->
            <div class="mb-4" x-show="selectedSociety" x-transition x-cloak>
                <x-input-label for="house_no" :value="__('House No. / Flat No. / Street')" />
                <p class="text-xs text-gray-500 mb-1">Optional. Only used to personalize your address. Never shown publicly.</p>
                <x-text-input id="house_no" x-model="houseNo" class="block mt-1 w-full" type="text" name="house_no" placeholder="e.g. H.No. 234, Street 4 OR Flat 301, Tower B" />
                <x-input-error :messages="$errors->get('house_no')" class="mt-2" />
            </div>

            <!-- Address Preview Box -->
            <div class="mt-6 p-4 rounded-md border-l-4 border-terracotta bg-cream text-sm shadow-sm" x-show="selectedLocality" x-transition x-cloak>
                <div class="flex items-start gap-2 mb-2 font-bold text-navy">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Your address:
                </div>
                <div class="pl-6 whitespace-pre-line text-gray-700 leading-relaxed font-mono" x-text="previewAddress">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
