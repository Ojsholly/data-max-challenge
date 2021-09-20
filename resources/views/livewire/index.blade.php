<div>
    <h1 class="my-10 text-3xl text-center">Books Table</h1>
    <table class="w-full mb-6 table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2">SN</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">ISBN</th>
                <th class="px-4 py-2">Authors</th>
                <th class="px-4 py-2">Number of Pages</th>
                <th class="px-4 py-2">Publisher</th>
                <th class="px-4 py-2">Country</th>
                <th class="px-4 py-2">Release Date</th>
                <th class="px-4 py-2 text-center" rowspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 border">{{ $book->name }}</td>
                <td class="px-4 py-2 border">{{ $book->isbn }}</td>
                <td class="px-4 py-2 border">{{ implode(", ", $book->authors) }}</td>
                <td class="px-4 py-2 border">{{ $book->number_of_pages }}</td>
                <td class="px-4 py-2 border">{{ $book->publisher }}</td>
                <td class="px-4 py-2 border">{{ $book->country }}</td>
                <td class="px-4 py-2 border">{{ $book->release_date }}</td>
                <td class="px-4 py-2 border">
                    <a href="#" class="bg-yellow-500 hover:bg-yellow-700 text-white text-center py-2 px-4 rounded">
                        Edit
                    </a>
                </td>
                <td class="px-4 py-2 border">
                    <a wire:click="confirmDelete({{ $book->id }})"
                        class="bg-red-500 hover:bg-red-700 text-white text-center py-2 px-4 rounded">
                        Delete
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
             if (result.isConfirmed) {
                window.livewire.emit('delete', event.detail.book.id);
            }
            });
        });
</script>
@endpush