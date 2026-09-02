<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
        /* Custom scrollbar for scrollable panels */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 106, 106, 0.15);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 106, 106, 0.3);
        }
        
        /* Light Theme Input & Styling */
        .auth-card input[type="text"],
        .auth-card input[type="email"],
        .auth-card input[type="password"],
        .auth-card input[type="tel"],
        .auth-card select {
            border-radius: 10px !important;
            background-color: #f8fafc !important; /* slate-50 */
            border: 1px solid #e2e8f0 !important; /* slate-200 */
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            height: 2.75rem !important;
            font-size: 0.875rem !important;
            color: #0f172a !important; /* slate-900 */
            transition: all 0.2s ease-in-out !important;
            width: 100% !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.01) !important;
        }
        .auth-card input::placeholder {
            color: #71717a !important; /* zinc-500 */
        }
        .auth-card select {
            cursor: pointer;
        }
        .auth-card input:focus,
        .auth-card select:focus {
            background-color: #ffffff !important;
            border-color: #006a6a !important;
            box-shadow: 0 0 0 3px rgba(0, 106, 106, 0.08) !important;
            outline: none !important;
        }
        /* Style adjustments for password show/hide button */
        .auth-card [data-flux-input] button {
            right: 0.75rem !important;
            color: rgba(0, 30, 64, 0.5) !important;
        }
        
        @keyframes blob1 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(60px, -80px) scale(1.2) rotate(45deg); }
            66% { transform: translate(-40px, 50px) scale(0.8) rotate(-45deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        @keyframes blob2 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(-70px, 60px) scale(0.8) rotate(-60deg); }
            66% { transform: translate(50px, -80px) scale(1.2) rotate(60deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        .animate-blob-1 {
            animation: blob1 15s infinite alternate ease-in-out;
        }
        .animate-blob-2 {
            animation: blob2 18s infinite alternate ease-in-out;
        }
        
        /* Stagger field animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-stagger-item {
            opacity: 0;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .delay-100 { animation-delay: 50ms; }
        .delay-200 { animation-delay: 100ms; }
        .delay-300 { animation-delay: 150ms; }
        .delay-400 { animation-delay: 200ms; }
        .delay-500 { animation-delay: 250ms; }
        .delay-600 { animation-delay: 300ms; }
        .delay-700 { animation-delay: 350ms; }
        .delay-800 { animation-delay: 400ms; }
        
        .register-form {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.75rem !important;
        }
        
        @media (min-width: 640px) {
            .register-form {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 0.75rem !important;
            }
            .register-form .col-span-full {
                grid-column: span 2 / span 2 !important;
            }
        }

        /* Screen-height based optimizations */
        @media (max-height: 800px) {
            .dynamic-py {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            .dynamic-gap {
                gap: 1rem !important;
            }
        }
    </style>
</head>
<body class="min-h-screen antialiased overflow-hidden relative bg-white">
    @include('components.page-transition')

    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen w-screen overflow-hidden">
        
        <!-- Left Side: Informative Copy (Desktop Only) -->
        <div class="hidden lg:flex flex-col justify-between p-8 xl:p-12 text-white h-screen relative overflow-hidden bg-[#0a1120] border-r border-white/5 dynamic-py">
            <!-- Background glow blobs -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#0a1120] via-[#101b33] to-[#0a1120] pointer-events-none"></div>
            <div class="absolute top-[10%] left-[10%] w-[400px] h-[400px] bg-[#00f5d4]/10 rounded-full filter blur-[100px] animate-blob-1 pointer-events-none"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[450px] h-[450px] bg-[#006a6a]/15 rounded-full filter blur-[110px] animate-blob-2 pointer-events-none"></div>
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle at 1px 1px, #00f5d4 1px, transparent 0); background-size: 30px 30px;"></div>

            <!-- Top Header & Home Button -->
            <div class="relative z-10 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-white no-underline group" wire:navigate>
                    <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-20 w-auto object-contain brightness-0 invert transition-transform group-hover:scale-105">
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-white/70 hover:text-white transition-colors" wire:navigate>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Home
                </a>
            </div>

            <!-- Mid Section: What GMA Gives You grid -->
            <div class="relative z-10 my-auto w-full flex flex-col justify-center">
                <h2 class="text-2xl xl:text-3xl font-black text-white tracking-tight mb-6 xl:mb-8 drop-shadow-[0_2px_10px_rgba(0,245,212,0.1)]">What GMA Membership Gives You</h2>
                
                <div class="grid grid-cols-2 gap-x-6 xl:gap-x-8 gap-y-4 xl:gap-y-6">
                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">campaign</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">A Voice in the Future</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Representing and advancing the interests of the used mobile ecosystem.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">hub</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">Year-Round Connection</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Stay connected year-round through ongoing networking, webinars, and events.</p>
                        </div>
                    </div>

                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">menu_book</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">Education & Resources</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Gain access to research, white papers, and actionable industry insights.</p>
                        </div>
                    </div>

                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">groups</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">Committees & Collaboration</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Work alongside other industry professionals to solve shared challenges.</p>
                        </div>
                    </div>

                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">trending_up</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">Leadership Development</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Develop stronger teams through education and leadership resources.</p>
                        </div>
                    </div>

                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">storefront</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">Business Growth</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Build relationships with buyers, sellers, and service providers.</p>
                        </div>
                    </div>

                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">gavel</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">Advocacy & Representation</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Strengthen the collective voice of the global used mobile ecosystem.</p>
                        </div>
                    </div>

                    <div class="flex gap-2.5 xl:gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-[#006a6a]/20 border border-[#006a6a]/30 flex items-center justify-center shrink-0 text-[#00f5d4] transition-all group-hover:bg-[#006a6a]/35 group-hover:border-[#00f5d4]/40">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-white text-xs xl:text-sm">Visibility & Credibility</h5>
                            <p class="text-white/60 text-[10px] xl:text-xs mt-0.5 leading-relaxed">Increase your company's visibility within a growing global community.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="relative z-10 text-[10px] text-white/40 tracking-wider">
                &copy; {{ date('Y') }} Global Mobile Association. All rights reserved.
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="flex flex-col h-screen overflow-y-auto bg-white text-zinc-950 p-6 sm:p-10 md:p-12 lg:p-16 relative custom-scrollbar dynamic-py">
            <!-- Mobile Header Only -->
            <div class="flex lg:hidden justify-between items-center mb-6 w-full">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-zinc-950 no-underline" wire:navigate>
                    <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-14 w-auto object-contain">
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-zinc-500 hover:text-zinc-900 transition-colors" wire:navigate>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Home
                </a>
            </div>

            <div class="mx-auto w-full max-w-2xl flex flex-col justify-center my-auto">
                <div class="auth-card flex flex-col gap-4 w-full dynamic-gap">
                    
                    <!-- Header -->
                    <div class="flex flex-col items-center text-center animate-stagger-item delay-100">
                        <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-16 w-auto object-contain mb-2 drop-shadow-sm hidden lg:block">
                        <h2 class="text-2xl font-black text-[#001e40] tracking-tight">Create an Account</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Enter your details below to join GMA</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-2" :status="session('status')" />

                    @if ($teamInvitation)
                        <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Register')" class="col-span-full" />
                    @endif

                    <form method="POST" action="{{ route('register.store') }}" class="register-form">
                        @csrf

                        <!-- Name -->
                        <div class="animate-stagger-item delay-200">
                            <flux:input
                                name="name"
                                :value="old('name')"
                                type="text"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Full Name"
                            />
                            @error('name') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="animate-stagger-item delay-300">
                            <flux:input
                                name="email"
                                :value="old('email', $invitationEmail ?? '')"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="Email Address"
                            />
                            @error('email') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="animate-stagger-item delay-400">
                            <flux:input
                                name="phone"
                                :value="old('phone')"
                                type="tel"
                                required
                                autocomplete="tel"
                                placeholder="Phone Number"
                            />
                            @error('phone') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Company Name -->
                        <div class="animate-stagger-item delay-500">
                            <flux:input
                                name="company_name"
                                :value="old('company_name')"
                                type="text"
                                required
                                autocomplete="organization"
                                placeholder="Company Name"
                            />
                            @error('company_name') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Industry -->
                        <div class="animate-stagger-item delay-600">
                            <flux:input
                                name="industry"
                                :value="old('industry')"
                                type="text"
                                required
                                placeholder="Industry - e.g. Retail, Wholesale"
                            />
                            @error('industry') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Company Website -->
                        <div class="animate-stagger-item delay-700">
                            <flux:input
                                name="company_website"
                                :value="old('company_website')"
                                type="text"
                                required
                                placeholder="Company Website"
                            />
                            @error('company_website') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Country Selector -->
                        <div class="animate-stagger-item delay-625 relative col-span-full">
                            <select
                                name="country"
                                required
                            >
                                <option value="" disabled selected hidden>Select Country</option>
                    <option value="AF" {{ old('country') == 'AF' ? 'selected' : '' }}>Afghanistan</option>
                    <option value="AL" {{ old('country') == 'AL' ? 'selected' : '' }}>Albania</option>
                    <option value="DZ" {{ old('country') == 'DZ' ? 'selected' : '' }}>Algeria</option>
                    <option value="AD" {{ old('country') == 'AD' ? 'selected' : '' }}>Andorra</option>
                    <option value="AO" {{ old('country') == 'AO' ? 'selected' : '' }}>Angola</option>
                    <option value="AG" {{ old('country') == 'AG' ? 'selected' : '' }}>Antigua and Barbuda</option>
                    <option value="AR" {{ old('country') == 'AR' ? 'selected' : '' }}>Argentina</option>
                    <option value="AM" {{ old('country') == 'AM' ? 'selected' : '' }}>Armenia</option>
                    <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
                    <option value="AT" {{ old('country') == 'AT' ? 'selected' : '' }}>Austria</option>
                    <option value="AZ" {{ old('country') == 'AZ' ? 'selected' : '' }}>Azerbaijan</option>
                    <option value="BS" {{ old('country') == 'BS' ? 'selected' : '' }}>Bahamas</option>
                    <option value="BH" {{ old('country') == 'BH' ? 'selected' : '' }}>Bahrain</option>
                    <option value="BD" {{ old('country') == 'BD' ? 'selected' : '' }}>Bangladesh</option>
                    <option value="BB" {{ old('country') == 'BB' ? 'selected' : '' }}>Barbados</option>
                    <option value="BY" {{ old('country') == 'BY' ? 'selected' : '' }}>Belarus</option>
                    <option value="BE" {{ old('country') == 'BE' ? 'selected' : '' }}>Belgium</option>
                    <option value="BZ" {{ old('country') == 'BZ' ? 'selected' : '' }}>Belize</option>
                    <option value="BJ" {{ old('country') == 'BJ' ? 'selected' : '' }}>Benin</option>
                    <option value="BT" {{ old('country') == 'BT' ? 'selected' : '' }}>Bhutan</option>
                    <option value="BO" {{ old('country') == 'BO' ? 'selected' : '' }}>Bolivia</option>
                    <option value="BA" {{ old('country') == 'BA' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                    <option value="BW" {{ old('country') == 'BW' ? 'selected' : '' }}>Botswana</option>
                    <option value="BR" {{ old('country') == 'BR' ? 'selected' : '' }}>Brazil</option>
                    <option value="BN" {{ old('country') == 'BN' ? 'selected' : '' }}>Brunei</option>
                    <option value="BG" {{ old('country') == 'BG' ? 'selected' : '' }}>Bulgaria</option>
                    <option value="BF" {{ old('country') == 'BF' ? 'selected' : '' }}>Burkina Faso</option>
                    <option value="BI" {{ old('country') == 'BI' ? 'selected' : '' }}>Burundi</option>
                    <option value="CV" {{ old('country') == 'CV' ? 'selected' : '' }}>Cabo Verde</option>
                    <option value="KH" {{ old('country') == 'KH' ? 'selected' : '' }}>Cambodia</option>
                    <option value="CM" {{ old('country') == 'CM' ? 'selected' : '' }}>Cameroon</option>
                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                    <option value="CF" {{ old('country') == 'CF' ? 'selected' : '' }}>Central African Republic</option>
                    <option value="TD" {{ old('country') == 'TD' ? 'selected' : '' }}>Chad</option>
                    <option value="CL" {{ old('country') == 'CL' ? 'selected' : '' }}>Chile</option>
                    <option value="CN" {{ old('country') == 'CN' ? 'selected' : '' }}>China</option>
                    <option value="CO" {{ old('country') == 'CO' ? 'selected' : '' }}>Colombia</option>
                    <option value="KM" {{ old('country') == 'KM' ? 'selected' : '' }}>Comoros</option>
                    <option value="CG" {{ old('country') == 'CG' ? 'selected' : '' }}>Congo</option>
                    <option value="CD" {{ old('country') == 'CD' ? 'selected' : '' }}>Congo (DRC)</option>
                    <option value="CR" {{ old('country') == 'CR' ? 'selected' : '' }}>Costa Rica</option>
                    <option value="CI" {{ old('country') == 'CI' ? 'selected' : '' }}>Côte d'Ivoire</option>
                    <option value="HR" {{ old('country') == 'HR' ? 'selected' : '' }}>Croatia</option>
                    <option value="CU" {{ old('country') == 'CU' ? 'selected' : '' }}>Cuba</option>
                    <option value="CY" {{ old('country') == 'CY' ? 'selected' : '' }}>Cyprus</option>
                    <option value="CZ" {{ old('country') == 'CZ' ? 'selected' : '' }}>Czech Republic</option>
                    <option value="DK" {{ old('country') == 'DK' ? 'selected' : '' }}>Denmark</option>
                    <option value="DJ" {{ old('country') == 'DJ' ? 'selected' : '' }}>Djibouti</option>
                    <option value="DM" {{ old('country') == 'DM' ? 'selected' : '' }}>Dominica</option>
                    <option value="DO" {{ old('country') == 'DO' ? 'selected' : '' }}>Dominican Republic</option>
                    <option value="EC" {{ old('country') == 'EC' ? 'selected' : '' }}>Ecuador</option>
                    <option value="EG" {{ old('country') == 'EG' ? 'selected' : '' }}>Egypt</option>
                    <option value="SV" {{ old('country') == 'SV' ? 'selected' : '' }}>El Salvador</option>
                    <option value="GQ" {{ old('country') == 'GQ' ? 'selected' : '' }}>Equatorial Guinea</option>
                    <option value="ER" {{ old('country') == 'ER' ? 'selected' : '' }}>Eritrea</option>
                    <option value="EE" {{ old('country') == 'EE' ? 'selected' : '' }}>Estonia</option>
                    <option value="SZ" {{ old('country') == 'SZ' ? 'selected' : '' }}>Eswatini</option>
                    <option value="ET" {{ old('country') == 'ET' ? 'selected' : '' }}>Ethiopia</option>
                    <option value="FJ" {{ old('country') == 'FJ' ? 'selected' : '' }}>Fiji</option>
                    <option value="FI" {{ old('country') == 'FI' ? 'selected' : '' }}>Finland</option>
                    <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                    <option value="GA" {{ old('country') == 'GA' ? 'selected' : '' }}>Gabon</option>
                    <option value="GM" {{ old('country') == 'GM' ? 'selected' : '' }}>Gambia</option>
                    <option value="GE" {{ old('country') == 'GE' ? 'selected' : '' }}>Georgia</option>
                    <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Germany</option>
                    <option value="GH" {{ old('country') == 'GH' ? 'selected' : '' }}>Ghana</option>
                    <option value="GR" {{ old('country') == 'GR' ? 'selected' : '' }}>Greece</option>
                    <option value="GD" {{ old('country') == 'GD' ? 'selected' : '' }}>Grenada</option>
                    <option value="GT" {{ old('country') == 'GT' ? 'selected' : '' }}>Guatemala</option>
                    <option value="GN" {{ old('country') == 'GN' ? 'selected' : '' }}>Guinea</option>
                    <option value="GW" {{ old('country') == 'GW' ? 'selected' : '' }}>Guinea-Bissau</option>
                    <option value="GY" {{ old('country') == 'GY' ? 'selected' : '' }}>Guyana</option>
                    <option value="HT" {{ old('country') == 'HT' ? 'selected' : '' }}>Haiti</option>
                    <option value="HN" {{ old('country') == 'HN' ? 'selected' : '' }}>Honduras</option>
                    <option value="HU" {{ old('country') == 'HU' ? 'selected' : '' }}>Hungary</option>
                    <option value="IS" {{ old('country') == 'IS' ? 'selected' : '' }}>Iceland</option>
                    <option value="IN" {{ old('country') == 'IN' ? 'selected' : '' }}>India</option>
                    <option value="ID" {{ old('country') == 'ID' ? 'selected' : '' }}>Indonesia</option>
                    <option value="IR" {{ old('country') == 'IR' ? 'selected' : '' }}>Iran</option>
                    <option value="IQ" {{ old('country') == 'IQ' ? 'selected' : '' }}>Iraq</option>
                    <option value="IE" {{ old('country') == 'IE' ? 'selected' : '' }}>Ireland</option>
                    <option value="IL" {{ old('country') == 'IL' ? 'selected' : '' }}>Israel</option>
                    <option value="IT" {{ old('country') == 'IT' ? 'selected' : '' }}>Italy</option>
                    <option value="JM" {{ old('country') == 'JM' ? 'selected' : '' }}>Jamaica</option>
                    <option value="JP" {{ old('country') == 'JP' ? 'selected' : '' }}>Japan</option>
                    <option value="JO" {{ old('country') == 'JO' ? 'selected' : '' }}>Jordan</option>
                    <option value="KZ" {{ old('country') == 'KZ' ? 'selected' : '' }}>Kazakhstan</option>
                    <option value="KE" {{ old('country') == 'KE' ? 'selected' : '' }}>Kenya</option>
                    <option value="KI" {{ old('country') == 'KI' ? 'selected' : '' }}>Kiribati</option>
                    <option value="KW" {{ old('country') == 'KW' ? 'selected' : '' }}>Kuwait</option>
                    <option value="KG" {{ old('country') == 'KG' ? 'selected' : '' }}>Kyrgyzstan</option>
                    <option value="LA" {{ old('country') == 'LA' ? 'selected' : '' }}>Laos</option>
                    <option value="LV" {{ old('country') == 'LV' ? 'selected' : '' }}>Latvia</option>
                    <option value="LB" {{ old('country') == 'LB' ? 'selected' : '' }}>Lebanon</option>
                    <option value="LS" {{ old('country') == 'LS' ? 'selected' : '' }}>Lesotho</option>
                    <option value="LR" {{ old('country') == 'LR' ? 'selected' : '' }}>Liberia</option>
                    <option value="LY" {{ old('country') == 'LY' ? 'selected' : '' }}>Libya</option>
                    <option value="LI" {{ old('country') == 'LI' ? 'selected' : '' }}>Liechtenstein</option>
                    <option value="LT" {{ old('country') == 'LT' ? 'selected' : '' }}>Lithuania</option>
                    <option value="LU" {{ old('country') == 'LU' ? 'selected' : '' }}>Luxembourg</option>
                    <option value="MG" {{ old('country') == 'MG' ? 'selected' : '' }}>Madagascar</option>
                    <option value="MW" {{ old('country') == 'MW' ? 'selected' : '' }}>Malawi</option>
                    <option value="MY" {{ old('country') == 'MY' ? 'selected' : '' }}>Malaysia</option>
                    <option value="MV" {{ old('country') == 'MV' ? 'selected' : '' }}>Maldives</option>
                    <option value="ML" {{ old('country') == 'ML' ? 'selected' : '' }}>Mali</option>
                    <option value="MT" {{ old('country') == 'MT' ? 'selected' : '' }}>Malta</option>
                    <option value="MH" {{ old('country') == 'MH' ? 'selected' : '' }}>Marshall Islands</option>
                    <option value="MR" {{ old('country') == 'MR' ? 'selected' : '' }}>Mauritania</option>
                    <option value="MU" {{ old('country') == 'MU' ? 'selected' : '' }}>Mauritius</option>
                    <option value="MX" {{ old('country') == 'MX' ? 'selected' : '' }}>Mexico</option>
                    <option value="FM" {{ old('country') == 'FM' ? 'selected' : '' }}>Micronesia</option>
                    <option value="MD" {{ old('country') == 'MD' ? 'selected' : '' }}>Moldova</option>
                    <option value="MC" {{ old('country') == 'MC' ? 'selected' : '' }}>Monaco</option>
                    <option value="MN" {{ old('country') == 'MN' ? 'selected' : '' }}>Mongolia</option>
                    <option value="ME" {{ old('country') == 'ME' ? 'selected' : '' }}>Montenegro</option>
                    <option value="MA" {{ old('country') == 'MA' ? 'selected' : '' }}>Morocco</option>
                    <option value="MZ" {{ old('country') == 'MZ' ? 'selected' : '' }}>Mozambique</option>
                    <option value="MM" {{ old('country') == 'MM' ? 'selected' : '' }}>Myanmar</option>
                    <option value="NA" {{ old('country') == 'NA' ? 'selected' : '' }}>Namibia</option>
                    <option value="NR" {{ old('country') == 'NR' ? 'selected' : '' }}>Nauru</option>
                    <option value="NP" {{ old('country') == 'NP' ? 'selected' : '' }}>Nepal</option>
                    <option value="NL" {{ old('country') == 'NL' ? 'selected' : '' }}>Netherlands</option>
                    <option value="NZ" {{ old('country') == 'NZ' ? 'selected' : '' }}>New Zealand</option>
                    <option value="NI" {{ old('country') == 'NI' ? 'selected' : '' }}>Nicaragua</option>
                    <option value="NE" {{ old('country') == 'NE' ? 'selected' : '' }}>Niger</option>
                    <option value="NG" {{ old('country') == 'NG' ? 'selected' : '' }}>Nigeria</option>
                    <option value="KP" {{ old('country') == 'KP' ? 'selected' : '' }}>North Korea</option>
                    <option value="MK" {{ old('country') == 'MK' ? 'selected' : '' }}>North Macedonia</option>
                    <option value="NO" {{ old('country') == 'NO' ? 'selected' : '' }}>Norway</option>
                    <option value="OM" {{ old('country') == 'OM' ? 'selected' : '' }}>Oman</option>
                    <option value="PK" {{ old('country') == 'PK' ? 'selected' : '' }}>Pakistan</option>
                    <option value="PW" {{ old('country') == 'PW' ? 'selected' : '' }}>Palau</option>
                    <option value="PS" {{ old('country') == 'PS' ? 'selected' : '' }}>Palestine</option>
                    <option value="PA" {{ old('country') == 'PA' ? 'selected' : '' }}>Panama</option>
                    <option value="PG" {{ old('country') == 'PG' ? 'selected' : '' }}>Papua New Guinea</option>
                    <option value="PY" {{ old('country') == 'PY' ? 'selected' : '' }}>Paraguay</option>
                    <option value="PE" {{ old('country') == 'PE' ? 'selected' : '' }}>Peru</option>
                    <option value="PH" {{ old('country') == 'PH' ? 'selected' : '' }}>Philippines</option>
                    <option value="PL" {{ old('country') == 'PL' ? 'selected' : '' }}>Poland</option>
                    <option value="PT" {{ old('country') == 'PT' ? 'selected' : '' }}>Portugal</option>
                    <option value="QA" {{ old('country') == 'QA' ? 'selected' : '' }}>Qatar</option>
                    <option value="RO" {{ old('country') == 'RO' ? 'selected' : '' }}>Romania</option>
                    <option value="RU" {{ old('country') == 'RU' ? 'selected' : '' }}>Russia</option>
                    <option value="RW" {{ old('country') == 'RW' ? 'selected' : '' }}>Rwanda</option>
                    <option value="KN" {{ old('country') == 'KN' ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                    <option value="LC" {{ old('country') == 'LC' ? 'selected' : '' }}>Saint Lucia</option>
                    <option value="VC" {{ old('country') == 'VC' ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
                    <option value="WS" {{ old('country') == 'WS' ? 'selected' : '' }}>Samoa</option>
                    <option value="SM" {{ old('country') == 'SM' ? 'selected' : '' }}>San Marino</option>
                    <option value="ST" {{ old('country') == 'ST' ? 'selected' : '' }}>Sao Tome and Principe</option>
                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>Saudi Arabia</option>
                    <option value="SN" {{ old('country') == 'SN' ? 'selected' : '' }}>Senegal</option>
                    <option value="RS" {{ old('country') == 'RS' ? 'selected' : '' }}>Serbia</option>
                    <option value="SC" {{ old('country') == 'SC' ? 'selected' : '' }}>Seychelles</option>
                    <option value="SL" {{ old('country') == 'SL' ? 'selected' : '' }}>Sierra Leone</option>
                    <option value="SG" {{ old('country') == 'SG' ? 'selected' : '' }}>Singapore</option>
                    <option value="SK" {{ old('country') == 'SK' ? 'selected' : '' }}>Slovakia</option>
                    <option value="SI" {{ old('country') == 'SI' ? 'selected' : '' }}>Slovenia</option>
                    <option value="SB" {{ old('country') == 'SB' ? 'selected' : '' }}>Solomon Islands</option>
                    <option value="SO" {{ old('country') == 'SO' ? 'selected' : '' }}>Somalia</option>
                    <option value="ZA" {{ old('country') == 'ZA' ? 'selected' : '' }}>South Africa</option>
                    <option value="KR" {{ old('country') == 'KR' ? 'selected' : '' }}>South Korea</option>
                    <option value="SS" {{ old('country') == 'SS' ? 'selected' : '' }}>South Sudan</option>
                    <option value="ES" {{ old('country') == 'ES' ? 'selected' : '' }}>Spain</option>
                    <option value="LK" {{ old('country') == 'LK' ? 'selected' : '' }}>Sri Lanka</option>
                    <option value="SD" {{ old('country') == 'SD' ? 'selected' : '' }}>Sudan</option>
                    <option value="SR" {{ old('country') == 'SR' ? 'selected' : '' }}>Suriname</option>
                    <option value="SE" {{ old('country') == 'SE' ? 'selected' : '' }}>Sweden</option>
                    <option value="CH" {{ old('country') == 'CH' ? 'selected' : '' }}>Switzerland</option>
                    <option value="SY" {{ old('country') == 'SY' ? 'selected' : '' }}>Syria</option>
                    <option value="TW" {{ old('country') == 'TW' ? 'selected' : '' }}>Taiwan</option>
                    <option value="TJ" {{ old('country') == 'TJ' ? 'selected' : '' }}>Tajikistan</option>
                    <option value="TZ" {{ old('country') == 'TZ' ? 'selected' : '' }}>Tanzania</option>
                    <option value="TH" {{ old('country') == 'TH' ? 'selected' : '' }}>Thailand</option>
                    <option value="TL" {{ old('country') == 'TL' ? 'selected' : '' }}>Timor-Leste</option>
                    <option value="TG" {{ old('country') == 'TG' ? 'selected' : '' }}>Togo</option>
                    <option value="TO" {{ old('country') == 'TO' ? 'selected' : '' }}>Tonga</option>
                    <option value="TT" {{ old('country') == 'TT' ? 'selected' : '' }}>Trinidad and Tobago</option>
                    <option value="TN" {{ old('country') == 'TN' ? 'selected' : '' }}>Tunisia</option>
                    <option value="TR" {{ old('country') == 'TR' ? 'selected' : '' }}>Turkey</option>
                    <option value="TM" {{ old('country') == 'TM' ? 'selected' : '' }}>Turkmenistan</option>
                    <option value="TV" {{ old('country') == 'TV' ? 'selected' : '' }}>Tuvalu</option>
                    <option value="UG" {{ old('country') == 'UG' ? 'selected' : '' }}>Uganda</option>
                    <option value="UA" {{ old('country') == 'UA' ? 'selected' : '' }}>Ukraine</option>
                    <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>United Arab Emirates</option>
                    <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                    <option value="UY" {{ old('country') == 'UY' ? 'selected' : '' }}>Uruguay</option>
                    <option value="UZ" {{ old('country') == 'UZ' ? 'selected' : '' }}>Uzbekistan</option>
                    <option value="VU" {{ old('country') == 'VU' ? 'selected' : '' }}>Vanuatu</option>
                    <option value="VA" {{ old('country') == 'VA' ? 'selected' : '' }}>Vatican City</option>
                    <option value="VE" {{ old('country') == 'VE' ? 'selected' : '' }}>Venezuela</option>
                    <option value="VN" {{ old('country') == 'VN' ? 'selected' : '' }}>Vietnam</option>
                    <option value="YE" {{ old('country') == 'YE' ? 'selected' : '' }}>Yemen</option>
                    <option value="ZM" {{ old('country') == 'ZM' ? 'selected' : '' }}>Zambia</option>
                    <option value="ZW" {{ old('country') == 'ZW' ? 'selected' : '' }}>Zimbabwe</option>
                            </select>
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-zinc-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            @error('country') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Physical Address -->
                        <div class="animate-stagger-item delay-650 col-span-full">
                            <flux:input
                                name="physical_address"
                                :value="old('physical_address')"
                                type="text"
                                required
                                placeholder="Physical Address"
                            />
                            @error('physical_address') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="animate-stagger-item delay-700">
                            <flux:input
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Password"
                                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                                viewable
                            />
                            @error('password') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="animate-stagger-item delay-700">
                            <flux:input
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm Password"
                                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                                viewable
                            />
                            @error('password_confirmation') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-1 animate-stagger-item delay-800 col-span-full">
                            <button type="submit" class="w-full h-11 rounded-full bg-gradient-to-r from-[#006a6a] to-[#009090] hover:from-[#009090] hover:to-[#006a6a] text-white font-bold transition-all duration-300 transform active:scale-98 shadow-[0_8px_16px_-8px_rgba(0,106,106,0.3)] hover:shadow-[0_8px_16px_-4px_rgba(0,106,106,0.4)] flex items-center justify-center text-sm" data-test="register-user-button">
                                {{ __('Create Account') }}
                            </button>
                        </div>
                    </form>

                    <!-- Footer link -->
                    <div class="text-center text-xs text-zinc-500 mt-1 animate-stagger-item delay-800 col-span-full">
                        <span>{{ __('Already have an account?') }}</span>
                        <a
                            href="{{ $teamInvitation ? route('login', ['invitation' => $teamInvitation['code']]) : route('login') }}"
                            data-test="team-invitation-login-link"
                            class="font-bold text-[#006a6a] hover:text-[#009090] transition-colors ml-1"
                            wire:navigate
                        >
                            {{ __('Log in') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
