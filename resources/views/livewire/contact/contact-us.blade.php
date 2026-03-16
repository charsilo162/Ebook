<!-- livewire/contact-us.blade.php -->

<div
    x-data="reveal(300)"
    x-show="show"
    x-transition
    class="bg-white rounded-2xl shadow-xl p-8 md:p-10"
>
    <h3 class="text-2xl font-semibold text-zinc-900">
        Send Us a Message
    </h3>

    <form wire:submit.prevent="submit" class="mt-8 space-y-6">
        <x-form.input
            label="Full Name"
            name="name"
            placeholder="John Doe"
            wire:model="name"
        />
        @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <x-form.input
            label="Email Address"
            name="email"
            type="email"
            placeholder="you@example.com"
            wire:model="email"
        />
        @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <x-form.textarea
            label="Message"
            name="message"
            rows="5"
            placeholder="Tell us how we can help you..."
            wire:model="message"
        />
        {{-- @error('message')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror --}}

       <button
    type="submit"
    wire:loading.attr="disabled"
    class="inline-flex items-center justify-center rounded-lg
           bg-purple-600 px-6 py-3 font-medium text-white
           hover:bg-purple-700 transition disabled:opacity-50"
>
    <span wire:loading.remove wire:target="submit">
        Send Message
    </span>

    <span wire:loading wire:target="submit">
        Sending...
    </span>
</button>
    </form>

        @if ($status)
            <div class="mt-4 p-4 rounded-lg
                {{ $statusType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $status }}
            </div>
        @endif
</div>