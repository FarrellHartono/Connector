<footer class="bg-gray-900 text-white py-6">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <!-- Logo or App Name -->
            <div class="text-lg font-bold">
                Connector<span class="text-blue-500">App</span>
            </div>

            @if (!request()->routeIs('welcome'))
            <!-- Navigation Links -->
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="{{ route("home") }}" class="text-gray-400 hover:text-white transition">Home</a>
                <a href="{{ route("listBusiness") }}" class="text-gray-400 hover:text-white transition">My Business</a>
                <a href="{{ route("profile") }}" class="text-gray-400 hover:text-white transition">Profile</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Approval</a>
            </div>
            @endif

            <!-- Copyright -->
            <div class="text-sm text-gray-500 mt-4 md:mt-0">
                &copy; 2024 ConnectorApp. All Rights Reserved.
            </div>
        </div>
    </div>
</footer>
