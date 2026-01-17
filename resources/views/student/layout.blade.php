<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 overflow-hidden">

<div class="flex h-screen">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-64 bg-white border-r shadow-sm hidden md:flex md:flex-col">

        <div class="px-6 py-4 text-xl font-bold border-b">
            🎓 Student Panel
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 text-sm">

            <a href="{{ route('student.dashboard') }}"
               class="px-4 py-2 rounded flex items-center gap-2
               {{ request()->routeIs('student.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-blue-50' }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('student.batches') }}"
               class="px-4 py-2 rounded flex items-center gap-2 text-gray-700 hover:bg-blue-50">
                📚 My Batches
            </a>

            <a href="{{ route('student.attendance') }}"
               class="px-4 py-2 rounded flex items-center gap-2 text-gray-700 hover:bg-blue-50">
                📝 Attendance
            </a>

            <a href="{{ route('student.tests') }}"
               class="px-4 py-2 rounded flex items-center gap-2 text-gray-700 hover:bg-blue-50">
                🧪 Tests / Practice
            </a>

           <a href="{{ route('student.results') }}"
   class="px-4 py-2 rounded flex items-center gap-2
   {{ request()->routeIs('student.results*')
        ? 'bg-blue-100 text-blue-700 font-semibold'
        : 'text-gray-700 hover:bg-blue-50' }}">
    📊 Results
</a>

            <a href="{{ route('student.live-classes') }}"
               class="px-4 py-2 rounded flex items-center gap-2 text-gray-700 hover:bg-blue-50">
                🎥 Live Classes
            </a>

            <a href="#"
               class="px-4 py-2 rounded flex items-center gap-2 text-gray-700 hover:bg-blue-50">
                📢 Announcements
            </a>

        </nav>

        <div class="px-4 py-4 border-t text-xs text-gray-500">
            Logged in as Student
        </div>
    </aside>

    <!-- ================= MAIN ================= -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- HEADER -->
        <header class="bg-white border-b px-6 h-16 flex justify-between items-center shrink-0">
            <h1 class="text-lg font-semibold text-gray-700">
                @yield('page-title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
