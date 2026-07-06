<x-layouts::auth :title="__('Register')" width="max-w-3xl">
    <style>
        /* Light Theme Pill Inputs & Styling */
        .auth-card input[type="text"],
        .auth-card input[type="email"],
        .auth-card input[type="password"],
        .auth-card input[type="tel"],
        .auth-card select {
            border-radius: 9999px !important;
            background-color: rgba(0, 0, 0, 0.03) !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
            padding-left: 1.5rem !important;
            padding-right: 2.5rem !important;
            height: 3.25rem !important;
            font-size: 0.95rem !important;
            color: #001e40 !important;
            transition: all 0.25s ease-in-out !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.01) !important;
            appearance: none !important;
            width: 100% !important;
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
            box-shadow: 0 0 0 3px rgba(0, 106, 106, 0.15), inset 0 2px 4px rgba(0,0,0,0.01) !important;
            outline: none !important;
        }
        /* Style adjustments for password show/hide button */
        .auth-card [data-flux-input] button {
            right: 0.75rem !important;
            color: rgba(0, 30, 64, 0.5) !important;
        }
    </style>

    <div class="auth-card flex flex-col gap-6">
        <!-- Logo & Header -->
        <div class="flex flex-col items-center text-center animate-stagger-item delay-100">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-36 w-auto object-contain mb-4 drop-shadow-sm">
            <h2 class="text-2xl font-black text-[#001e40] tracking-tight">Create an Account</h2>
            <p class="text-sm text-zinc-500 mt-1">Enter your details below to join GMA</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($teamInvitation)
            <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Register')" />
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
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
            </div>

            <!-- Country Selector -->
            <div class="animate-stagger-item delay-625 relative">
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
            </div>

            <!-- Physical Address -->
            <div class="animate-stagger-item delay-650">
                <flux:input
                    name="physical_address"
                    :value="old('physical_address')"
                    type="text"
                    required
                    placeholder="Physical Address"
                />
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
            </div>

            <!-- Submit Button -->
            <div class="mt-2 animate-stagger-item delay-800">
                <button type="submit" class="w-full h-12.5 rounded-full bg-gradient-to-r from-[#006a6a] to-[#009090] hover:from-[#009090] hover:to-[#006a6a] text-white font-bold transition-all duration-300 transform active:scale-98 shadow-[0_10px_20px_-10px_rgba(0,106,106,0.35)] hover:shadow-[0_10px_20px_-5px_rgba(0,106,106,0.5)] flex items-center justify-center text-base" data-test="register-user-button">
                    {{ __('Create Account') }}
                </button>
            </div>
        </form>

        <!-- Footer link -->
        <div class="text-center text-sm text-zinc-500 mt-2 animate-stagger-item delay-800">
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
</x-layouts::auth>
