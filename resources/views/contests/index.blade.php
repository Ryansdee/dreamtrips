<title>News | Dream Trips</title>
<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <h1>Contests</h1>
                    <ul>
                    @foreach($contests as $contest)
                        <li>
                            <a href="{{ route('contests.show', $contest->id) }}">{{ $contest->name }}</a>
                            <p>{{ $contest->description }}</p>
                            <p>{{ $contest->entry_fee }}€</p>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
