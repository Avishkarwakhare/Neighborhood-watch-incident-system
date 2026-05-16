<section x-data="{
    selectedState: '{{ old('state_id', $user->state_id) }}',
    selectedCity: '{{ old('city_id', $user->city_id) }}',
    selectedLocality: '{{ old('locality_id', $user->locality_id) }}',
    selectedSociety: '{{ old('society_id', $user->society_id) }}',
    houseNo: '{{ old('house_no', $user->house_no) }}',
    states: [],
    cities: [],
    localities: [],
    societies: [],
    loadStates() {
        fetch('/api/states')
            .then(r => r.json())
            .then(data => {
                this.states = data;
                if(this.selectedState) this.loadCities();
            });
    },
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
                } else if(this.selectedCity) {
                    this.loadLocalities();
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
                } else if(this.selectedLocality) {
                    this.loadSocieties();
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
        let st = this.states.find(st => st.id == this.selectedState);
        
        if (soc) parts.push(soc.name);
        if (loc) parts.push(loc.name);
        if (cit) parts.push(cit.name);
        if (st) {
            let stateName = st.name;
            if (soc && soc.pincode) stateName += ' - ' + soc.pincode;
            parts.push(stateName);
        }
        
        return parts.join(', ') || 'Select location to see preview...';
    },
    init() {
        this.loadStates();
    }
}" x-init="init()">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Location') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your address and locality. This helps us show you hyper-local incidents.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.location.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- State -->
        <div>
            <x-input-label for="state_id" :value="__('State')" />
            <select name="state_id" id="state_id" x-model="selectedState" @change="selectedCity=''; selectedLocality=''; selectedSociety=''; loadCities()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                <option value="">— Select State —</option>
                <template x-for="state in states" :key="state.id">
                    <option :value="state.id" x-text="state.name"></option>
                </template>
            </select>
            <x-input-error :messages="$errors->get('state_id')" class="mt-2" />
        </div>

        <!-- City -->
        <div x-show="selectedState" x-transition x-cloak>
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
        <div x-show="selectedCity" x-transition x-cloak>
            <x-input-label for="locality_id" :value="__('Locality / Area')" />
            <select name="locality_id" id="locality_id" x-model="selectedLocality" @change="selectedSociety=''; loadSocieties()" :disabled="localities.length === 0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                <option value="">— Select Locality —</option>
                <template x-for="loc in localities" :key="loc.id">
                    <option :value="loc.id" x-text="loc.name"></option>
                </template>
            </select>
            <x-input-error :messages="$errors->get('locality_id')" class="mt-2" />
        </div>

        <!-- Society -->
        <div x-show="selectedLocality" x-transition x-cloak>
            <x-input-label for="society_id" :value="__('Society / Colony')" />
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
        <div x-show="selectedSociety" x-transition x-cloak>
            <x-input-label for="house_no" :value="__('House No. / Flat No. / Street')" />
            <x-text-input id="house_no" x-model="houseNo" class="block mt-1 w-full" type="text" name="house_no" placeholder="e.g. H.No. 234, Street 4 OR Flat 301, Tower B" />
            <x-input-error :messages="$errors->get('house_no')" class="mt-2" />
        </div>

        <!-- Address Preview Box -->
        <div class="mt-6 p-4 rounded-md border-l-4 border-terracotta bg-cream text-sm shadow-sm" x-show="selectedLocality" x-transition x-cloak>
            <div class="flex items-start gap-2 mb-2 font-bold text-navy">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                Preview:
            </div>
            <div class="pl-6 whitespace-pre-line text-gray-700 leading-relaxed font-mono" x-text="previewAddress">
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Save Location') }}</x-primary-button>

            @if (session('success') === 'Location updated successfully.')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
