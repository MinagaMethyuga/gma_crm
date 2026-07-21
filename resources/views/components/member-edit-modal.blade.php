<div id="member-edit-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeMemberEditModal()"></div>

    <div class="fixed inset-0 flex items-center justify-center p-4" style="pointer-events: none;">
        <div id="member-edit-modal-content" class="bg-white rounded-2xl shadow-2xl w-full overflow-hidden transition-all" style="max-width: 60vw; max-height: 90vh; pointer-events: auto;">
            <div class="flex flex-col" style="max-height: 90vh;">
                <!-- Header -->
                <div class="flex items-center justify-between px-8 py-5 border-b border-slate-200 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#4338ca]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#4338ca]">edit_square</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Edit Member</h3>
                            <p class="text-[13px] text-slate-500" id="member-edit-subtitle">Update member details and plan</p>
                        </div>
                    </div>
                    <button onclick="closeMemberEditModal()" class="w-9 h-9 rounded-full hover:bg-slate-100 flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-slate-500">close</span>
                    </button>
                </div>

                <!-- Scrollable Body -->
                <div class="flex-1 overflow-y-auto px-8 py-6 custom-scroll">
                    <form id="member-edit-form" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="edit-user-id" name="user_id" value="">

                        <!-- Summary Card -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 rounded-xl p-5 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-white overflow-hidden shrink-0 border-2 border-indigo-200 shadow-sm">
                                    <img id="edit-avatar" src="" alt="" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-[15px] font-bold text-slate-900" id="edit-name-display"></h4>
                                        <span id="edit-status-badge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide"></span>
                                        <span id="edit-role-badge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide"></span>
                                    </div>
                                    <p class="text-[13px] text-slate-500 mt-0.5" id="edit-email-display"></p>
                                    <p class="text-[12px] text-slate-400 mt-0.5">
                                        Referred by: <span id="edit-referred-by" class="font-medium text-slate-600"></span>
                                        &middot; <span id="edit-joined-date"></span>
                                        &middot; Tier: <span id="edit-tier-display" class="font-semibold text-indigo-600"></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Fields -->
                        <div class="mb-8">
                            <h4 class="text-[13px] font-bold text-slate-500 uppercase tracking-wider mb-4">Profile Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit-name" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Full Name</label>
                                    <input type="text" id="edit-name" name="name" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" required>
                                </div>
                                <div>
                                    <label for="edit-email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Email</label>
                                    <input type="email" id="edit-email" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-500 bg-slate-50 cursor-not-allowed" readonly disabled>
                                </div>
                                <div>
                                    <label for="edit-phone" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Phone</label>
                                    <input type="text" id="edit-phone" name="phone" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow">
                                </div>
                                <div>
                                    <label for="edit-company" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Company</label>
                                    <input type="text" id="edit-company" name="company_name" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow">
                                </div>
                                <div>
                                    <label for="edit-industry" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Industry</label>
                                    <input type="text" id="edit-industry" name="industry" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="e.g. Telecommunications">
                                </div>
                                <div>
                                    <label for="edit-job-title" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Job Title</label>
                                    <input type="text" id="edit-job-title" name="job_title" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="e.g. CEO">
                                </div>
                                <div>
                                    <label for="edit-country" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Country</label>
                                    <input type="text" id="edit-country" name="country" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="e.g. United States">
                                </div>
                                <div>
                                    <label for="edit-role" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Role</label>
                                    <div class="relative">
                                        <select id="edit-role" name="role" class="appearance-none w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow bg-white">
                                            <option value="member">Member</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="edit-address" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Physical Address</label>
                                <input type="text" id="edit-address" name="physical_address" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="Street address, city, state">
                            </div>
                            <div class="mt-4">
                                <label for="edit-website" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Company Website</label>
                                <input type="url" id="edit-website" name="company_website" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="https://example.com">
                            </div>
                        </div>

                        <!-- Plan + Payment Section -->
                        <div class="mb-8">
                            <h4 class="text-[13px] font-bold text-slate-500 uppercase tracking-wider mb-4">Plan Assignment & Payment</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit-plan" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Plan</label>
                                    <div class="relative">
                                        <select id="edit-plan" name="plan_id" class="appearance-none w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow bg-white">
                                            <option value="">No Plan</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="edit-plan-period" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Period</label>
                                    <div class="relative">
                                        <select id="edit-plan-period" name="plan_period" class="appearance-none w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow bg-white">
                                            <option value="monthly">Monthly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="edit-invoice-number" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Invoice Number</label>
                                    <input type="text" id="edit-invoice-number" name="invoice_number" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="e.g. INV-001">
                                </div>
                                <div>
                                    <label for="edit-payment-method" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Payment Method</label>
                                    <input type="text" id="edit-payment-method" name="payment_method" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="e.g. Cash, Bank Transfer">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="edit-notes" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Notes</label>
                                <textarea id="edit-notes" name="notes" rows="3" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow resize-none" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>

                        <!-- Security Section: Reset Password -->
                        <div class="mb-8">
                            <h4 class="text-[13px] font-bold text-slate-500 uppercase tracking-wider mb-4">Security</h4>
                            <div class="bg-amber-50 border border-amber-200/60 rounded-xl p-4 mb-4">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-amber-600 text-[20px] mt-0.5">shield</span>
                                    <div>
                                        <p class="text-[13px] font-semibold text-amber-800">Reset Password</p>
                                        <p class="text-[12px] text-amber-600 mt-0.5">Set a new password for this user. They will need to use the new password on their next login.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit-new-password" class="block text-[13px] font-semibold text-slate-700 mb-1.5">New Password</label>
                                    <div class="relative inline-flex w-full">
                                        <input type="password" id="edit-new-password" name="new_password" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" style="padding-right: 2.5rem" placeholder="Minimum 8 characters">
                                        <button type="button" onclick="togglePasswordField('edit-new-password')" class="absolute inset-y-0 right-0 flex items-center justify-center w-10 rounded-r-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]" id="edit-new-password-icon">visibility_off</span>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label for="edit-new-password-confirmation" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                                    <div class="relative inline-flex w-full">
                                        <input type="password" id="edit-new-password-confirmation" name="new_password_confirmation" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" style="padding-right: 2.5rem" placeholder="Re-enter password">
                                        <button type="button" onclick="togglePasswordField('edit-new-password-confirmation')" class="absolute inset-y-0 right-0 flex items-center justify-center w-10 rounded-r-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]" id="edit-new-password-confirmation-icon">visibility_off</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" onclick="resetPassword()" id="reset-password-btn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-[13px] font-bold text-amber-700 bg-amber-100 hover:bg-amber-200 border border-amber-200 transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">key</span>
                                    Reset Password
                                </button>
                            </div>
                        </div>

                        <!-- Danger Zone: Delete User -->
                        <div class="mb-2">
                            <h4 class="text-[13px] font-bold text-red-500 uppercase tracking-wider mb-4">Danger Zone</h4>
                            <div class="border border-red-200 rounded-xl p-5 bg-red-50/30">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-[14px] font-bold text-red-800">Delete this user</p>
                                        <p class="text-[12px] text-red-600 mt-1 max-w-md">Permanently remove this user and all associated data. This action cannot be undone.</p>
                                    </div>
                                    <button type="button" onclick="confirmDeleteMember()" id="delete-member-btn" class="shrink-0 inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-[13px] font-bold text-red-600 bg-white border border-red-300 hover:bg-red-50 hover:border-red-400 transition-colors shadow-sm">
                                        <span class="material-symbols-outlined text-[16px]">delete_forever</span>
                                        Delete User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 px-8 py-4 border-t border-slate-200 bg-slate-50/50 shrink-0">
                    <button onclick="closeMemberEditModal()" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-slate-700 hover:bg-slate-200/70 transition-colors border border-slate-200">
                        Cancel
                    </button>
                    <button onclick="saveMemberEdit()" class="px-6 py-2.5 rounded-lg text-[13px] font-bold text-white bg-[#4338ca] hover:bg-[#3730a3] transition-colors shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">check</span>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-confirm-modal" class="fixed inset-0 z-[60] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteConfirm()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4" style="pointer-events: none;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" style="pointer-events: auto;">
            <div class="p-8 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-5">
                    <span class="material-symbols-outlined text-red-500 text-[32px]">delete_forever</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Delete User?</h3>
                <p class="text-[13px] text-slate-500 mb-1">You are about to permanently delete</p>
                <p class="text-[14px] font-bold text-slate-900 mb-4" id="delete-confirm-name"></p>
                <p class="text-[12px] text-red-500 font-medium">This action cannot be undone. All data will be permanently removed.</p>
            </div>
            <div class="flex border-t border-slate-200">
                <button onclick="closeDeleteConfirm()" class="flex-1 px-4 py-3.5 text-[13px] font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button onclick="executeDeleteMember()" id="execute-delete-btn" class="flex-1 px-4 py-3.5 text-[13px] font-bold text-red-600 bg-red-50 hover:bg-red-100 border-l border-red-200 transition-colors">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let allPlans = [];
