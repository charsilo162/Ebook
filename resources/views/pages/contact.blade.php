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
            <div
                x-data="reveal(300)"
                x-show="show"
                x-transition
                class="bg-white rounded-2xl shadow-xl p-8 md:p-10"
            >
                <h3 class="text-2xl font-semibold text-zinc-900">
                    Send Us a Message
                </h3>

                <form class="mt-8 space-y-6">
                    <x-form.input
                        label="Full Name"
                        name="name"
                        placeholder="John Doe"
                    />

                    <x-form.input
                        label="Email Address"
                        name="email"
                        type="email"
                        placeholder="you@example.com"
                    />

                    <x-form.textarea
                        label="Message"
                        name="message"
                        rows="5"
                        placeholder="Tell us how we can help you..."
                    />

                    <button
                        class="inline-flex items-center justify-center rounded-lg
                            bg-purple-600 px-6 py-3 font-medium text-white
                            hover:bg-purple-700 transition"
                    >
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>


    <x-sections.site-footer
    :columns="[
        [
            'Corporate Info',
            'Accessibility',
            'Jobs',
            
        ],
     
        [
           
            'FAQ',
            'Casting',
            'Contact Us',
           
        ],
        [
            'Parental Guidelines and TV Ratings',
            'Video Viewing Policy',
            'Viewer Panel',
            'Shop',
        ],
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
