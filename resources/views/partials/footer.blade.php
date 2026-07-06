<footer class="bg-gradient-to-br from-[#001e40] via-[#003c70] to-[#001e40] text-white border-t border-white/10 relative overflow-hidden">
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#006a6a]/20 blur-[130px] pointer-events-none"></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 px-4 md:px-10 py-24 max-w-[1280px] mx-auto relative z-10">
        <div class="col-span-1">
            <div class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white to-[#40e0d0] mb-6">GMA</div>
            <p class="text-base text-white/70 mb-6 leading-relaxed">The Global Mobile Association is the definitive body for the used mobile ecosystem, fostering leadership, standards, and global trade.</p>
            <div class="flex gap-4">
                <a href="#" class="w-11 h-11 border border-white/20 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110 hover:border-[#006a6a] hover:bg-[#006a6a]/10">
                    <span class="material-symbols-outlined text-white">share</span>
                </a>
                <a href="#" class="w-11 h-11 border border-white/20 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110 hover:border-[#006a6a] hover:bg-[#006a6a]/10">
                    <span class="material-symbols-outlined text-white">alternate_email</span>
                </a>
            </div>
        </div>
        <div>
            <h4 class="text-[13px] uppercase tracking-widest text-white mb-8 relative after:content-[''] after:absolute after:bottom-[-8px] after:left-0 after:w-8 after:h-[2px] after:bg-[#006a6a] font-semibold">Navigation</h4>
            <ul class="space-y-4">
                @foreach(['about' => 'About GMA', 'who-we-serve' => 'Who We Serve', 'committees' => 'Committees', 'events' => 'Events', 'research-insights' => 'Research & Insights'] as $route => $label)
                <li class="hover:translate-x-1.5 transition-transform duration-200">
                    <a href="{{ route($route) }}" class="text-white/75 hover:text-[#40e0d0] transition-colors duration-300 font-medium">{{ $label }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-[13px] uppercase tracking-widest text-white mb-8 relative after:content-[''] after:absolute after:bottom-[-8px] after:left-0 after:w-8 after:h-[2px] after:bg-[#006a6a] font-semibold">Association</h4>
            <ul class="space-y-4">
                <li class="hover:translate-x-1.5 transition-transform duration-200">
                    <a href="{{ route('register') }}" class="text-white/75 hover:text-[#40e0d0] transition-colors duration-300 font-medium">Join GMA</a>
                </li>
                @foreach(['Privacy Policy', 'Terms of Service'] as $link)
                <li class="hover:translate-x-1.5 transition-transform duration-200">
                    <a href="#" class="text-white/75 hover:text-[#40e0d0] transition-colors duration-300 font-medium">{{ $link }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="max-w-[1280px] mx-auto px-4 md:px-10 py-8 border-t border-white/10 text-center md:text-left relative z-10">
        <p class="text-base text-white/60">&copy; 2026 Global Mobile Association. All rights reserved.</p>
    </div>
</footer>