let editUserData = null;

function togglePasswordField(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility_off';
    }
}

function openMemberEditModal(userId) {
    fetch('/members/' + userId + '/edit', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        const user = data.user;
        allPlans = data.plans;
        editUserData = user;
        const lastValues = data.last_values || {};

        document.getElementById('edit-user-id').value = user.id;
        document.getElementById('edit-avatar').src = user.avatar_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name || 'User') + '&background=103C68&color=fff';
        document.getElementById('edit-avatar').alt = user.name;
        document.getElementById('edit-name-display').textContent = user.name;
        document.getElementById('edit-email-display').textContent = user.email;
        document.getElementById('edit-referred-by').textContent = user.referrer ? user.referrer.name : 'None';
        document.getElementById('edit-joined-date').textContent = user.created_at ? new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';

        const statusBadge = document.getElementById('edit-status-badge');
        if (user.plan_id) {
            statusBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200/60';
            statusBadge.innerHTML = '<span class="w-1 h-1 rounded-full bg-emerald-500"></span> Active';
        } else {
            statusBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-amber-50 text-amber-700 border border-amber-200/60';
            statusBadge.innerHTML = '<span class="w-1 h-1 rounded-full bg-amber-500"></span> Pending';
        }

        const roleBadge = document.getElementById('edit-role-badge');
        if (user.role === 'admin') {
            roleBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-purple-50 text-purple-700 border border-purple-200/60';
            roleBadge.innerHTML = '<span class="w-1 h-1 rounded-full bg-purple-500"></span> Admin';
        } else {
            roleBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-600 border border-slate-200/60';
            roleBadge.innerHTML = '<span class="w-1 h-1 rounded-full bg-slate-500"></span> Member';
        }

        document.getElementById('edit-tier-display').textContent = user.plan ? user.plan.name : 'No Plan';

        // Profile fields
        document.getElementById('edit-name').value = user.name || '';
        document.getElementById('edit-company').value = user.company_name || '';
        document.getElementById('edit-phone').value = user.phone || '';
        document.getElementById('edit-email').value = user.email || '';
        document.getElementById('edit-industry').value = user.industry || '';
        document.getElementById('edit-job-title').value = user.job_title || '';
        document.getElementById('edit-country').value = user.country || '';
        document.getElementById('edit-role').value = user.role || 'member';
        document.getElementById('edit-address').value = user.physical_address || '';
        document.getElementById('edit-website').value = user.company_website || '';

        // Plan select
        const planSelect = document.getElementById('edit-plan');
        planSelect.innerHTML = '<option value="">No Plan</option>';
        data.plans.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.name;
            if (user.plan_id && user.plan_id == p.id) opt.selected = true;
            planSelect.appendChild(opt);
        });

        document.getElementById('edit-plan-period').value = (data.latest_order && data.latest_order.plan_period) ? data.latest_order.plan_period : 'monthly';

        // Invoice fields
        document.getElementById('edit-invoice-number').value = lastValues.invoice_number || '';
        document.getElementById('edit-payment-method').value = lastValues.payment_method || '';
        document.getElementById('edit-notes').value = lastValues.notes || '';

        // Reset password fields
        document.getElementById('edit-new-password').value = '';
        document.getElementById('edit-new-password-confirmation').value = '';

        // Show modal
        document.getElementById('member-edit-modal').classList.remove('hidden');
    })
    .catch(err => {
        console.error('Failed to load member data:', err);
        alert('Could not load member details. Please try again.');
    });
}

