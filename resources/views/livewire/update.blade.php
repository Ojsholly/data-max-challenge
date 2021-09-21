<div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                    <div class="text-gray-600">
                        <p class="font-medium text-lg">Book Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                            <div class="md:col-span-5">
                                <label for="full_name">Name</label>
                                <input type="text" wire:model.lazy="name"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" />
                                @error('name')
                                <p class="text-small text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-5">
                                <label for="full_name">ISBN</label>
                                <input type="text" wire:model.lazy="isbn"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" />
                                @error('isbn')
                                <p class="text-small text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-5">
                                <label for="full_name">Authors</label>
                                <textarea rows="5" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    wire:model.lazy="authors"></textarea>
                                <small>For multiple authors, kindly enter the names separated by a comma and
                                    space.</small>
                                @error('authors')
                                <p class="text-small text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-5">
                                <label for="email">Country</label>
                                <input type="text" wire:model.lazy="country"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" />
                                @error('country')
                                <p class="text-small text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="country">Publisher</label>
                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                    <input wire:model.lazy="publisher"
                                        class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent" />
                                    @error('publisher')
                                    <p class="text-small text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-1">
                                <label for="state">Number of Pages</label>
                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                    <input wire:model.lazy="number_of_pages"
                                        class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent"
                                        value="" />
                                    @error('number_of_pages')
                                    <p class="text-small text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label for="zipcode">Release Date</label>
                                <input type="date" max="{{ date('Y-m-d', strtotime('yesterday')) }}"
                                    wire:model.lazy="release_date"
                                    class="transition-all flex items-center h-10 border mt-1 rounded px-4 w-full bg-gray-50" />
                                @error('release_date')
                                <p class="text-small text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-5 text-right">
                                <div class="inline-flex items-end">
                                    <button type="submit" wire:click="update"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="https://www.buymeacoffee.com/dgauderman" target="_blank"
            class="md:absolute bottom-0 right-0 p-4 float-right">
            <img src="https://www.buymeacoffee.com/assets/img/guidelines/logo-mark-3.svg" alt="Buy Me A Coffee"
                class="transition-all rounded-full w-14 -rotate-45 hover:shadow-sm shadow-lg ring hover:ring-4 ring-white">
        </a>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('swal:error', event => {
            Swal.fire({
                title: 'Error',
                text: event.detail.message,
                icon: 'error'
            });
        });

    window.addEventListener('swal:success', event => {
        Swal.fire({
            title: 'Success',
            text: event.detail.message,
            icon: 'success'
        });

        setTimeout(function(){
            window.location.href = "{{ config('app.url') . '/index' }}";
        }, 3000);

    });
</script>
@endpush
