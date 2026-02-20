<footer class="relative bg-gradient-to-br from-purple-700 via-purple-600 to-indigo-600 text-white overflow-hidden">

    {{-- Soft top divider --}}
    <div class="absolute inset-x-0 top-0 h-px bg-white/20"></div>

    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-5 gap-10">

        {{-- Logo + Socials --}}
        <div class="space-y-6">

            <h2 class="text-2xl font-semibold tracking-tight">
                Logo
            </h2>

            <div class="flex space-x-4 text-lg">

                <a href="#"
                   class="h-10 w-10 rounded-full bg-white/10 backdrop-blur
                          flex items-center justify-center
                          hover:bg-white hover:text-purple-700
                          transition duration-300 shadow-md">
                    𝕏
                </a>

                <a href="#"
                   class="h-10 w-10 rounded-full bg-white/10 backdrop-blur
                          flex items-center justify-center
                          hover:bg-white hover:text-purple-700
                          transition duration-300 shadow-md">
                    📘
                </a>

                <a href="#"
                   class="h-10 w-10 rounded-full bg-white/10 backdrop-blur
                          flex items-center justify-center
                          hover:bg-white hover:text-purple-700
                          transition duration-300 shadow-md">
                    📸
                </a>

            </div>
        </div>

        {{-- Footer Columns --}}
        @foreach ($columns as $column)
            <div>
                <ul class="space-y-3 text-sm">
                    @foreach ($column as $link)
                        <li>
                            <a href="#"
                               class="relative text-white/80 hover:text-white
                                      transition duration-300
                                      after:absolute after:left-0 after:-bottom-1
                                      after:h-[1px] after:w-0
                                      after:bg-white
                                      after:transition-all after:duration-300
                                      hover:after:w-full">
                                {{ $link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

    </div>
</footer>
