<x-layouts.app title="Contact Us">

    <!-- HERO SECTION -->
        <section class="relative overflow-hidden text-white">

            <!-- BACKGROUND IMAGE -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('{{ asset('storage/images/p2.jpg') }}');"
            ></div>

            <!-- SOFT PURPLE OVERLAY -->
            <div class="absolute inset-0 bg-gradient-to-r
            from-purple-900/60 via-purple-700/30 to-transparent"></div>

            <!-- GRADIENT FOR DEPTH (LIGHT) -->
            <div class="absolute inset-0 bg-gradient-to-br
                from-purple-900/40 via-purple-700/20 to-indigo-800/30">
            </div>

            <!-- CONTENT -->
            <div class="relative max-w-7xl mx-auto px-6 pt-32 pb-24">
                <div
                    x-data="reveal(100)"
                    x-show="show"
                    x-transition
                    class="max-w-2xl"
                >
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                        Get in Touch
                    </h1>

                    <p class="mt-4 text-lg text-purple-100">
                        Questions about our ebooks, downloads, or learning resources?
                        We’re here to help.
                    </p>
                </div>
            </div>

        </section>



 <!-- CONTACT SECTION -->
<section class="bg-gradient-to-r from-purple-50 via-purple-50 to-white">

    <div class="absolute inset-0 bg-gradient-to-b
        from-purple-100/60 via-purple-50/40 to-transparent">
    </div>

    <div class="relative max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- INFO -->
            <div x-data="reveal(100)" x-show="show" x-transition>
                <h2 class="text-3xl font-semibold text-zinc-900">
                    Let’s Talk
                </h2>
                <p class="mt-4 text-zinc-600 max-w-md">
                    Our support team is ready to assist you with any questions.
                </p>
            </div>

            <!-- FORM -->
       <livewire:contact.contact-us />

        </div>
    </div>
</section> 



    <x-sections.site-footer
        :links="[
            // ['label' => 'About Us', 'route' => 'about-us'],
            ['label' => 'Contact Us', 'route' => 'contact'],
            ['label' => 'Categories', 'route' => 'category.books'],
        ]"
    />

    <script>
        document.addEventListener('alpine:init', () => {
        Alpine.data('reveal', (delay = 0) => ({
            show: false,
            init() {
                setTimeout(() => {
                    this.show = true
                }, delay)
            }
        }))
    })
    </script>
</x-layouts.app>