function closeMemberEditModal() {
    document.getElementById('member-edit-modal').classList.add('hidden');
    editUserData = null;
}

function saveMemberEdit() {
    const userId = document.getElementById('edit-user-id').value;
    if (!userId) return;

    const form = document.getElementById('member-edit-form');
    const formData = new FormData(form);

    formData.append('_method', 'PUT');
    formData.append('plan_id', formData.get('plan_id') || '');

    const submitBtn = document.querySelector('#member-edit-modal-content button[onclick="saveMemberEdit()"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span> Saving...';

    fetch('/members/' + userId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Save failed');
        return data;
    })
    .then(() => {
        closeMemberEditModal();
        window.location.reload();
    })
    .catch(err => {
        console.error('Save failed:', err);
        alert('Failed to save: ' + err.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function resetPassword() {
    const userId = document.getElementById('edit-user-id').value;
    if (!userId) return;

    const password = document.getElementById('edit-new-password').value;
    const confirmation = document.getElementById('edit-new-password-confirmation').value;

    if (!password) {
        alert('Please enter a new password.');
        return;
    }
    if (password.length < 8) {
        alert('Password must be at least 8 characters.');
        return;
    }
    if (password !== confirmation) {
        alert('Passwords do not match.');
        return;
    }

    const btn = document.getElementById('reset-password-btn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="w-4 h-4 border-2 border-amber-600 border-t-transparent rounded-full animate-spin"></span> Resetting...';

    fetch('/members/' + userId + '/reset-password', {
        method: 'PUT',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            new_password: password,
            new_password_confirmation: confirmation,
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Reset failed');
        return data;
    })
    .then(data => {
        document.getElementById('edit-new-password').value = '';
        document.getElementById('edit-new-password-confirmation').value = '';
        alert(data.message || 'Password has been reset successfully.');
    })
    .catch(err => {
        console.error('Password reset failed:', err);
        alert('Failed to reset password: ' + err.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

function confirmDeleteMember() {
    if (!editUserData) return;
    document.getElementById('delete-confirm-name').textContent = editUserData.name + ' (' + editUserData.email + ')';
    document.getElementById('delete-confirm-modal').classList.remove('hidden');
}

function closeDeleteConfirm() {
    document.getElementById('delete-confirm-modal').classList.add('hidden');
}

function executeDeleteMember() {
    const userId = document.getElementById('edit-user-id').value;
    if (!userId) return;

    const btn = document.getElementById('execute-delete-btn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="w-4 h-4 border-2 border-red-600 border-t-transparent rounded-full animate-spin"></span> Deleting...';

    const token = document.querySelector('input[name="_token"]').value;
    const formData = new FormData();
    formData.append('_method', 'DELETE');
    formData.append('_token', token);

    fetch('/members/' + userId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Delete failed');
        return data;
    })
    .then(() => {
        closeDeleteConfirm();
        closeMemberEditModal();
        window.location.reload();
    })
    .catch(err => {
        console.error('Delete failed:', err);
        alert('Failed to delete: ' + err.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}
</script>
