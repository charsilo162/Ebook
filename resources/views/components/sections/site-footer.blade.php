<footer class="bg-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-5 gap-8">

        {{-- Logo + Socials --}}
        <div class="space-y-4">
            <h2 class="text-xl font-bold">Logo</h2>

            <div class="flex space-x-4 text-lg">
                <a href="#" class="hover:opacity-80">𝕏</a>
                <a href="#" class="hover:opacity-80">📘</a>
                <a href="#" class="hover:opacity-80">📸</a>
            </div>
        </div>

        {{-- Footer Columns --}}
        @foreach ($columns as $column)
            <div>
                <ul class="space-y-2 text-sm">
                    @foreach ($column as $link)
                        <li>
                            <a href="#" class="hover:underline">
                                {{ $link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</footer>
