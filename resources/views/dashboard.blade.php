<x-app-layout>


    <div class="py-12 text-center">
        <h2 class="text-2xl font-bold">Welcome {{Auth::user()->name}}</h2>
        
    </div>

    <div class="max-w-6xl mx-auto mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <!-- Department Card -->
    @if(Auth::user()->role === 'admin' && $departmentCount !== null)
    <a href="{{ route('departments.index') }}" class="block">
        <x-dashboard-box title="Departments" count="{{ $departmentCount }}" icon="🏫" />
    </a>
    @endif

    <!-- Development Card -->
     @if (in_array(Auth::user()->role, ['admin', 'hr', 'development']))
    <a href="{{ route('developments.index') }}" class="block">
        <x-dashboard-box title="Development Member" count="{{ $developmentCount }}" icon="💻" />
    </a>
    @endif

    <!-- Marketing cards  -->
     @if (in_array(Auth::user()->role, ['admin', 'hr', 'marketing']))
     <a href="{{ route('marketings.index') }}" class="block">
        <x-dashboard-box title="Marketing Member" count="{{ $marketingCount }}" icon="💻" />
    </a>
    @endif

</div>

    </div>
</x-app-layout>
